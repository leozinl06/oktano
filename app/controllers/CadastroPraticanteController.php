<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Praticante.php';

class CadastroPraticanteController{
    private $db;
    private $praticanteModel;

    public function __construct(){
        $database = new Database();
        $this->db = $database->conectar();
        $this->praticanteModel = new Praticante($this->db);
    }

    public function index(){
        $resultado = null;
        if(isset($_SESSION['resultado'])){
            $resultado = $_SESSION['resultado'];
            unset($_SESSION['resultado']);
        }

        $dadosForm = null;
        if(isset($_SESSION['dados_form'])){
            $dadosForm = $_SESSION['dados_form'];
            unset($_SESSION['dados_form']);
        }

        require_once __DIR__ . '/../views/pages/cadastro_praticante.php';
    }

    public function registrar(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $codigo_personal = strtoupper(filter_input(INPUT_POST, 'codigo_personal', FILTER_SANITIZE_SPECIAL_CHARS));

            $senha = $_POST['senha'] ?? '';
            $confirmarSenha = $_POST['confirmar-senha'] ?? '';

            $_SESSION['dados_form'] = $_POST;

            if (empty($nome) || empty($email) || empty($codigo_personal) || empty($senha)) {
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'Todos os campos são obrigatórios.'];
                header('Location: /oktano/public/cadastro-praticante');
                exit;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'Formato de e-mail inválido.'];
                header('Location: /oktano/public/cadastro-praticante');
                exit;
            }

            if (!preg_match('/^[A-Z0-9]{6}$/', $codigo_personal)) {
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'O código de vínculo deve conter exatamente 6 caracteres alfanuméricos.'];
                header('Location: /oktano/public/cadastro-praticante');
                exit;
            }

            if (strlen($senha) < 8) {
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'A senha deve conter no mínimo 8 caracteres.'];
                header('Location: /oktano/public/cadastro-praticante');
                exit;
            }

            if ($senha !== $confirmarSenha) {
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'As senhas não coincidem.'];
                header('Location: /oktano/public/cadastro-praticante');
                exit;
            }

            if($this->praticanteModel->verificaExistencia($email)){
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'O e-mail já está vinculado a uma conta existente.'];
                header('Location: /oktano/public/cadastro-praticante');
                exit;
            }

            $id_personal = $this->praticanteModel->buscarIdPersonalPorCodigo($codigo_personal);

            if(!$id_personal){
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'Personal não encontrado. Verifique o código fornecido.', 'campo' => 'codigo_personal'];
                header('Location: /oktano/public/cadastro-praticante');
                exit;
            }

            if($this->praticanteModel->cadastrar($id_personal, $nome, $email, $senha)){
                $_SESSION['resultado'] = ['sucesso' => true, 'mensagem' => 'Cadastro realizado com sucesso!'];
                header('Location: /oktano/public/login/acesso?tipo=praticante');
                exit;
            } else{
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'Ocorreu um erro interno. Tente novamente mais tarde.'];
                header('Location: /oktano/public/cadastro-praticante');
                exit;
            }
        }

        return null;
    }
}