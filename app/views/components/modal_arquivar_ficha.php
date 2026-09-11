<div class="modal-overlay modal-overlay--oculto" id="modal-arquivar-ficha">
    <div class="modal-box card-superficie">
        <header class="modal-box__cabecalho">
            <div class="modal-box__icone-info">
                <i class="ph ph-archive"></i>
            </div>
            <h2 class="modal-box__titulo">Arquivar Ficha</h2>
        </header>
        
        <div class="modal-box__corpo">
            <p class="texto-secundario">Deseja arquivar esta ficha? Ela não aparecerá mais na listagem principal do aluno, mas poderá ser recuperada posteriormente.</p>
        </div>
        
        <form action="/oktano/public/treinos/arquivar-ficha" method="POST" id="form-arquivar-ficha">
            <input type="hidden" name="id_ficha" id="input-id-ficha-arquivar" value="">
            <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>">
            
            <footer class="modal-box__acoes">
                <button type="submit" class="btn btn-primario modal-box__btn">Sim, arquivar</button>
                <button type="button" class="btn btn-secundario-texto js-modal-fechar-arquivar modal-box__btn">Cancelar</button>
            </footer>
        </form>
    </div>
</div>