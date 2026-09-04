<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $tituloPagina ?? "Oktano" ?></title>

    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    <link rel="stylesheet" href="/oktano/public/assets/css/style.css">

    <?php if(isset($estilosCSS) && is_array($estilosCSS)): ?>
        <?php foreach ($estilosCSS as $css): ?>
            <link rel="stylesheet" href="/oktano/public/assets/css/<?= htmlspecialchars($css) ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
