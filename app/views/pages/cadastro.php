<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crie sua conta (Personal) - Oktano</title>
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/cadastro.css">
</head>
<body>

    <main class="card-superficie">
        <div class="cadastro-logo-container">
            <div class="cadastro-logo-placeholder">Logo</div>
        </div>

        <header>
            <h1 class="titulo-principal">Área do Personal</h1>
            <p class="subtitulo">Preencha seus dados abaixo</p>
        </header>

        <?php if(isset($resultado)): ?>
            <div class="alerta <?= $resultado['sucesso'] ? 'alerta-sucesso' : 'alerta-erro' ?>">
                <?= $resultado['mensagem'] ?>
            </div>
        <?php endif; ?>

        <form action="cadastro/processar" method="POST" novalidate>
            
            <div class="form-group">
                <label for="nome" class="form-label">Nome Completo</label>
                <div class="input-wrapper">
                    <input type="text" id="nome" name="nome" class="form-input com-icone" placeholder="João Silva" required>
                    <i class="ph ph-user input-icon"></i>
                </div>
                <span class="form-error-msg"></span>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-wrapper">
                    <input type="email" id="email" name="email" class="form-input com-icone" placeholder="joaosilva@exemplo.com" required>
                    <i class="ph ph-envelope input-icon"></i>
                </div>
                <span class="form-error-msg"></span>
            </div>

            <div class="form-group">
                <label for="registro" class="form-label">Registro Profissional (CREF, CREFITO)</label>
                <div class="input-wrapper">
                    <input type="text" id="registro" name="registro" class="form-input com-icone" placeholder="Ex: 000000-G/UF" required>
                    <i class="ph ph-identification-badge input-icon"></i>
                </div>
                <span class="form-error-msg"></span>
            </div>

            <div class="form-group">
                <label for="codigo_vinculo" class="form-label">Código de Vínculo (6 caracteres)</label>
                <div class="input-wrapper">
                    <input type="text" id="codigo_vinculo" name="codigo_vinculo" class="form-input com-icone" placeholder="Ex: A1B2C3" maxlength="6" required>
                    <i class="ph ph-link input-icon"></i>
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

            <button type="submit" class="btn btn-primario">Cadastrar como Personal</button>
            <a href="/oktano/public/login/acesso?tipo=personal" class="btn btn-secundario-texto">Voltar</a>

        </form>
    </main>

    <script src="assets/js/cadastro.js"></script>
</body>
</html>