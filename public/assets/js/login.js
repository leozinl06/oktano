document.addEventListener('DOMContentLoaded', () => {
    const form = document.querySelector('form');
    const inputEmail = document.getElementById('email');
    const inputSenha = document.getElementById('senha');

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

    [inputEmail, inputSenha].forEach(input => {
        input.addEventListener('input', () => {
            if(input.classList.contains('is-invalid')){
                removerErro(input);
            }
        });
    });

    form.addEventListener('submit', (e) => {
        let formularioValido = true;
        
        [inputEmail, inputSenha].forEach(removerErro);

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