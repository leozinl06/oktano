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
}

document.addEventListener('DOMContentLoaded', configurarDetalhesFicha);