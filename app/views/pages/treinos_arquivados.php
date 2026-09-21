<?php
$tituloPagina = 'Treinos arquivados';
$paginaAtiva = 'treinos/arquivados';
$urlAtual = $_SERVER['REQUEST_URI'] ?? (BASE_URL . '/treinos/arquivados');
$urlRetorno = $urlAtual;
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
                <h1>Fichas arquivadas</h1>
                <p>Fichas que não estão mais ativas para os alunos.</p>
            </div>
            <div class="pagina__acoes">
                <a href="<?= BASE_URL ?>/treinos" class="btn btn--secundario">
                    <i class="ph ph-arrow-left"></i>
                    Voltar para treinos
                </a>
            </div>
        </div>

        <?php if(!empty($resultado)): ?>
        <div class="alerta alerta--<?= $resultado['sucesso'] ? 'sucesso' : 'erro' ?>" role="alert">
            <i class="ph-bold ph-<?= $resultado['sucesso'] ? 'check-circle' : 'x-circle' ?>"></i>
            <span><?= htmlspecialchars($resultado['mensagem']) ?></span>
        </div>
        <?php endif; ?>

        <?php if(empty($fichas)): ?>
            <div class="card estado-vazio">
                <i class="ph ph-archive"></i>
                <h3>Nenhuma ficha arquivada</h3>
                <p>Fichas arquivadas a partir da tela de treinos aparecerão aqui.</p>
            </div>
        <?php else: ?>
        <div class="tabela-wrapper">
            <table class="tabela">
                <thead>
                    <tr>
                        <th>Aluno</th>
                        <th>Ficha</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($fichas as $ficha): ?>
                    <tr>
                        <td data-rotulo="Aluno"><?= htmlspecialchars($ficha['nome_aluno']) ?></td>
                        <td data-rotulo="Ficha">
                            <div class="tabela__titulo-principal"><?= htmlspecialchars($ficha['titulo']) ?></div>
                            <?php if(!empty($ficha['descricao'])): ?>
                            <div class="tabela__subtexto"><?= htmlspecialchars($ficha['descricao']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td data-rotulo="Status">
                            <span class="badge badge--arquivada">Arquivada</span>
                        </td>
                        <td data-rotulo="Ações">
                            <div class="tabela__acoes">
                                <form method="POST" action="<?= BASE_URL ?>/treinos/desarquivar-ficha" onsubmit="return confirm('Restaurar esta ficha para rascunho?');">
                                    <input type="hidden" name="id_ficha" value="<?= $ficha['id'] ?>">
                                    <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($urlAtual) ?>">
                                    <button type="submit" class="btn btn--icone" title="Restaurar ficha">
                                        <i class="ph ph-arrow-counter-clockwise"></i>
                                    </button>
                                </form>
                                <button type="button" class="btn btn--icone js-btn-excluir-ficha" data-id="<?= $ficha['id'] ?>" title="Excluir ficha">
                                    <i class="ph ph-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>
    </div>
</main>

<?php require __DIR__ . '/../components/modal_excluir.php'; ?>

<script type="module" src="<?= BASE_URL ?>/assets/js/modal_exclusao.js"></script>

</body>
</html>
