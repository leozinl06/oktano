<?php
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Praticante.php';
require_once __DIR__ . '/../models/FichaTreino.php';
require_once __DIR__ . '/../core/BaseController.php';

class AlunosController extends BaseController{
    private $db;
    private $praticanteModel;
    private $fichaTreinoModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conectar();
        $this->praticanteModel = new Praticante($this->db);
        $this->fichaTreinoModel = new FichaTreino($this->db);
    }

    public function index() {
        $id_personal = $this->exigirAutenticacao('personal');

        $alunos_bruto = $this->praticanteModel->buscarAlunosPorPersonal($id_personal);
        $alunos_limpo = [];
        
        foreach($alunos_bruto as $aluno){
            $partes_nome = explode(' ', trim($aluno['nome']));
            $nome_exibicao = $partes_nome[0] . (count($partes_nome) > 1 ? ' ' . end($partes_nome) : '');
            
            $alunos_limpo[] = [
                'id' => $aluno['id'],
                'nome_exibicao' => $nome_exibicao,
                'fichas' => $this->fichaTreinoModel->buscarFichasPorAluno($aluno['id'])
            ];
        }
        $alunos = $alunos_limpo;
        
        $resultado = $this->obterResultadoSessao();
        require_once __DIR__ . '/../views/pages/alunos.php';
    }
}