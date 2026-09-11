<?php
$tituloPagina = "Meus Alunos - Oktano";
$estilosCSS = ['header', 'aluno', 'treino'];
require_once __DIR__ . '/../components/head.php';
?>

<body>
    <?php 
        $tipoUsuario = 'personal';
        require_once __DIR__ . '/../components/header.php'; 
    ?>

    <main class="container-principal">
        <header class="cabecalho-pagina">
            <h1 class="titulo-principal">Meus Alunos</h1>
            <p class="subtitulo">Gerencie as fichas de treino dos seus praticantes</p>

            <?php if (!empty($alunos)): ?>
            <div class="pesquisa-barra">
                <div class="input-wrapper">
                    <input type="text" id="pesquisa-aluno" class="form-input com-icone" placeholder="Buscar aluno pelo nome...">
                    <i class="ph ph-magnifying-glass input-icon"></i>
                </div>
            </div>
            <?php endif; ?>
        </header>

        <?php if(isset($resultado)): ?>
            <div class="alerta <?= $resultado['sucesso'] ? 'alerta-sucesso' : 'alerta-erro' ?>">
                <?= $resultado['mensagem'] ?>
            </div>
        <?php endif; ?>

        <section class="aluno-lista">
            <?php if (empty($alunos)): ?>
                <div class="card-superficie vazio-estado">
                    <p class="texto-secundario">Nenhum aluno vinculado ainda.</p>
                </div>
            <?php else: ?>
                <div id="msg-pesquisa-vazia" class="card-superficie vazio-estado is-hidden">
                    <p class="texto-secundario">Nenhum aluno encontrado com este nome.</p>
                </div>

                <?php foreach ($alunos as $aluno): ?>
                    <article class="aluno-item">
                        <button class="aluno-item__cabecalho" aria-expanded="false">
                            <span class="aluno-item__nome"><?= htmlspecialchars($aluno['nome_exibicao']) ?></span>
                            <i class="ph ph-caret-down aluno-item__icone-expansao"></i>
                        </button>
                        
                        <div class="aluno-item__conteudo-wrapper">
                            <div class="aluno-item__conteudo">
                                
                                <div class="ficha-lista">
                                    <?php foreach ($aluno['fichas'] as $ficha): ?>
                                        <div class="ficha-card ficha-card--<?= htmlspecialchars($ficha['status']) ?>">
                                            <div class="ficha-card__info">
                                                <span class="ficha-card__titulo"><?= htmlspecialchars($ficha['titulo']) ?></span>
                                                <span class="treino-card__status badge-<?= htmlspecialchars($ficha['status']) ?>">
                                                    <?= ucfirst(htmlspecialchars($ficha['status'])) ?>
                                                </span>
                                            </div>

                                            <div class="ficha-card__acoes">
                                                <button class="btn-icone" title="Visualizar ficha">
                                                    <i class="ph ph-eye"></i>
                                                </button>
                                                
                                                <a href="/oktano/public/treinos/editar-ficha?id=<?= htmlspecialchars($ficha['id']) ?>" class="btn-icone" title="Editar ficha">
                                                    <i class="ph ph-pencil-simple"></i> Editar
                                                </a>

                                                <button class="btn-icone" title="Arquivar ficha">
                                                    <i class="ph ph-archive"></i>
                                                </button>

                                                <button class="btn-icone btn-icone--erro js-btn-excluir-ficha" data-id="<?= htmlspecialchars($ficha['id']) ?>" title="Excluir ficha">
                                                    <i class="ph ph-trash"></i>
                                                </button>
                                            </div>

                                        </div>
                                    <?php endforeach; ?>
                                </div>

                                <a href="/oktano/public/treinos/nova-ficha?aluno_id=<?= htmlspecialchars($aluno['id']) ?>" class="btn btn-primario aluno-item__btn-criar">
                                    Criar nova ficha de treino
                                </a>
                                
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

        <?php require_once __DIR__ . '/../components/modal_exclusao_ficha.php'; ?>
    </main>

    <script type="module" src="/oktano/public/assets/js/alunos.js"></script>
    <script type="module" src="/oktano/public/assets/js/modal_exclusao.js"></script>
</body>
</html>