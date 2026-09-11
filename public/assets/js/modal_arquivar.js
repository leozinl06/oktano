export function configurarModalArquivar(){
    const modalOverlay = document.getElementById('modal-arquivar-ficha');
    const botoesArquivar = document.querySelectorAll('.js-btn-arquivar-ficha');
    const botoesFechar = document.querySelectorAll('.js-modal-fechar-arquivar');
    const inputIdFicha = document.getElementById('input-id-ficha-arquivar');

    if (!modalOverlay) return;

    const fecharModal = () => {
        modalOverlay.classList.add('modal-overlay--oculto');
        if (inputIdFicha) inputIdFicha.value = '';
    };

    const abrirModal = (id) => {
        if (inputIdFicha) inputIdFicha.value = id;
        modalOverlay.classList.remove('modal-overlay--oculto');
    };

    botoesArquivar.forEach(botao => {
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

document.addEventListener('DOMContentLoaded', configurarModalArquivar);