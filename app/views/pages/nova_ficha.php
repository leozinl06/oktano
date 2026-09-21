<?php
$tituloPagina = 'Nova ficha';
$paginaAtiva = 'alunos';
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
        <a href="<?= BASE_URL ?>/alunos" class="btn btn--texto btn--pequeno" style="padding-left:0; margin-bottom: var(--espaco-3);">
            <i class="ph ph-arrow-left"></i> Voltar para alunos
        </a>

        <div class="pagina__cabecalho">
            <div>
                <h1>Nova ficha de treino</h1>
                <p>Para <strong style="color: var(--cor-texto);"><?= htmlspecialchars($aluno['nome']) ?></strong></p>
            </div>
        </div>

        <?php if(!empty($resultado)): ?>
        <div class="alerta alerta--<?= $resultado['sucesso'] ? 'sucesso' : 'erro' ?>" role="alert">
            <i class="ph-bold ph-<?= $resultado['sucesso'] ? 'check-circle' : 'x-circle' ?>"></i>
            <span><?= htmlspecialchars($resultado['mensagem']) ?></span>
        </div>
        <?php endif; ?>

        <div class="card card-formulario">
            <form method="POST" action="<?= BASE_URL ?>/treinos/criar-ficha" novalidate>
                <input type="hidden" name="id_aluno" value="<?= $aluno['id'] ?>">

                <div class="form-group">
                    <label for="titulo" class="form-label">Título da ficha</label>
                    <input type="text" name="titulo" id="titulo" class="form-input" placeholder="Ex.: Treino A — Superiores">
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group">
                    <label for="descricao" class="form-label">Descrição <span class="opcional">(opcional)</span></label>
                    <textarea name="descricao" id="descricao" class="form-textarea" placeholder="Séries, repetições, observações..."></textarea>
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">Status inicial</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">Selecione...</option>
                        <option value="rascunho">Rascunho</option>
                        <option value="ativa">Ativa</option>
                    </select>
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-rodape">
                    <a href="<?= BASE_URL ?>/alunos" class="btn btn--secundario">Cancelar</a>
                    <button type="submit" class="btn btn--primario">
                        <i class="ph ph-check"></i>
                        Criar ficha
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script type="module" src="<?= BASE_URL ?>/assets/js/nova_ficha.js"></script>

</body>
</html>
