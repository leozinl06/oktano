import { configurarValidacaoGlobal } from "./validador.js";

document.addEventListener('DOMContentLoaded', () => {
    const { definirErro, removerErro, configurarLimpezaAoDigitar } = configurarValidacaoGlobal();

    const ctxPersonais = document.getElementById('grafico-personais');
    const ctxPraticantes = document.getElementById('grafico-praticantes');
    
    // Captura as cores do root para manter o design system
    const rootStyles = getComputedStyle(document.documentElement);
    const corPrimaria = rootStyles.getPropertyValue('--cor-primaria').trim() || '#FF5722';
    const corInfo = rootStyles.getPropertyValue('--info').trim() || '#3b82f6';

    const charts = {}; 
    const filtrosAtivos = {
        personais: { inicio: null, fim: null },
        praticantes: { inicio: null, fim: null }
    };

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
                        ticks: { precision: 0 },
                        grid: { color: 'rgba(255, 255, 255, 0.05)' }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        };
    };

    // Inicialização dos gráficos
    if (ctxPersonais && window.dadosPersonais) {
        charts['personais'] = new Chart(ctxPersonais, criarConfiguracaoGrafico(window.dadosPersonais, 'Novos Personais', corPrimaria));
    }
    if (ctxPraticantes && window.dadosPraticantes) {
        charts['praticantes'] = new Chart(ctxPraticantes, criarConfiguracaoGrafico(window.dadosPraticantes, 'Novos Alunos', corInfo));
    }

    // --- LÓGICA DO MODAL DE FILTRO ---
    const modalFiltro = document.getElementById('modal-filtro-periodo');
    const formFiltro = document.getElementById('form-filtro-periodo');
    const inputTipoAlvo = document.getElementById('filtro-tipo-alvo');
    const inputInicio = document.getElementById('filtro-inicio');
    const inputFim = document.getElementById('filtro-fim');
    const camposData = [inputInicio, inputFim];

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

    formFiltro.addEventListener('submit', async (e) => {
        e.preventDefault();
        camposData.forEach(removerErro);

        const tipo = inputTipoAlvo.value;
        const inicio = inputInicio.value;
        const fim = inputFim.value;

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

    document.querySelectorAll('.js-redefinir-grafico').forEach(btn => {
        btn.addEventListener('click', async () => {
            const tipo = btn.dataset.tipo;
            const iconeOriginal = btn.innerHTML;
            btn.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Redefinindo...';
            await atualizarGrafico(tipo, null, null);
            btn.innerHTML = iconeOriginal;
        });
    });

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

            filtrosAtivos[tipo].inicio = inicio;
            filtrosAtivos[tipo].fim = fim;

        } catch (error) {
            console.error("Erro ao buscar estatísticas:", error);
            alert("Não foi possível carregar os dados.");
        }
    }

    // --- LÓGICA DE EXPORTAÇÃO (.XLS) ---
    document.querySelectorAll('.js-exportar-dados').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const tipo = btn.dataset.tipo;
            const chart = charts[tipo];
            const filtro = filtrosAtivos[tipo];
            const dados = chart.data;

            if (dados.labels.length === 0) {
                alert('Não há dados visíveis para exportar neste período.');
                return;
            }

            const tituloBase = tipo === 'personais' ? 'Relatório de Personais Registrados' : 'Relatório de Alunos Registrados';
            const periodoTexto = (filtro.inicio && filtro.fim) ? `Período: ${filtro.inicio} a ${filtro.fim}` : 'Período: Histórico Geral Completo';

            let htmlTable = `
                <html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">
                <head>
                    <meta charset="utf-8">
                    <style>
                        th { background-color: #6c5ce7; color: white; font-weight: bold; padding: 10px; border: 1px solid #ccc; font-family: sans-serif; }
                        td { padding: 10px; border: 1px solid #ccc; text-align: center; font-family: sans-serif; }
                        h2, p { font-family: sans-serif; }
                    </style>
                </head>
                <body>
                    <h2>${tituloBase}</h2>
                    <p><b>${periodoTexto}</b></p>
                    <p><small>Gerado pelo Oktano Dashboard Administrativo</small></p>
                    <br>
                    <table>
                        <thead>
                            <tr>
                                <th>Mês / Ano</th>
                                <th>Total de Novos Registros</th>
                            </tr>
                        </thead>
                        <tbody>
            `;

            for (let i = 0; i < dados.labels.length; i++) {
                htmlTable += `<tr><td>${dados.labels[i]}</td><td>${dados.datasets[0].data[i]}</td></tr>`;
            }

            htmlTable += `
                        </tbody>
                    </table>
                </body>
                </html>
            `;

            let filename = `Oktano_Relatorio_${tipo}`;
            if (filtro.inicio && filtro.fim) {
                filename += `_${filtro.inicio}_ate_${filtro.fim}`;
            } else {
                filename += `_geral`;
            }
            filename += `.xls`;

            const blob = new Blob([htmlTable], { type: 'application/vnd.ms-excel;charset=utf-8' });
            const url = URL.createObjectURL(blob);
            const link = document.createElement("a");
            link.href = url;
            link.download = filename;
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    });
});