<?php
$tituloPagina = 'Painel do Administrador';
$paginaAtiva = 'dashboard_administrador';
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
            <h1>Olá, <?= htmlspecialchars(explode(' ', $nomeUsuario)[0] ?: 'Administrador') ?> 👋</h1>
            <p>Painel administrativo do Oktano.</p>
        </div>

        <div class="card estado-vazio">
            <i class="ph ph-shield-check"></i>
            <h3>Nenhum painel de gestão conectado ainda</h3>
            <p>
                Esta tela está pronta para receber os módulos de administração
                (contas, personais e relatórios) assim que as consultas correspondentes
                forem implementadas no backend.
            </p>
        </div>
    </div>
</main>

</body>
</html>
