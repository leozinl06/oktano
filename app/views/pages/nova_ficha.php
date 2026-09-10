<?php
$tituloPagina = "Nova Ficha - Oktano";
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
                <h1 class="titulo-principal">Criar Ficha de Treino</h1>
                <p class="subtitulo">Vinculando ao aluno: <strong><?= htmlspecialchars($aluno['nome']) ?></strong></p>
            </header>

            <section class="card-superficie">
                <?php if(isset($resultado)): ?>
                    <div class="alerta <?= $resultado['sucesso'] ? 'alerta-sucesso' : 'alerta-erro' ?>">
                        <?= $resultado['mensagem'] ?>
                    </div>
                <?php endif; ?>

                <form action="/oktano/public/treinos/criar-ficha" method="POST">
                    <input type="hidden" name="id_aluno" value="<?= htmlspecialchars($aluno['id']) ?>">

                    <div class="form-group">
                        <label for="titulo" class="form-label">Título da Ficha</label>
                        <div class="input-wrapper">
                            <input type="text" id="titulo" name="titulo" class="form-input" placeholder="Ex: Hipertrofia A" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="descricao" class="form-label">Descrição (Opcional)</label>
                        <div class="input-wrapper">
                            <textarea id="descricao" name="descricao" class="form-input" rows="4" placeholder="Observações gerais da ficha..."></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Status Inicial</label>
                        <div class="input-wrapper">
                            <select id="status" name="status" class="form-input" required>
                                <option value="rascunho">Rascunho</option>
                                <option value="ativa">Ativa</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primario">Salvar Ficha</button>
                    <a href="/oktano/public/alunos" class="btn btn-secundario-texto">Cancelar</a>
                </form>
            </section>
        </div>
    </main>
</body>
</html>