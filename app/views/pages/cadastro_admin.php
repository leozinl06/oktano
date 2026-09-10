<?php
$tituloPagina = "Crie sua conta (Administrador) - Oktano";
$estilosCSS = ['cadastro'];
require_once __DIR__ . '/../components/head.php';
?>

<body class="layout-auth">
    <main class="card-superficie">
        <div class="cadastro-logo-container">
            <img src="/oktano/public/assets/img/logo-texto__acima.svg" alt="Logo Oktano" class="cadastro-logo-container__imagem">
        </div>
        
        <header>
            <h1 class="titulo-principal">Área do Administrador</h1>
            <p class="subtitulo">Preencha seus dados abaixo</p>
        </header>

        <?php if(isset($resultado)): ?>
            <div class="alerta <?= $resultado['sucesso'] ? 'alerta-sucesso' : 'alerta-erro' ?>">
                <?= $resultado['mensagem'] ?>
            </div>
        <?php endif; ?>

        <form action="cadastro-admin/processar" method="POST" novalidate>
            
            <div class="form-group">
                <label for="nome" class="form-label">Nome Completo</label>
                <div class="input-wrapper">
                    <input type="text" id="nome" name="nome" class="form-input com-icone" placeholder="Seu Nome" required>
                    <i class="ph ph-user input-icon"></i>
                </div>
                <span class="form-error-msg"></span>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email Corporativo</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" class="form-input com-icone" placeholder="admin@oktano.com" required>
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
                
                <div class="forca-senha-container" id="indicador-forca">
                    <div class="forca-senha-barra"></div>
                    <div class="forca-senha-barra"></div>
                    <div class="forca-senha-barra"></div>
                </div>
                <span class="forca-senha-texto"></span>
                <span class="form-error-msg"></span>
            </div>

            <div class="form-group">
                <label for="confirmar-senha" class="form-label">Confirmar Senha</label>
                <div class="input-wrapper">
                    <input type="password" id="confirmar-senha" name="confirmar-senha" class="form-input com-icone" placeholder="*********" required>
                    <i class="ph ph-shield-check input-icon"></i>
                </div>
                <span class="form-error-msg"></span>
            </div>

            <button type="submit" class="btn btn-primario">Cadastrar como Administrador</button>
            <a href="/oktano/public/login/acesso?tipo=administrador" class="btn btn-secundario-texto">Voltar</a>
        </form>
    </main>

    <script type="module" src="/oktano/public/assets/js/cadastro_admin.js"></script>
</body>
</html>