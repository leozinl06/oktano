<?php
$tituloPagina = "Editar Ficha - Oktano";
$estilosCSS = ['header', 'treino'];
require_once __DIR__ . '/../components/head.php';
?>
<body>
    <?php
        $tipoUsuario = 'personal';
        require_once __DIR__ . '/../components/header.php';
    ?>
    <main class="container-principal">
        <div class="conteudo-centralizado">
            <header class="cabecalho-pagina cabecalho-pagina--central">
                <h1 class="titulo-principal">Editar Ficha de Treino</h1>
                <p class="subtitulo">Atualizando a ficha de: <strong><?= htmlspecialchars($aluno['nome']) ?></strong></p>
            </header>

            <section class="card-superficie">
                <?php if(isset($resultado)): ?>
                    <div class="alerta <?= $resultado['sucesso'] ? 'alerta-sucesso' : 'alerta-erro' ?>">
                        <?= $resultado['mensagem'] ?>
                    </div>
                <?php endif; ?>

                <form action="/oktano/public/treinos/atualizar-ficha" method="POST" novalidate>
                    <input type="hidden" name="id_ficha" value="<?= htmlspecialchars($ficha['id']) ?>">
                    <input type="hidden" name="url_retorno" value="<?= htmlspecialchars($url_origem) ?>">

                    <div class="form-group">
                        <label for="titulo" class="form-label">Título da Ficha</label>
                        <div class="input-wrapper">
                            <input type="text" id="titulo" name="titulo" class="form-input" value="<?= htmlspecialchars($ficha['titulo']) ?>" placeholder="Ex: Hipertrofia A" required>
                        </div>
                        <span class="form-error-msg"></span>
                    </div>

                    <div class="form-group">
                        <label for="descricao" class="form-label">Descrição (Opcional)</label>
                        <div class="input-wrapper">
                            <textarea id="descricao" name="descricao" class="form-input" rows="4" placeholder="Observações gerais da ficha..."><?= htmlspecialchars($ficha['descricao']) ?></textarea>
                        </div>
                        <span class="form-error-msg"></span>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status Inicial</label>
                        <div class="input-wrapper">
                            <select id="status" name="status" class="form-input" required>
                                <option value="rascunho" <?= $ficha['status'] === 'rascunho' ? 'selected' : '' ?>>Rascunho</option>
                                <option value="ativa" <?= $ficha['status'] === 'ativa' ? 'selected' : '' ?>>Ativa</option>
                            </select>
                        </div>
                        <span class="form-error-msg"></span>
                    </div>

                    <button type="submit" class="btn btn-primario">Atualizar Ficha</button>
                    <a href="<?= htmlspecialchars($url_origem) ?>" class="btn btn-secundario-texto">Cancelar</a>
                </form>
            </section>
        </div>
    </main>
    <script type="module" src="/oktano/public/assets/js/editar_ficha.js"></script>
</body>
</html>