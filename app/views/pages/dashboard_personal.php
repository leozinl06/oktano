<?php
$tituloPagina = 'Painel do Personal';
$paginaAtiva = 'dashboard_personal';
$nomeUsuario = $_SESSION['usuario_nome'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<?php require __DIR__ . '/../components/head.php'; ?>
</head>
<body>

<?php require __DIR__ . '/../components/cabecalho.php'; ?>

<main class="pagina">
    <div class="container">
        <div class="saudacao">
            <h1>Olá, <?= htmlspecialchars(explode(' ', $nomeUsuario)[0] ?: 'Personal') ?> 👋</h1>
            <p>O que você quer fazer hoje?</p>
        </div>

        <div class="grade-dashboard">
            <a href="<?= BASE_URL ?>/alunos" class="card card--interativo cartao-atalho">
                <div class="cartao-atalho__topo">
                    <span class="cartao-atalho__icone"><i class="ph ph-users"></i></span>
                    <i class="ph ph-arrow-right" style="color: var(--cor-texto-terciario);"></i>
                </div>
                <div>
                    <h3>Meus alunos</h3>
                    <p>Veja seus praticantes vinculados e as fichas de cada um.</p>
                </div>
            </a>

            <a href="<?= BASE_URL ?>/treinos" class="card card--interativo cartao-atalho">
                <div class="cartao-atalho__topo">
                    <span class="cartao-atalho__icone"><i class="ph ph-barbell"></i></span>
                    <i class="ph ph-arrow-right" style="color: var(--cor-texto-terciario);"></i>
                </div>
                <div>
                    <h3>Fichas de treino</h3>
                    <p>Crie, edite e organize as fichas ativas dos seus alunos.</p>
                </div>
            </a>

            <a href="<?= BASE_URL ?>/treinos/arquivados" class="card card--interativo cartao-atalho">
                <div class="cartao-atalho__topo">
                    <span class="cartao-atalho__icone"><i class="ph ph-archive"></i></span>
                    <i class="ph ph-arrow-right" style="color: var(--cor-texto-terciario);"></i>
                </div>
                <div>
                    <h3>Fichas arquivadas</h3>
                    <p>Consulte ou restaure fichas que já foram arquivadas.</p>
                </div>
            </a>
        </div>
    </div>
</main>

</body>
</html>
