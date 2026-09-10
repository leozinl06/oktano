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

const inputPesquisa = document.getElementById('pesquisa-aluno');
const itensAluno = document.querySelectorAll('.aluno-item');
const msgVaziaPesquisa = document.getElementById('msg-pesquisa-vazia');

if(inputPesquisa){
    inputPesquisa.addEventListener('input', (e) => {
        const termoPesquisa = e.target.value.toLowerCase().trim();
        let quantidadeVisivel = 0;

        itensAluno.forEach(item => {
            const nomeAluno = item.querySelector('.aluno-item__nome').textContent.toLowerCase(); //nome no card x

            if(nomeAluno.includes(termoPesquisa)){
                item.classList.remove('is-hidden');
                quantidadeVisivel++;
            } else{
                item.classList.add('is-hidden');
            }
        });

        if(msgVaziaPesquisa){
            if(quantidadeVisivel === 0 && itensAluno.length > 0){
                msgVaziaPesquisa.classList.remove('is-hidden');
            } else{
                msgVaziaPesquisa.classList.add('is-hidden');
            }
        }
    });
}