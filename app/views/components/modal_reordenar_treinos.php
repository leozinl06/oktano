<?php 
if(!defined('BASE_URL')){ define('BASE_URL', '/oktano/public'); }
$urlRetorno = $urlAtual ?? (BASE_URL . '/treinos/detalhes?id=' . ($ficha['id'] ?? ''));
?>
<div class="modal-overlay modal-overlay--oculto" id="modal-reordenar-treino" role="dialog" aria-modal="true">
    <div class="modal">
        <div class="modal__icone" style="color: var(--cor-primaria); background-color: var(--cor-primaria-clara);">
            <i class="ph-bold ph-list-numbers"></i>
        </div>
        <h3 class="modal__titulo">Reordenar Treinos</h3>
        <p class="modal__texto">Use as setas para ajustar a ordem de execução dos treinos.</p>

        <form method="POST" action="<?= BASE_URL ?>/treinos/reordenar" id="form-reordenar-treino">
            <input type="hidden" name="id_ficha" value="<?= htmlspecialchars($ficha['id'] ?? '') ?>">
            <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($urlRetorno) ?>">

            <ul id="lista-reordenar-treinos" style="list-style: none; padding: 0; margin: var(--espaco-3) 0; display: flex; flex-direction: column; gap: var(--espaco-2);">
                <?php if(!empty($treinos)): ?>
                    <?php foreach($treinos as $treino): ?>
                        <li class="card item-reordenavel" style="display: flex; justify-content: space-between; align-items: center; padding: var(--espaco-2) var(--espaco-3);">
                            <input type="hidden" name="treinos_ordem[]" value="<?= $treino['id'] ?>">
                            <strong style="text-align: left; flex: 1;"><?= htmlspecialchars($treino['titulo']) ?></strong>
                            
                            <div style="display: flex; gap: 4px;">
                                <button type="button" class="btn btn--icone js-move-up" aria-label="Mover para cima">
                                    <i class="ph-bold ph-caret-up"></i>
                                </button>
                                <button type="button" class="btn btn--icone js-move-down" aria-label="Mover para baixo">
                                    <i class="ph-bold ph-caret-down"></i>
                                </button>
                            </div>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>

            <div class="modal__acoes">
                <button type="button" class="btn btn--secundario js-modal-fechar-reordenar">Cancelar</button>
                <button type="submit" class="btn btn--primario">
                    <i class="ph ph-check"></i> Salvar Ordem
                </button>
            </div>
        </form>
    </div>
</div>