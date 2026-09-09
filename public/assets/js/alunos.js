const cabecalhosExpansivo = document.querySelectorAll('.aluno-item__cabecalho');

cabecalhosExpansivo.forEach(cabecalho => {
    cabecalho.addEventListener('click', () => {
        const itemPai = cabecalho.closest('.aluno-item');
        const estaAberto = itemPai.classList.contains('is-open');

        document.querySelectorAll('.aluno-item').forEach(item => {
            item.classList.remove('is-open');
        });
        document.querySelectorAll('.aluno-item__cabecalho').forEach(btn => {
            btn.setAttribute('aria-expanded', 'false');
        });

        if(!estaAberto){
            itemPai.classList.add('is-open');
            cabecalho.setAttribute('aria-expanded', 'true');
        } else{
            itemPai.classList.remove('is-open');
            cabecalho.setAttribute('aria-expanded', 'false');
        }
    });
});
