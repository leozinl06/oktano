<?php

require_once __DIR__ . '/../core/BaseModel.php';
require_once __DIR__ . '/../core/ContaUsuario.php';

class Administrador extends BaseModel{
    use ContaUsuario;

    protected $tabela = 'administrador';

    public function cadastrar($nome, $email, $senha){
        return $this->cadastrarConta(['nome' => $nome, 'email' => $email, 'senha' => $senha]);
    }
}