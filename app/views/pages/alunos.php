<?php
$tituloPagina = "Meus Alunos - Oktano";
$estilosCSS = ['header', 'aluno'];
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
                                        <!-- A classe modificadora muda de acordo com o status da ficha -->
                                        <div class="ficha-card ficha-card--<?= htmlspecialchars($ficha['status']) ?>">
                                            <span class="ficha-card__titulo"><?= htmlspecialchars($ficha['titulo']) ?></span>
                                            <button class="btn-icone" title="Visualizar ficha">
                                                <i class="ph ph-eye"></i>
                                            </button>
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
    </main>

    <script type="module" src="/oktano/public/assets/js/alunos.js"></script>
</body>
</html>