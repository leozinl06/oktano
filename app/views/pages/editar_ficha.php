<?php
$tituloPagina = 'Editar ficha';
$paginaAtiva = 'treinos';
$urlVoltar = $url_origem ?? (BASE_URL . '/treinos');
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
        <a href="<?= htmlspecialchars($urlVoltar) ?>" class="btn btn--texto btn--pequeno" style="padding-left:0; margin-bottom: var(--espaco-3);">
            <i class="ph ph-arrow-left"></i> Voltar
        </a>

        <div class="pagina__cabecalho">
            <div>
                <h1>Editar ficha de treino</h1>
                <p>Aluno: <strong style="color: var(--cor-texto);"><?= htmlspecialchars($aluno['nome']) ?></strong></p>
            </div>
        </div>

        <?php if(!empty($resultado)): ?>
        <div class="alerta alerta--<?= $resultado['sucesso'] ? 'sucesso' : 'erro' ?>" role="alert">
            <i class="ph-bold ph-<?= $resultado['sucesso'] ? 'check-circle' : 'x-circle' ?>"></i>
            <span><?= htmlspecialchars($resultado['mensagem']) ?></span>
        </div>
        <?php endif; ?>

        <div class="card card-formulario">
            <form method="POST" action="<?= BASE_URL ?>/treinos/atualizar-ficha" novalidate>
                <input type="hidden" name="id_ficha" value="<?= $ficha['id'] ?>">
                <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($urlVoltar) ?>">

                <div class="form-group">
                    <label for="titulo" class="form-label">Título da ficha</label>
                    <input type="text" name="titulo" id="titulo" class="form-input" value="<?= htmlspecialchars($ficha['titulo']) ?>">
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group">
                    <label for="descricao" class="form-label">Descrição <span class="opcional">(opcional)</span></label>
                    <textarea name="descricao" id="descricao" class="form-textarea"><?= htmlspecialchars($ficha['descricao']) ?></textarea>
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="rascunho" <?= $ficha['status'] === 'rascunho' ? 'selected' : '' ?>>Rascunho</option>
                        <option value="ativa" <?= $ficha['status'] === 'ativa' ? 'selected' : '' ?>>Ativa</option>
                        <option value="arquivada" <?= $ficha['status'] === 'arquivada' ? 'selected' : '' ?>>Arquivada</option>
                    </select>
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-rodape">
                    <a href="<?= htmlspecialchars($urlVoltar) ?>" class="btn btn--secundario">Cancelar</a>
                    <button type="submit" class="btn btn--primario">
                        <i class="ph ph-check"></i>
                        Salvar alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script type="module" src="<?= BASE_URL ?>/assets/js/editar_ficha.js"></script>

</body>
</html>
