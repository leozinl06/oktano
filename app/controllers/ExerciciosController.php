<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Treino.php';
// Importa o novo serviço da ExerciseDB
require_once __DIR__ . '/../core/ExerciseDBService.php';

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
}