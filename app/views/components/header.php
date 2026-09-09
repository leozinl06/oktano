<?php

$url = "/oktano/public";

$tipoUsuario = $tipoUsuario ?? 'default';

$menus = [
    'personal' => [
        ['url' => $url . '/dashboard_personal', 'icone' => 'ph-squares-four', 'texto' => 'Início'],
        ['url' => $url . '/alunos', 'icone' => 'ph-users', 'texto' => 'Alunos'],
        ['url' => $url . '/treinos', 'icone' => 'ph-clipboard-text', 'texto' => 'Treinos']
    ],
    'praticante' => [
        ['url' => $url . '/dashboard_praticante', 'icone' => 'ph-squares-four', 'texto' => 'Início'],
        ['url' => $url . '/meus-treinos', 'icone' => 'ph-barbell', 'texto' => 'Meus Treinos'],
        ['url' => $url . '/progesso', 'icone' => 'ph-chart-line-up', 'texto' => 'Progresso']
    ]
];

$linksAtuais = $menus[$tipoUsuario] ?? [];

?>

<header class='header-layout'>
    <div class="header-layout__logo">
        <span class="logo-texto">Oktano</span>
    </div>

    <div class="header-layout__controles">
        <nav class="nav-principal">
            <?php foreach($linksAtuais as $link): ?>
                <a href="<?= htmlspecialchars($link['url']) ?>" class="nav-principal__item">
                    <i class="ph <?= htmlspecialchars($link['icone']) ?> nav-principal__icone"></i>
                    <span class="nav-principal__texto"><?= htmlspecialchars($link['texto']) ?></span>
                </a>
            <?php endforeach; ?>
        </nav>

        <div class="avatar-usuario">
            <i class="ph ph-user avatar-usuario__icone"></i>
        </div>
    </div>

</header>