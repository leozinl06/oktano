<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Treino.php';
require_once __DIR__ . '/../core/ExerciseDBService.php';
require_once __DIR__ . '/../models/Exercicio.php';
require_once __DIR__ . '/../models/TreinoExercicio.php';


class ExerciciosController extends BaseController {
    private $db;
    private $treinoModel;
    private $treinoExercicioModel;
    private $exercicioModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conectar();
        $this->treinoModel = new Treino($this->db);
        $this->treinoExercicioModel = new TreinoExercicio($this->db);
        $this->exercicioModel = new Exercicio($this->db);
    }

    public function index() {
        $this->exigirAutenticacao('personal');
        
        $id_treino = filter_input(INPUT_GET, 'id_treino', FILTER_SANITIZE_NUMBER_INT);
        $id_treino_exercicio = filter_input(INPUT_GET, 'id_treino_exercicio', FILTER_SANITIZE_NUMBER_INT);
        
        if(!$id_treino){
            $this->redirecionarComResultado('/oktano/public/treinos', false, 'Treino não especificado.');
        }

        $treino = $this->treinoModel->buscarPorId($id_treino);
        if(!$treino) {
            $this->redirecionarComResultado('/oktano/public/treinos', false, 'Treino não encontrado.');
        }

        $exercicioPai = null;
        if($id_treino_exercicio){
            $exercicioPai = $this->treinoExercicioModel->buscarPorIdETreino($id_treino_exercicio, $id_treino);
            if(!$exercicioPai){
                $this->redirecionarComResultado(
                    '/oktano/public/treinos/detalhes?id=' . $treino['id_ficha_treino'],
                    false,
                    'Exercício principal não encontrado neste treino.'
                );
            }
        }

        $tituloPagina = 'Buscar Exercícios - ' . htmlspecialchars($treino['titulo']);
        $paginaAtiva = 'treinos';
        $resultado = $this->obterResultadoSessao();
        
        require_once __DIR__ . '/../views/pages/buscar_exercicios.php';
    }

    public function pesquisarApi() {
        $this->iniciarSessao();
        header('Content-Type: application/json');
        
        $termo = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);
        if(empty($termo)) {
            echo json_encode([]);
            return;
        }

        $api = new ExerciseDBService();
        $resultados = $api->buscarExercicios($termo);
        
        if (isset($resultados['erro'])) {
            http_response_code(400);
        }
        echo json_encode($resultados);
    }

    public function adicionarAoTreino() {
        $this->exigirAutenticacao('personal');

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_treino = filter_input(INPUT_POST, 'id_treino', FILTER_SANITIZE_NUMBER_INT);
            $id_treino_exercicio = filter_input(INPUT_POST, 'id_treino_exercicio', FILTER_SANITIZE_NUMBER_INT);
            $api_id = filter_input(INPUT_POST, 'api_id', FILTER_SANITIZE_SPECIAL_CHARS);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $musculo = filter_input(INPUT_POST, 'musculo', FILTER_SANITIZE_SPECIAL_CHARS);
            $series = filter_input(INPUT_POST, 'series', FILTER_SANITIZE_NUMBER_INT);
            $repeticoes = filter_input(INPUT_POST, 'repeticoes', FILTER_SANITIZE_SPECIAL_CHARS);
            $descanso = filter_input(INPUT_POST, 'descanso', FILTER_SANITIZE_NUMBER_INT) ?: 60;
            $observacoes = filter_input(INPUT_POST, 'observacoes', FILTER_SANITIZE_SPECIAL_CHARS);

            $queryAlternativo = $id_treino_exercicio ? '&id_treino_exercicio=' . $id_treino_exercicio : '';
            $url_retorno_busca = '/oktano/public/treinos/buscar-exercicios?id_treino=' . $id_treino . $queryAlternativo;

            if(empty($nome) || empty($musculo) || empty($series) || empty($repeticoes)) {
                $this->redirecionarComResultado($url_retorno_busca, false, 'Preencha as séries e repetições.');
            }

            $database = new Database();
            $db = $database->conectar();

            $exercicioModel = new Exercicio($db);
            $treinoExercicioModel = new TreinoExercicio($db);
            $treinoModel = new Treino($db);

            // 1. Busca ou Cadastra o exercício base (da API ou custom)
            $id_exercicio = $this->exercicioModel->obterOuCadastrar($api_id, $nome, $musculo);
            
            if(!$id_exercicio){
                $this->redirecionarComResultado($url_retorno_busca, false, 'Falha ao registrar o exercicio base no sistema.');
            }

            if(!empty($id_treino_exercicio)){
                $exercicioPai = $treinoExercicioModel->buscarPorIdETreino($id_treino_exercicio, $id_treino);
                if (!$exercicioPai) {
                    $this->redirecionarComResultado($url_retorno_busca, false, 'Exercício principal inválido.');
                }

                if ((int)$exercicioPai['id_exercicio'] === (int)$id_exercicio) {
                    $this->redirecionarComResultado($url_retorno_busca, false, 'O exercício alternativo deve ser diferente do exercício principal.');
                }

                $treino = $treinoModel->buscarPorId($id_treino);
                $url_detalhes = '/oktano/public/treinos/detalhes?id=' . $treino['id_ficha_treino'];

                if ($treinoExercicioModel->salvarAlternativo($id_treino_exercicio, $id_treino, $id_exercicio, $series, $repeticoes, $descanso, $observacoes)) {
                    $this->redirecionarComResultado($url_detalhes, true, "Exercício alternativo '{$nome}' vinculado com sucesso!");
                } else {
                    $this->redirecionarComResultado($url_retorno_busca, false, 'Falha ao vincular o exercício alternativo.');
                }
            } else{
                if ($treinoExercicioModel->cadastrar($id_treino, $id_exercicio, $series, $repeticoes, $descanso, $observacoes)) {
                    $this->redirecionarComResultado($url_retorno_busca, true, "Exercício '{$nome}' adicionado com sucesso!");
                } else {
                    $this->redirecionarComResultado($url_retorno_busca, false, 'Falha ao vincular o exercício ao treino.');
                }
            }
        }
    }
}