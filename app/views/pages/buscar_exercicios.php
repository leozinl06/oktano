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
                <a href="<?= BASE_URL ?>/treinos/detalhes?id=<?= $treino['id_ficha_treino'] ?>" class="btn btn--texto btn--pequeno ficha-voltar__btn">
                    <i class="ph ph-arrow-left"></i> Voltar para a Ficha
                </a>
            </div>

            <?php if (!empty($resultado)): ?>
            <div class="alerta alerta--<?= $resultado['sucesso'] ? 'sucesso' : 'erro' ?>" role="alert">
                <i class="ph-bold ph-<?= $resultado['sucesso'] ? 'check-circle' : 'x-circle' ?>"></i>
                <span><?= htmlspecialchars($resultado['mensagem']) ?></span>
            </div>
            <?php endif; ?>

            <div class="pagina__cabecalho">
                <div>
                    <?php if (!empty($exercicioPai)): ?>
                        <span class="badge badge--alternativo">
                            <i class="ph-bold ph-arrows-left-right"></i> Vinculando Exercício Alternativo
                        </span>
                        <h1>Alternativo para: <?= htmlspecialchars($exercicioPai['nome_principal']) ?></h1>
                        <p class="ficha-detalhes__texto">Treino: <?= htmlspecialchars($treino['titulo']) ?></p>
                    <?php else: ?>
                        <h1>Pesquisar para: <?= htmlspecialchars($treino['titulo']) ?></h1>
                        <?php if (!empty($treino['descricao'])): ?>
                            <p class="ficha-detalhes__texto"><?= nl2br(htmlspecialchars($treino['descricao'])) ?></p>
                        <?php endif; ?>
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

            <div class="grade-busca-exercicios" id="grade-resultados"></div>
            
            <div id="estado-vazio-api" class="card estado-vazio">
                <i class="ph ph-barbell"></i>
                <h3 id="estado-vazio-titulo">Nenhum exercício pesquisado</h3>
                <p id="estado-vazio-texto">Digite o nome do exercício acima para buscar na base de dados.</p>
                <div id="estado-vazio-acoes" class="estado-vazio__acoes is-hidden">
                    <button type="button" class="btn btn--primario" id="btn-criar-exercicio-customizado">
                        <i class="ph ph-plus"></i> Criar Exercício Customizado
                    </button>
                </div>
            </div>
        </div>
    </main>

    <!-- MODAL 1: CRIAR EXERCÍCIO CUSTOMIZADO -->
    <div class="modal-overlay modal-overlay--oculto" id="modal-exercicio-customizado" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-customizado">
        <div class="modal">
            <div class="modal__icone modal__icone--primario">
                <i class="ph-bold ph-barbell"></i>
            </div>
            <h3 class="modal__titulo" id="titulo-modal-customizado">Criar Exercício Customizado</h3>
            <p class="modal__texto">Informe os dados básicos do exercício para continuar com a prescrição.</p>

            <form id="form-exercicio-customizado" novalidate>
                <div class="form-group form-group--esquerda">
                    <label for="custom-exercicio-nome" class="form-label">Nome do exercício</label>
                    <input type="text" id="custom-exercicio-nome" class="form-input" placeholder="Ex: Elevação pélvica na máquina" required>
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group form-group--esquerda">
                    <label for="custom-exercicio-musculo" class="form-label">Músculo alvo / Grupo muscular</label>
                    <input type="text" id="custom-exercicio-musculo" class="form-input" placeholder="Ex: Glúteos" required>
                    <span class="form-error-msg"></span>
                </div>

                <div class="modal__acoes">
                    <button type="button" class="btn btn--secundario js-modal-fechar-customizado">Cancelar</button>
                    <button type="submit" class="btn btn--primario">
                        Continuar <i class="ph ph-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: CONFIGURAÇÃO DE CARGA DE TRABALHO DO EXERCÍCIO -->
    <div class="modal-overlay modal-overlay--oculto" id="modal-configurar-exercicio" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-exercicio">
        <div class="modal">
            <div class="modal__icone modal__icone--primario">
                <i class="ph-bold ph-sliders"></i>
            </div>
            <h3 class="modal__titulo" id="titulo-modal-exercicio">Configurar Exercício</h3>
            <p class="modal__texto">Defina a carga de trabalho para este exercício.</p>
            
            <form method="POST" action="<?= BASE_URL ?>/treinos/adicionar-exercicio" novalidate id="form-configurar-exercicio">
                <input type="hidden" name="id_treino" value="<?= htmlspecialchars($treino['id']) ?>">
                <input type="hidden" name="id_treino_exercicio" value="<?= htmlspecialchars($exercicioPai['id'] ?? '') ?>">
                <input type="hidden" name="api_id" id="modal-exercicio-api_id" value="">
                <input type="hidden" name="nome" id="modal-exercicio-nome" value="">
                <input type="hidden" name="musculo" id="modal-exercicio-musculo" value="">
                
                <div class="form-grid-duplo">
                    <div class="form-group">
                        <label for="modal-series" class="form-label">Séries</label>
                        <input type="number" name="series" id="modal-series" class="form-input" placeholder="Ex: 3" required>
                        <span class="form-error-msg"></span>
                    </div>
                    <div class="form-group">
                        <label for="modal-repeticoes" class="form-label">Repetições</label>
                        <input type="text" name="repeticoes" id="modal-repeticoes" class="form-input" placeholder="Ex: 10-12" required>
                        <span class="form-error-msg"></span>
                    </div>
                </div>

                <div class="form-group form-group--esquerda">
                    <label for="modal-descanso" class="form-label">Descanso (segundos)</label>
                    <input type="number" name="descanso" id="modal-descanso" class="form-input" placeholder="Ex: 60" value="60">
                    <span class="form-error-msg"></span>
                </div>
                
                <div class="form-group form-group--esquerda">
                    <label for="modal-observacoes" class="form-label">Observações <span class="opcional">(opcional)</span></label>
                    <textarea name="observacoes" id="modal-observacoes" class="form-textarea" placeholder="Dicas de execução, cadência..."></textarea>
                </div>
                
                <div class="modal__acoes">
                    <button type="button" class="btn btn--secundario js-modal-fechar-configurar">Cancelar</button>
                    <button type="submit" class="btn btn--primario">
                        <i class="ph ph-plus"></i> Salvar no Treino
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script type="module" src="<?= BASE_URL ?>/assets/js/buscar_exercicios.js"></script>
</body>
</html>