<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FichaTreino.php';
require_once __DIR__ . '/../models/Treino.php';

class MeusTreinosController extends BaseController{
    public function index(){
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
        
        $id_praticante = $_SESSION['usuario_id'] ?? null;
        if(!$id_praticante || $_SESSION['usuario_tipo'] !== 'praticante'){
            header('Location: /oktano/public/login/acesso?tipo=praticante');
            exit;
        }

        $database = new Database();
        $db = $database->conectar();
        $fichaTreinoModel = new FichaTreino($db);

        $todasFichas = $fichaTreinoModel->buscarFichasPorAluno($id_praticante);

        $fichasAtivas = array_filter($todasFichas, function($ficha) { //filtro 
            return $ficha['status'] === 'ativa';
        });

        require_once __DIR__ . '/../views/pages/meus_treinos.php';
    }

    public function detalhes(){
        if(session_status() === PHP_SESSION_NONE) session_start();

        $id_praticante = $_SESSION['usuario_id'] ?? null;
        if(!$id_praticante || $_SESSION['usuario_tipo'] !== 'praticante'){
            header('Location: /oktano/public/login/acesso?tipo=praticante');
            exit;
        }

        $id_ficha = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
        if(!$id_ficha){
            $this->redirecionarComResultado('/oktano/public/meus-treinos', false, 'Ficha não especificada.');
        }

        $database = new Database();
        $db = $database->conectar();
        $fichaTreinoModel = new FichaTreino($db);
        
        $ficha = $fichaTreinoModel->buscarPorId($id_ficha);

        if(!$ficha || $ficha['id_praticante'] != $id_praticante || $ficha['status'] !== 'ativa'){
            $this->redirecionarComResultado('/oktano/public/meus-treinos', false, 'Ficha não encontrada ou indisponível.');
        }

        $treinoModel = new Treino($db);
        
        $treinos = $treinoModel->buscarPorFicha($id_ficha);

        $tituloPagina = 'Detalhes do Treino';
        $paginaAtiva = 'meus-treinos';

        require_once __DIR__ . '/../views/pages/meus_treinos_detalhes.php';
    }
}