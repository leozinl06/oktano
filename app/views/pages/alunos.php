<?php
$tituloPagina = 'Alunos';
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
        <div class="pagina__cabecalho">
            <div>
                <h1>Alunos</h1>
                <p>Praticantes vinculados ao seu código de personal.</p>
            </div>
        </div>

        <?php if(!empty($resultado)): ?>
        <div class="alerta alerta--<?= $resultado['sucesso'] ? 'sucesso' : 'erro' ?>" role="alert">
            <i class="ph-bold ph-<?= $resultado['sucesso'] ? 'check-circle' : 'x-circle' ?>"></i>
            <span><?= htmlspecialchars($resultado['mensagem']) ?></span>
        </div>
        <?php endif; ?>

        <?php if(empty($alunos)): ?>
            <div class="card estado-vazio">
                <i class="ph ph-users"></i>
                <h3>Nenhum aluno vinculado ainda</h3>
                <p>Compartilhe seu código de vínculo para que praticantes se cadastrem com você.</p>
            </div>
        <?php else: ?>

        <div class="campo-busca" style="margin-bottom: var(--espaco-4);">
            <i class="ph ph-magnifying-glass"></i>
            <input type="search" id="pesquisa-aluno" class="form-input" placeholder="Buscar aluno pelo nome...">
        </div>

        <p id="msg-pesquisa-vazia" class="form-hint is-hidden" style="margin-bottom: var(--espaco-3);">
            Nenhum aluno encontrado com esse nome.
        </p>

        <div>
            <?php foreach($alunos as $aluno): ?>
            <div class="aluno-item">
                <button type="button" class="aluno-item__cabecalho" aria-expanded="false">
                    <span class="aluno-item__identidade">
                        <span class="aluno-item__avatar"><?= strtoupper(substr($aluno['nome_exibicao'], 0, 1)) ?></span>
                        <span>
                            <span class="aluno-item__nome"><?= htmlspecialchars($aluno['nome_exibicao']) ?></span><br>
                            <span class="aluno-item__meta"><?= count($aluno['fichas']) ?> ficha(s) ativa(s)</span>
                        </span>
                    </span>
                    <i class="ph ph-caret-down aluno-item__chevron"></i>
                </button>

                <div class="aluno-item__corpo">
                    <div class="aluno-item__conteudo">
                        <?php if(empty($aluno['fichas'])): ?>
                            <p class="form-hint">Este aluno ainda não tem fichas de treino.</p>
                        <?php else: ?>
                            <?php foreach($aluno['fichas'] as $ficha): ?>
                            <div class="aluno-item__ficha">
                                <div>
                                    <div style="font-weight:600;"><?= htmlspecialchars($ficha['titulo']) ?></div>
                                    <span class="badge badge--<?= $ficha['status'] ?>"><?= ucfirst($ficha['status']) ?></span>
                                </div>
                                <a href="<?= BASE_URL ?>/treinos/editar-ficha?id=<?= $ficha['id'] ?>" class="btn btn--secundario btn--pequeno">
                                    <i class="ph ph-pencil-simple"></i>
                                    Editar
                                </a>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <a href="<?= BASE_URL ?>/treinos/nova-ficha?aluno_id=<?= $aluno['id'] ?>" class="btn btn--primario btn--pequeno" style="align-self: flex-start;">
                            <i class="ph ph-plus"></i>
                            Nova ficha para <?= htmlspecialchars($aluno['nome_exibicao']) ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>

        <?php endif; ?>
    </div>
</main>

<script type="module" src="<?= BASE_URL ?>/assets/js/alunos.js"></script>

</body>
</html>
