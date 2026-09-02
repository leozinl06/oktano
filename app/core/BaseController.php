<?php

abstract class BaseController{
    
    protected function redirecionarComResultado(string $url, bool $sucesso, string $mensagem): void{
        $_SESSION['resultado'] = ['sucesso' => $sucesso, 'mensagem' => $mensagem];
        header('Location: ' . $url);
        exit;
    }
}