<?php
// Partial: modal_adicionar_treino
// Espera: $ficha (array contendo os dados da ficha) e opcional $urlAtual

if(!defined('BASE_URL')){
    define('BASE_URL', '/oktano/public');
}
$urlRetorno = $urlAtual ?? (BASE_URL . '/treinos/detalhes?id=' . ($ficha['id'] ?? ''));
?>
<div class="modal-overlay modal-overlay--oculto" id="modal-adicionar-treino" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-adicionar-treino">
    <div class="modal">
        <div class="modal__icone" style="color: var(--cor-primaria); background-color: var(--cor-primaria-clara);">
            <i class="ph-bold ph-plus"></i>
        </div>
        <h3 class="modal__titulo" id="titulo-modal-adicionar-treino">Adicionar Novo Treino</h3>
        <p class="modal__texto">
            Crie uma nova divisão de treino para esta ficha (Ex: Costas e Bíceps).
        </p>
        
        <form method="POST" action="<?= BASE_URL ?>/treinos/adicionar-treino" novalidate id="form-adicionar-treino">
            <input type="hidden" name="id_ficha" value="<?= htmlspecialchars($ficha['id'] ?? '') ?>">
            <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($urlRetorno) ?>">
            
            <div class="form-group" style="text-align: left;">
                <label for="treino-titulo" class="form-label">Título do treino</label>
                <input type="text" name="titulo" id="treino-titulo" class="form-input" placeholder="Ex.: Treino A">
                <span class="form-error-msg"></span>
            </div>
            
            <div class="form-group" style="text-align: left;">
                <label for="treino-descricao" class="form-label">Descrição <span class="opcional">(opcional)</span></label>
                <textarea name="descricao" id="treino-descricao" class="form-textarea" placeholder="Foco principal, técnica utilizada..."></textarea>
            </div>
            
            <div class="modal__acoes">
                <button type="button" class="btn btn--secundario js-modal-fechar-adicionar-treino">Cancelar</button>
                <button type="submit" class="btn btn--primario">
                    <i class="ph ph-check"></i>
                    Salvar Treino
                </button>
            </div>
        </form>
    </div>
</div>