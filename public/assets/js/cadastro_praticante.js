document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');

    const inputNome = document.getElementById('nome');
    const inputEmail = document.getElementById('email');
    const inputCodigoPersonal = document.getElementById('codigo_personal');

    const inputSenha = document.getElementById('senha');
    const inputConfirmarSenha = document.getElementById('confirmar-senha');

    const indicadorForca = document.getElementById('indicador-forca');
    const textoForca = document.querySelector('.forca-senha-texto');

    const alertaGlobal = document.querySelector('.alerta');

    if(alertaGlobal){
        setTimeout(() => {
            alertaGlobal.classList.add('alerta-oculto');

            setTimeout(() => {
                alertaGlobal.remove();
            }, 500);
        }, 5000);
    }

    const definirErro = (input, mensagem) => {
        input.classList.add('is-invalid');
        const spanErro = input.closest('.form-group').querySelector('.form-error-msg');
        if (spanErro) {
            spanErro.textContent = mensagem;
        }
    };

    const removerErro = (input) => {
        input.classList.remove('is-invalid');
    };

    const isEmailValido = (email) => {
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return regex.test(email);
    };

    inputSenha.addEventListener('input', () => {
        const valorSenha = inputSenha.value;
        indicadorForca.classList.remove('senha-fraca', 'senha-media', 'senha-forte');
        
        if (valorSenha.length === 0){
            textoForca.textContent = "Força da senha: -";
        } else if (valorSenha.length < 6){
            indicadorForca.classList.add('senha-fraca');
            textoForca.textContent = "Força da senha: Fraca";
        } else if (valorSenha.length >= 6 && valorSenha.length < 10){
            indicadorForca.classList.add('senha-media');
            textoForca.textContent = "Força da senha: Média";
        } else {
            indicadorForca.classList.add('senha-forte');
            textoForca.textContent = "Força senha: Forte";
        }
    });

    [inputNome, inputEmail, inputSenha, inputConfirmarSenha, inputCodigoPersonal].forEach(input => {
        input.addEventListener('input', () => {
            if(input.classList.contains('is-invalid')){
                removerErro(input);
            }
        });
    });

    form.addEventListener('submit', (e) => {
        let formularioValido = true;
        
        [inputNome, inputEmail, inputSenha, inputConfirmarSenha, inputCodigoPersonal].forEach(removerErro);

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