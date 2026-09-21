<?php
/**
 * Partial: head
 * Variáveis esperadas do escopo que faz o include:
 *   $tituloPagina (string) — título específico da página, opcional
 */
if(!defined('BASE_URL')){
    $caminhoBase = dirname($_SERVER['SCRIPT_NAME']);
    $base = ($caminhoBase === '/' || $caminhoBase === '\\') ? '' : $caminhoBase;
    define('BASE_URL', $base);
}
$titulo = isset($tituloPagina) && $tituloPagina !== ''
    ? $tituloPagina . ' · Oktano'
    : 'Oktano — Gestão de treinos';
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($titulo) ?></title>
<link rel="icon" type="image/svg+xml" href="<?= BASE_URL ?>/assets/img/logo.svg">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.0.3/src/regular/style.css">
<link rel="stylesheet" href="https://unpkg.com/@phosphor-icons/web@2.0.3/src/bold/style.css">

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/token.css">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/base.css">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/components.css">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/layout.css">