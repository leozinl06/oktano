document.addEventListener('DOMContentLoaded', () => {
    // ==========================================
    // CONFIGURAÇÕES DE PERSISTÊNCIA (Local Storage)
    // ==========================================
    const urlParams = new URLSearchParams(window.location.search);
    const idTreino = urlParams.get('id_treino');
    
    const storageTimeKey = `oktano_treino_inicio_${idTreino}`;
    const storageCargasKey = `oktano_treino_cargas_${idTreino}`;
    const storageTrocasKey = `oktano_treino_trocas_${idTreino}`;

    // ==========================================
    // 1. CRONÔMETRO PRINCIPAL E ESTADO DO TREINO
    // ==========================================
    const btnIniciarTreino = document.getElementById('btn-iniciar-treino');
    const textoIniciar = document.getElementById('texto-iniciar');
    const btnFinalizarTreino = document.getElementById('btn-finalizar-treino');
    const botoesEditarCarga = document.querySelectorAll('.js-editar-carga');
    const previewsAlternativo = document.querySelectorAll('.js-preview-alternativo');
    const botoesTrocarExercicio = document.querySelectorAll('.js-btn-trocar-exercicio');

    let treinoInterval = null;
    let treinoSegundos = 0;
    let treinoEmAndamento = false;

    const atualizarVisorTreino = () => {
        const min = String(Math.floor(treinoSegundos / 60)).padStart(2, '0');
        const seg = String(treinoSegundos % 60).padStart(2, '0');
        textoIniciar.textContent = `${min}:${seg}`;
    };

    const sincronizarCargaCard = (caixaMetrica, cargaPadrao) => {
        const idExercicio = caixaMetrica.getAttribute('data-id-exercicio');
        const targetValorCarga = caixaMetrica.querySelector('.js-valor-carga');
        const cargasSalvas = JSON.parse(localStorage.getItem(storageCargasKey)) || {};

        if (cargasSalvas[idExercicio] !== undefined) {
            targetValorCarga.textContent = `${cargasSalvas[idExercicio]} kg`;
            targetValorCarga.classList.add('metrica-box__valor--editada');
        } else {
            targetValorCarga.textContent = `${cargaPadrao} kg`;
            targetValorCarga.classList.remove('metrica-box__valor--editada');
        }
    };

    const aplicarDadosExercicioNoCard = (cartao, usarAlternativo) => {
        const rawDados = usarAlternativo
            ? cartao.getAttribute('data-alternativo')
            : cartao.getAttribute('data-principal');

        if (!rawDados) return;

        const dados = JSON.parse(rawDados);
        cartao.setAttribute('data-usando-alternativo', usarAlternativo ? 'true' : 'false');

        // Atualiza título e badge indicativa
        const elTitulo = cartao.querySelector('.js-exercicio-titulo');
        const elBadgeAtivo = cartao.querySelector('.js-badge-alternativo-ativo');
        if (elTitulo) elTitulo.textContent = dados.nome;
        if (elBadgeAtivo) elBadgeAtivo.classList.toggle('is-hidden', !usarAlternativo);

        // Atualiza métricas de séries, repetições e descanso
        const elSeries = cartao.querySelector('.js-exercicio-series');
        const elRepeticoes = cartao.querySelector('.js-exercicio-repeticoes');
        const boxDescanso = cartao.querySelector('.js-abrir-descanso');
        const elDescanso = cartao.querySelector('.js-exercicio-descanso');

        if (elSeries) elSeries.textContent = dados.series;
        if (elRepeticoes) elRepeticoes.textContent = dados.repeticoes;
        if (boxDescanso) boxDescanso.setAttribute('data-tempo', dados.descanso);
        if (elDescanso) elDescanso.textContent = `${dados.descanso}s`;

        // Atualiza observações
        const obsContainer = cartao.querySelector('.js-exercicio-obs-container');
        const obsTexto = cartao.querySelector('.js-exercicio-obs-texto');
        if (obsContainer && obsTexto) {
            if (dados.observacoes && dados.observacoes.trim() !== '') {
                obsTexto.textContent = dados.observacoes;
                obsContainer.classList.remove('is-hidden');
            } else {
                obsTexto.textContent = '';
                obsContainer.classList.add('is-hidden');
            }
        }

        // Atualiza ID do exercício ativo na caixa de carga e sincroniza o peso
        const caixaMetrica = cartao.querySelector('.metrica-carga');
        if (caixaMetrica) {
            caixaMetrica.setAttribute('data-id-exercicio', dados.id_exercicio);
            sincronizarCargaCard(caixaMetrica, dados.carga);
        }
    };

    const ativarInterfaceTreino = () => {
        treinoEmAndamento = true;

        btnIniciarTreino.classList.remove('btn--primario');
        btnIniciarTreino.classList.add('btn--secundario');
        textoIniciar.classList.add('cronometro-ativo');
        
        atualizarVisorTreino();

        // Revela ações de execução: finalizar, editar carga e trocar exercício; esconde preview alternativo
        btnFinalizarTreino.classList.remove('is-hidden');
        botoesEditarCarga.forEach(btn => btn.classList.remove('is-hidden'));
        previewsAlternativo.forEach(preview => preview.classList.add('is-hidden'));
        botoesTrocarExercicio.forEach(btn => btn.classList.remove('is-hidden'));

        treinoInterval = setInterval(() => {
            const startTime = parseInt(localStorage.getItem(storageTimeKey), 10);
            treinoSegundos = Math.floor((Date.now() - startTime) / 1000);
            atualizarVisorTreino();
        }, 1000);
    };

    // Eventos de troca de exercício durante o treino
    botoesTrocarExercicio.forEach(btn => {
        btn.addEventListener('click', () => {
            if (!treinoEmAndamento) return;

            const cartao = btn.closest('.js-cartao-exercicio');
            if (!cartao) return;

            const idTreinoExercicio = cartao.getAttribute('data-id-treino-exercicio');
            const usandoAlternativo = cartao.getAttribute('data-usando-alternativo') === 'true';
            const novoEstadoAlternativo = !usandoAlternativo;

            aplicarDadosExercicioNoCard(cartao, novoEstadoAlternativo);

            const trocasSalvas = JSON.parse(localStorage.getItem(storageTrocasKey)) || {};
            trocasSalvas[idTreinoExercicio] = novoEstadoAlternativo;
            localStorage.setItem(storageTrocasKey, JSON.stringify(trocasSalvas));
        });
    });

    // VERIFICAÇÃO DE REFRESH: A página foi recarregada no meio do treino?
    if (idTreino && localStorage.getItem(storageTimeKey)) {
        const startTime = parseInt(localStorage.getItem(storageTimeKey), 10);
        treinoSegundos = Math.floor((Date.now() - startTime) / 1000);
        
        const trocasSalvas = JSON.parse(localStorage.getItem(storageTrocasKey)) || {};
        document.querySelectorAll('.js-cartao-exercicio').forEach(cartao => {
            const idTe = cartao.getAttribute('data-id-treino-exercicio');
            const usarAlt = Boolean(trocasSalvas[idTe]);
            aplicarDadosExercicioNoCard(cartao, usarAlt);
        });

        ativarInterfaceTreino();
    }

    if (btnIniciarTreino) {
        btnIniciarTreino.addEventListener('click', () => {
            if (treinoEmAndamento) return; 
            
            localStorage.setItem(storageTimeKey, Date.now());
            treinoSegundos = 0;
            
            ativarInterfaceTreino();
        });
    }

    // ==========================================
    // 2. MODAL DE FADIGA E FINALIZAÇÃO
    // ==========================================
    const modalFadiga = document.getElementById('modal-fadiga');
    const formFinalizar = document.getElementById('form-finalizar-sessao');
    const btnSalvarSessao = document.getElementById('btn-salvar-sessao');

    if (btnFinalizarTreino) {
        btnFinalizarTreino.addEventListener('click', () => {
            clearInterval(treinoInterval);
            
            const displayTempoFinal = document.getElementById('tempo-final-treino');
            if (displayTempoFinal) displayTempoFinal.textContent = textoIniciar.textContent;

            modalFadiga.classList.remove('modal-overlay--oculto');
        });
    }

    document.querySelectorAll('.js-fechar-fadiga').forEach(btn => {
        btn.addEventListener('click', () => {
            modalFadiga.classList.add('modal-overlay--oculto');
            
            treinoInterval = setInterval(() => {
                const startTime = parseInt(localStorage.getItem(storageTimeKey), 10);
                treinoSegundos = Math.floor((Date.now() - startTime) / 1000);
                atualizarVisorTreino();
            }, 1000);
        });
    });

    if (formFinalizar) {
        formFinalizar.addEventListener('submit', async (e) => {
            e.preventDefault();

            const fadigaSelecionada = document.querySelector('input[name="fadiga"]:checked');
            if (!fadigaSelecionada) return;

            const textoOriginalBtn = btnSalvarSessao.innerHTML;
            btnSalvarSessao.innerHTML = '<i class="ph ph-spinner ph-spin"></i> Salvando...';
            btnSalvarSessao.disabled = true;

            const exerciciosSessao = [];
            document.querySelectorAll('.metrica-carga').forEach(el => {
                const idTreinoExercicio = el.getAttribute('data-id-treino-exercicio');
                const idExercicio = el.getAttribute('data-id-exercicio');
                
                const cargaTexto = el.querySelector('.js-valor-carga').textContent;
                const carga = parseFloat(cargaTexto.replace(' kg', '').trim()) || 0;
                
                exerciciosSessao.push({
                    id_treino_exercicio: parseInt(idTreinoExercicio, 10),
                    id_exercicio: parseInt(idExercicio, 10),
                    carga: carga
                });
            });

            const payload = {
                id_treino: parseInt(idTreino, 10),
                duracao_segundos: treinoSegundos,
                nivel_fadiga: parseInt(fadigaSelecionada.value, 10),
                exercicios: exerciciosSessao
            };

            try {
                const res = await fetch('/oktano/public/meus-treinos/salvar-sessao', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(payload)
                });
                
                const data = await res.json();
                
                if (data.sucesso) {
                    localStorage.removeItem(storageTimeKey);
                    localStorage.removeItem(storageCargasKey);
                    localStorage.removeItem(storageTrocasKey);
                    
                    window.location.href = '/oktano/public/meus-treinos';
                } else {
                    alert(data.mensagem || 'Erro ao salvar a sessão.');
                    btnSalvarSessao.innerHTML = textoOriginalBtn;
                    btnSalvarSessao.disabled = false;
                }
            } catch (error) {
                console.error(error);
                alert('Ocorreu um erro de rede. Tente novamente.');
                btnSalvarSessao.innerHTML = textoOriginalBtn;
                btnSalvarSessao.disabled = false;
            }
        });
    }

    // ==========================================
    // 3. MODAL DE CARGA (INPUT MANUAL)
    // ==========================================
    const modalCarga = document.getElementById('modal-carga');
    const formCarga = document.getElementById('form-carga');
    const inputCarga = document.getElementById('input-valor-carga');
    const inputHiddenId = document.getElementById('input-id-exercicio-carga');
    let targetValorCarga = null;

    document.querySelectorAll('.js-editar-carga').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const caixaMetrica = e.target.closest('.metrica-carga');
            const idExercicio = caixaMetrica.getAttribute('data-id-exercicio');
            
            targetValorCarga = caixaMetrica.querySelector('.js-valor-carga');
            inputHiddenId.value = idExercicio;
            inputCarga.value = ''; 
            
            modalCarga.classList.remove('modal-overlay--oculto');
            inputCarga.focus();
        });
    });

    document.querySelectorAll('.js-fechar-carga').forEach(btn => {
        btn.addEventListener('click', () => modalCarga.classList.add('modal-overlay--oculto'));
    });

    if (formCarga) {
        formCarga.addEventListener('submit', (e) => {
            e.preventDefault();
            const valor = inputCarga.value.trim();
            const idExercicio = inputHiddenId.value;
            
            if (valor !== '' && targetValorCarga) {
                targetValorCarga.textContent = `${valor} kg`;
                targetValorCarga.classList.add('metrica-box__valor--editada');
                
                const cargasSalvas = JSON.parse(localStorage.getItem(storageCargasKey)) || {};
                cargasSalvas[idExercicio] = valor;
                localStorage.setItem(storageCargasKey, JSON.stringify(cargasSalvas));
            }
            
            modalCarga.classList.add('modal-overlay--oculto');
        });
    }

    // ==========================================
    // 4. CRONÔMETRO DE DESCANSO REGRESSIVO
    // ==========================================
    const modalDescanso = document.getElementById('modal-descanso');
    const displayDescanso = document.getElementById('display-descanso');
    const btnPlayDescanso = document.querySelector('.js-play-descanso');
    const btnPauseDescanso = document.querySelector('.js-pause-descanso');
    
    let descansoInterval = null;
    let descansoSegundosAtuais = 0;

    const atualizarDisplayDescanso = () => {
        const min = String(Math.floor(descansoSegundosAtuais / 60)).padStart(2, '0');
        const seg = String(descansoSegundosAtuais % 60).padStart(2, '0');
        displayDescanso.textContent = `${min}:${seg}`;
    };

    const iniciarDescanso = () => {
        if (descansoSegundosAtuais <= 0) return;
        
        btnPlayDescanso.classList.add('is-hidden');
        btnPauseDescanso.classList.remove('is-hidden');
        
        descansoInterval = setInterval(() => {
            descansoSegundosAtuais--;
            atualizarDisplayDescanso();
            if (descansoSegundosAtuais <= 0) pararDescanso();
        }, 1000);
    };

    const pararDescanso = () => {
        clearInterval(descansoInterval);
        btnPauseDescanso.classList.add('is-hidden');
        btnPlayDescanso.classList.remove('is-hidden');
    };

    document.querySelectorAll('.js-abrir-descanso').forEach(box => {
        box.addEventListener('click', () => {
            const tempoStr = box.getAttribute('data-tempo');
            descansoSegundosAtuais = parseInt(tempoStr, 10);
            
            pararDescanso();
            atualizarDisplayDescanso();
            modalDescanso.classList.remove('modal-overlay--oculto');
        });
    });

    if (btnPlayDescanso) btnPlayDescanso.addEventListener('click', iniciarDescanso);
    if (btnPauseDescanso) btnPauseDescanso.addEventListener('click', pararDescanso);

    document.querySelectorAll('.js-fechar-descanso').forEach(btn => {
        btn.addEventListener('click', () => {
            pararDescanso();
            modalDescanso.classList.add('modal-overlay--oculto');
        });
    });
});