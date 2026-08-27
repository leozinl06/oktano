<?php

class LoginController{

    public function index(){
        require_once __DIR__ . '/../views/pages/selecao_login.php';
    }

    public function acesso(){ //exibir tela do form de login
        $tipo = isset($_GET['tipo']) ? filter_var($_GET['tipo'], FILTER_SANITIZE_SPECIAL_CHARS) : ''; //pega o tipo de user na url

        if($tipo === 'personal' || $tipo === 'praticante'){
            $tipo_usuario = $tipo;

            $resultado = null;
            if(isset($_SESSION['resultado'])){
                $resultado = $_SESSION['resultado'];
                unset($_SESSION['resultado']);
            }

            require_once __DIR__ . '/../views/pages/login.php';
        } else{
            header('Location: oktano/public/login');
            exit;
        }
    }
}