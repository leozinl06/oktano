<?php 
if (!defined('BASE_URL')) {
    define('BASE_URL', '/oktano/public');
}
$urlRetorno = $urlAtual ?? (BASE_URL . '/treinos/detalhes?id=' . ($ficha['id'] ?? ''));
?>
<div class="modal-overlay modal-overlay--oculto" id="modal-reordenar-exercicios" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-reordenar-exercicios">
    <div class="modal">
        <div class="modal__icone modal__icone--primario">
            <i class="ph-bold ph-list-numbers"></i>
        </div>
        <h3 class="modal__titulo" id="titulo-modal-reordenar-exercicios">Reordenar Exercícios</h3>
        <p class="modal__texto" id="subtitulo-modal-reordenar-exercicios">
            Use as setas para ajustar a ordem de execução dos exercícios.
        </p>

        <form method="POST" action="<?= BASE_URL ?>/treinos/reordenar-exercicios" id="form-reordenar-exercicios">
            <input type="hidden" name="id_ficha" value="<?= htmlspecialchars($ficha['id'] ?? '') ?>">
            <input type="hidden" name="id_treino" id="reordenar-exercicios-id-treino" value="">
            <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($urlRetorno) ?>">

            <ul id="lista-reordenar-exercicios" class="lista-reordenavel"></ul>

            <div class="modal__acoes">
                <button type="button" class="btn btn--secundario js-modal-fechar-reordenar-exercicios">Cancelar</button>
                <button type="submit" class="btn btn--primario">
                    <i class="ph ph-check"></i> Salvar Ordem
                </button>
            </div>
        </form>
    </div>
</div>