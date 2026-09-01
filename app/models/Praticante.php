<?php

class Praticante{
    private $conn;
    private $tabela = 'praticante';

    public function __construct($db){
        $this->conn = $db;
    }

    public function buscarIdPersonalPorCodigo($codigo_vinculo){
        $query = 'SELECT id FROM personal
                    WHERE codigo_vinculo = :codigo LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':codigo', $codigo_vinculo);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row['id'];
        }

        return false;
    }

    public function verificaExistencia($email){
        $query = 'SELECT id FROM ' . $this->tabela . 
                    ' WHERE email = :email LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }

    public function cadastrar($id_personal, $nome, $email, $senha){
        $query = 'INSERT INTO ' . $this->tabela . 
                    ' (id_personal, nome, email, senha) 
                    VALUES (:id_personal, :nome, :email, :senha)';
        $stmt = $this->conn->prepare($query);

        $nome = htmlspecialchars(strip_tags($nome));
        $email = htmlspecialchars(strip_tags($email));
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        
        $stmt->bindParam(':id_personal', $id_personal);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hash);

        if($stmt->execute()){
            return true;
        }

        return false;
    }

    public function buscarPorEmail($email){
        $query = "SELECT * FROM " . $this->tabela . ' WHERE email = :email LIMIT 1';
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }
}