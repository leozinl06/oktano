<?php
$tituloPagina = 'Painel do Administrador';
$paginaAtiva = 'dashboard_administrador';
$nomeUsuario = $_SESSION['usuario_nome'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require __DIR__ . '/../components/head.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<?php require __DIR__ . '/../components/cabecalho.php'; ?>

<main class="pagina">
    <div class="container">
        <div class="saudacao">
            <h1>Olá, <?= htmlspecialchars(explode(' ', $nomeUsuario)[0] ?: 'Administrador') ?> 👋</h1>
            <p>Visão geral de crescimento da plataforma Oktano.</p>
        </div>

        <div class="admin-dashboard-grid">
            <!-- Gráfico de Personais -->
            <div class="card">
                <div class="grafico-card__cabecalho">
                    <div class="grafico-card__info">
                        <h3 class="grafico-card__titulo">Total de Personais Registrados</h3>
                        <span class="grafico-card__total"><?= htmlspecialchars($totalPersonais) ?></span>
                    </div>
                    <button type="button" class="btn btn--secundario btn--pequeno js-exportar-dados">
                        <i class="ph ph-download-simple"></i> Exportar
                    </button>
                </div>
                <div class="grafico-card__canvas-wrapper">
                    <canvas id="grafico-personais"></canvas>
                </div>
            </div>

            <!-- Gráfico de Alunos -->
            <div class="card">
                <div class="grafico-card__cabecalho">
                    <div class="grafico-card__info">
                        <h3 class="grafico-card__titulo">Total de Alunos Registrados</h3>
                        <span class="grafico-card__total"><?= htmlspecialchars($totalPraticantes) ?></span>
                    </div>
                    <button type="button" class="btn btn--secundario btn--pequeno js-exportar-dados">
                        <i class="ph ph-download-simple"></i> Exportar
                    </button>
                </div>
                <div class="grafico-card__canvas-wrapper">
                    <canvas id="grafico-praticantes"></canvas>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Injetando os dados do backend para serem consumidos pelo JS -->
<script>
    window.dadosPersonais = <?= json_encode($dadosGraficoPersonais) ?>;
    window.dadosPraticantes = <?= json_encode($dadosGraficoPraticantes) ?>;
</script>
<script type="module" src="<?= BASE_URL ?>/assets/js/dashboard_admin.js"></script>
</body>
</html>