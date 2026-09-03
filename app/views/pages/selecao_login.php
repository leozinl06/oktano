<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acessar Plataforma - Oktano</title>
    
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    
    <link rel="stylesheet" href="/oktano/public/assets/css/style.css">
    <link rel="stylesheet" href="/oktano/public/assets/css/login.css">
</head>
<body class="layout-auth">
    <main class="card-superficie">
        <div class="cadastro-logo-container">
            <div class="cadastro-logo-placeholder">Logo</div>
        </div>
        <header>
            <h1 class="titulo-principal">Acessar Plataforma</h1>
            <p class="subtitulo">Como você deseja entrar?</p>
        </header>

        <div class="selecao-container">
            <a href="login/acesso?tipo=personal" class="selecao-card">
                <i class="ph ph-barbell selecao-icone"></i>
                <span class="selecao-texto">Sou Personal</span>
            </a>
            
            <a href="login/acesso?tipo=praticante" class="selecao-card">
                <i class="ph ph-person selecao-icone"></i>
                <span class="selecao-texto">Sou Praticante</span>
            </a>
        </div>
    </main>
</body>
</html>