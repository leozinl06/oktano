import { configurarValidacaoGlobal } from "./validador.js";
import { vincularModalAcao } from "./modal.js";

document.addEventListener('DOMContentLoaded', () => {
    configurarValidacaoGlobal();

    vincularModalAcao({
        idModal: 'modal-arquivar-ficha',
        seletorAbrir: '.js-btn-arquivar-ficha',
        seletorFechar: '.js-modal-fechar-arquivar',
        idInput: 'input-id-ficha-arquivar'
    });

    vincularModalAcao({
        idModal: 'modal-desarquivar-ficha',
        seletorAbrir: '.js-btn-desarquivar-ficha',
        seletorFechar: '.js-modal-fechar-desarquivar',
        idInput: 'input-id-ficha-desarquivar'
    });

    vincularModalAcao({
        idModal: 'modal-exclusao-ficha',
        seletorAbrir: '.js-btn-excluir-ficha',
        seletorFechar: '.js-modal-fechar',
        idInput: 'input-id-ficha-exclusao'
    });
});