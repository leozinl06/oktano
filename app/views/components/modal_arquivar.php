<?php
/**
 * Partial: modal_arquivar
 * Espera (opcional): $urlRetorno — para onde redirecionar após a ação.
 * Acionado por qualquer botão com classe .js-btn-arquivar-ficha e data-id="<id da ficha>".
 * Lógica de abrir/fechar em public/assets/js/modal_arquivar.js
 */
if(!defined('BASE_URL')){
    define('BASE_URL', '/oktano/public');
}
$urlRetorno = $urlRetorno ?? (BASE_URL . '/treinos');
?>
<div class="modal-overlay modal-overlay--oculto" id="modal-arquivar-ficha" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-arquivar">
    <div class="modal">
        <div class="modal__icone modal__icone--aviso">
            <i class="ph-bold ph-archive"></i>
        </div>
        <h3 class="modal__titulo" id="titulo-modal-arquivar">Arquivar esta ficha?</h3>
        <p class="modal__texto">
            A ficha será movida para a lista de arquivados e deixará de aparecer para o aluno.
            Você pode restaurá-la para rascunho quando quiser.
        </p>

        <form method="POST" action="<?= BASE_URL ?>/treinos/arquivar-ficha">
            <input type="hidden" name="id_ficha" id="input-id-ficha-arquivar" value="">
            <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($urlRetorno) ?>">

            <div class="modal__acoes">
                <button type="button" class="btn btn--secundario js-modal-fechar-arquivar">Cancelar</button>
                <button type="submit" class="btn btn--primario">
                    <i class="ph ph-archive"></i>
                    Arquivar
                </button>
            </div>
        </form>
    </div>
</div>
