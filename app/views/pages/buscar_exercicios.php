<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require __DIR__ . '/../components/head.php'; ?>
</head>
<body>
    <?php require __DIR__ . '/../components/cabecalho.php'; ?>
    <main class="pagina">
        <div class="container">
            <div class="pagina__cabecalho">
                <div>
                    <h1><?= htmlspecialchars($treino['titulo']) ?></h1>
                    <?php if(!empty($treino['descricao'])): ?>
                        <p class="ficha-detalhes__texto"><?= nl2br(htmlspecialchars($treino['descricao'])) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card card-pesquisa-api">
                <div class="campo-busca">
                    <i class="ph ph-magnifying-glass"></i>
                    <input type="search" id="input-pesquisa-api" class="form-input" placeholder="Pesquisar exercícios..." autocomplete="off">
                </div>
                
                <div id="loader-pesquisa" class="loader-pesquisa is-hidden">
                    <i class="ph ph-spinner ph-spin"></i> Buscando...
                </div>
            </div>

            <div class="grade-busca-exercicios" id="grade-resultados">
                
            </div>
            
            <div id="estado-vazio-api" class="card estado-vazio">
                <i class="ph ph-barbell"></i>
                <h3>Nenhum exercício pesquisado</h3>
                <p>Digite o nome do exercício acima para buscar na base de dados externa.</p>
            </div>
        </div>
    </main>
    <script type="module" src="<?= BASE_URL ?>/assets/js/buscar_exercicios.js"></script>
</body>
</html>