import { configurarValidacaoGlobal } from "./validador";

document.addEventListener('DOMContentLoaded', () => {
    const {definirErro, removerErro, isEmailValido, configurarLimpezaAoDigitar} = configurarValidacaoGlobal();

    const form = document.querySelector('form');
    const inputEmail = document.getElementById('email');
    const inputSenha = document.getElementById('senha');

    const campos = [inputEmail, inputSenha];

    configurarLimpezaAoDigitar(campos);

    form.addEventListener('submit', (e) => {
        let formularioValido = true;
        
        campos.forEach(removerErro);

        if(inputEmail.value.trim() === ''){
            definirErro(inputEmail, 'O e-mail é obrigatório para acessar.');
            formularioValido = false;
        } else if(!isEmailValido(inputEmail.value.trim())){
            definirErro(inputEmail, 'Insira um formato de e-mail válido.');
            formularioValido = false;
        }

        if (inputSenha.value.trim() === ''){
            definirErro(inputSenha, 'A senha é obrigatória.');
            formularioValido = false;
        }

        if (!formularioValido){
            e.preventDefault();
        }
    });
});