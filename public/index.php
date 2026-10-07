<?php

session_start();

require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();

$router->adicionar('/', 'LoginController', 'index');

$router->adicionar('cadastro', 'CadastroController', 'index');
$router->adicionar('cadastro/processar', 'CadastroController', 'registrar');
$router->adicionar('cadastro-praticante', 'CadastroPraticanteController', 'index'); //rotas cadastro
$router->adicionar('cadastro-praticante/processar', 'CadastroPraticanteController', 'registrar');
$router->adicionar('cadastro-admin', 'CadastroAdminController', 'index');
$router->adicionar('cadastro-admin/processar', 'CadastroAdminController', 'registrar');

$router->adicionar('login', 'LoginController', 'index');
$router->adicionar('login/acesso', 'LoginController', 'acesso'); //rotas login
$router->adicionar('login/processar', 'LoginController', 'processar');

$router->adicionar('logout', 'LogoutController', 'index');

$router->adicionar('dashboard_personal', 'DashboardPersonalController', 'index');
$router->adicionar('dashboard_praticante', 'DashboardPraticanteController', 'index');
$router->adicionar('dashboard_administrador', 'DashboardAdminController', 'index');

$router->adicionar('alunos', 'AlunosController', 'index');

$router->adicionar('treinos', 'TreinosController', 'index');
$router->adicionar('treinos/nova-ficha', 'TreinosController', 'novaFicha');
$router->adicionar('treinos/criar-ficha', 'TreinosController', 'criarFicha');
$router->adicionar('treinos/excluir-ficha', 'TreinosController', 'excluirFicha');
$router->adicionar('treinos/editar-ficha', 'TreinosController', 'editarFicha');
$router->adicionar('treinos/atualizar-ficha', 'TreinosController', 'atualizarFicha');
$router->adicionar('treinos/arquivados', 'TreinosController', 'arquivados');
$router->adicionar('treinos/arquivar-ficha', 'TreinosController', 'arquivarFicha');
$router->adicionar('treinos/desarquivar-ficha', 'TreinosController', 'desarquivarFicha');
$router->adicionar('treinos/detalhes', 'TreinosController', 'detalhesFicha');
$router->adicionar('treinos/reordenar', 'TreinosController', 'reordenarTreinos');

$router->adicionar('treinos/adicionar-treino', 'TreinosController', 'adicionarTreino');
$router->adicionar('treinos/editar-treino', 'TreinosController', 'editarTreino');
$router->adicionar('treinos/excluir-treino', 'TreinosController', 'excluirTreino');


$router->adicionar('treinos/buscar-exercicios', 'ExerciciosController', 'index');
$router->adicionar('api/exercicios/buscar', 'ExerciciosController', 'pesquisarApi');
$router->adicionar('treinos/adicionar-exercicio', 'ExerciciosController', 'adicionarAoTreino');

$router->adicionar('meus-treinos', 'MeusTreinosController', 'index');
$router->adicionar('meus-treinos/detalhes', 'MeusTreinosController', 'detalhes');
$router->adicionar('meus-treinos/exercicios', 'MeusTreinosController', 'exercicios');
$router->adicionar('meus-treinos/salvar-sessao', 'MeusTreinosController', 'salvarSessao');

$router->adicionar('sessoes', 'SessoesController', 'index');

$router->adicionar('api/admin/estatisticas', 'DashboardAdminController', 'apiEstatisticas');


$url = isset($_GET['url']) ? $_GET['url'] : '';

$router->despachar($url);