export function configurarValidacaoGlobal() {
    const alertaGlobal = document.querySelector('.alerta');
    if(alertaGlobal){
        setTimeout(() => {
            alertaGlobal.classList.add('alerta-oculto');
            setTimeout(() => alertaGlobal.remove(), 500);
        }, 5000);
    }

    const definirErro = (input, mensagem) => {
        input.classList.add('is-invalid');
        const spanErro = input.closest('.form-group').querySelector('.form-error-msg');
        if (spanErro) spanErro.textContent = mensagem;
    };

    const removerErro = (input) => input.classList.remove('is-invalid');

    const isEmailValido = (email) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);

    const configurarLimpezaAoDigitar = (inputs) => {
        inputs.forEach(input => {
            if(input) {
                input.addEventListener('input', () => {
                    if(input.classList.contains('is-invalid')) removerErro(input);
                });
            }
        });
    };

    const configurarForcaSenha = (inputSenha, indicadorForca, textoForca) => {
        if(!inputSenha || !indicadorForca) return;
        inputSenha.addEventListener('input', () => {
            const valor = inputSenha.value;
            indicadorForca.classList.remove('senha-fraca', 'senha-media', 'senha-forte');
            
            if (valor.length === 0){
                textoForca.textContent = "Força da senha: -";
            } else if (valor.length < 6){
                indicadorForca.classList.add('senha-fraca');
                textoForca.textContent = "Força da senha: Fraca";
            } else if (valor.length < 10){
                indicadorForca.classList.add('senha-media');
                textoForca.textContent = "Força da senha: Média";
            } else {
                indicadorForca.classList.add('senha-forte');
                textoForca.textContent = "Força da senha: Forte";
            }
        });
    };

    return { definirErro, removerErro, isEmailValido, configurarLimpezaAoDigitar, configurarForcaSenha };
}