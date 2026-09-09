const cabecalhosExpansivo = document.querySelectorAll('.aluno-item__cabecalho');

const fecharTodos = () => {
    document.querySelectorAll('.aluno-item.is-open').forEach(item => {
        item.classList.remove('is-open');
        item.querySelector('.aluno-item__cabecalho').setAttribute('aria-expanded', 'false');
    });
};


cabecalhosExpansivo.forEach(cabecalho => {
    cabecalho.addEventListener('click', () => {
        const itemPai = cabecalho.closest('.aluno-item');
        const estaAberto = itemPai.classList.contains('is-open');

        fecharTodos();

        if(!estaAberto){
            itemPai.classList.add('is-open');
            cabecalho.setAttribute('aria-expanded', 'true');
        }
    });
});

document.addEventListener('click', (e) => {
    if(!e.target.closest('.aluno-item')){
        fecharTodos();
    }
});
