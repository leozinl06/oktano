<?php
$tituloPagina = "Acessar Plataforma - Oktano";
$estilosCSS = ['login'];
require_once __DIR__ . '/../components/head.php';
?>
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