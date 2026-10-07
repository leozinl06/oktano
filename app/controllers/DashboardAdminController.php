<?php
require_once __DIR__ . "/../core/BaseController.php";
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Personal.php';
require_once __DIR__ . '/../models/Praticante.php';

class DashboardAdminController extends BaseController {
    
    // Método que carrega a página inicial do Dashboard
    public function index(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $id_admin = $_SESSION['usuario_id'] ?? null;
        if(!$id_admin || $_SESSION['usuario_tipo'] !== 'administrador'){
            header('Location: /oktano/public/login/acesso?tipo=administrador');
            exit;
        }

        $database = new Database();
        $db = $database->conectar();

        $personalModel = new Personal($db);
        $praticanteModel = new Praticante($db);

        // Buscando dados de Personal
        $totalPersonais = $personalModel->obterTotal();
        $statsPersonais = $personalModel->obterEstatisticasMensais();

        // Buscando dados de Praticantes (Alunos)
        $totalPraticantes = $praticanteModel->obterTotal();
        $statsPraticantes = $praticanteModel->obterEstatisticasMensais();

        // Formatando arrays para o Chart.js do Frontend
        $dadosGraficoPersonais = ['labels' => [], 'data' => []];
        foreach($statsPersonais as $row) {
            $dadosGraficoPersonais['labels'][] = $row['mes_ano'];
            $dadosGraficoPersonais['data'][] = $row['total'];
        }

        $dadosGraficoPraticantes = ['labels' => [], 'data' => []];
        foreach($statsPraticantes as $row) {
            $dadosGraficoPraticantes['labels'][] = $row['mes_ano'];
            $dadosGraficoPraticantes['data'][] = $row['total'];
        }

        require_once __DIR__ . '/../views/pages/dashboard_administrador.php';
    }

    // Método da API que responde ao filtro do JavaScript
    public function apiEstatisticas() {
        if(session_status() === PHP_SESSION_NONE) session_start();
        header('Content-Type: application/json');
        
        if(empty($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'administrador'){
            http_response_code(403);
            echo json_encode(['erro' => 'Acesso negado']);
            return;
        }

        $tipo = $_GET['tipo'] ?? '';
        $inicio = $_GET['inicio'] ?? null;
        $fim = $_GET['fim'] ?? null;

        $database = new Database();
        $db = $database->conectar();

        try {
            $dados = [];
            if ($tipo === 'personais') {
                $model = new Personal($db);
                $dados = $model->obterEstatisticasMensais($inicio, $fim);
            } elseif ($tipo === 'praticantes') {
                $model = new Praticante($db);
                $dados = $model->obterEstatisticasMensais($inicio, $fim);
            } else {
                http_response_code(400);
                echo json_encode(['erro' => 'Tipo inválido']);
                return;
            }

            $resultado = ['labels' => [], 'data' => []];
            $totalPeriodo = 0;
            
            foreach($dados as $row) {
                $resultado['labels'][] = $row['mes_ano'];
                $resultado['data'][] = $row['total'];
                $totalPeriodo += (int)$row['total'];
            }
            $resultado['total'] = $totalPeriodo;

            echo json_encode($resultado);

        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['erro' => 'Erro na base de dados: ' . $e->getMessage()]);
        }
    }
}