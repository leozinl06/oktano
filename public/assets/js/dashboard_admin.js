document.addEventListener('DOMContentLoaded', () => {
    const ctxPersonais = document.getElementById('grafico-personais');
    const ctxPraticantes = document.getElementById('grafico-praticantes');
    
    // Captura as cores do design system nativo definidos no root do CSS
    const rootStyles = getComputedStyle(document.documentElement);
    const corPrimaria = rootStyles.getPropertyValue('--cor-primaria').trim() || '#FF5722';
    const corInfo = rootStyles.getPropertyValue('--info').trim() || '#3b82f6';

    // Configuração base comum para evitar repetição (DRY)
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
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0 // Evita números decimais na quantidade de usuários
                        }
                    }
                }
            }
        };
    };

    // Inicialização do Gráfico de Personais
    if (ctxPersonais && window.dadosPersonais) {
        new Chart(ctxPersonais, criarConfiguracaoGrafico(window.dadosPersonais, 'Novos Personais', corPrimaria));
    }

    // Inicialização do Gráfico de Praticantes
    if (ctxPraticantes && window.dadosPraticantes) {
        new Chart(ctxPraticantes, criarConfiguracaoGrafico(window.dadosPraticantes, 'Novos Alunos', corInfo));
    }

    document.querySelectorAll('.js-exportar-dados').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            alert('A funcionalidade de exportação estará disponível em breve!');
        });
    });
});