<?php
/**
 * Partial: modal_excluir
 * Espera (opcional): $urlRetorno — para onde redirecionar após a ação.
 * Acionado por qualquer botão com classe .js-btn-excluir-ficha e data-id="<id da ficha>".
 * Lógica de abrir/fechar em public/assets/js/modal_exclusao.js
 */
if(!defined('BASE_URL')){
    define('BASE_URL', '/oktano/public');
}
$urlRetorno = $urlRetorno ?? (BASE_URL . '/treinos');
?>
<div class="modal-overlay modal-overlay--oculto" id="modal-exclusao-ficha" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-exclusao">
    <div class="modal">
        <div class="modal__icone modal__icone--perigo">
            <i class="ph-bold ph-warning"></i>
        </div>
        <h3 class="modal__titulo" id="titulo-modal-exclusao">Excluir esta ficha?</h3>
        <p class="modal__texto">
            Essa ação é <strong>permanente</strong> e não pode ser desfeita. Todo o histórico
            associado a esta ficha será perdido.
        </p>

        <form method="POST" action="<?= BASE_URL ?>/treinos/excluir-ficha">
            <input type="hidden" name="id_ficha" id="input-id-ficha-exclusao" value="">
            <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($urlRetorno) ?>">

            <div class="modal__acoes">
                <button type="button" class="btn btn--secundario js-modal-fechar">Cancelar</button>
                <button type="submit" class="btn btn--perigo">
                    <i class="ph ph-trash"></i>
                    Excluir
                </button>
            </div>
        </form>
    </div>
</div>
