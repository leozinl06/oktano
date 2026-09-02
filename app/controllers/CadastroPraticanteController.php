<?php

require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Praticante.php';
require_once __DIR__ . '/../core/BaseController.php';

class CadastroPraticanteController extends BaseController{
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

            $url = '/oktano/public/cadastro-praticante';

            $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $codigo_personal = strtoupper(filter_input(INPUT_POST, 'codigo_personal', FILTER_SANITIZE_SPECIAL_CHARS));

            $senha = $_POST['senha'] ?? '';
            $confirmarSenha = $_POST['confirmar-senha'] ?? '';

            $_SESSION['dados_form'] = $_POST;

            if (empty($nome) || empty($email) || empty($codigo_personal) || empty($senha)) {
                $this->redirecionarComResultado($url, false, 'Todos os campos são obrigatórios.');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->redirecionarComResultado($url, false, 'Formato de e-mail inválido.');
            }

            if (!preg_match('/^[A-Z0-9]{6}$/', $codigo_personal)) {
                $this->redirecionarComResultado($url, false, 'O código de vínculo deve conter exatamente 6 caracteres.');
            }

            if (strlen($senha) < 8) {
                $this->redirecionarComResultado($url, false, 'A senha deve conter no mínimo 8 caracteres.');
            }

            if ($senha !== $confirmarSenha) {
                $this->redirecionarComResultado($url, false, 'As senhas não coincidem.');
            }

            if($this->praticanteModel->verificaExistencia($email)){
                $this->redirecionarComResultado($url, false, 'O e-mail já está vinculado a uma conta existente.');
            }

            $id_personal = $this->praticanteModel->buscarIdPersonalPorCodigo($codigo_personal);

            if(!$id_personal){
                $_SESSION['resultado'] = ['sucesso' => false, 'mensagem' => 'Personal não encontrado. Verifique o código fornecido.', 'campo' => 'codigo_personal'];
                header('Location: /oktano/public/cadastro-praticante');
                exit;
            }

            if($this->praticanteModel->cadastrar($id_personal, $nome, $email, $senha)){
                $this->redirecionarComResultado('/oktano/public/login/acesso?tipo=praticante', true, 'Cadastro realizado com sucesso!');
                
            } else{
                $this->redirecionarComResultado($url, false, 'Ocorreu um erro interno. Tente novamente mais tarde.');
            }
        }

        return null;
    }
}