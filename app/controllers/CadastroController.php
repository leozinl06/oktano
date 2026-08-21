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
                return ['sucesso' => false, 'mensagem' => 'Todos os campos são obrigatórios.'];
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                return ['sucesso' => false, 'mensagem' => 'Formato de e-mail inválido.'];
            }

            if (strlen($senha) < 8) {
                return ['sucesso' => false, 'mensagem' => 'A senha deve conter no mínimo 8 caracteres.'];
            }

            if ($senha !== $confirmarSenha) {
                return ['sucesso' => false, 'mensagem' => 'As senhas não coincidem.'];
            }

            if($this->personalModel->verificaExistencia($email, $registro)){
                return ['sucesso' => false, 'mensagem' => 'O e-mail ou registro profissional já estão vinculados a uma conta existente.'];
            }

            if($this->personalModel->cadastrar($nome, $email, $registro, $senha)){
                return ['sucesso' => true, 'mensagem' => 'Cadastro realizado com sucesso!'];
            } else{
                return ['sucesso' => false, 'mensagem' => 'Ocorreu um erro. Tente novamente'];
            }
        }

        return null;
    }
}