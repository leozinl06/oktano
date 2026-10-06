document.addEventListener('DOMContentLoaded', () => {
    const cabecalhosAccordion = document.querySelectorAll('.js-sessoes-accordion');

    const fecharTodos = () => {
        document.querySelectorAll('.aluno-item.is-open').forEach(item => {
            item.classList.remove('is-open');
            item.querySelector('.aluno-item__cabecalho').setAttribute('aria-expanded', 'false');
        });
    };

    cabecalhosAccordion.forEach(cabecalho => {
        cabecalho.addEventListener('click', () => {
            const itemPai = cabecalho.closest('.aluno-item');
            const estaAberto = itemPai.classList.contains('is-open');
            
            fecharTodos();
            
            if(!estaAberto) {
                itemPai.classList.add('is-open');
                cabecalho.setAttribute('aria-expanded', 'true');
            }
        });
    });
});