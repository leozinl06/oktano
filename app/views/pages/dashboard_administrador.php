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
                        <h3 class="grafico-card__titulo">Total de Personais</h3>
                        <span class="grafico-card__total" id="total-personais"><?= htmlspecialchars($totalPersonais) ?></span>
                    </div>
                    <div style="display: flex; gap: var(--espaco-2);">
                        <button type="button" class="btn btn--icone js-abrir-filtro" data-tipo="personais" title="Selecionar Período">
                            <i class="ph ph-calendar-blank"></i>
                        </button>
                        <button type="button" class="btn btn--secundario btn--pequeno js-exportar-dados">
                            <i class="ph ph-download-simple"></i> Exportar
                        </button>
                    </div>
                </div>
                <div class="grafico-card__canvas-wrapper">
                    <canvas id="grafico-personais"></canvas>
                    <div id="vazio-personais" class="grafico-estado-vazio is-hidden">
                        <i class="ph ph-chart-bar"></i>
                        <p>Não há dados disponíveis com os filtros atuais.</p>
                        <button type="button" class="btn btn--texto btn--pequeno js-redefinir-grafico" data-tipo="personais">
                            Redefinir Padrões
                        </button>
                    </div>
                </div>
            </div>

            <!-- Gráfico de Alunos -->
            <div class="card">
                <div class="grafico-card__cabecalho">
                    <div class="grafico-card__info">
                        <h3 class="grafico-card__titulo">Total de Alunos</h3>
                        <span class="grafico-card__total" id="total-praticantes"><?= htmlspecialchars($totalPraticantes) ?></span>
                    </div>
                    <div style="display: flex; gap: var(--espaco-2);">
                        <button type="button" class="btn btn--icone js-abrir-filtro" data-tipo="praticantes" title="Selecionar Período">
                            <i class="ph ph-calendar-blank"></i>
                        </button>
                        <button type="button" class="btn btn--secundario btn--pequeno js-exportar-dados">
                            <i class="ph ph-download-simple"></i> Exportar
                        </button>
                    </div>
                </div>
                <div class="grafico-card__canvas-wrapper">
                    <canvas id="grafico-praticantes"></canvas>
                    <div id="vazio-praticantes" class="grafico-estado-vazio is-hidden">
                        <i class="ph ph-chart-bar"></i>
                        <p>Não há dados disponíveis com os filtros atuais.</p>
                        <button type="button" class="btn btn--texto btn--pequeno js-redefinir-grafico" data-tipo="praticantes">
                            Redefinir Padrões
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Modal Selecionar Período -->
<div class="modal-overlay modal-overlay--oculto" id="modal-filtro-periodo" role="dialog" aria-modal="true">
    <div class="modal modal--pequeno">
        <div class="modal__icone" style="color: var(--cor-primaria); background-color: var(--cor-primaria-clara); margin-inline: auto;">
            <i class="ph-bold ph-calendar"></i>
        </div>
        <h3 class="modal__titulo" style="text-align: center;">Selecionar Período</h3>
        <p class="modal__texto" style="text-align: center; margin-bottom: var(--espaco-4);">Defina o intervalo de meses para análise.</p>
        
        <form id="form-filtro-periodo" novalidate>
            <input type="hidden" id="filtro-tipo-alvo">
            <div class="form-group" style="text-align: left;">
                <label for="filtro-inicio" class="form-label">Mês de Início</label>
                <input type="month" id="filtro-inicio" class="form-input" required>
                <span class="form-error-msg"></span>
            </div>
            <div class="form-group" style="text-align: left;">
                <label for="filtro-fim" class="form-label">Mês de Fim</label>
                <input type="month" id="filtro-fim" class="form-input" required>
                <span class="form-error-msg"></span>
            </div>
            <div class="modal__acoes">
                <button type="button" class="btn btn--secundario js-fechar-filtro">Cancelar</button>
                <button type="submit" class="btn btn--primario">Aplicar Filtro</button>
            </div>
        </form>
    </div>
</div>

<script>
    window.BASE_URL = '<?= BASE_URL ?>'
    window.dadosPersonais = <?= json_encode($dadosGraficoPersonais) ?>;
    window.dadosPraticantes = <?= json_encode($dadosGraficoPraticantes) ?>;
</script>
<script type="module" src="<?= BASE_URL ?>/assets/js/dashboard_admin.js"></script>
</body>
</html>