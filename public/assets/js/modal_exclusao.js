export function configurarModalExclusao(){
    const modalOverlay = document.getElementById('modal-exclusao-ficha');
    const botoesExcluir = document.querySelectorAll('.js-btn-excluir-ficha');
    const botoesFechar = document.querySelectorAll('.js-modal-fechar');
    const inputIdFicha = document.getElementById('input-id-ficha-exclusao');

    if (!modalOverlay) return;

    const fecharModal = () => {
        modalOverlay.classList.add('modal-overlay--oculto');
        if(inputIdFicha) inputIdFicha.value = '';
    };

    const abrirModal = (id) => {
        if(inputIdFicha) inputIdFicha.value = id;
        modalOverlay.classList.remove('modal-overlay--oculto');
    };

    botoesExcluir.forEach(botao => {
        botao.addEventListener('click', (e) => {
            e.preventDefault();
            const idFicha = botao.dataset.id;
            if(idFicha) abrirModal(idFicha);
        });
    });

    botoesFechar.forEach(botao => {
        botao.addEventListener('click', fecharModal);
    });

    modalOverlay.addEventListener('click', (e) => {
        if(e.target === modalOverlay) fecharModal();
    });

    document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape' && !modalOverlay.classList.contains('modal-overlay--oculto')){
            fecharModal();
        }
    });
}

document.addEventListener('DOMContentLoaded', configurarModalExclusao);