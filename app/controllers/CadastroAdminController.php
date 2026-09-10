<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Administrador.php';
require_once __DIR__ . '/../core/BaseController.php';

class CadastroAdminController extends BaseController{
    private $db;
    private $adminModel;

    public function __construct(){
        $database = new Database();
        $this->db = $database->conectar();
        $this->adminModel = new Administrador($this->db);
    }

    public function index(){
        $resultado = null;
        if(isset($_SESSION['resultado'])){
            $resultado = $_SESSION['resultado'];
            unset($_SESSION['resultado']);
        }
        require_once __DIR__ . '/../views/pages/cadastro_admin.php';
    }

    public function registrar(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $url = '/oktano/public/cadastro-admin';
            
            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $senha = $_POST['senha'] ?? '';
            $confirmarSenha = $_POST['confirmar-senha'] ?? '';

            if (empty($nome) || empty($email) || empty($senha)) {
                $this->redirecionarComResultado($url, false, 'Todos os campos são obrigatórios.');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->redirecionarComResultado($url, false, 'Formato de e-mail inválido.');
            }

            if (strlen($senha) < 8) {
                $this->redirecionarComResultado($url, false, 'A senha deve conter no mínimo 8 caracteres.');
            }

            if ($senha !== $confirmarSenha) {
                $this->redirecionarComResultado($url, false, 'As senhas não coincidem.');
            }

            if($this->adminModel->verificaExistencia($email)){
                $this->redirecionarComResultado($url, false, 'O e-mail já está vinculado a uma conta existente.');
            }

            if($this->adminModel->cadastrar($nome, $email, $senha)){
                $this->redirecionarComResultado('/oktano/public/login/acesso?tipo=administrador', true, 'Cadastro de Administrador realizado com sucesso!');
            } else {
                $this->redirecionarComResultado($url, false, 'Ocorreu um erro interno. Tente novamente mais tarde.');
            }
        }
        return null;
    }
}