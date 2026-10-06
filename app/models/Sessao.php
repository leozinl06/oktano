<?php

class Sessao{
    private $conn;
    private $tabela = 'sessao';

    public function __construct($db){
        $this->conn = $db;
    }

    public function cadastrar($id_treino, $duracao_minutos, $nivel_fadiga){
        $query = "INSERT INTO " . $this->tabela . " (id_treino, data_realizacao, duracao_minutos, nivel_fadiga) 
                  VALUES (:id_treino, NOW(), :duracao, :fadiga)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_treino', $id_treino, PDO::PARAM_INT);
        $stmt->bindParam(':duracao', $duracao_minutos, PDO::PARAM_INT);
        $stmt->bindParam(':fadiga', $nivel_fadiga, PDO::PARAM_INT);

        if($stmt->execute()){
            return $this->conn->lastInsertId();
        }
        return false;
    }

    
}