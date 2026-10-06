<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/Sessao.php';

class SessoesController extends BaseController{
    public function index(){
        if(session_status() === PHP_SESSION_NONE) session_start();
        
        $id_personal = $_SESSION['usuario_id'] ?? null;
        if(!$id_personal || $_SESSION['usuario_tipo'] !== 'personal'){
            header('Location: /oktano/public/login/acesso?tipo=personal');
            exit;
        }

        $database = new Database();
        $db = $database->conectar();
        
        $sessaoModel = new Sessao($db);
        $sessoesBrutas = $sessaoModel->buscarSessoesPorPersonal($id_personal);

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

            $historico[$alunoId]['fichas'][$fichaId]['treinos'][$treinoId]['sessoes'][] = [
                'data' => $dataFormatada,
                'duracao' => $row['duracao_minutos'],
                'fadiga' => $row['nivel_fadiga']
            ];
        }

        $tituloPagina = 'Sessões de Treino';
        $paginaAtiva = 'sessoes';

        require_once __DIR__ . '/../views/pages/sessoes.php';
    }
}