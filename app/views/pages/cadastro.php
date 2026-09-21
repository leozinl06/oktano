<?php $tituloPagina = 'Cadastro de Personal'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
<?php require __DIR__ . '/../components/head.php'; ?>
</head>
<body>

<div class="tela-auth">
    <aside class="tela-auth__lateral">
        <div class="tela-auth__logo">
            <img src="<?= BASE_URL ?>/assets/img/logo.svg" alt="">
            Oktano
        </div>
        <div>
            <h2>Leve sua carteira de alunos para o digital.</h2>
            <p>Monte fichas de treino, acompanhe a evolução dos seus alunos e organize tudo com o código de vínculo do Oktano.</p>
        </div>
        <p style="color: var(--cor-texto-terciario); font-size: 0.85rem;">© <?= date('Y') ?> Oktano</p>
    </aside>

    <div class="tela-auth__conteudo">
        <div class="tela-auth__caixa">
            <div class="tela-auth__cabecalho">
                <h1>Criar conta de Personal</h1>
                <p>Preencha seus dados profissionais para começar.</p>
            </div>

            <?php if(!empty($resultado)): ?>
            <div class="alerta alerta--<?= $resultado['sucesso'] ? 'sucesso' : 'erro' ?>" role="alert">
                <i class="ph-bold ph-<?= $resultado['sucesso'] ? 'check-circle' : 'x-circle' ?>"></i>
                <span><?= htmlspecialchars($resultado['mensagem']) ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/cadastro/processar" novalidate>
                <div class="form-group">
                    <label for="nome" class="form-label">Nome completo</label>
                    <input type="text" name="nome" id="nome" class="form-input" placeholder="Como você quer ser chamado" autocomplete="name">
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" id="email" class="form-input" placeholder="seu@email.com" autocomplete="email">
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group">
                    <label for="registro" class="form-label">Registro profissional</label>
                    <input type="text" name="registro" id="registro" class="form-input" placeholder="Ex.: CREF 000000-G/PR">
                    <span class="form-hint">Inclua a sigla do estado (mínimo de 5 caracteres).</span>
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group">
                    <label for="codigo_vinculo" class="form-label">Código de vínculo</label>
                    <input type="text" name="codigo_vinculo" id="codigo_vinculo" class="form-input" placeholder="6 caracteres, ex.: A1B2C3" maxlength="6">
                    <span class="form-hint">Você usará esse código para vincular seus alunos ao seu perfil.</span>
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
                <a href="<?= BASE_URL ?>/login/acesso?tipo=personal">Entrar</a>
            </p>
        </div>
    </div>
</div>

<script type="module" src="<?= BASE_URL ?>/assets/js/cadastro.js"></script>
<script src="<?= BASE_URL ?>/assets/js/alternar-senha.js"></script>

</body>
</html>
