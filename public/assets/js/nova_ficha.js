import { configurarValidacaoGlobal } from "./validador.js";

const {definirErro, removerErro, configurarLimpezaAoDigitar} = configurarValidacaoGlobal();

const form = document.querySelector('form');
const inputTitulo = document.getElementById('titulo');

const campos = [inputTitulo, selectStatus];

configurarLimpezaAoDigitar(campos);

if(form){
    form.addEventListener('submit', (e) => {
        let formularioValido = true;

        campos.forEach(removerErro);

        if (inputTitulo.value.trim() === '') {
            definirErro(inputTitulo, 'O título da ficha é obrigatório.');
            formularioValido = false;
        }

        if (!formularioValido) {
            e.preventDefault();
        }
    });
}