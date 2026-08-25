<?php

class CadastroPraticanteController{

    function index(){
        $resultado = null;
        if(isset($_SESSION['resultado'])){
            $resultado = $_SESSION['resultado'];
            unset($_SESSION['resultado']);
        }

        require_once __DIR__ . '/../views/pages/cadastro_praticante.php';
    }
}