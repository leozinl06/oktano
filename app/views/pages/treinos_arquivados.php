<?php
$tituloPagina = "Treinos Arquivados - Oktano";
$estilosCSS = ['header', 'treino'];
require_once __DIR__ . '/../components/head.php';
?>
<body>
    <?php
        $tipoUsuario = 'personal';
        require_once __DIR__ . '/../components/header.php';
    ?>
    <main class="container-principal">
        <header class="cabecalho-pagina">
            <div class="cabecalho-pagina__conteudo-topo">
                <div class="cabecalho-pagina__titulos">
                    <h1 class="titulo-principal">Treinos Arquivados</h1>
                    <p class="subtitulo">Histórico de fichas desativadas do sistema</p>
                </div>
                <a href="/oktano/public/treinos" class="btn btn-secundario">
                    <i class="ph ph-arrow-left"></i> Voltar aos Ativos
                </a>
            </div>
        </header>

        <section>
            <?php if(isset($resultado)): ?>
                <div class="alerta <?= $resultado['sucesso'] ? 'alerta-sucesso' : 'alerta-erro' ?>">
                    <?= $resultado['mensagem'] ?>
                </div>
            <?php endif; ?>

            <?php if(empty($fichas)): ?>
                <div class="card-superficie vazio-estado">
                    <p class="texto-secundario">Nenhuma ficha de treino encontra-se arquivada.</p>
                </div>
            <?php else: ?>
                <div class="treino-grid">
                    <?php foreach ($fichas as $ficha): ?>
                        <article class="card-superficie treino-card treino-card--arquivada">
                            <div class="treino-card__cabecalho">
                                <h3 class="treino-card__titulo"><?= htmlspecialchars($ficha['titulo']) ?></h3>
                                <span class="treino-card__status badge-arquivada">Arquivada</span>
                            </div>
                            
                            <div class="treino-card__corpo">
                                <p class="treino-card__aluno">
                                    <i class="ph ph-user"></i> Aluno: <strong><?= htmlspecialchars($ficha['nome_aluno']) ?></strong>
                                </p>
                                <?php if(!empty($ficha['descricao'])): ?>
                                    <p class="treino-card__descricao"><?= htmlspecialchars($ficha['descricao']) ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="treino-card__acoes">
                                <form action="/oktano/public/treinos/desarquivar-ficha" method="POST" style="display:inline;">
                                    <input type="hidden" name="id_ficha" value="<?= htmlspecialchars($ficha['id']) ?>">
                                    <button type="submit" class="btn btn-secundario-texto">
                                        <i class="ph ph-arrow-u-up-left"></i> Restaurar
                                    </button>
                                </form>
                                
                                <button class="btn btn-secundario-texto btn-secundario-texto--erro js-btn-excluir-ficha" data-id="<?= htmlspecialchars($ficha['id']) ?>">
                                    <i class="ph ph-trash"></i> Excluir
                                </button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <?php require_once __DIR__ . '/../components/modal_exclusao_ficha.php'; ?>
    </main>
    <script type="module" src="/oktano/public/assets/js/treinos.js"></script>
    <script type="module" src="/oktano/public/assets/js/modal_exclusao.js"></script>
</body>
</html>