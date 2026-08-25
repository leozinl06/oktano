<?php

session_start();

require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();

$router->adicionar('cadastro', 'CadastroController', 'index');
$router->adicionar('cadastro/processar', 'CadastroController', 'registrar');

$router->adicionar('cadastro_praticante', 'CadastroPraticanteController', 'index');

$url = isset($_GET['url']) ? $_GET['url'] : '';

$router->despachar($url);