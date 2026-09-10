import { configurarValidacaoGlobal } from "./validador.js";

const {definirErro, removerErro, isEmailValido, configurarForcaSenha, configurarLimpezaAoDigitar} = configurarValidacaoGlobal();

const form = document.querySelector('form');
const inputNome = document.getElementById('nome');
const inputEmail = document.getElementById('email');
const inputSenha = document.getElementById('senha');
const inputConfirmarSenha = document.getElementById('confirmar-senha');

const indicadorForca = document.getElementById('indicador-forca');
const textoForca = document.querySelector('.forca-senha-texto');

const campos = [inputNome, inputEmail, inputSenha, inputConfirmarSenha];

configurarForcaSenha(inputSenha, indicadorForca, textoForca);
configurarLimpezaAoDigitar(campos);

form.addEventListener('submit', (e) => {
    let formularioValido = true;
    
    campos.forEach(removerErro); 

    if (inputNome.value.trim() === '') {
        definirErro(inputNome, 'O nome é obrigatório.');
        formularioValido = false;
    }

    if (inputEmail.value.trim() === '') {
        definirErro(inputEmail, 'O e-mail é obrigatório.');
        formularioValido = false;
    } else if(!isEmailValido(inputEmail.value.trim())) {
        definirErro(inputEmail, 'Formato de e-mail inválido.');
        formularioValido = false;
    }

    if (inputSenha.value.trim() === '') {
        definirErro(inputSenha, 'A senha é obrigatória.');
        formularioValido = false;
    } else if(inputSenha.value.length < 8) {
        definirErro(inputSenha, 'A senha deve ter no mínimo 8 caracteres.');
        formularioValido = false;
    }

    if (inputConfirmarSenha.value.trim() === '') {
        definirErro(inputConfirmarSenha, 'Por favor, confirme sua senha.');
        formularioValido = false;
    } else if(inputConfirmarSenha.value.trim() !== inputSenha.value) {
        definirErro(inputConfirmarSenha, 'As senhas não coincidem.');
        formularioValido = false;
    }

    if (!formularioValido) {
        e.preventDefault();
    }
});