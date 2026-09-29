import { configurarValidacaoGlobal } from "./validador.js";

export function configurarDetalhesFicha(){
    const { definirErro, removerErro, configurarLimpezaAoDigitar } = configurarValidacaoGlobal();

    const modalAdicionar = document.getElementById('modal-adicionar-treino');
    const btnAbrirAdicionar = document.querySelector('.js-btn-adicionar-treino');
    const botoesFecharAdicionar = document.querySelectorAll('.js-modal-fechar-adicionar-treino');
    const formAdicionar = document.getElementById('form-adicionar-treino');
    const inputTitulo = document.getElementById('treino-titulo');

    if(modalAdicionar && btnAbrirAdicionar){
        configurarLimpezaAoDigitar([inputTitulo]);

        const fecharModalAdicionar = () => {
            modalAdicionar.classList.add('modal-overlay--oculto');
            formAdicionar.reset();
            removerErro(inputTitulo); 
        };

        btnAbrirAdicionar.addEventListener('click', (e) => {
            e.preventDefault();
            modalAdicionar.classList.remove('modal-overlay--oculto');
            inputTitulo.focus();
        });

        botoesFecharAdicionar.forEach(btn => btn.addEventListener('click', fecharModalAdicionar));

        modalAdicionar.addEventListener('click', (e) => {
            if(e.target === modalAdicionar) fecharModalAdicionar();
        });

        document.addEventListener('keydown', (e) => {
            if(e.key === 'Escape' && !modalAdicionar.classList.contains('modal-overlay--oculto')){
                fecharModalAdicionar();
            }
        });

        formAdicionar.addEventListener('submit', (e) => {
            let valido = true;
            removerErro(inputTitulo);

            if(inputTitulo.value.trim() === ''){
                definirErro(inputTitulo, 'O título do treino é obrigatório.');
                valido = false;
            }

            if(!valido){
                e.preventDefault();
            }
        });
    }
}

document.addEventListener('DOMContentLoaded', configurarDetalhesFicha);