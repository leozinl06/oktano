<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FichaTreino.php';
require_once __DIR__ . '/../models/Treino.php';
require_once __DIR__ . '/../models/TreinoExercicio.php';

class MeusTreinosController extends BaseController{
    public function index(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        $id_praticante = $_SESSION['usuario_id'] ?? null;
        if(!$id_praticante || $_SESSION['usuario_tipo'] !== 'praticante'){
            header('Location: /oktano/public/login/acesso?tipo=praticante');
            exit;
        }

        $database = new Database();
        $db = $database->conectar();
        $fichaTreinoModel = new FichaTreino($db);

        $todasFichas = $fichaTreinoModel->buscarFichasPorAluno($id_praticante);

        $fichasAtivas = array_filter($todasFichas, function($ficha) { //filtro 
            return $ficha['status'] === 'ativa';
        });

        require_once __DIR__ . '/../views/pages/meus_treinos.php';
    }

    public function detalhes(){
        if(session_status() === PHP_SESSION_NONE) session_start();

        $id_praticante = $_SESSION['usuario_id'] ?? null;
        if(!$id_praticante || $_SESSION['usuario_tipo'] !== 'praticante'){
            header('Location: /oktano/public/login/acesso?tipo=praticante');
            exit;
        }

        $id_ficha = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if(!$id_ficha){
            $this->redirecionarComResultado('/oktano/public/meus-treinos', false, 'Ficha não especificada.');
        }

        $database = new Database();
        $db = $database->conectar();
        $fichaTreinoModel = new FichaTreino($db);
        
        $ficha = $fichaTreinoModel->buscarPorId($id_ficha);

        if(!$ficha || $ficha['id_praticante'] != $id_praticante || $ficha['status'] !== 'ativa'){
            $this->redirecionarComResultado('/oktano/public/meus-treinos', false, 'Ficha não encontrada ou indisponível.');
        }

        $treinoModel = new Treino($db);
        
        $treinos = $treinoModel->buscarPorFicha($id_ficha);

        $tituloPagina = 'Detalhes do Treino';
        $paginaAtiva = 'meus-treinos';

        require_once __DIR__ . '/../views/pages/meus_treinos_detalhes.php';
    }

    public function exercicios(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        
        $id_praticante = $_SESSION['usuario_id'] ?? null;
        if(!$id_praticante || $_SESSION['usuario_tipo'] !== 'praticante'){
            header('Location: /oktano/public/login/acesso?tipo=praticante');
            exit;
        }

        $id_treino = filter_input(INPUT_GET, 'id_treino', FILTER_SANITIZE_NUMBER_INT);
        if(!$id_treino){
            $this->redirecionarComResultado('/oktano/public/meus-treinos', false, 'Treino não especificado.');
        }

        $database = new Database();
        $db = $database->conectar();
        
        $treinoModel = new Treino($db);
        $treino = $treinoModel->buscarPorId($id_treino);

        if(!$treino){
            $this->redirecionarComResultado('/oktano/public/meus-treinos', false, 'Treino não encontrado.');
        }

        $fichaTreinoModel = new FichaTreino($db);
        $ficha = $fichaTreinoModel->buscarPorId($treino['id_ficha_treino']);

        if(!$ficha || $ficha['id_praticante'] != $id_praticante || $ficha['status'] !== 'ativa'){
            $this->redirecionarComResultado('/oktano/public/meus-treinos', false, 'Acesso não autorizado a este treino.');
        }

        $treinoExercicioModel = new TreinoExercicio($db);
        $exercicios = $treinoExercicioModel->buscarPorTreino($id_treino);

        $tituloPagina = 'Treino: ' . htmlspecialchars($treino['titulo']);
        $paginaAtiva = 'meus-treinos';

        require_once __DIR__ . '/../views/pages/meus_treinos_exercicios.php';
    }

    public function salvarSessao(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json');
        
        if($_SERVER['REQUEST_METHOD'] !== 'POST'){
            echo json_encode(['sucesso' => false, 'mensagem' => 'Método inválido.']);
            return;
        }

        $dados = json_decode(file_get_contents('php://input'), true);

        if(!isset($dados['id_treino'], $dados['duracao_segundos'], $dados['nivel_fadiga'], $dados['exercicios'])) {
            echo json_encode(['sucesso' => false, 'mensagem' => 'Dados incompletos.']);
            return;
        }

        $database = new Database();
        $db = $database->conectar();
        
        require_once __DIR__ . '/../models/Sessao.php';
        require_once __DIR__ . '/../models/ExercicioSessao.php';
        
        $sessaoModel = new Sessao($db);
        $esModel = new ExercicioSessao($db);

        try{
            $db->beginTransaction();
            
            $id_sessao = $sessaoModel->cadastrar(
                $dados['id_treino'], 
                $dados['duracao_segundos'], 
                $dados['nivel_fadiga']
            );

            if(!$id_sessao) {
                throw new Exception("Falha ao salvar a sessão.");
            }

            foreach($dados['exercicios'] as $ex) {
                $esModel->cadastrar(
                    $id_sessao,
                    $ex['id_treino_exercicio'],
                    $ex['id_exercicio'],
                    $ex['carga']
                );
            }

            $db->commit();

            $_SESSION['resultado'] = ['sucesso' => true, 'mensagem' => 'Treino finalizado com sucesso!'];
            echo json_encode(['sucesso' => true]);
        } catch (Exception $e){
            $db->rollBack();
            echo json_encode(['sucesso' => false, 'mensagem' => 'Erro interno ao salvar: ' . $e->getMessage()]);
        }
    }
}