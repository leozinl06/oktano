<?php

class Treino{
    private $conn;
    private $tabela = 'treino';

    public function __construct($db){
        $this->conn = $db;
    }

    public function cadastrar($id_ficha_treino, $titulo, $descricao){
        //busca maior ordem para os treinos da ficha atual
        $queryOrdem = "SELECT MAX(ordem) as max_ordem FROM " . $this->tabela . " WHERE id_ficha_treino = :id_ficha_treino";
        $stmtOrdem = $this->conn->prepare($queryOrdem);

        $stmtOrdem->bindParam(':id_ficha_treino', $id_ficha_treino, PDO::PARAM_INT);
        $stmtOrdem->execute();

        $row = $stmtOrdem->fetch(PDO::FETCH_ASSOC);
        $ordem = ($row['max_ordem'] !== null) ? (int)$row['max_ordem'] + 1 : 1;

        $query = "INSERT INTO " . $this->tabela . " (id_ficha_treino, titulo, descricao, ordem) 
                VALUES (:id_ficha_treino, :titulo, :descricao, :ordem)";
        
        $stmt = $this->conn->prepare($query);

        $titulo = strip_tags($titulo);
        $descricao = strip_tags($descricao);

        $stmt->bindParam(':id_ficha_treino', $id_ficha_treino, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':ordem', $ordem, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function atualizar($id, $titulo, $descricao) {
        $query = "UPDATE " . $this->tabela . " SET titulo = :titulo, descricao = :descricao WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        $titulo = trim(strip_tags($titulo));
        $descricao = trim(strip_tags($descricao));
        
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function excluir($id) {
        $query = "DELETE FROM " . $this->tabela . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        return $stmt->execute();
    }

    public function buscarPorFicha($id_ficha_treino){
        $query = "SELECT * FROM " . $this->tabela . " 
                WHERE id_ficha_treino = :id_ficha_treino 
                ORDER BY ordem ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_ficha_treino', $id_ficha_treino, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}