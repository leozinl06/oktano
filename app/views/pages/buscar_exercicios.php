<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require __DIR__ . '/../components/head.php'; ?>
</head>
<body>
    <?php require __DIR__ . '/../components/cabecalho.php'; ?>
    <main class="pagina">
        <div class="container">
            <a href="<?= BASE_URL ?>/treinos/detalhes?id=<?= $treino['id_ficha_treino'] ?>" class="btn btn--texto btn--pequeno" style="padding-left:0; margin-bottom: var(--espaco-3);">
                <i class="ph ph-arrow-left"></i> Voltar para a Ficha
            </a>

            <div class="pagina__cabecalho">
                <div>
                    <h1>Pesquisar para: <?= htmlspecialchars($treino['titulo']) ?></h1>
                    <?php if(!empty($treino['descricao'])): ?>
                        <p class="ficha-detalhes__texto"><?= nl2br(htmlspecialchars($treino['descricao'])) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- EXIBIÇÃO DE ALERTAS DE SUCESSO/ERRO -->
            <?php if(!empty($resultado)): ?>
            <div class="alerta alerta--<?= $resultado['sucesso'] ? 'sucesso' : 'erro' ?>" role="alert">
                <i class="ph-bold ph-<?= $resultado['sucesso'] ? 'check-circle' : 'x-circle' ?>"></i>
                <span><?= htmlspecialchars($resultado['mensagem']) ?></span>
            </div>
            <?php endif; ?>

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
                <h3>Nenhum exercício pesquisado</h3>
                <p>Digite o nome do exercício acima para buscar na base de dados.</p>
            </div>
        </div>
    </main>

    <!-- MODAL DE CONFIGURAÇÃO DO EXERCÍCIO -->
    <div class="modal-overlay modal-overlay--oculto" id="modal-configurar-exercicio" role="dialog" aria-modal="true">
        <div class="modal">
            <div class="modal__icone" style="color: var(--cor-primaria); background-color: var(--cor-primaria-clara);">
                <i class="ph-bold ph-sliders"></i>
            </div>
            <h3 class="modal__titulo" id="titulo-modal-exercicio">Configurar Exercício</h3>
            <p class="modal__texto">Defina a carga de trabalho para este exercício.</p>
            
            <form method="POST" action="<?= BASE_URL ?>/treinos/adicionar-exercicio" novalidate id="form-configurar-exercicio">
                <!-- Campos Ocultos para o Backend -->
                <input type="hidden" name="id_treino" value="<?= htmlspecialchars($treino['id']) ?>">
                <input type="hidden" name="api_id" id="modal-exercicio-api_id" value="">
                <input type="hidden" name="nome" id="modal-exercicio-nome" value="">
                <input type="hidden" name="musculo" id="modal-exercicio-musculo" value="">
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--espaco-3); text-align: left;">
                    <div class="form-group">
                        <label for="modal-series" class="form-label">Séries</label>
                        <input type="number" name="series" id="modal-series" class="form-input" placeholder="Ex: 3" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-repeticoes" class="form-label">Repetições</label>
                        <input type="text" name="repeticoes" id="modal-repeticoes" class="form-input" placeholder="Ex: 10-12" required>
                    </div>
                </div>

                <div class="form-group" style="text-align: left;">
                    <label for="modal-descanso" class="form-label">Descanso (segundos)</label>
                    <input type="number" name="descanso" id="modal-descanso" class="form-input" placeholder="Ex: 60" value="60">
                </div>
                
                <div class="form-group" style="text-align: left;">
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