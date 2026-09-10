<?php
require_once __DIR__ . "/../core/BaseController.php";

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

        require_once __DIR__ . '/../views/pages/dashboard_administrador.php';
    }
}