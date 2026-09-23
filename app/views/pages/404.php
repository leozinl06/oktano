<?php 
if(session_status() === PHP_SESSION_NONE) session_start();
$tituloPagina = 'Página não encontrada'; 
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?php require __DIR__ . '/../components/head.php'; ?>
</head>
<body>
    <main class="pagina-erro">
        <div class="erro-container">
            <i class="ph ph-map-trifold erro-container__icone"></i>
            
            <h1 class="erro-container__titulo">Erro 404</h1>
            <p class="erro-container__texto">
                Desculpe, não conseguimos encontrar a página que você está procurando. Ela pode ter sido movida, excluída ou o endereço digitado está incorreto.
            </p>
            
            <?php 
                $urlInicio = BASE_URL . '/login';
                if (isset($_SESSION['usuario_tipo'])) {
                    $urlInicio = BASE_URL . '/dashboard_' . $_SESSION['usuario_tipo'];
                }
            ?>
            <a href="<?= htmlspecialchars($urlInicio) ?>" class="btn btn--primario">
                <i class="ph ph-arrow-left"></i>
                Voltar para o Início
            </a>
        </div>
    </main>
</body>
</html>