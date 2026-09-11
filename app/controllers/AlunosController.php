<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Praticante.php';
require_once __DIR__ . '/../models/FichaTreino.php';
require_once __DIR__ . '/../core/BaseController.php';

class AlunosController extends BaseController{

    public function index(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }

        $id_personal = $_SESSION['usuario_id'] ?? null;
        if(!$id_personal || $_SESSION['usuario_tipo'] !== 'personal'){
            header('Location: /oktano/public/login/acesso?tipo=personal');
            exit;
        }

        $database = new Database();
        $db = $database->conectar();

        $praticanteModel = new Praticante($db);
        $fichaTreinoModel = new FichaTreino($db);

        $alunos_bruto = $praticanteModel->buscarAlunosPorPersonal($id_personal);
        $alunos_limpo = [];

        foreach($alunos_bruto as $aluno){
            $partes_nome = explode(' ', trim($aluno['nome']));
            $nome_exibicao = $partes_nome[0];
            if(count($partes_nome) > 1){
                $nome_exibicao .= ' ' . end($partes_nome);
            }

            $fichas = $fichaTreinoModel->buscarFichasPorAluno($aluno['id']);

            $alunos_limpo[] = [
                'id' => $aluno['id'],
                'nome_exibicao' => $nome_exibicao,
                'fichas' => $fichas
            ];
        }

        $alunos = $alunos_limpo;

        $resultado = $_SESSION['resultado'] ?? null;
        unset($_SESSION['resultado']);

        require_once __DIR__ . '/../views/pages/alunos.php';
    }
}