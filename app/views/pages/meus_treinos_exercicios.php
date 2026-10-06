<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require __DIR__ . '/../components/head.php'; ?>
</head>
<body>
    <?php require __DIR__ . '/../components/cabecalho.php'; ?>
    
    <main class="pagina">
        <div class="container container--estreito">
            
            <div class="ficha-voltar" style="margin-bottom: var(--espaco-4);">
                <a href="<?= BASE_URL ?>/meus-treinos/detalhes?id=<?= $ficha['id'] ?>" class="btn btn--texto btn--pequeno ficha-voltar__btn">
                    <i class="ph ph-arrow-left"></i> Voltar para a Ficha
                </a>
            </div>

            <div class="execucao-cabecalho">
                <h1 class="execucao-cabecalho__titulo"><?= htmlspecialchars($treino['titulo']) ?></h1>
                <?php if (!empty($treino['descricao'])): ?>
                    <p class="form-hint"><?= nl2br(htmlspecialchars($treino['descricao'])) ?></p>
                <?php endif; ?>
            </div>

            <button type="button" class="btn btn--primario btn--bloco btn--gigante">
                <i class="ph-bold ph-play"></i> Iniciar Treino
            </button>

            <div class="lista-exercicios-tela">
                <?php if (empty($exercicios)): ?>
                    <div class="card estado-vazio">
                        <i class="ph ph-barbell"></i>
                        <h3>Treino Vazio</h3>
                        <p>Nenhum exercício foi cadastrado nesta divisão de treino ainda.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($exercicios as $ex): ?>
                        <div class="card cartao-exercicio-expandido">
                            <div class="cartao-exercicio-expandido__topo">
                                <span class="cartao-exercicio-expandido__ordem"><?= $ex['ordem'] ?></span>
                                <h3 class="cartao-exercicio-expandido__titulo"><?= htmlspecialchars($ex['nome']) ?></h3>
                            </div>
                            
                            <div class="cartao-exercicio-expandido__metricas">
                                <div class="metrica-box">
                                    <span class="metrica-box__valor"><?= $ex['series'] ?></span>
                                    <span class="metrica-box__rotulo">Séries</span>
                                </div>
                                <div class="metrica-box">
                                    <span class="metrica-box__valor"><?= htmlspecialchars($ex['repeticoes']) ?></span>
                                    <span class="metrica-box__rotulo">Repetições</span>
                                </div>
                                <div class="metrica-box">
                                    <span class="metrica-box__valor"><?= $ex['tempo_descanso_seg'] ?>s</span>
                                    <span class="metrica-box__rotulo">Descanso</span>
                                </div>
                            </div>

                            <?php if (!empty($ex['observacoes'])): ?>
                                <div class="cartao-exercicio-expandido__obs">
                                    <strong><i class="ph ph-info"></i> Observação:</strong><br>
                                    <span class="form-hint" style="color: var(--cor-texto);"><?= nl2br(htmlspecialchars($ex['observacoes'])) ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </main>
</body>
</html>