<?php
if(!defined('BASE_URL')){ define('BASE_URL', '/oktano/public'); }
$urlRetorno = $urlAtual ?? (BASE_URL . '/treinos/detalhes?id=' . ($ficha['id'] ?? ''));
?>
<div class="modal-overlay modal-overlay--oculto" id="modal-editar-treino" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-editar-treino">
    <div class="modal">
        <div class="modal__icone" style="color: var(--cor-primaria); background-color: var(--cor-primaria-clara);">
            <i class="ph-bold ph-pencil-simple"></i>
        </div>
        <h3 class="modal__titulo" id="titulo-modal-editar-treino">Editar Treino</h3>
        <p class="modal__texto">
            Altere o título ou a descrição desta divisão de treino.
        </p>
        
        <form method="POST" action="<?= BASE_URL ?>/treinos/editar-treino" novalidate id="form-editar-treino">
            <input type="hidden" name="id_treino" id="editar-treino-id" value="">
            <input type="hidden" name="id_ficha" value="<?= htmlspecialchars($ficha['id'] ?? '') ?>">
            <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($urlRetorno) ?>">
            
            <div class="form-group" style="text-align: left;">
                <label for="editar-treino-titulo" class="form-label">Título do treino</label>
                <input type="text" name="titulo" id="editar-treino-titulo" class="form-input" placeholder="Ex.: Treino A">
                <span class="form-error-msg"></span>
            </div>
            
            <div class="form-group" style="text-align: left;">
                <label for="editar-treino-descricao" class="form-label">Descrição <span class="opcional">(opcional)</span></label>
                <textarea name="descricao" id="editar-treino-descricao" class="form-textarea" placeholder="Foco principal, técnica utilizada..."></textarea>
            </div>
            
            <div class="modal__acoes">
                <button type="button" class="btn btn--secundario js-modal-fechar-editar-treino">Cancelar</button>
                <button type="submit" class="btn btn--primario">
                    <i class="ph ph-check"></i>
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>