<div class="modal-overlay is-hidden" id="modal-exclusao-ficha">
    <div class="modal-box card-superficie">
        <header class="modal-box__cabecalho">
            <div class="modal-box__icone-alerta">
                <i class="ph ph-warning"></i>
            </div>
            <h2 class="modal-box__titulo">Confirmar Exclusão</h2>
        </header>
        
        <div class="modal-box__corpo">
            <p class="texto-secundario">Tem certeza que deseja excluir esta ficha de treino? Esta ação não poderá ser desfeita.</p>
        </div>
        
        <form action="/oktano/public/treinos/excluir-ficha" method="POST" id="form-excluir-ficha">
            <input type="hidden" name="id_ficha" id="input-id-ficha-exclusao" value="">
            <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
            
            <footer class="modal-box__acoes">
                <button type="submit" class="btn btn-primario btn-primario--erro modal-box__btn">Sim, excluir</button>
                <button type="button" class="btn btn-secundario-texto js-modal-fechar modal-box__btn">Cancelar</button>
            </footer>
        </form>
    </div>
</div>