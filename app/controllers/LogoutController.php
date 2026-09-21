<?php
require_once __DIR__ . '/../core/BaseController.php';

class LogoutController extends BaseController{

    public function index(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $_SESSION = []; //esvazia array de dados de sessão

        if(ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, //destroi cookie da sessão, se existir
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
            );
        }

        session_destroy(); //destroi sessão

        header('Location: /oktano/public/login');
        exit;
    }
}