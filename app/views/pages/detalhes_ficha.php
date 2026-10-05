<?php
$tituloPagina = 'Detalhes da Ficha';
$paginaAtiva = 'treinos';
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
            <div class="ficha-voltar">
                <a href="<?= BASE_URL ?>/treinos" class="btn btn--texto btn--pequeno ficha-voltar__btn">
                    <i class="ph ph-arrow-left"></i> Voltar para treinos
                </a>
            </div>

            <div class="pagina__cabecalho">
                <div>
                    <h1><?= htmlspecialchars($ficha['titulo']) ?></h1>
                    <p class="ficha-meta">Aluno: <strong
                            class="ficha-meta__destaque"><?= htmlspecialchars($aluno['nome']) ?></strong></p>
                </div>
                <div class="pagina__acoes">
                    <span class="badge badge--<?= $ficha['status'] ?>"><?= ucfirst($ficha['status']) ?></span>
                </div>
            </div>

            <?php if (!empty($resultado)): ?>
                <div class="alerta alerta--<?= $resultado['sucesso'] ? 'sucesso' : 'erro' ?>" role="alert">
                    <i class="ph-bold ph-<?= $resultado['sucesso'] ? 'check-circle' : 'x-circle' ?>"></i>
                    <span><?= htmlspecialchars($resultado['mensagem']) ?></span>
                </div>
            <?php endif; ?>

            <div class="card ficha-detalhes">
                <h3>Informações da Ficha</h3>
                <p class="ficha-detalhes__texto">
                    <?= !empty($ficha['descricao']) ? nl2br(htmlspecialchars($ficha['descricao'])) : '<span class="form-hint">Nenhuma descrição adicionada.</span>' ?>
                </p>
            </div>

            <div class="ficha-acoes">
                <button type="button" class="btn btn--primario js-btn-adicionar-treino">
                    <i class="ph ph-plus"></i>
                    Adicionar Treinos
                </button>
                <button type="button" class="btn btn--secundario">
                    <i class="ph ph-arrows-down-up"></i>
                    Reordenar Treinos
                </button>
            </div>

            <div class="treinos-lista">
                <div class="treinos-lista__cabecalho">
                    <h2>Divisões de Treino</h2>
                </div>

                <?php if (empty($treinos)): ?>
                    <div class="card estado-vazio">
                        <i class="ph ph-barbell"></i>
                        <h3>Nenhum treino adicionado</h3>
                        <p>Crie a primeira divisão de treino para começar a montar os exercícios.</p>
                    </div>
                <?php else: ?>
                    <div class="grade-treinos">
                        <?php foreach ($treinos as $treino): ?>
                            <div class="grade-treinos">
                                <?php foreach ($treinos as $treino): ?>
                                    <div class="card treino-card">

                                        <div class="treino-card__topo">
                                            <button type="button" class="treino-card__cabecalho js-treino-accordion"
                                                aria-expanded="false">
                                                <div class="treino-card__info">
                                                    <h3 class="treino-card__titulo">
                                                        <?= htmlspecialchars($treino['titulo']) ?>
                                                    </h3>
                                                    <span class="form-hint">
                                                        <?= count($treino['exercicios']) ?> exercício(s)
                                                    </span>
                                                </div>
                                                <i class="ph ph-caret-down treino-card__chevron"></i>
                                            </button>

                                            <div class="treino-card__acoes-icones">
                                                <button type="button" class="btn btn--icone js-btn-editar-treino"
                                                    data-id="<?= $treino['id'] ?>"
                                                    data-titulo="<?= htmlspecialchars($treino['titulo']) ?>"
                                                    data-descricao="<?= htmlspecialchars($treino['descricao']) ?>"
                                                    title="Editar Treino">
                                                    <i class="ph ph-pencil-simple"></i>
                                                </button>
                                                <button type="button" class="btn btn--icone btn--icone-perigo js-btn-excluir-treino"
                                                    data-id="<?= $treino['id'] ?>" title="Excluir Treino">
                                                    <i class="ph ph-trash"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="treino-card__corpo">
                                            <div class="treino-card__conteudo">
                                                <div class="treino-card__conteudo-interno">

                                                    <?php if (!empty($treino['descricao'])): ?>
                                                        <p class="treino-card__desc">
                                                            <i class="ph ph-text-align-left"></i>
                                                            <?= nl2br(htmlspecialchars($treino['descricao'])) ?>
                                                        </p>
                                                    <?php endif; ?>
                                                    
                                                    <div class="lista-exercicios">
                                                        <?php if (empty($treino['exercicios'])): ?>
                                                            <div class="estado-vazio estado-vazio--pequeno">
                                                                <p class="form-hint">Nenhum exercício adicionado a esta divisão.</p>
                                                            </div>
                                                        <?php else: ?>
                                                            <?php foreach ($treino['exercicios'] as $ex): ?>
                                                                <div class="lista-exercicios__item">
                                                                    <div class="lista-exercicios__info">
                                                                        <div class="lista-exercicios__titulo-grupo">
                                                                            <span class="lista-exercicios__ordem">
                                                                                <?= $ex['ordem'] ?>
                                                                            </span>
                                                                            <strong class="lista-exercicios__nome">
                                                                                <?= htmlspecialchars($ex['nome']) ?>
                                                                            </strong>
                                                                        </div>
                                                                        <span class="badge badge--rascunho lista-exercicios__musculo">
                                                                            <?= htmlspecialchars($ex['musculo']) ?>
                                                                        </span>
                                                                    </div>
                                                                    <div class="lista-exercicios__params">
                                                                        <div class="param-badge param-badge--destaque"
                                                                            title="Séries e Repetições">
                                                                            <i class="ph ph-arrows-out-line-horizontal"></i>
                                                                            <span>
                                                                                <?= $ex['series'] ?>x<?= htmlspecialchars($ex['repeticoes']) ?>
                                                                            </span>
                                                                        </div>
                                                                        <div class="param-badge" title="Tempo de Descanso">
                                                                            <i class="ph ph-timer"></i>
                                                                            <span>
                                                                                <?= $ex['tempo_descanso_seg'] ?>s
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="treino-card__rodape">
                                                        <a href="<?= BASE_URL ?>/treinos/buscar-exercicios?id_treino=<?= $treino['id'] ?>"
                                                            class="btn btn--primario btn--bloco">
                                                            <i class="ph ph-plus"></i> Adicionar Exercícios
                                                        </a>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <?php require __DIR__ . '/../components/modal_adicionar_treino.php'; ?>
    <?php require __DIR__ . '/../components/modal_editar_treino.php'; ?>
    <?php require __DIR__ . '/../components/modal_excluir_treino.php'; ?>

    <script type="module" src="<?= BASE_URL ?>/assets/js/detalhes_ficha.js"></script>

</body>

</html>