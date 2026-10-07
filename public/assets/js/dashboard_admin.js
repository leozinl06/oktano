import { configurarValidacaoGlobal } from "./validador.js";

document.addEventListener('DOMContentLoaded', () => {
    // Importa as funções visuais de erro do sistema
    const { definirErro, removerErro, configurarLimpezaAoDigitar } = configurarValidacaoGlobal();

    const ctxPersonais = document.getElementById('grafico-personais');
    const ctxPraticantes = document.getElementById('grafico-praticantes');
    
    const rootStyles = getComputedStyle(document.documentElement);
    const corPrimaria = rootStyles.getPropertyValue('--cor-primaria').trim() || '#FF5722';
    const corInfo = rootStyles.getPropertyValue('--info').trim() || '#3b82f6';

    const charts = {};

    const criarConfiguracaoGrafico = (dados, rotulo, corPrincipal) => {
        return {
            type: 'bar',
            data: {
                labels: dados.labels,
                datasets: [{
                    label: rotulo,
                    data: dados.data,
                    backgroundColor: corPrincipal,
                    borderRadius: 4,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        };
    };

    // Inicialização
    if (ctxPersonais && window.dadosPersonais) {
        charts['personais'] = new Chart(ctxPersonais, criarConfiguracaoGrafico(window.dadosPersonais, 'Novos Personais', corPrimaria));
    }
    if (ctxPraticantes && window.dadosPraticantes) {
        charts['praticantes'] = new Chart(ctxPraticantes, criarConfiguracaoGrafico(window.dadosPraticantes, 'Novos Alunos', corInfo));
    }

    // Lógica do Modal de Filtro
    const modalFiltro = document.getElementById('modal-filtro-periodo');
    const formFiltro = document.getElementById('form-filtro-periodo');
    const inputTipoAlvo = document.getElementById('filtro-tipo-alvo');
    const inputInicio = document.getElementById('filtro-inicio');
    const inputFim = document.getElementById('filtro-fim');
    const camposData = [inputInicio, inputFim];

    // Remove a classe de erro assim que o usuário altera o valor do input
    configurarLimpezaAoDigitar(camposData);
    
    document.querySelectorAll('.js-abrir-filtro').forEach(btn => {
        btn.addEventListener('click', () => {
            inputTipoAlvo.value = btn.dataset.tipo;
            modalFiltro.classList.remove('modal-overlay--oculto');
        });
    });

    const fecharModalFiltro = () => {
        modalFiltro.classList.add('modal-overlay--oculto');
        formFiltro.reset();
        camposData.forEach(removerErro);
    };

    document.querySelectorAll('.js-fechar-filtro').forEach(btn => {
        btn.addEventListener('click', fecharModalFiltro);
    });

    // Filtra ao submeter o formulário
    formFiltro.addEventListener('submit', async (e) => {
        e.preventDefault();
        camposData.forEach(removerErro);

        const tipo = inputTipoAlvo.value;
        const inicio = inputInicio.value;
        const fim = inputFim.value;

        // Validação personalizada visual
        if (!inicio) {
            definirErro(inputInicio, 'Selecione o mês de início.');
            return;
        }
        if (!fim) {
            definirErro(inputFim, 'Selecione o mês de fim.');
            return;
        }
        if (inicio > fim) {
            definirErro(inputFim, 'A data final não pode ser anterior à data inicial.');
            return;
        }

        const btnSubmit = formFiltro.querySelector('button[type="submit"]');
        const txtOriginal = btnSubmit.textContent;
        btnSubmit.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Filtrando...';

        await atualizarGrafico(tipo, inicio, fim);
        
        btnSubmit.textContent = txtOriginal;
        fecharModalFiltro();
    });

    // Limpa o filtro retornando ao padrão
    document.querySelectorAll('.js-redefinir-grafico').forEach(btn => {
        btn.addEventListener('click', async () => {
            const tipo = btn.dataset.tipo;
            const iconeOriginal = btn.innerHTML;
            btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Redefinindo...';
            await atualizarGrafico(tipo, null, null);
            btn.innerHTML = iconeOriginal;
        });
    });

    // Exportar (Provisório)
    document.querySelectorAll('.js-exportar-dados').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            alert('A funcionalidade de exportação estará disponível em breve!');
        });
    });

    // Função de requisição para a API
    async function atualizarGrafico(tipo, inicio, fim) {
        let url = `${window.BASE_URL}/api/admin/estatisticas?tipo=${tipo}`;
        if (inicio && fim) {
            url += `&inicio=${inicio}&fim=${fim}`;
        }

        try {
            const res = await fetch(url);

            if(!res.ok){
                throw new Error(`Erro HTTP: ${res.status}`);
            }

            const dados = await res.json();

            if (dados.erro) {
                alert("Falha na API: " + dados.erro);
                return;
            }

            const canvas = document.getElementById(`grafico-${tipo}`);
            const emptyState = document.getElementById(`vazio-${tipo}`);
            const totalDisplay = document.getElementById(`total-${tipo}`);

            if (dados.labels.length === 0) {
                canvas.classList.add('is-hidden');
                emptyState.classList.remove('is-hidden');
                totalDisplay.textContent = '0';
            } else {
                canvas.classList.remove('is-hidden');
                emptyState.classList.add('is-hidden');
                
                charts[tipo].data.labels = dados.labels;
                charts[tipo].data.datasets[0].data = dados.data;
                charts[tipo].update();
                
                totalDisplay.textContent = dados.total;
            }
        } catch (error) {
            console.error("Erro ao buscar estatísticas:", error);
            alert("Não foi possível carregar os dados. Verifique se a rota da API foi adicionada corretamente no index.php.");
        }
    }
});