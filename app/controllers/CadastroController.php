<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Personal.php';
require_once __DIR__ . '/../core/BaseController.php';

class CadastroController extends BaseController{
    private $db;
    private $personalModel;

    public function __construct(){
        $database = new Database();
        $this->db = $database->conectar(); //inicia conexão

        $this->personalModel = new Personal($this->db); //instancia um personal
    }

    public function index(){
        $resultado = null;
        if(isset($_SESSION['resultado'])){
            $resultado = $_SESSION['resultado'];
            unset($_SESSION['resultado']);
        }

        require_once __DIR__ . '/../views/pages/cadastro.php';
    }

    public function registrar(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $url = '/oktano/public/cadastro';

            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $registro = filter_input(INPUT_POST, 'registro', FILTER_SANITIZE_SPECIAL_CHARS);
            $codigo_vinculo = filter_input(INPUT_POST, 'codigo_vinculo', FILTER_SANITIZE_SPECIAL_CHARS);

            $senha = $_POST['senha'] ?? '';
            $confirmarSenha = $_POST['confirmar-senha'] ?? '';

            if (empty($nome) || empty($email) || empty($registro) || empty($codigo_vinculo) || empty($senha)) {
                $this->redirecionarComResultado($url, false, 'Todos os campos são obrigatórios');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->redirecionarComResultado($url, false, 'Formato de e-mail inválido.');
            }

            if(!preg_match('/^[a-zA-Z0-9]{6}$/', $codigo_vinculo)){
                $this->redirecionarComResultado($url, false, 'O código deve conter exatamente 6 caracteres.');
            }

            if (strlen($senha) < 8) {
                $this->redirecionarComResultado($url, false, 'A senha deve conter no mínimo 8 caracteres.');
            }

            if ($senha !== $confirmarSenha) {
                $this->redirecionarComResultado($url, false, 'As senhas não coincidem.');
            }

            if($this->personalModel->verificaExistencia($email, $registro, $codigo_vinculo)){
                $this->redirecionarComResultado($url, false, 'O e-mail ou registro profissional já estão vinculados a uma conta existente.');
            }

            if($this->personalModel->cadastrar($nome, $email, $registro, strtoupper($codigo_vinculo), $senha)){
                $this->redirecionarComResultado('/oktano/public/login/acesso?tipo=personal', true, 'Cadastro realizado com sucesso!');
            
            } else{
                $this->redirecionarComResultado($url, false, 'Ocorreu um erro interno. Tente novamente mais tarde.');
            }
        }

        return null;
    }
}