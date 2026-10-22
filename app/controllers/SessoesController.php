<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Sessao.php';

class SessoesController extends BaseController{
    private $db;
    private $sessaoModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->conectar();
        $this->sessaoModel = new Sessao($this->db);
    }

    public function index(){
        $id_personal = $this->exigirAutenticacao('personal');

        $sessoesBrutas = $this->sessaoModel->buscarSessoesPorPersonal($id_personal);
        $historico = [];
        
        foreach($sessoesBrutas as $row) {
            $alunoId = $row['aluno_id'];
            $fichaId = $row['ficha_id'];
            $treinoId = $row['treino_id'];

            if(!isset($historico[$alunoId])) {
                $historico[$alunoId] = ['nome' => $row['aluno_nome'], 'fichas' => []];
            }

            if(!isset($historico[$alunoId]['fichas'][$fichaId])) {
                $historico[$alunoId]['fichas'][$fichaId] = ['titulo' => $row['ficha_titulo'], 'treinos' => []];
            }

            if(!isset($historico[$alunoId]['fichas'][$fichaId]['treinos'][$treinoId])) {
                $historico[$alunoId]['fichas'][$fichaId]['treinos'][$treinoId] = ['titulo' => $row['treino_titulo'], 'sessoes' => []];
            }

            $dataFormatada = date('d/m/Y H:i', strtotime($row['data_realizacao']));

            $segundosTotais = (int)$row['duracao_segundos'];
            $minutos = floor($segundosTotais/60);
            $segundos = $segundosTotais % 60;
            $duracaoFormatada = sprintf('%02d:%02d', $minutos, $segundos);

            $historico[$alunoId]['fichas'][$fichaId]['treinos'][$treinoId]['sessoes'][] = [
                'data' => $dataFormatada,
                'duracao' => $duracaoFormatada,
                'fadiga' => $row['nivel_fadiga']
            ];
        }

        $tituloPagina = 'Sessões de Treino';
        $paginaAtiva = 'sessoes';

        require_once __DIR__ . '/../views/pages/sessoes.php';
    }
}