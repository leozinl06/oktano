<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Personal.php';
require_once __DIR__ . '/../models/Praticante.php';
require_once __DIR__ . '/../models/Administrador.php';

class LoginController{

    public function index(){
        require_once __DIR__ . '/../views/pages/selecao_login.php';
    }

    public function acesso(){ //exibir tela do form de login
        $tipo = isset($_GET['tipo']) ? filter_var($_GET['tipo'], FILTER_SANITIZE_SPECIAL_CHARS) : ''; //pega o tipo de user na url

        if($tipo === 'personal' || $tipo === 'praticante' || $tipo === 'administrador'){
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

    public function processar(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $tipo_usuario = filter_input(INPUT_POST, 'tipo_usuario', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $senha = $_POST['senha'] ?? '';

            if(empty($email) || empty($senha) || empty($tipo_usuario)){
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'Todos os campos são obrigatórios.'];
                header("Location: /oktano/public/login/acesso?tipo=$tipo_usuario");
                exit;
            }

            $database = new Database();
            $db = $database->conectar();
            $usuario = false;

            if($tipo_usuario === 'personal'){
                $model = new Personal($db);
                $usuario = $model->buscarPorEmail($email);
            } elseif($tipo_usuario === 'praticante'){
                $model = new Praticante($db);
                $usuario = $model->buscarPorEmail($email);
            } elseif($tipo_usuario === 'administrador'){
                $model = new Administrador($db);
                $usuario = $model->buscarPorEmail($email);
            }

            if($usuario && password_verify($senha, $usuario['senha'])){
                
                session_regenerate_id(true); //previne ataques de roubo de sessão

                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_tipo'] = $tipo_usuario;

                header('Location: /oktano/public/dashboard_' . $tipo_usuario);
                exit;
            } else{
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'E-mail ou senha incorretos.'];
                header("Location: /oktano/public/login/acesso?tipo=$tipo_usuario");
            }
        }
    }
}