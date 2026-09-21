<?php
/**
 * Partial: cabecalho
 * Variáveis esperadas do escopo que faz o include:
 *   $paginaAtiva (string) — slug da rota ativa, para marcar o link no menu
 * Usa a sessão para saber o tipo de usuário logado (personal/praticante/administrador).
 */
if(!defined('BASE_URL')){
    define('BASE_URL', '/oktano/public');
}
$paginaAtiva = $paginaAtiva ?? '';
$tipoUsuario = $_SESSION['usuario_tipo'] ?? null;
$nomeUsuario = $_SESSION['usuario_nome'] ?? '';

$linksPorTipo = [
    'personal' => [
        ['rota' => 'dashboard_personal', 'label' => 'Painel', 'icone' => 'ph-squares-four'],
        ['rota' => 'alunos', 'label' => 'Alunos', 'icone' => 'ph-users'],
        ['rota' => 'treinos', 'label' => 'Treinos', 'icone' => 'ph-barbell'],
        ['rota' => 'treinos/arquivados', 'label' => 'Arquivados', 'icone' => 'ph-archive'],
    ],
    'praticante' => [
        ['rota' => 'dashboard_praticante', 'label' => 'Painel', 'icone' => 'ph-squares-four'],
        ['rota' => 'meus-treinos', 'label' => 'Meus treinos', 'icone' => 'ph-barbell'],
    ],
    'administrador' => [
        ['rota' => 'dashboard_administrador', 'label' => 'Painel', 'icone' => 'ph-squares-four'],
    ],
];

$links = $linksPorTipo[$tipoUsuario] ?? [];
?>
<header class="cabecalho">
    <div class="cabecalho__conteudo">
        <a href="<?= BASE_URL ?>/<?= $tipoUsuario ? 'dashboard_' . $tipoUsuario : '' ?>" class="cabecalho__logo">
            <img src="<?= BASE_URL ?>/assets/img/logo.svg" alt="">
            Oktano
        </a>

        <button type="button" class="cabecalho__toggle" id="botao-menu-mobile" aria-expanded="false" aria-controls="nav-principal" aria-label="Abrir menu de navegação">
            <i class="ph ph-list"></i>
        </button>

        <nav class="cabecalho__nav" id="nav-principal">
            <ul class="cabecalho__links">
                <?php foreach($links as $link): ?>
                <li>
                    <a href="<?= BASE_URL . '/' . $link['rota'] ?>" class="cabecalho__link<?= $paginaAtiva === $link['rota'] ? ' is-ativo' : '' ?>">
                        <i class="ph <?= $link['icone'] ?>"></i>
                        <?= $link['label'] ?>
                    </a>
                </li>
                <?php endforeach; ?>
            </ul>

            <?php if($tipoUsuario): ?>
            <div class="cabecalho__usuario">
                <i class="ph ph-user-circle" style="font-size:1.3rem;"></i>
                <span><?= htmlspecialchars($nomeUsuario) ?></span>
                <a href="<?= BASE_URL ?>/logout" class="btn--icone" title="Sair" style="margin-left:auto;">
                    <i class="ph ph-sign-out"></i>
                </a>
            </div>
            <?php endif; ?>
        </nav>
    </div>
</header>

<script>
(() => {
    const botao = document.getElementById('botao-menu-mobile');
    const nav = document.getElementById('nav-principal');
    if(!botao || !nav) return;

    botao.addEventListener('click', () => {
        const aberto = nav.classList.toggle('is-aberto');
        botao.setAttribute('aria-expanded', aberto ? 'true' : 'false');
        botao.innerHTML = aberto ? '<i class="ph ph-x"></i>' : '<i class="ph ph-list"></i>';
    });

    nav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            nav.classList.remove('is-aberto');
            botao.setAttribute('aria-expanded', 'false');
            botao.innerHTML = '<i class="ph ph-list"></i>';
        });
    });
})();
</script>
