<?php

session_start();

require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();

$router->adicionar('cadastro', 'CadastroController', 'index');
$router->adicionar('cadastro/processar', 'CadastroController', 'registrar');

$router->adicionar('cadastro-praticante', 'CadastroPraticanteController', 'index');
$router->adicionar('cadastro-praticante/processar', 'CadastroPraticanteController', 'registrar');

$url = isset($_GET['url']) ? $_GET['url'] : '';

$router->despachar($url);