<?php
/**
 * Partial: modal_desarquivar
 * Espera (opcional): $urlRetorno — para onde redirecionar após a ação.
 * Acionado por qualquer botão com classe .js-btn-desarquivar-ficha e data-id="<id da ficha>".
 */
if (!defined('BASE_URL')) {
    define('BASE_URL', '/oktano/public');
}
$urlRetorno = $urlRetorno ?? (BASE_URL . '/treinos/arquivados');
?>
<div class="modal-overlay modal-overlay--oculto" id="modal-desarquivar-ficha" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-desarquivar">
    <div class="modal">
        <div class="modal__icone modal__icone--primario">
            <i class="ph-bold ph-arrow-counter-clockwise"></i>
        </div>
        <h3 class="modal__titulo" id="titulo-modal-desarquivar">Restaurar esta ficha?</h3>
        <p class="modal__texto">
            A ficha será movida de volta para a lista de treinos com o status de <strong>rascunho</strong>.
        </p>
        <form method="POST" action="<?= BASE_URL ?>/treinos/desarquivar-ficha">
            <input type="hidden" name="id_ficha" id="input-id-ficha-desarquivar" value="">
            <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($urlRetorno) ?>">
            <div class="modal__acoes">
                <button type="button" class="btn btn--secundario js-modal-fechar-desarquivar">Cancelar</button>
                <button type="submit" class="btn btn--primario">
                    <i class="ph ph-arrow-counter-clockwise"></i>
                    Restaurar
                </button>
            </div>
        </form>
    </div>
</div>