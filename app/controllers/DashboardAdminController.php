<?php
require_once __DIR__ . "/../core/BaseController.php";
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Personal.php';
require_once __DIR__ . '/../models/Praticante.php';

class DashboardAdminController extends BaseController {
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

        $totalPersonais = $personalModel->obterTotal();
        $statsPersonais = $personalModel->obterEstatisticasMensais();

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
}