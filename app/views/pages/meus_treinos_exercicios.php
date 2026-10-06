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

            <!-- Cabeçalho do Treino -->
            <div class="execucao-cabecalho">
                <h1 class="execucao-cabecalho__titulo"><?= htmlspecialchars($treino['titulo']) ?></h1>
                <?php if (!empty($treino['descricao'])): ?>
                    <p class="form-hint"><?= nl2br(htmlspecialchars($treino['descricao'])) ?></p>
                <?php endif; ?>
            </div>

            <!-- Botão Iniciar Treino (Vira Cronômetro via JS) -->
            <button type="button" id="btn-iniciar-treino" class="btn btn--primario btn--bloco btn--gigante">
                <i class="ph-bold ph-play"></i> <span id="texto-iniciar">Iniciar Treino</span>
            </button>

            <!-- Lista de Exercícios -->
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
                                <!-- Métrica Descanso Clicável -->
                                <div class="metrica-box metrica-box--clicavel js-abrir-descanso" data-tempo="<?= $ex['tempo_descanso_seg'] ?>" title="Iniciar Cronômetro">
                                    <span class="metrica-box__valor"><?= $ex['tempo_descanso_seg'] ?>s</span>
                                    <span class="metrica-box__rotulo">Descanso <i class="ph-bold ph-play-circle" style="vertical-align: middle;"></i></span>
                                </div>
                                <!-- Métrica Carga -->
                                <div class="metrica-box metrica-carga" data-id-exercicio="<?= $ex['id'] ?>">
                                    <?php 
                                        // Formata a carga para remover casas decimais desnecessárias (ex: 20.00 vira 20)
                                        $cargaAtual = !empty($ex['ultima_carga']) ? (float)$ex['ultima_carga'] : 0;
                                    ?>
                                    <span class="metrica-box__valor js-valor-carga"><?= $cargaAtual ?> kg</span>
                                    
                                    <!-- Rótulo e botão agrupados e centralizados abaixo do número -->
                                    <div class="metrica-box__acoes">
                                        <span class="metrica-box__rotulo">Carga</span>
                                        <button type="button" class="btn-metrica-editar js-editar-carga is-hidden" title="Editar Carga">
                                            <i class="ph-bold ph-pencil-simple"></i>
                                        </button>
                                    </div>
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

            <!-- Botão Finalizar Treino (Oculto até iniciar) -->
            <div class="execucao-rodape">
                <button type="button" id="btn-finalizar-treino" class="btn btn--primario btn--bloco btn--gigante is-hidden">
                    <i class="ph-bold ph-check-circle"></i> Finalizar Treino
                </button>
            </div>

        </div>
    </main>

    <!-- Modal Editar Carga -->
    <div class="modal-overlay modal-overlay--oculto" id="modal-carga" role="dialog" aria-modal="true">
        <div class="modal modal--pequeno">
            <h3 class="modal__titulo">Definir Carga</h3>
            <form id="form-carga" novalidate>
                <input type="hidden" id="input-id-exercicio-carga">
                <div class="form-group">
                    <input type="number" id="input-valor-carga" class="form-input" placeholder="Ex: 20" step="0.5" required>
                    <span class="form-hint">Peso em kg utilizado nesta sessão.</span>
                </div>
                <div class="modal__acoes">
                    <button type="button" class="btn btn--secundario js-fechar-carga">Cancelar</button>
                    <button type="submit" class="btn btn--primario">Salvar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Cronômetro de Descanso -->
    <div class="modal-overlay modal-overlay--oculto" id="modal-descanso" role="dialog" aria-modal="true">
        <div class="modal modal--pequeno">
            <div class="modal__icone" style="color: var(--info); background-color: var(--info-fundo); margin-inline: auto;">
                <i class="ph-bold ph-timer"></i>
            </div>
            <h3 class="modal__titulo" style="text-align: center;">Descanso</h3>
            
            <div class="cronometro-display" id="display-descanso">00:00</div>
            
            <div class="modal__acoes" style="justify-content: center; margin-top: var(--espaco-4);">
                <button type="button" class="btn btn--secundario btn--icone js-fechar-descanso" title="Fechar" style="padding: 1rem; font-size: 1.5rem;">
                    <i class="ph-bold ph-x"></i>
                </button>
                <button type="button" class="btn btn--secundario btn--icone js-pause-descanso is-hidden" title="Pausar" style="padding: 1rem; font-size: 1.5rem;">
                    <i class="ph-bold ph-pause"></i>
                </button>
                <button type="button" class="btn btn--primario btn--icone js-play-descanso" title="Iniciar/Continuar" style="padding: 1rem; font-size: 1.5rem;">
                    <i class="ph-bold ph-play"></i>
                </button>
            </div>
        </div>
    </div>

    <script type="module" src="<?= BASE_URL ?>/assets/js/executar_treino.js"></script>
</body>
</html>