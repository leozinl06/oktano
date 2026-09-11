<?php
$tituloPagina = "Treinos - Oktano";
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
                    <h1 class="titulo-principal">Gerenciamento de Treinos</h1>
                    <p class="subtitulo">Visão geral de todas as fichas ativas e alunos vinculados</p>
                </div>
                <a href="/oktano/public/treinos/arquivados" class="btn btn-secundario">
                    <i class="ph ph-archive"></i> Fichas Arquivadas
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
                    <p class="texto-secundario">Nenhuma ficha de treino cadastrada no sistema.</p>
                </div>
            <?php else: ?>
                <div class="treino-grid"> 
                    <?php foreach ($fichas as $ficha): ?>
                        <article class="card-superficie treino-card treino-card--<?= htmlspecialchars($ficha['status']) ?>">
                            <div class="treino-card__cabecalho">
                                <h3 class="treino-card__titulo"><?= htmlspecialchars($ficha['titulo']) ?></h3>
                                <span class="treino-card__status badge-<?= htmlspecialchars($ficha['status']) ?>">
                                    <?= ucfirst(htmlspecialchars($ficha['status'])) ?>
                                </span>
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
                                <button type="button" onclick="window.location.href='/oktano/public/treinos/editar-ficha?id=<?= htmlspecialchars($ficha['id']) ?>'" class="btn btn-secundario-texto">
                                    <i class="ph ph-pencil-simple"></i> Editar
                                </button>
                                
                                <button class="btn btn-secundario-texto js-btn-arquivar-ficha" data-id="<?= htmlspecialchars($ficha['id']) ?>">
                                    <i class="ph ph-archive"></i> Arquivar
                                </button>
                                
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
        <?php require_once __DIR__ . '/../components/modal_arquivar_ficha.php'; ?>
    </main>
    <script type="module" src="/oktano/public/assets/js/modal_exclusao.js"></script>
    <script type="module" src="/oktano/public/assets/js/modal_arquivar.js"></script>
    <script type="module" src="/oktano/public/assets/js/treinos.js"></script>
</body>
</html>