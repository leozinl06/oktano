document.addEventListener('DOMContentLoaded', () => {
    const botoesAlternar = document.querySelectorAll('.js-alternar-senha');

    botoesAlternar.forEach(botao => {
        botao.addEventListener('click', () => {
            const alvoId = botao.getAttribute('data-alvo');
            const inputSenha = document.getElementById(alvoId);
            const icone = botao.querySelector('i');

            if (inputSenha) {
                const tipoAtual = inputSenha.getAttribute('type');
                const novoTipo = tipoAtual === 'password' ? 'text' : 'password';
                inputSenha.setAttribute('type', novoTipo);

                if (novoTipo === 'text') {
                    icone.classList.remove('ph-eye');
                    icone.classList.add('ph-eye-slash');
                    botao.setAttribute('aria-label', 'Ocultar senha');
                } else {
                    icone.classList.remove('ph-eye-slash');
                    icone.classList.add('ph-eye');
                    botao.setAttribute('aria-label', 'Mostrar senha');
                }
            }
        });
    });
});