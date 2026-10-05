<?php

class Exercicio{
    private $conn;
    private $tabela = 'exercicio';

    public function __construct($db){
        $this->conn = $db;
    }

    public function buscarPorApiId($api_id){
        $query = "SELECT id FROM " . $this->tabela . " WHERE api_id = :api_id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':api_id', $api_id);
        $stmt->execute();
        
        if($stmt->rowCount() > 0){
            return $stmt->fetch(PDO::FETCH_ASSOC)['id'];
        }
        return false;
    }

    public function cadastrar($api_id, $nome, $musculo, $imagem_url = null){
        $query = "INSERT INTO " . $this->tabela . " (api_id, nome, musculo, imagem_url, url_video) 
                  VALUES (:api_id, :nome, :musculo, :imagem_url, '')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':api_id', $api_id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':musculo', $musculo);
        $stmt->bindParam(':imagem_url', $imagem_url);
        
        if($stmt->execute()){
            return $this->conn->lastInsertId();
        }
        return false;
    }
}