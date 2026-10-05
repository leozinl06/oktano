<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Treino.php';
// Importa o novo serviço da ExerciseDB
require_once __DIR__ . '/../core/ExerciseDBService.php';

require_once __DIR__ . '/../models/Exercicio.php';
require_once __DIR__ . '/../models/TreinoExercicio.php';


class ExerciciosController extends BaseController {
    public function index() {
        if(session_status() === PHP_SESSION_NONE) session_start();

        $id_treino = filter_input(INPUT_GET, 'id_treino', FILTER_SANITIZE_NUMBER_INT);
        if(!$id_treino) {
            die("Treino não especificado.");
        }

        $database = new Database();
        $db = $database->conectar();
        $treinoModel = new Treino($db);
        
        $treino = $treinoModel->buscarPorId($id_treino);
        
        if(!$treino) {
            die("Treino não encontrado.");
        }

        $tituloPagina = 'Buscar Exercícios - ' . htmlspecialchars($treino['titulo']);
        $paginaAtiva = 'treinos';
        
        require_once __DIR__ . '/../views/pages/buscar_exercicios.php';
    }

    public function pesquisarApi() {
        if(session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json');

        $termo = filter_input(INPUT_GET, 'q', FILTER_SANITIZE_SPECIAL_CHARS);
        if(empty($termo)) {
            echo json_encode([]);
            return;
        }

        // Instancia o novo serviço
        $api = new ExerciseDBService();
        $resultados = $api->buscarExercicios($termo);

        if (isset($resultados['erro'])) {
            http_response_code(400);
            echo json_encode($resultados);
            return;
        }

        echo json_encode($resultados);
    }

    public function adicionarAoTreino() {
        if(session_status() === PHP_SESSION_NONE) session_start();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_treino = filter_input(INPUT_POST, 'id_treino', FILTER_SANITIZE_NUMBER_INT);
            $api_id = filter_input(INPUT_POST, 'api_id', FILTER_SANITIZE_SPECIAL_CHARS);
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $musculo = filter_input(INPUT_POST, 'musculo', FILTER_SANITIZE_SPECIAL_CHARS);

            $series = filter_input(INPUT_POST, 'series', FILTER_SANITIZE_NUMBER_INT);
            $repeticoes = filter_input(INPUT_POST, 'repeticoes', FILTER_SANITIZE_SPECIAL_CHARS);
            $descanso = filter_input(INPUT_POST, 'descanso', FILTER_SANITIZE_NUMBER_INT) ?: 60;
            $observacoes = filter_input(INPUT_POST, 'observacoes', FILTER_SANITIZE_SPECIAL_CHARS);

            $url_retorno = '/oktano/public/treinos/buscar-exercicios?id_treino=' . $id_treino;

            if(empty($api_id) || empty($series) || empty($repeticoes)) {
                $this->redirecionarComResultado($url_retorno, false, 'Preencha as séries e repetições.');
            }

            $database = new Database();
            $db = $database->conectar();
            $exercicioModel = new Exercicio($db);
            $treinoExercicioModel = new TreinoExercicio($db);

            // 1. Busca ou Cadastra o exercício base vindo da API
            $id_exercicio = $exercicioModel->buscarPorApiId($api_id);
            if(!$id_exercicio) {
                $id_exercicio = $exercicioModel->cadastrar($api_id, $nome, $musculo);
            }

            if($id_exercicio) {
                // 2. Vincula o exercício à ficha de treino atual
                if($treinoExercicioModel->cadastrar($id_treino, $id_exercicio, $series, $repeticoes, $descanso, $observacoes)) {
                    $this->redirecionarComResultado($url_retorno, true, "Exercício '{$nome}' adicionado com sucesso!");
                } else {
                    $this->redirecionarComResultado($url_retorno, false, 'Falha ao vincular o exercício ao treino.');
                }
            } else {
                $this->redirecionarComResultado($url_retorno, false, 'Falha ao registrar o exercício base no sistema.');
            }
        }
    }
}