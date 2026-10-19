import { configurarValidacaoGlobal } from "./validador.js";

const { definirErro, removerErro, configurarLimpezaAoDigitar } = configurarValidacaoGlobal();

document.addEventListener('DOMContentLoaded', () => {
    const inputPesquisa = document.getElementById('input-pesquisa-api');
    const gradeResultados = document.getElementById('grade-resultados');
    const estadoVazio = document.getElementById('estado-vazio-api');
    const estadoVazioTitulo = document.getElementById('estado-vazio-titulo');
    const estadoVazioTexto = document.getElementById('estado-vazio-texto');
    const estadoVazioAcoes = document.getElementById('estado-vazio-acoes');
    const btnCriarCustomizado = document.getElementById('btn-criar-exercicio-customizado');
    const loader = document.getElementById('loader-pesquisa');

    const modalCustomizado = document.getElementById('modal-exercicio-customizado');
    const formCustomizado = document.getElementById('form-exercicio-customizado');
    const inputCustomNome = document.getElementById('custom-exercicio-nome');
    const inputCustomMusculo = document.getElementById('custom-exercicio-musculo');

    const modalConfigurar = document.getElementById('modal-configurar-exercicio');
    const formConfigurar = document.getElementById('form-configurar-exercicio');
    const inputSeries = document.getElementById('modal-series');
    const inputRepeticoes = document.getElementById('modal-repeticoes');
    const inputDescanso = document.getElementById('modal-descanso');

    const camposCustomizado = [inputCustomNome, inputCustomMusculo];
    const camposConfigurar = [inputSeries, inputRepeticoes, inputDescanso];

    configurarLimpezaAoDigitar([...camposCustomizado, ...camposConfigurar]);

    let timeoutId;

    const capitalizarTexto = (texto) => {
        const limpo = texto.trim();
        return limpo ? limpo.charAt(0).toUpperCase() + limpo.slice(1) : '';
    };

    const atualizarEstadoVazio = ({ titulo, texto, exibirBotaoCustomizado = false }) => {
        estadoVazio.classList.remove('is-hidden');
        estadoVazioTitulo.textContent = titulo;
        estadoVazioTexto.textContent = texto;
        estadoVazioAcoes.classList.toggle('is-hidden', !exibirBotaoCustomizado);
    };

    // ==========================================
    // 1. PESQUISA NA API
    // ==========================================
    if (inputPesquisa) {
        inputPesquisa.addEventListener('input', (e) => {
            clearTimeout(timeoutId);
            const termo = e.target.value.trim();

            if (termo.length < 3) {
                gradeResultados.innerHTML = '';
                atualizarEstadoVazio({
                    titulo: 'Nenhum exercício pesquisado',
                    texto: 'Digite o nome do exercício acima para buscar na base de dados.',
                    exibirBotaoCustomizado: false
                });
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
                atualizarEstadoVazio({
                    titulo: 'Nenhum resultado encontrado',
                    texto: `Não encontramos o exercício "${termo}". Crie um exercício customizado para adicioná-lo ao treino.`,
                    exibirBotaoCustomizado: true
                });
                return;
            }

            renderizarResultados(dados);
        } catch (erro) {
            loader.classList.add('is-hidden');
            gradeResultados.innerHTML = '<p class="form-error-msg erro-grid-inteiro"><i class="ph ph-warning"></i> Falha na conexão com o servidor.</p>';
            console.error('Erro ao buscar exercícios:', erro);
        }
    }

    function renderizarResultados(exercicios) {
        const fragmento = document.createDocumentFragment();

        exercicios.forEach(ex => {
            const cartao = document.createElement('div');
            cartao.classList.add('card', 'cartao-exercicio-api');

            const parteDoCorpo = ex.bodyPart || 'Não classificado';
            const alvo = ex.target || 'Diversos';
            const equipamento = ex.equipment || 'Sem equipamento';
            const nomeCapitalizado = capitalizarTexto(ex.name);

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

    // ==========================================
    // 2. FUNÇÕES COMPARTILHADAS DE MODAL (DRY)
    // ==========================================
    const fecharModal = (modal, form, campos = []) => {
        if (!modal) return;
        modal.classList.add('modal-overlay--oculto');
        if (form) form.reset();
        campos.forEach(removerErro);
    };

    const vincularFechamentoModal = (modal, form, seletorBtnFechar, campos = []) => {
        if (!modal) return;

        document.querySelectorAll(seletorBtnFechar).forEach(btn => {
            btn.addEventListener('click', () => fecharModal(modal, form, campos));
        });

        modal.addEventListener('click', (e) => {
            if (e.target === modal) fecharModal(modal, form, campos);
        });
    };

    const abrirModalConfigurar = ({ apiId = '', nome, musculo }) => {
        document.getElementById('modal-exercicio-api_id').value = apiId;
        document.getElementById('modal-exercicio-nome').value = nome;
        document.getElementById('modal-exercicio-musculo').value = musculo;
        document.getElementById('titulo-modal-exercicio').textContent = nome;

        modalConfigurar.classList.remove('modal-overlay--oculto');
        if (inputSeries) inputSeries.focus();
    };

    vincularFechamentoModal(modalCustomizado, formCustomizado, '.js-modal-fechar-customizado', camposCustomizado);
    vincularFechamentoModal(modalConfigurar, formConfigurar, '.js-modal-fechar-configurar', camposConfigurar);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (modalCustomizado && !modalCustomizado.classList.contains('modal-overlay--oculto')) {
                fecharModal(modalCustomizado, formCustomizado, camposCustomizado);
            }
            if (modalConfigurar && !modalConfigurar.classList.contains('modal-overlay--oculto')) {
                fecharModal(modalConfigurar, formConfigurar, camposConfigurar);
            }
        }
    });

    // ==========================================
    // 3. FLUXO: EXERCÍCIO DA API -> CONFIGURAR
    // ==========================================
    gradeResultados.addEventListener('click', (e) => {
        const btn = e.target.closest('.js-selecionar-exercicio');
        if (btn) {
            abrirModalConfigurar({
                apiId: btn.getAttribute('data-api-id'),
                nome: btn.getAttribute('data-nome'),
                musculo: btn.getAttribute('data-musculo')
            });
        }
    });

    // ==========================================
    // 4. FLUXO: EXERCÍCIO CUSTOMIZADO -> CONFIGURAR
    // ==========================================
    if (btnCriarCustomizado && modalCustomizado) {
        btnCriarCustomizado.addEventListener('click', () => {
            camposCustomizado.forEach(removerErro);
            const termoAtual = inputPesquisa ? capitalizarTexto(inputPesquisa.value) : '';
            inputCustomNome.value = termoAtual;
            inputCustomMusculo.value = '';

            modalCustomizado.classList.remove('modal-overlay--oculto');
            if (termoAtual) {
                inputCustomMusculo.focus();
            } else {
                inputCustomNome.focus();
            }
        });
    }

    if (formCustomizado) {
        formCustomizado.addEventListener('submit', (e) => {
            e.preventDefault();
            camposCustomizado.forEach(removerErro);

            const nome = capitalizarTexto(inputCustomNome.value);
            const musculo = capitalizarTexto(inputCustomMusculo.value);
            let valido = true;

            if (!nome) {
                definirErro(inputCustomNome, 'Informe o nome do exercício.');
                valido = false;
            }

            if (!musculo) {
                definirErro(inputCustomMusculo, 'Informe o músculo alvo ou grupo muscular.');
                valido = false;
            }

            if (!valido) return;

            fecharModal(modalCustomizado, formCustomizado, camposCustomizado);

            // Segue exatamente o mesmo fluxo de configuração de exercício
            abrirModalConfigurar({
                apiId: '',
                nome: nome,
                musculo: musculo
            });
        });
    }

    // Validação do formulário de configuração antes de enviar
    if (formConfigurar) {
        formConfigurar.addEventListener('submit', (e) => {
            camposConfigurar.forEach(removerErro);
            let valido = true;

            const valorSeries = inputSeries.value.trim();
            if (!valorSeries || Number(valorSeries) <= 0) {
                definirErro(inputSeries, 'Informe um número válido de séries.');
                valido = false;
            }

            if (!inputRepeticoes.value.trim()) {
                definirErro(inputRepeticoes, 'Informe as repetições.');
                valido = false;
            }

            const valorDescanso = inputDescanso ? inputDescanso.value.trim() : '60';
            if (inputDescanso && (valorDescanso === '' || Number(valorDescanso) < 0)) {
                definirErro(inputDescanso, 'Informe o tempo de descanso em segundos.');
                valido = false;
            }

            if (!valido) {
                e.preventDefault();
                return;
            }
        });
    }
});