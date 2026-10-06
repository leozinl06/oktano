document.addEventListener('DOMContentLoaded', () => {

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

    if (btnIniciarTreino) {
        btnIniciarTreino.addEventListener('click', () => {
            if (treinoEmAndamento) return; 
            
            treinoEmAndamento = true;

            // transforma o botão primário em um display de cronômetro secundário
            btnIniciarTreino.classList.remove('btn--primario');
            btnIniciarTreino.classList.add('btn--secundario');
            
            textoIniciar.classList.add('cronometro-ativo');
            textoIniciar.textContent = "00:00";

            // exibe as caixas de carga e o botão de finalizar
            btnFinalizarTreino.classList.remove('is-hidden');

            botoesEditarCarga.forEach(btn => btn.classList.remove('is-hidden'));

            // inicia o cronômetro do treino
            treinoInterval = setInterval(() => {
                treinoSegundos++;
                const min = String(Math.floor(treinoSegundos / 60)).padStart(2, '0');
                const seg = String(treinoSegundos % 60).padStart(2, '0');
                textoIniciar.textContent = `${min}:${seg}`;
            }, 1000);
        });
    }

    // botão finalizar
    if (btnFinalizarTreino) {
        btnFinalizarTreino.addEventListener('click', () => {
            clearInterval(treinoInterval);
            
            // Aqui futuramente coletaremos todas as "Cargas" preenchidas via DOM
            // e faremos um POST via fetch() para o backend.
            alert(`Treino finalizado com duração de ${textoIniciar.textContent}. Os dados serão salvos no banco em breve!`);
        });
    }


    // ==========================================
    // 2. MODAL DE CARGA (INPUT MANUAL)
    // ==========================================
    const modalCarga = document.getElementById('modal-carga');
    const formCarga = document.getElementById('form-carga');
    const inputCarga = document.getElementById('input-valor-carga');
    const inputHiddenId = document.getElementById('input-id-exercicio-carga');
    let targetValorCarga = null; // armazena o span que será atualizado

    // abrir Modal de Carga
    document.querySelectorAll('.js-editar-carga').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const caixaMetrica = e.target.closest('.metrica-carga');
            const idExercicio = caixaMetrica.getAttribute('data-id-exercicio');
            
            targetValorCarga = caixaMetrica.querySelector('.js-valor-carga');
            inputHiddenId.value = idExercicio;
            inputCarga.value = ''; // limpa input
            
            modalCarga.classList.remove('modal-overlay--oculto');
            inputCarga.focus();
        });
    });

    // fechar Modal
    document.querySelectorAll('.js-fechar-carga').forEach(btn => {
        btn.addEventListener('click', () => modalCarga.classList.add('modal-overlay--oculto'));
    });

    // salvar carga no DOM
    if (formCarga) {
        formCarga.addEventListener('submit', (e) => {
            e.preventDefault();
            const valor = inputCarga.value.trim();
            
            if (valor !== '' && targetValorCarga) {
                targetValorCarga.textContent = `${valor} kg`;
                targetValorCarga.style.color = "var(--cor-primaria)"; // highlight visual
            }
            
            modalCarga.classList.add('modal-overlay--oculto');
        });
    }


    // ==========================================
    // 3. CRONÔMETRO DE DESCANSO REGRESSIVO
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

            if (descansoSegundosAtuais <= 0) {
                pararDescanso();
                // Opcional: tocar um som de "beep" aqui no futuro
            }
        }, 1000);
    };

    const pararDescanso = () => {
        clearInterval(descansoInterval);
        btnPauseDescanso.classList.add('is-hidden');
        btnPlayDescanso.classList.remove('is-hidden');
    };

    // Abrir Modal de Descanso
    document.querySelectorAll('.js-abrir-descanso').forEach(box => {
        box.addEventListener('click', (e) => {
            const tempoStr = box.getAttribute('data-tempo');
            descansoSegundosAtuais = parseInt(tempoStr, 10);
            
            pararDescanso(); // Reseta qualquer estado anterior
            atualizarDisplayDescanso();
            
            modalDescanso.classList.remove('modal-overlay--oculto');
        });
    });

    // Controles Play/Pause
    if(btnPlayDescanso) btnPlayDescanso.addEventListener('click', iniciarDescanso);
    if(btnPauseDescanso) btnPauseDescanso.addEventListener('click', pararDescanso);

    // Fechar Descanso
    document.querySelectorAll('.js-fechar-descanso').forEach(btn => {
        btn.addEventListener('click', () => {
            pararDescanso();
            modalDescanso.classList.add('modal-overlay--oculto');
        });
    });

});