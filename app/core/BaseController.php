<?php

abstract class BaseController{

    protected function iniciarSessao(): void{
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }

    protected function exigirAutenticacao(string $tipoEsperado): int{
        $this->iniciarSessao();
        $idUsuario = $_SESSION['usuario_id'] ?? null;
        if(!$idUsuario || ($_SESSION['usuario_tipo'] ?? '') !== $tipoEsperado){
            header('Location: /oktano/public/login/acesso?tipo=' . urlencode($tipoEsperado));
            exit;
        }

        return (int)$idUsuario;
    }

    protected function obterResultadoSessao(): ?array{
        $this->iniciarSessao();
        $resultado = $_SESSION['resultado'] ?? null;
        unset($_SESSION['resultado']);
        return $resultado;
    }
    
    protected function redirecionarComResultado(string $url, bool $sucesso, string $mensagem): void{
        $_SESSION['resultado'] = ['sucesso' => $sucesso, 'mensagem' => $mensagem];
        header('Location: ' . $url);
        exit;
    }
}