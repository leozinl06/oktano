import { vincularModalAcao } from "./modal.js";

document.addEventListener('DOMContentLoaded', () => {
    vincularModalAcao({
        idModal: 'modal-sair',
        seletorAbrir: '.js-btn-abrir-sair',
        seletorFechar: '.js-modal-fechar-sair'
    });
});