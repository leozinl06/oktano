<?php

require_once __DIR__ . "/../core/BaseController.php";

class DashboardPersonalController extends BaseController{

    public function index(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $id_personal = $_SESSION['usuario_id'] ?? null;

        if(!$id_personal || $_SESSION['usuario_tipo'] !== 'personal'){
            header('Location: /oktano/public/login/acesso?tipo=personal');
            exit;
        }

        require_once __DIR__ . '/../views/pages/dashboard_personal.php';
    }
}