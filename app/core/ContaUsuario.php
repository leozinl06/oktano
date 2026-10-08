<?php

trait ContaUsuario{

    public function buscarPorEmail($email){
        return $this->buscarUm("SELECT * FROM " . $this->tabela . " WHERE email = :email LIMIT 1", ['email' => $email]);
    }

    public function verificaExistencia($email){
        return (bool) $this->buscarUm("SELECT id FROM " . $this->tabela . " WHERE email = :email LIMIT 1", ['email' => $email]);
    }

    protected function cadastrarConta($dados){ //dados: coluna => valor
        foreach($dados as $coluna => $valor){
            //se for coluna = senha faz o hash, se não, higieniza
            $dados[$coluna] = ($coluna === 'senha') ? password_hash($valor, PASSWORD_DEFAULT) : $this->limpar($valor); 
        }

        $colunas = implode(', ', array_keys($dados)); //colunas do db com virgula
        $marcadores = ':' . implode(', :', array_keys($dados)); //nomes para injeção com virgula e :
        
        return $this->executar("INSERT INTO " . $this->tabela . " ($colunas) VALUES ($marcadores)", $dados);
    }
}