import { configurarValidacaoGlobal } from "./validador.js";

configurarValidacaoGlobal();

document.addEventListener('DOMContentLoaded', () => {
    const inputPesquisa = document.getElementById('input-pesquisa-api');
    const gradeResultados = document.getElementById('grade-resultados');
    const estadoVazio = document.getElementById('estado-vazio-api');
    const loader = document.getElementById('loader-pesquisa');

    let timeoutId;

    if (inputPesquisa) {
        inputPesquisa.addEventListener('input', (e) => {
            clearTimeout(timeoutId);
            const termo = e.target.value.trim();

            if (termo.length < 3) { 
                gradeResultados.innerHTML = '';
                estadoVazio.classList.remove('is-hidden');
                estadoVazio.querySelector('h3').textContent = 'Nenhum exercício pesquisado';
                estadoVazio.querySelector('p').textContent = 'Digite o nome do exercício acima para buscar.';
                return;
            }

            estadoVazio.classList.add('is-hidden');
            gradeResultados.innerHTML = '';
            loader.classList.remove('is-hidden');

            timeoutId = setTimeout(() => {
                realizarBusca(termo);
            }, 600);
        });
    }

    async function realizarBusca(termo) {
        try {
            const resposta = await fetch(`/oktano/public/api/exercicios/buscar?q=${encodeURIComponent(termo)}`);
            const dados = await resposta.json();

            loader.classList.add('is-hidden');

            if (!resposta.ok) {
                gradeResultados.innerHTML = `<p class="form-error-msg erro-grid-inteiro"><i class="ph ph-warning"></i> ${dados.erro || 'Erro de integração com a API.'}</p>`;
                return;
            }

            if (!dados || dados.length === 0) {
                estadoVazio.classList.remove('is-hidden');
                estadoVazio.querySelector('h3').textContent = 'Nenhum resultado encontrado';
                estadoVazio.querySelector('p').textContent = `Não encontramos o exercício "${termo}". Lembre-se de pesquisar termos em inglês, ex: "Squat" ou "Curl".`;
                return;
            }

            renderizarResultados(dados);
        } catch (erro) {
            loader.classList.add('is-hidden');
            gradeResultados.innerHTML = '<p class="form-error-msg erro-grid-inteiro"><i class="ph ph-warning"></i> Falha na conexão com o servidor.</p>';
            console.error('Erro ao buscar exercícios:', erro);
        }
    }

    // (Mantenha o código existente que busca os dados intacto)

    // Modifique levemente a injeção do HTML no renderizarResultados para enviar mais dados (data-musculo):
    function renderizarResultados(exercicios) {
        const fragmento = document.createDocumentFragment();

        exercicios.forEach(ex => {
            const cartao = document.createElement('div');
            cartao.classList.add('card', 'cartao-exercicio-api');

            const parteDoCorpo = ex.bodyPart || 'Não classificado';
            const alvo = ex.target || 'Diversos';
            const equipamento = ex.equipment || 'Sem equipamento';
            const nomeCapitalizado = ex.name.charAt(0).toUpperCase() + ex.name.slice(1);

            cartao.innerHTML = `
                <div class="cartao-exercicio-api__corpo">
                    <h3 class="cartao-exercicio-api__titulo">${nomeCapitalizado}</h3>
                    <p class="form-hint cartao-exercicio-api__musculos">Alvo: ${alvo}</p>
                    <p class="form-hint cartao-exercicio-api__musculos">Equipamento: ${equipamento}</p>
                    <span class="badge badge--ativa">${parteDoCorpo}</span>
                </div>
                <div class="cartao-exercicio-api__rodape">
                    <button type="button" class="btn btn--primario btn--bloco js-selecionar-exercicio" 
                        data-api-id="${ex.id}" 
                        data-nome="${nomeCapitalizado}" 
                        data-musculo="${alvo}">
                        <i class="ph ph-plus"></i> Adicionar
                    </button>
                </div>
            `;
            fragmento.appendChild(cartao);
        });

        gradeResultados.appendChild(fragmento);
    }

    // LÓGICA DO MODAL
    const modalConfigurar = document.getElementById('modal-configurar-exercicio');
    const formConfigurar = document.getElementById('form-configurar-exercicio');
    
    // Event Delegation para capturar cliques nos botões recém-criados
    gradeResultados.addEventListener('click', (e) => {
        const btn = e.target.closest('.js-selecionar-exercicio');
        if(btn) {
            // Preenche os campos ocultos com os dados da API
            document.getElementById('modal-exercicio-api_id').value = btn.getAttribute('data-api-id');
            document.getElementById('modal-exercicio-nome').value = btn.getAttribute('data-nome');
            document.getElementById('modal-exercicio-musculo').value = btn.getAttribute('data-musculo');
            
            // Atualiza o título do Modal
            document.getElementById('titulo-modal-exercicio').textContent = btn.getAttribute('data-nome');
            
            // Exibe o modal
            modalConfigurar.classList.remove('modal-overlay--oculto');
        }
    });

    // Fechar modal
    document.querySelectorAll('.js-modal-fechar-configurar').forEach(btn => {
        btn.addEventListener('click', () => {
            modalConfigurar.classList.add('modal-overlay--oculto');
            formConfigurar.reset();
        });
    });

    // Fechar ao clicar fora ou apertar ESC
    modalConfigurar.addEventListener('click', (e) => {
        if(e.target === modalConfigurar) {
            modalConfigurar.classList.add('modal-overlay--oculto');
            formConfigurar.reset();
        }
    });

    document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape' && !modalConfigurar.classList.contains('modal-overlay--oculto')){
            modalConfigurar.classList.add('modal-overlay--oculto');
            formConfigurar.reset();
        }
    });

    // Fechar modal ao submeter
    formConfigurar.addEventListener('submit', () => {
        modalConfigurar.classList.add('modal-overlay--oculto');
    });
});