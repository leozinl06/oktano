<?php
/**
 * Partial: modal_sair
 * Modal de confirmação para evitar logout acidental.
 */
if(!defined('BASE_URL')){
    define('BASE_URL', '/oktano/public');
}
?>
<div class="modal-overlay modal-overlay--oculto" id="modal-sair" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-sair">
    <div class="modal">
        <div class="modal__icone modal__icone--aviso">
            <i class="ph-bold ph-sign-out"></i>
        </div>
        <h3 class="modal__titulo" id="titulo-modal-sair">Deseja realmente sair?</h3>
        <p class="modal__texto">
            Sua sessão atual será encerrada e você precisará fazer login novamente para acessar a plataforma.
        </p>
        <div class="modal__acoes">
            <button type="button" class="btn btn--secundario js-modal-fechar-sair">Cancelar</button>
            <a href="<?= BASE_URL ?>/logout" class="btn btn--perigo">
                <i class="ph ph-sign-out"></i>
                Sair
            </a>
        </div>
    </div>
</div>