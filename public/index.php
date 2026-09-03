<?php

session_start();

require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();

$router->adicionar('cadastro', 'CadastroController', 'index');
$router->adicionar('cadastro/processar', 'CadastroController', 'registrar');
$router->adicionar('cadastro-praticante', 'CadastroPraticanteController', 'index'); //rotas cadastro
$router->adicionar('cadastro-praticante/processar', 'CadastroPraticanteController', 'registrar');

$router->adicionar('login', 'LoginController', 'index');
$router->adicionar('login/acesso', 'LoginController', 'acesso'); //rotas login
$router->adicionar('login/processar', 'LoginController', 'processar');

$router->adicionar('dashboard_personal', 'DashboardPersonalController', 'index');
$router->adicionar('dashboard_praticante', 'DashboardPraticanteController', 'index');

$url = isset($_GET['url']) ? $_GET['url'] : '';

$router->despachar($url);