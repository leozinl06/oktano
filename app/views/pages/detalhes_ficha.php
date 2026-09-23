<?php 
$tituloPagina = 'Detalhes da Ficha'; 
$paginaAtiva = 'treinos'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require __DIR__ . '/../components/head.php'; ?>
</head>
<body>
    <?php require __DIR__ . '/../components/cabecalho.php'; ?>

    <main class="pagina">
        <div class="container">
            <div class="ficha-voltar">
                <a href="<?= BASE_URL ?>/treinos" class="btn btn--texto btn--pequeno ficha-voltar__btn">
                    <i class="ph ph-arrow-left"></i> Voltar para treinos
                </a>
            </div>

            <div class="pagina__cabecalho">
                <div>
                    <h1><?= htmlspecialchars($ficha['titulo']) ?></h1>
                    <p class="ficha-meta">Aluno: <strong class="ficha-meta__destaque"><?= htmlspecialchars($aluno['nome']) ?></strong></p>
                </div>
                <div class="pagina__acoes">
                    <span class="badge badge--<?= $ficha['status'] ?>"><?= ucfirst($ficha['status']) ?></span>
                </div>
            </div>

            <?php if(!empty($resultado)): ?>
            <div class="alerta alerta--<?= $resultado['sucesso'] ? 'sucesso' : 'erro' ?>" role="alert">
                <i class="ph-bold ph-<?= $resultado['sucesso'] ? 'check-circle' : 'x-circle' ?>"></i>
                <span><?= htmlspecialchars($resultado['mensagem']) ?></span>
            </div>
            <?php endif; ?>

            <div class="card ficha-detalhes">
                <h3>Informações da Ficha</h3>
                <p class="ficha-detalhes__texto">
                    <?= !empty($ficha['descricao']) ? nl2br(htmlspecialchars($ficha['descricao'])) : '<span class="form-hint">Nenhuma descrição adicionada.</span>' ?>
                </p>
            </div>

            <div class="ficha-acoes">
                <button type="button" class="btn btn--primario">
                    <i class="ph ph-plus"></i>
                    Adicionar Treinos
                </button>
                <button type="button" class="btn btn--secundario">
                    <i class="ph ph-arrows-down-up"></i>
                    Reordenar Treinos
                </button>
            </div>
        </div>
    </main>
</body>
</html>