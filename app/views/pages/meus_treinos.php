<?php 
$tituloPagina = "Meus Treinos - Oktano"; 
$estilosCSS = ['header', 'treino']; 
require_once __DIR__ . '/../components/head.php'; 
?>
<body>
    <?php
        $tipoUsuario = 'praticante';
        require_once __DIR__ . '/../components/header.php';
    ?>
    
    <main class="container-principal">
        <header class="cabecalho-pagina">
            <div class="cabecalho-pagina__titulos">
                <h1 class="titulo-principal">Meus Treinos</h1>
                <p class="subtitulo">Acesse e acompanhe as suas fichas de treino liberadas.</p>
            </div>
        </header>

        <section class="meus-treinos">
            <?php if (empty($fichasAtivas)): ?>
                <div class="card-superficie vazio-estado">
                    <p class="texto-secundario">Nenhum treino disponível no momento.</p>
                </div>
            <?php else: ?>
                <div class="treino-grid">
                    <?php foreach ($fichasAtivas as $ficha): ?>
                        <article class="card-superficie treino-card treino-card--ativa">
                            <div class="treino-card__cabecalho">
                                <h3 class="treino-card__titulo"><?= htmlspecialchars($ficha['titulo']) ?></h3>
                                <i class="ph ph-barbell treino-card__icone-destaque"></i>
                            </div>
                            
                            <div class="treino-card__corpo">
                                <?php if (!empty($ficha['descricao'])): ?>
                                    <p class="treino-card__descricao"><?= htmlspecialchars($ficha['descricao']) ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="treino-card__acoes">
                                <a href="/oktano/public/meus-treinos/visualizar?id=<?= htmlspecialchars($ficha['id']) ?>" class="btn btn-primario treino-card__btn-iniciar">
                                    Ver Treino
                                </a>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
</body>
</html>