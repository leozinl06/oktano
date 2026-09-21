export function configurarModalSair() {
    const modalOverlay = document.getElementById('modal-sair');
    const botaoSair = document.querySelector('.js-btn-abrir-sair');
    const botaoFechar = document.querySelector('.js-modal-fechar-sair');

    if (!modalOverlay || !botaoSair) return;

    const fecharModal = () => {
        modalOverlay.classList.add('modal-overlay--oculto');
    };

    const abrirModal = () => {
        modalOverlay.classList.remove('modal-overlay--oculto');
    };

    botaoSair.addEventListener('click', (e) => {
        e.preventDefault();
        abrirModal();
    });

    if (botaoFechar) {
        botaoFechar.addEventListener('click', fecharModal);
    }

    modalOverlay.addEventListener('click', (e) => {
        if (e.target === modalOverlay) fecharModal();
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !modalOverlay.classList.contains('modal-overlay--oculto')) {
            fecharModal();
        }
    });
}

document.addEventListener('DOMContentLoaded', configurarModalSair);