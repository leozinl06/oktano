<?php

class Personal{
    private $conn;
    private $tabela = 'personal';

    public function __construct($db){
        $this->conn = $db;
    }

    public function verificaExistencia($email, $registro){ //checa duplicidade
        $query = 'SELECT id FROM ' . $this->tabela . ' WHERE email = :email OR registro_profissional = :registro LIMIT 1';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':registro', $registro);
        $stmt->execute();

        return $stmt->rowCount() > 0; //retorna true se rowCount > 0 
    }

    public function cadastrar($nome, $email, $registro, $senha){
        $query = 'INSERT INTO ' . $this->tabela . ' (nome, email, registro_profissional, senha)
                VALUES (:nome, :email, :registro, :senha)';
        
        $stmt = $this->conn->prepare($query);

        $nome = htmlspecialchars(strip_tags($nome));
        $email = htmlspecialchars(strip_tags($email)); //higienização contra XSS
        $registro = htmlspecialchars(strip_tags($registro));

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':registro', $registro);
        $stmt->bindParam(':senha', $senha_hash);

        if($stmt->execute()){
            return true; //se inserido
        }

        return false;
    }
}