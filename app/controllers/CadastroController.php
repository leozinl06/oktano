<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Personal.php';

class CadastroController{
    private $db;
    private $personalModel;

    public function __construct(){
        $database = new Database();
        $this->db = $database->conectar(); //inicia conexão

        $this->personalModel = new Personal($this->db); //instancia um personal
    }

    public function registrar(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $registro = filter_input(INPUT_POST, 'registro', FILTER_SANITIZE_SPECIAL_CHARS);

            $senha = $_POST['senha'] ?? '';
            $confirmarSenha = $_POST['confirmar-senha'] ?? '';

            if (empty($nome) || empty($email) || empty($registro) || empty($senha)) {
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'Todos os campos são obrigatórios.'];
                header('Location: ' . $_SERVER['PHP_SELF']); // redireciona para a própria página
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'Formato de e-mail inválido.'];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if (strlen($senha) < 8) {
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'Formato de e-mail inválido.'];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if ($senha !== $confirmarSenha) {
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'As senhas não coincidem.'];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if($this->personalModel->verificaExistencia($email, $registro)){
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'O e-mail ou registro profissional já estão vinculados a uma conta existente.'];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }

            if($this->personalModel->cadastrar($nome, $email, $registro, $senha)){
                $_SESSION['resultado'] = ['sucesso' => true, 'mensagem' => 'Cadastro realizado com sucesso!'];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else{
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'Ocorreu um erro interno. Tente novamente mais tarde.'];
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            }
        }

        return null;
    }
}