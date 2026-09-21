<?php
$tituloPagina = 'Entrar';

$rotulosPorTipo = [
    'personal' => ['label' => 'Personal', 'icone' => 'ph-whistle', 'cadastro' => 'cadastro'],
    'praticante' => ['label' => 'Praticante', 'icone' => 'ph-person-simple-run', 'cadastro' => 'cadastro-praticante'],
    'administrador' => ['label' => 'Administrador', 'icone' => 'ph-shield-check', 'cadastro' => null],
];
$infoTipo = $rotulosPorTipo[$tipo_usuario] ?? ['label' => 'usuário', 'icone' => 'ph-user', 'cadastro' => null];
?>
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
            <h2>Bem-vindo de volta.</h2>
            <p>Entre para acompanhar seus treinos e continuar de onde parou.</p>
        </div>
        <p style="color: var(--cor-texto-terciario); font-size: 0.85rem;">© <?= date('Y') ?> Oktano</p>
    </aside>

    <div class="tela-auth__conteudo">
        <div class="tela-auth__caixa">
            <a href="<?= BASE_URL ?>/login" class="btn btn--texto btn--pequeno" style="margin-bottom: var(--espaco-4); padding-left:0;">
                <i class="ph ph-arrow-left"></i> Trocar tipo de acesso
            </a>

            <div class="tela-auth__cabecalho">
                <h1>Entrar como <?= htmlspecialchars($infoTipo['label']) ?></h1>
                <p>Informe seus dados de acesso para continuar.</p>
            </div>

            <?php if(!empty($resultado)): ?>
            <div class="alerta alerta--<?= $resultado['sucesso'] ? 'sucesso' : 'erro' ?>" role="alert">
                <i class="ph-bold ph-<?= $resultado['sucesso'] ? 'check-circle' : 'x-circle' ?>"></i>
                <span><?= htmlspecialchars($resultado['mensagem']) ?></span>
            </div>
            <?php endif; ?>

            <form method="POST" action="<?= BASE_URL ?>/login/processar" novalidate>
                <input type="hidden" name="tipo_usuario" value="<?= htmlspecialchars($tipo_usuario) ?>">

                <div class="form-group">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" name="email" id="email" class="form-input" placeholder="seu@email.com" autocomplete="email">
                    <span class="form-error-msg"></span>
                </div>

                <div class="form-group">
                    <div class="linha-senha">
                        <label for="senha" class="form-label">Senha</label>
                    </div>
                    <div class="campo-senha">
                        <input type="password" name="senha" id="senha" class="form-input" placeholder="Sua senha" autocomplete="current-password">
                        <button type="button" class="campo-senha__alternar js-alternar-senha" data-alvo="senha" aria-label="Mostrar senha">
                            <i class="ph ph-eye"></i>
                        </button>
                    </div>
                    <span class="form-error-msg"></span>
                </div>

                <button type="submit" class="btn btn--primario btn--bloco" style="margin-top: var(--espaco-2);">
                    Entrar
                    <i class="ph ph-arrow-right"></i>
                </button>
            </form>

            <?php if($infoTipo['cadastro']): ?>
            <p class="tela-auth__rodape">
                Ainda não tem conta?
                <a href="<?= BASE_URL . '/' . $infoTipo['cadastro'] ?>">Cadastre-se</a>
            </p>
            <?php else: ?>
            <p class="tela-auth__rodape">
                Acesso de administrador é concedido pela equipe Oktano.
            </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script type="module" src="<?= BASE_URL ?>/assets/js/login.js"></script>
<script src="<?= BASE_URL ?>/assets/js/alternar-senha.js"></script>

</body>
</html>
