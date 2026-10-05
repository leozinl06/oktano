import { configurarValidacaoGlobal } from "./validador.js";

export function configurarDetalhesFicha() {
    const { definirErro, removerErro, configurarLimpezaAoDigitar } = configurarValidacaoGlobal();

    // ==========================================
    // 1. MODAL: ADICIONAR TREINO
    // ==========================================
    const modalAdicionar = document.getElementById('modal-adicionar-treino');
    const btnAbrirAdicionar = document.querySelector('.js-btn-adicionar-treino');
    const formAdicionar = document.getElementById('form-adicionar-treino');
    const inputTituloAdic = document.getElementById('treino-titulo');

    if (modalAdicionar && btnAbrirAdicionar && formAdicionar && inputTituloAdic) {
        configurarLimpezaAoDigitar([inputTituloAdic]);

        btnAbrirAdicionar.addEventListener('click', (e) => {
            e.preventDefault();
            modalAdicionar.classList.remove('modal-overlay--oculto');
            inputTituloAdic.focus();
        });

        document.querySelectorAll('.js-modal-fechar-adicionar-treino').forEach(btn => {
            btn.addEventListener('click', () => {
                modalAdicionar.classList.add('modal-overlay--oculto');
                formAdicionar.reset();
                removerErro(inputTituloAdic);
            });
        });

        formAdicionar.addEventListener('submit', (e) => {
            removerErro(inputTituloAdic);
            if (inputTituloAdic.value.trim() === '') {
                definirErro(inputTituloAdic, 'O título do treino é obrigatório.');
                e.preventDefault();
            }
        });
    }

    // ==========================================
    // 2. MODAL: EDITAR TREINO
    // ==========================================
    const modalEditar = document.getElementById('modal-editar-treino');
    const formEditar = document.getElementById('form-editar-treino');
    const inputIdTreinoEdit = document.getElementById('editar-treino-id');
    const inputTituloEdit = document.getElementById('editar-treino-titulo');
    const inputDescricaoEdit = document.getElementById('editar-treino-descricao');

    if (modalEditar && formEditar && inputTituloEdit) {
        configurarLimpezaAoDigitar([inputTituloEdit]);

        document.querySelectorAll('.js-btn-editar-treino').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                if (inputIdTreinoEdit) inputIdTreinoEdit.value = btn.dataset.id;
                inputTituloEdit.value = btn.dataset.titulo;
                if (inputDescricaoEdit) inputDescricaoEdit.value = btn.dataset.descricao;
                
                modalEditar.classList.remove('modal-overlay--oculto');
                inputTituloEdit.focus();
            });
        });

        document.querySelectorAll('.js-modal-fechar-editar-treino').forEach(btn => {
            btn.addEventListener('click', () => {
                modalEditar.classList.add('modal-overlay--oculto');
                formEditar.reset();
                removerErro(inputTituloEdit);
            });
        });

        formEditar.addEventListener('submit', (e) => {
            removerErro(inputTituloEdit);
            if (inputTituloEdit.value.trim() === '') {
                definirErro(inputTituloEdit, 'O título não pode ficar em branco.');
                e.preventDefault();
            }
        });
    }

    // ==========================================
    // 3. MODAL: EXCLUIR TREINO
    // ==========================================
    const modalExcluir = document.getElementById('modal-excluir-treino');
    const inputIdTreinoExcluir = document.getElementById('excluir-treino-id');

    if (modalExcluir && inputIdTreinoExcluir) {
        document.querySelectorAll('.js-btn-excluir-treino').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                inputIdTreinoExcluir.value = btn.dataset.id;
                modalExcluir.classList.remove('modal-overlay--oculto');
            });
        });

        document.querySelectorAll('.js-modal-fechar-excluir-treino').forEach(btn => {
            btn.addEventListener('click', () => {
                modalExcluir.classList.add('modal-overlay--oculto');
                inputIdTreinoExcluir.value = '';
            });
        });
    }

    // ==========================================
    // 4. LÓGICA DE FECHAMENTO GLOBAL
    // ==========================================
    document.querySelectorAll('.modal-overlay').forEach(modal => {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.classList.add('modal-overlay--oculto');
                const form = modal.querySelector('form');
                if (form) form.reset();
                modal.querySelectorAll('.is-invalid').forEach(input => removerErro(input));
            }
        });
    });

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal-overlay:not(.modal-overlay--oculto)').forEach(modal => {
                modal.classList.add('modal-overlay--oculto');
                const form = modal.querySelector('form');
                if (form) form.reset();
                modal.querySelectorAll('.is-invalid').forEach(input => removerErro(input));
            });
        }
    });

    // ==========================================
    // 5. ACORDEÃO: EXPANDIR/RECOLHER TREINOS
    // ==========================================
    const cabecalhosTreino = document.querySelectorAll('.js-treino-accordion');
    
    cabecalhosTreino.forEach(cabecalho => {
        cabecalho.addEventListener('click', () => {
            const card = cabecalho.closest('.treino-card');
            const icone = cabecalho.querySelector('.treino-card__chevron');
            
            // Alterna a classe is-open que aciona o CSS Grid
            const isAberto = card.classList.toggle('is-open');
            cabecalho.setAttribute('aria-expanded', isAberto);
            
            if (isAberto) {
                icone.classList.remove('ph-caret-down');
                icone.classList.add('ph-caret-up');
            } else {
                icone.classList.remove('ph-caret-up');
                icone.classList.add('ph-caret-down');
            }
        });
    });

    // ==========================================
    // 6. MODAL: REORDENAR TREINOS
    // ==========================================
    const modalReordenar = document.getElementById('modal-reordenar-treino');
    const btnAbrirReordenar = document.querySelector('.js-btn-reordenar-treino');
    const listaReordenar = document.getElementById('lista-reordenar-treinos');

    if (modalReordenar && btnAbrirReordenar && listaReordenar) {
        btnAbrirReordenar.addEventListener('click', (e) => {
            e.preventDefault();
            modalReordenar.classList.remove('modal-overlay--oculto');
        });

        document.querySelectorAll('.js-modal-fechar-reordenar').forEach(btn => {
            btn.addEventListener('click', () => {
                modalReordenar.classList.add('modal-overlay--oculto');
            });
        });

        listaReordenar.addEventListener('click', (e) => {
            const btnUp = e.target.closest('.js-move-up');
            const btnDown = e.target.closest('.js-move-down');
            const liItem = e.target.closest('.item-reordenavel');

            if (!liItem) return;

            // Identifica o elemento vizinho que vai trocar de lugar
            let sibling = null;
            if (btnUp && liItem.previousElementSibling) {
                sibling = liItem.previousElementSibling;
            } else if (btnDown && liItem.nextElementSibling) {
                sibling = liItem.nextElementSibling;
            }

            if (!sibling) return; // Não faz nada se já está no topo ou no fundo

            // 1. Grava as posições originais na tela antes de mover (First)
            const liRect = liItem.getBoundingClientRect();
            const siblingRect = sibling.getBoundingClientRect();

            // 2. Faz a troca no DOM instantaneamente
            if (btnUp) {
                listaReordenar.insertBefore(liItem, sibling);
            } else {
                listaReordenar.insertBefore(sibling, liItem);
            }

            // 3. Pega as novas posições após a troca (Last)
            const newLiRect = liItem.getBoundingClientRect();
            const newSiblingRect = sibling.getBoundingClientRect();

            // 4. Cria a ilusão de animação movendo os itens de volta de onde vieram e deslizando para a posição atual (Invert & Play)
            liItem.animate([
                { transform: `translateY(${liRect.top - newLiRect.top}px)` },
                { transform: 'translateY(0)' }
            ], {
                duration: 250, // Velocidade da animação em milissegundos
                easing: 'ease-in-out'
            });

            sibling.animate([
                { transform: `translateY(${siblingRect.top - newSiblingRect.top}px)` },
                { transform: 'translateY(0)' }
            ], {
                duration: 250,
                easing: 'ease-in-out'
            });
        });
    }
}

document.addEventListener('DOMContentLoaded', configurarDetalhesFicha);