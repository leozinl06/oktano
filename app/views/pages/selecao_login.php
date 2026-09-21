<?php $tituloPagina = 'Entrar'; ?>
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
            <h2>Treino acompanhado, resultado de verdade.</h2>
            <p>Personal trainers montam e acompanham fichas de treino; alunos executam e evoluem — tudo em um só lugar.</p>
        </div>
        <p style="color: var(--cor-texto-terciario); font-size: 0.85rem;">© <?= date('Y') ?> Oktano</p>
    </aside>

    <div class="tela-auth__conteudo">
        <div class="tela-auth__caixa" style="max-width: 560px;">
            <div class="tela-auth__logo" style="justify-content:center; display:none;"></div>

            <div class="tela-auth__cabecalho" style="text-align:center;">
                <h1>Como você quer entrar?</h1>
                <p>Escolha o tipo de acesso para continuar no Oktano.</p>
            </div>

            <div class="grade-selecao">
                <a href="<?= BASE_URL ?>/login/acesso?tipo=personal" class="cartao-selecao">
                    <span class="cartao-selecao__icone"><i class="ph ph-barbell"></i></span>
                    <span class="cartao-selecao__titulo">Sou Personal</span>
                    <span class="cartao-selecao__desc">Gerencio alunos e monto fichas de treino.</span>
                </a>
                <a href="<?= BASE_URL ?>/login/acesso?tipo=praticante" class="cartao-selecao">
                    <span class="cartao-selecao__icone"><i class="ph ph-person-simple-run"></i></span>
                    <span class="cartao-selecao__titulo">Sou Praticante</span>
                    <span class="cartao-selecao__desc">Acompanho os treinos que meu personal montou.</span>
                </a>
                <a href="<?= BASE_URL ?>/login/acesso?tipo=administrador" class="cartao-selecao">
                    <span class="cartao-selecao__icone"><i class="ph ph-shield-check"></i></span>
                    <span class="cartao-selecao__titulo">Sou Administrador</span>
                    <span class="cartao-selecao__desc">Supervisiono contas e o funcionamento da plataforma.</span>
                </a>
            </div>

            <p class="tela-auth__rodape">
                Ainda não tem conta?
                <a href="<?= BASE_URL ?>/cadastro">Cadastre-se como Personal</a>
                ou
                <a href="<?= BASE_URL ?>/cadastro-praticante">como Praticante</a>.
            </p>
        </div>
    </div>
</div>

</body>
</html>
