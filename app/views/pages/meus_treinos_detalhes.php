<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require __DIR__ . '/../components/head.php'; ?>
</head>
<body>
    <?php require __DIR__ . '/../components/cabecalho.php'; ?>
    
    <main class="pagina">
        <div class="container">
            <a href="<?= BASE_URL ?>/meus-treinos" class="btn btn--texto btn--pequeno" style="padding-left:0; margin-bottom: var(--espaco-3);">
                <i class="ph ph-arrow-left"></i> Voltar para Meus Treinos
            </a>

            <div class="pagina__cabecalho">
                <div>
                    <h1><?= htmlspecialchars($ficha['titulo']) ?></h1>
                </div>
                <div class="pagina__acoes">
                    <span class="badge badge--<?= $ficha['status'] ?>"><?= ucfirst($ficha['status']) ?></span>
                </div>
            </div>

            <?php if (!empty($ficha['descricao'])): ?>
            <div class="card ficha-detalhes" style="margin-bottom: var(--espaco-4);">
                <p class="ficha-detalhes__texto">
                    <?= nl2br(htmlspecialchars($ficha['descricao'])) ?>
                </p>
            </div>
            <?php endif; ?>

            <div class="treinos-lista">
                <div class="treinos-lista__cabecalho">
                    <h2>Treinos da Ficha</h2>
                </div>

                <?php if (empty($treinos)): ?>
                    <div class="card estado-vazio">
                        <i class="ph ph-barbell"></i>
                        <h3>Nenhum treino disponível</h3>
                        <p>Seu personal ainda não adicionou treinos nesta ficha.</p>
                    </div>
                <?php else: ?>
                    <div class="grade-fichas">
                        <?php foreach ($treinos as $treino): ?>
                            <div class="card cartao-ficha">
                                <div class="cartao-ficha__topo">
                                    <h3><?= htmlspecialchars($treino['titulo']) ?></h3>
                                </div>
                                
                                <p class="cartao-ficha__desc">
                                    <?php if (!empty($treino['descricao'])): ?>
                                        <?= nl2br(htmlspecialchars($treino['descricao'])) ?>
                                    <?php else: ?>
                                        <span class="form-hint">Nenhuma descrição.</span>
                                    <?php endif; ?>
                                </p>
                                
                                <div class="cartao-ficha__rodape" style="margin-top: var(--espaco-4);">
                                    <a href="<?= BASE_URL ?>/meus-treinos/exercicios?id_treino=<?= $treino['id'] ?>" class="btn btn--secundario btn--bloco">
                                        <i class="ph ph-eye"></i> Ver Exercícios
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>