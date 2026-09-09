<?php

$rota_cadastro = ($tipo_usuario === 'praticante') ? 'cadastro-praticante' : 'cadastro';
$tituloPagina = "Login " . ucfirst($tipo_usuario) . " - Oktano";
$estilosCSS = ['login'];
require_once __DIR__ . '/../components/head.php';

?>
<body class="layout-auth">
    <main class="card-superficie">
        <div class="cadastro-logo-container">
            <div class="cadastro-logo-placeholder">Logo</div>
        </div>
        
        <header>
            <h1 class="titulo-principal">Área do <?= ucfirst($tipo_usuario) ?></h1>
            <p class="subtitulo">Insira seus dados para acessar</p>
        </header>

        <?php if(isset($resultado)): ?>
            <div class="alerta <?= $resultado['sucesso'] ? 'alerta-sucesso' : 'alerta-erro' ?>">
                <?= $resultado['mensagem'] ?>
            </div>
        <?php endif; ?>

        <form action="/oktano/public/login/processar" method="POST" novalidate>
            <input type="hidden" name="tipo_usuario" value="<?= $tipo_usuario ?>">

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" class="form-input com-icone" placeholder="seu@email.com" required>
                    <i class="ph ph-envelope input-icon"></i>
                </div>
                <span class="form-error-msg"></span>
            </div>

            <div class="form-group">
                <label for="senha" class="form-label">Senha</label>
                <div class="input-wrapper">
                    <input type="password" id="senha" name="senha" class="form-input com-icone" placeholder="*********" required>
                    <i class="ph ph-lock-key input-icon"></i>
                </div>
                <span class="form-error-msg"></span>
            </div>

            <button type="submit" class="btn btn-primario">Entrar</button>
            <a href="/oktano/public/login" class="btn btn-secundario-texto">Voltar</a>
            
            <div class="link-container">
                <a href="/oktano/public/<?= $rota_cadastro ?>" class="link-simples">Não tem uma conta? Cadastre-se</a>
            </div>
        </form>
    </main>

    <script type="module" src="/oktano/public/assets/js/login.js"></script>
</body>
</html>