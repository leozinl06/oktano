export function vincularModalAcao({ idModal, seletorAbrir, seletorFechar, idInput = null }) {
    const modalOverlay = document.getElementById(idModal);
    const botoesAbrir = document.querySelectorAll(seletorAbrir);
    const botoesFechar = document.querySelectorAll(seletorFechar);
    const inputId = idInput ? document.getElementById(idInput) : null;

    if (!modalOverlay || botoesAbrir.length === 0) return;

    const fecharModal = () => {
        modalOverlay.classList.add('modal-overlay--oculto');
        if (inputId) inputId.value = '';
    };

    const abrirModal = (id = '') => {
        if (inputId) inputId.value = id;
        modalOverlay.classList.remove('modal-overlay--oculto');
    };

    botoesAbrir.forEach(botao => {
        botao.addEventListener('click', (e) => {
            e.preventDefault();
            abrirModal(botao.dataset.id ?? '');
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