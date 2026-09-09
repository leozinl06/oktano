<?php
require_once __DIR__ . '/../core/BaseController.php';

class DashboardPraticanteController extends BaseController{

    public function index(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $id_praticante = $_SESSION['usuario_id'] ?? null;

        if(!$id_praticante || $_SESSION['usuario_tipo'] !== 'praticante'){
            header('Location: /oktano/public/login/acesso?tipo=praticante');
            exit;
        }

        require_once __DIR__ . '/../views/pages/dashboard_praticante.php';
    }
}