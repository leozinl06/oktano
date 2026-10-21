<?php
if (!defined('BASE_URL')) {
    define('BASE_URL', '/oktano/public');
}
$urlRetorno = $urlAtual ?? (BASE_URL . '/treinos/detalhes?id=' . ($ficha['id'] ?? ''));
?>
<div class="modal-overlay modal-overlay--oculto" id="modal-excluir-exercicio" role="dialog" aria-modal="true" aria-labelledby="titulo-modal-excluir-exercicio">
    <div class="modal">
        <div class="modal__icone modal__icone--perigo">
            <i class="ph-bold ph-warning"></i>
        </div>
        <h3 class="modal__titulo" id="titulo-modal-excluir-exercicio">Excluir este exercício?</h3>
        <p class="modal__texto">
            Essa ação é <strong>permanente</strong>. O exercício será removido desta divisão de treino.
        </p>
        <form method="POST" action="<?= BASE_URL ?>/treinos/excluir-exercicio">
            <input type="hidden" name="id_treino_exercicio" id="excluir-exercicio-id" value="">
            <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($urlRetorno) ?>">
            <div class="modal__acoes">
                <button type="button" class="btn btn--secundario js-modal-fechar-excluir-exercicio">Cancelar</button>
                <button type="submit" class="btn btn--perigo">
                    <i class="ph ph-trash"></i>
                    Excluir
                </button>
            </div>
        </form>
    </div>
</div>