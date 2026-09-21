<?php
$tituloPagina = 'Painel do Praticante';
$paginaAtiva = 'dashboard_praticante';
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
            <h1>Olá, <?= htmlspecialchars(explode(' ', $nomeUsuario)[0] ?: 'Praticante') ?> 👋</h1>
            <p>Pronto para o treino de hoje?</p>
        </div>

        <div class="grade-dashboard">
            <a href="<?= BASE_URL ?>/meus-treinos" class="card card--interativo cartao-atalho">
                <div class="cartao-atalho__topo">
                    <span class="cartao-atalho__icone"><i class="ph ph-barbell"></i></span>
                    <i class="ph ph-arrow-right" style="color: var(--cor-texto-terciario);"></i>
                </div>
                <div>
                    <h3>Meus treinos</h3>
                    <p>Veja as fichas de treino que seu personal montou para você.</p>
                </div>
            </a>
        </div>
    </div>
</main>

</body>
</html>
