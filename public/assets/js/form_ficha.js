import { configurarValidacaoGlobal } from "./validador.js";

const { definirErro, removerErro, configurarLimpezaAoDigitar } = configurarValidacaoGlobal();

const form = document.querySelector('form');
const inputTitulo = document.getElementById('titulo');
const selectStatus = document.getElementById('status');

const campos = [inputTitulo, selectStatus].filter(Boolean);

configurarLimpezaAoDigitar(campos);

if (form) {
    form.addEventListener('submit', (e) => {
        let formularioValido = true;
        campos.forEach(removerErro);

        if (inputTitulo && inputTitulo.value.trim() === '') {
            definirErro(inputTitulo, 'O título da ficha é obrigatório.');
            formularioValido = false;
        }

        if (selectStatus && selectStatus.value.trim() === '') {
            definirErro(selectStatus, 'Por favor, selecione o status da ficha.');
            formularioValido = false;
        }

        if (!formularioValido) {
            e.preventDefault();
        }
    });
}