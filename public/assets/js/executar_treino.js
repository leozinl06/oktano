document.addEventListener('DOMContentLoaded', () => {

    // ==========================================
    // CONFIGURAÇÕES DE PERSISTÊNCIA (Local Storage)
    // ==========================================
    const urlParams = new URLSearchParams(window.location.search);
    const idTreino = urlParams.get('id_treino');
    
    // Chaves únicas para salvar o estado deste treino específico no navegador
    const storageTimeKey = `oktano_treino_inicio_${idTreino}`;
    const storageCargasKey = `oktano_treino_cargas_${idTreino}`;


    // ==========================================
    // 1. CRONÔMETRO PRINCIPAL E ESTADO DO TREINO
    // ==========================================
    const btnIniciarTreino = document.getElementById('btn-iniciar-treino');
    const textoIniciar = document.getElementById('texto-iniciar');
    const btnFinalizarTreino = document.getElementById('btn-finalizar-treino');
    const botoesEditarCarga = document.querySelectorAll('.js-editar-carga'); 

    let treinoInterval = null;
    let treinoSegundos = 0;
    let treinoEmAndamento = false;

    // Função auxiliar para atualizar os números na tela
    const atualizarVisorTreino = () => {
        const min = String(Math.floor(treinoSegundos / 60)).padStart(2, '0');
        const seg = String(treinoSegundos % 60).padStart(2, '0');
        textoIniciar.textContent = `${min}:${seg}`;
    };

    // Função que ativa a interface "Modo Treino"
    const ativarInterfaceTreino = () => {
        treinoEmAndamento = true;

        // Transforma o botão primário em um display de cronômetro
        btnIniciarTreino.classList.remove('btn--primario');
        btnIniciarTreino.classList.add('btn--secundario');
        textoIniciar.classList.add('cronometro-ativo');
        
        atualizarVisorTreino();

        // Revela o botão de finalizar e os lápis de edição
        btnFinalizarTreino.classList.remove('is-hidden');
        botoesEditarCarga.forEach(btn => btn.classList.remove('is-hidden'));

        // Inicia o cronômetro baseando-se no relógio interno do sistema (à prova de refresh)
        treinoInterval = setInterval(() => {
            const startTime = parseInt(localStorage.getItem(storageTimeKey), 10);
            treinoSegundos = Math.floor((Date.now() - startTime) / 1000);
            atualizarVisorTreino();
        }, 1000);
    };

    // VERIFICAÇÃO DE REFRESH: A página foi recarregada no meio do treino?
    if (idTreino && localStorage.getItem(storageTimeKey)) {
        // Resgata o tempo
        const startTime = parseInt(localStorage.getItem(storageTimeKey), 10);
        treinoSegundos = Math.floor((Date.now() - startTime) / 1000);
        
        // Resgata as cargas já preenchidas
        const cargasSalvas = JSON.parse(localStorage.getItem(storageCargasKey)) || {};
        document.querySelectorAll('.metrica-carga').forEach(el => {
            const idEx = el.getAttribute('data-id-exercicio');
            if (cargasSalvas[idEx]) {
                const targetValorCarga = el.querySelector('.js-valor-carga');
                targetValorCarga.textContent = `${cargasSalvas[idEx]} kg`;
                targetValorCarga.style.color = "var(--cor-primaria)";
            }
        });

        // Reativa a tela do jeito que estava
        ativarInterfaceTreino();
    }

    // Ação de clicar no Iniciar
    if (btnIniciarTreino) {
        btnIniciarTreino.addEventListener('click', () => {
            if (treinoEmAndamento) return; 
            
            // Marca o exato milissegundo de início e salva no storage
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
            clearInterval(treinoInterval); // Congela o tempo
            
            // Injeta o tempo final no visor do modal de fadiga
            const displayTempoFinal = document.getElementById('tempo-final-treino');
            if (displayTempoFinal) displayTempoFinal.textContent = textoIniciar.textContent;

            modalFadiga.classList.remove('modal-overlay--oculto');
        });
    }

    // Fechar modal de fadiga se desistir
    document.querySelectorAll('.js-fechar-fadiga').forEach(btn => {
        btn.addEventListener('click', () => {
            modalFadiga.classList.add('modal-overlay--oculto');
            
            // Retoma o cronômetro baseando-se no relógio do sistema para não perder tempo
            treinoInterval = setInterval(() => {
                const startTime = parseInt(localStorage.getItem(storageTimeKey), 10);
                treinoSegundos = Math.floor((Date.now() - startTime) / 1000);
                atualizarVisorTreino();
            }, 1000);
        });
    });

    // Envio dos dados para o backend
    if (formFinalizar) {
        formFinalizar.addEventListener('submit', async (e) => {
            e.preventDefault();

            const fadigaSelecionada = document.querySelector('input[name="fadiga"]:checked');
            if (!fadigaSelecionada) return; // Validação silenciosa

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
                    // LIMPEZA: O treino terminou, apagamos os rascunhos salvos no navegador
                    localStorage.removeItem(storageTimeKey);
                    localStorage.removeItem(storageCargasKey);
                    
                    window.location.href = '/oktano/public/meus-treinos';
                } else {
                    alert(data.mensagem || "Erro ao salvar a sessão.");
                    btnSalvarSessao.innerHTML = textoOriginalBtn;
                    btnSalvarSessao.disabled = false;
                }
            } catch (error) {
                console.error(error);
                alert("Ocorreu um erro de rede. Tente novamente.");
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
                targetValorCarga.style.color = "var(--cor-primaria)";
                
                // Salva a carga digitada no storage para protegê-la de refreshes
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
        box.addEventListener('click', (e) => {
            const tempoStr = box.getAttribute('data-tempo');
            descansoSegundosAtuais = parseInt(tempoStr, 10);
            
            pararDescanso();
            atualizarDisplayDescanso();
            modalDescanso.classList.remove('modal-overlay--oculto');
        });
    });

    if(btnPlayDescanso) btnPlayDescanso.addEventListener('click', iniciarDescanso);
    if(btnPauseDescanso) btnPauseDescanso.addEventListener('click', pararDescanso);

    document.querySelectorAll('.js-fechar-descanso').forEach(btn => {
        btn.addEventListener('click', () => {
            pararDescanso();
            modalDescanso.classList.add('modal-overlay--oculto');
        });
    });
});