<?php
$tituloPagina = 'Meus treinos';
$paginaAtiva = 'meus-treinos';
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
        <div class="pagina__cabecalho">
            <div>
                <h1>Meus treinos</h1>
                <p>Fichas ativas montadas pelo seu personal trainer.</p>
            </div>
        </div>

        <?php if(empty($fichasAtivas)): ?>
            <div class="card estado-vazio">
                <i class="ph ph-barbell"></i>
                <h3>Nenhuma ficha ativa no momento</h3>
                <p>Assim que seu personal criar uma ficha de treino para você, ela aparecerá aqui.</p>
            </div>
        <?php else: ?>
        <div class="grade-fichas">
            <?php foreach($fichasAtivas as $ficha): ?>
            <div class="card cartao-ficha">
                <div class="cartao-ficha__topo">
                    <h3><?= htmlspecialchars($ficha['titulo']) ?></h3>
                    <span class="badge badge--<?= $ficha['status'] ?>"><?= ucfirst($ficha['status']) ?></span>
                </div>
                <p class="cartao-ficha__desc">
                    <?= $ficha['descricao'] !== '' ? htmlspecialchars($ficha['descricao']) : 'Sem observações adicionadas pelo personal.' ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>
