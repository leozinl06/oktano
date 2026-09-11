<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FichaTreino.php';
require_once __DIR__ . '/../models/Praticante.php';
require_once __DIR__ . '/../core/BaseController.php';

class TreinosController extends BaseController{

    public function index(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        
        $id_personal = $_SESSION['usuario_id'] ?? null;
        if(!$id_personal || $_SESSION['usuario_tipo'] !== 'personal'){
            header('Location: /oktano/public/login/acesso?tipo=personal');
            exit;
        }

        $database = new Database();
        $db = $database->conectar();
        $fichaTreinoModel = new FichaTreino($db);
        
        $fichas = $fichaTreinoModel->buscarFichasPorPersonal($id_personal);
        
        $resultado = $_SESSION['resultado'] ?? null;
        unset($_SESSION['resultado']);

        require_once __DIR__ . '/../views/pages/treinos.php';
    }

    public function novaFicha(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        
        $id_personal = $_SESSION['usuario_id'] ?? null;
        if(!$id_personal || $_SESSION['usuario_tipo'] !== 'personal'){
            header('Location: /oktano/public/login/acesso?tipo=personal');
            exit;
        }

        $id_aluno = filter_input(INPUT_GET, 'aluno_id', FILTER_SANITIZE_NUMBER_INT);
        
        if(!$id_aluno){
            $this->redirecionarComResultado('/oktano/public/alunos', false, 'Aluno não especificado.');
        }

        $database = new Database();
        $db = $database->conectar();
        $praticanteModel = new Praticante($db);
        
        $aluno = $praticanteModel->buscarPorId($id_aluno);

        if(!$aluno || $aluno['id_personal'] != $id_personal){
            $this->redirecionarComResultado('/oktano/public/alunos', false, 'Aluno inválido ou não autorizado.');
        }

        $resultado = $_SESSION['resultado'] ?? null;
        unset($_SESSION['resultado']);

        require_once __DIR__ . '/../views/pages/nova_ficha.php';
    }

    public function criarFicha(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_aluno = filter_input(INPUT_POST, 'id_aluno', FILTER_SANITIZE_NUMBER_INT);
            $titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_SPECIAL_CHARS);
            $descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_SPECIAL_CHARS);
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

            $url = '/oktano/public/treinos/nova-ficha?aluno_id=' . $id_aluno;

            if(empty($titulo) || empty($status)){
                $this->redirecionarComResultado($url, false, 'Título e status são obrigatórios.');
            }

            $database = new Database();
            $db = $database->conectar();
            $fichaTreinoModel = new FichaTreino($db);

            if($fichaTreinoModel->cadastrar($id_aluno, $titulo, $descricao, $status)){
                $this->redirecionarComResultado('/oktano/public/treinos', true, 'Ficha criada com sucesso!');
            } else {
                $this->redirecionarComResultado($url, false, 'Erro ao criar ficha.');
            }
        }
    }

    public function editarFicha(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        
        $id_personal = $_SESSION['usuario_id'] ?? null;
        if(!$id_personal || $_SESSION['usuario_tipo'] !== 'personal'){
            header('Location: /oktano/public/login/acesso?tipo=personal');
            exit;
        }

        $id_ficha = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        
        if(!$id_ficha){
            $this->redirecionarComResultado('/oktano/public/treinos', false, 'Ficha não especificada.');
        }

        $database = new Database();
        $db = $database->conectar();
        $fichaTreinoModel = new FichaTreino($db);
        $praticanteModel = new Praticante($db);
        
        $ficha = $fichaTreinoModel->buscarPorId($id_ficha);

        if ($ficha) {
            $aluno = $praticanteModel->buscarPorId($ficha['id_praticante']);
        }
        
        if(!$ficha || !$aluno || $aluno['id_personal'] != $id_personal){
            $this->redirecionarComResultado('/oktano/public/treinos', false, 'Ficha inválida ou não autorizada.');
        }

        $resultado = $_SESSION['resultado'] ?? null;
        unset($_SESSION['resultado']);
   
        $url_origem = $_SERVER['HTTP_REFERER'] ?? '/oktano/public/treinos';

        require_once __DIR__ . '/../views/pages/editar_ficha.php';
    }

    public function excluirFicha(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        
        $id_personal = $_SESSION['usuario_id'] ?? null;
        if(!$id_personal || $_SESSION['usuario_tipo'] !== 'personal'){
            header('Location: /oktano/public/login/acesso?tipo=personal');
            exit;
        }

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $id_ficha = filter_input(INPUT_POST, 'id_ficha', FILTER_SANITIZE_NUMBER_INT);
            
            $url_retorno = filter_input(INPUT_POST, 'url_retorno', FILTER_SANITIZE_URL) ?: '/oktano/public/treinos';

            if(empty($id_ficha)){
                $this->redirecionarComResultado($url_retorno, false, 'ID da ficha não fornecido para exclusão.');
            }

            $database = new Database();
            $db = $database->conectar();
            $fichaTreinoModel = new FichaTreino($db);

            if($fichaTreinoModel->excluir($id_ficha)){
                $this->redirecionarComResultado($url_retorno, true, 'Ficha excluída permanentemente com sucesso!');
            } else {
                $this->redirecionarComResultado($url_retorno, false, 'Falha ao excluir a ficha. Tente novamente.');
            }
        }
    }
}