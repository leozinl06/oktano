<?php $tituloPagina = 'Cadastro de Administrador'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<?php require __DIR__ . '/../components/head.php'; ?>
</head>
<body>

<div class="tela-auth">
    <aside class="tela-auth__lateral">
        <div class="tela-auth__logo">
            <img src="<?= BASE_URL ?>/assets/img/logo-texto__direita.svg" alt="">
        </div>
        <div>
            <h2>Supervisione a plataforma com segurança.</h2>
            <p>Contas de administrador têm acesso a informações sensíveis — cadastre-se apenas se estiver autorizado.</p>
        </div>
        <p style="color: var(--cor-texto-terciario); font-size: 0.85rem;">© <?= date('Y') ?> Oktano</p>
    </aside>

    <div class="tela-auth__conteudo">
        <div class="tela-auth__caixa">
            <div class="tela-auth__cabecalho">
                <h1>Criar conta de Administrador</h1>
                <p>Preencha os dados abaixo para solicitar acesso administrativo.</p>
            </div>

            <?php if(!empty($resultado)): ?>
            <div class="alerta alerta--<?= $resultado['sucesso'] ? 'sucesso' : 'erro' ?>" role="alert">
                <i class="ph-bold ph-<?= $resultado['sucesso'] ? 'check-circle' : 'x-circle' ?>"></i>
                <span><?= htmlspecialchars($resultado['mensagem']) ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/cadastro-admin/processar" novalidate>
                <div class="form-group">
                    <label for="nome" class="form-label">Nome completo</label>
                    <input type="text" name="nome" id="nome" class="form-input" placeholder="Seu nome completo" autocomplete="name">
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" id="email" class="form-input" placeholder="seu@email.com" autocomplete="email">
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group">
                    <label for="senha" class="form-label">Senha</label>
                    <div class="campo-senha">
                        <input type="password" name="senha" id="senha" class="form-input" placeholder="Mínimo de 8 caracteres" autocomplete="new-password">
                        <button type="button" class="campo-senha__alternar js-alternar-senha" data-alvo="senha" aria-label="Mostrar senha">
                            <i class="ph ph-eye"></i>
                        </button>
                    </div>
                    <div class="forca-senha" id="indicador-forca"><span></span><span></span><span></span></div>
                    <span class="forca-senha-texto">Força da senha: -</span>
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group">
                    <label for="confirmar-senha" class="form-label">Confirmar senha</label>
                    <input type="password" name="confirmar-senha" id="confirmar-senha" class="form-input" placeholder="Repita a senha" autocomplete="new-password">
                    <span class="form-error-msg"></span>
                </div>

                <button type="submit" class="btn btn--primario btn--bloco" style="margin-top: var(--espaco-2);">
                    Criar conta
                    <i class="ph ph-arrow-right"></i>
                </button>
            </form>

            <p class="tela-auth__rodape">
                Já tem uma conta?
                <a href="<?= BASE_URL ?>/login/acesso?tipo=administrador">Entrar</a>
            </p>
        </div>
    </div>
</div>

<script type="module" src="<?= BASE_URL ?>/assets/js/cadastro_admin.js"></script>
<script src="<?= BASE_URL ?>/assets/js/alternar-senha.js"></script>

</body>
</html>
