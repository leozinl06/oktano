function vincularModalFicha({ idModal, seletorAbrir, seletorFechar, idInput }) {
    const modalOverlay = document.getElementById(idModal);
    const botoesAbrir = document.querySelectorAll(seletorAbrir);
    const botoesFechar = document.querySelectorAll(seletorFechar);
    const inputIdFicha = document.getElementById(idInput);

    if (!modalOverlay) return;

    const fecharModal = () => {
        modalOverlay.classList.add('modal-overlay--oculto');
        if (inputIdFicha) inputIdFicha.value = '';
    };

    const abrirModal = (id) => {
        if (inputIdFicha) inputIdFicha.value = id;
        modalOverlay.classList.remove('modal-overlay--oculto');
    };

    botoesAbrir.forEach(botao => {
        botao.addEventListener('click', (e) => {
            e.preventDefault();
            const idFicha = botao.dataset.id;
            if (idFicha) abrirModal(idFicha);
        });
    });

    botoesFechar.forEach(botao => {
        botao.addEventListener('click', fecharModal);
    });

    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) fecharModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modalOverlay.classList.contains('modal-overlay--oculto')) {
            fecharModal();
        }
    });
}

export function configurarModalArquivar() {
    vincularModalFicha({
        idModal: 'modal-arquivar-ficha',
        seletorAbrir: '.js-btn-arquivar-ficha',
        seletorFechar: '.js-modal-fechar-arquivar',
        idInput: 'input-id-ficha-arquivar'
    });

    vincularModalFicha({
        idModal: 'modal-desarquivar-ficha',
        seletorAbrir: '.js-btn-desarquivar-ficha',
        seletorFechar: '.js-modal-fechar-desarquivar',
        idInput: 'input-id-ficha-desarquivar'
    });
}

document.addEventListener('DOMContentLoaded', configurarModalArquivar);