<?php
$tituloPagina = 'Treinos';
$paginaAtiva = 'treinos';
$urlAtual = $_SERVER['REQUEST_URI'] ?? (BASE_URL . '/treinos');
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
                <h1>Fichas de treino</h1>
                <p>Fichas ativas dos seus alunos.</p>
            </div>
            <div class="pagina__acoes">
                <a href="<?= BASE_URL ?>/treinos/arquivados" class="btn btn--secundario">
                    <i class="ph ph-archive"></i>
                    Arquivados
                </a>
                <a href="<?= BASE_URL ?>/alunos" class="btn btn--primario">
                    <i class="ph ph-plus"></i>
                    Nova ficha
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
                <i class="ph ph-clipboard-text"></i>
                <h3>Nenhuma ficha ativa</h3>
                <p>Comece criando uma ficha de treino a partir da página de um aluno.</p>
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
                            <a href="<?= BASE_URL ?>/treinos/detalhes?id=<?= $ficha['id'] ?>" class="tabela__titulo-principal tabela__ficha-link">
                                <?= htmlspecialchars($ficha['titulo']) ?>
                            </a>
                            <?php if(!empty($ficha['descricao'])): ?>
                            <div class="tabela__subtexto"><?= htmlspecialchars($ficha['descricao']) ?></div>
                            <?php endif; ?>
                        </td>
                        <td data-rotulo="Status">
                            <span class="badge badge--<?= $ficha['status'] ?>"><?= ucfirst($ficha['status']) ?></span>
                        </td>
                        <td data-rotulo="Ações">
                            <div class="tabela__acoes">
                                <a href="<?= BASE_URL ?>/treinos/detalhes?id=<?= $ficha['id'] ?>" class="btn btn--icone" title="Ver detalhes">
                                    <i class="ph ph-eye"></i>
                                </a>
                                <a href="<?= BASE_URL ?>/treinos/editar-ficha?id=<?= $ficha['id'] ?>" class="btn btn--icone" title="Editar ficha">
                                    <i class="ph ph-pencil-simple"></i>
                                </a>
                                <button type="button" class="btn btn--icone js-btn-arquivar-ficha" data-id="<?= $ficha['id'] ?>" title="Arquivar ficha">
                                    <i class="ph ph-archive"></i>
                                </button>
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

<?php require __DIR__ . '/../components/modal_arquivar.php'; ?>
<?php require __DIR__ . '/../components/modal_excluir.php'; ?>

<script type="module" src="<?= BASE_URL ?>/assets/js/treinos.js"></script>
<script type="module" src="<?= BASE_URL ?>/assets/js/modal_arquivar.js"></script>
<script type="module" src="<?= BASE_URL ?>/assets/js/modal_exclusao.js"></script>

</body>
</html>
