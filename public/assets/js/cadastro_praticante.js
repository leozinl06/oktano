import { configurarValidacaoGlobal } from "./validador";

document.addEventListener('DOMContentLoaded', () => {
    const { definirErro, removerErro, isEmailValido, configurarForcaSenha, configurarLimpezaAoDigitar } = configurarValidacaoGlobal();

    const form = document.querySelector('form');

    const inputNome = document.getElementById('nome');
    const inputEmail = document.getElementById('email');
    const inputCodigoPersonal = document.getElementById('codigo_personal');

    const inputSenha = document.getElementById('senha');
    const inputConfirmarSenha = document.getElementById('confirmar-senha');

    const indicadorForca = document.getElementById('indicador-forca');
    const textoForca = document.querySelector('.forca-senha-texto');

    const campos = [inputNome, inputEmail, inputSenha, inputConfirmarSenha, inputCodigoPersonal];

    configurarForcaSenha(inputSenha, indicadorForca, textoForca);
    configurarLimpezaAoDigitar(campos);

    form.addEventListener('submit', (e) => {
        let formularioValido = true;
        
        campos.forEach(removerErro);

        if (inputNome.value.trim() === ''){
            definirErro(inputNome, 'O nome é obrigatório para o cadastro.');
            formularioValido = false;
        }

        if(inputEmail.value.trim() === ''){
            definirErro(inputEmail, 'O e-mail é obrigatório para o cadastro.');
            formularioValido = false;
        } else if(!isEmailValido(inputEmail.value.trim())){
            definirErro(inputEmail, 'O formato do e-mail parece inválido (ex: seu@email.com).');
            formularioValido = false;
        }

        const regexCodigo = /^[a-zA-Z0-9]{6}$/; 
        if(inputCodigoPersonal.value.trim() === ''){
            definirErro(inputCodigoPersonal, 'O código fornecido pelo Personal é obrigatório.');
            formularioValido = false;
        } else if (!regexCodigo.test(inputCodigoPersonal.value.trim())){
            definirErro(inputCodigoPersonal, 'O código deve conter exatamente 6 caracteres (apenas letras e números).');
            formularioValido = false;
        }

        if (inputSenha.value.trim() === ''){
            definirErro(inputSenha, 'Você precisa criar uma senha de acesso.');
            formularioValido = false;
        } else if(inputSenha.value.length < 8){
            definirErro(inputSenha, 'Por segurança, sua senha deve ter no mínimo 8 caracteres.');
            formularioValido = false;
        }

        if (inputConfirmarSenha.value.trim() === ''){
            definirErro(inputConfirmarSenha, 'Por favor, confirme sua senha.');
            formularioValido = false;
        } else if(inputConfirmarSenha.value.trim() !== inputSenha.value){
            definirErro(inputConfirmarSenha, 'As senhas não coincidem. Digite novamente.');
            formularioValido = false;
        }

        if (!formularioValido){
            e.preventDefault();
        }
    });
});