<?php
require_once __DIR__ . '/../core/BaseController.php';
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../models/FichaTreino.php';

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
}