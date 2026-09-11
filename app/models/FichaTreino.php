<?php

class FichaTreino{
    private $conn;
    private $tabela = 'ficha_treino';

    public function __construct($db){
        $this->conn = $db;
    }

    public function cadastrar($id_praticante, $titulo, $descricao, $status = 'rascunho'){
        $query = "INSERT INTO " . $this->tabela . " (id_praticante, titulo, descricao, status) 
                  VALUES (:id_praticante, :titulo, :descricao, :status)";
        
        $stmt = $this->conn->prepare($query);
        
        $titulo = htmlspecialchars(strip_tags($titulo));
        $descricao = htmlspecialchars(strip_tags($descricao));
        $status = htmlspecialchars(strip_tags($status));

        $stmt->bindParam(':id_praticante', $id_praticante, PDO::PARAM_INT);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':status', $status);

        return $stmt->execute();
    }

    public function buscarFichasPorPersonal($id_personal){
        $query = "SELECT f.id, f.titulo, f.descricao, f.status, p.nome AS nome_aluno 
                  FROM " . $this->tabela . " f 
                  INNER JOIN praticante p ON f.id_praticante = p.id 
                  WHERE p.id_personal = :id_personal 
                  ORDER BY f.id DESC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_personal', $id_personal, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarFichasPorAluno($id_praticante){
        $query = "SELECT id, titulo, descricao, status FROM " . $this->tabela . " WHERE id_praticante = :id_praticante ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_praticante', $id_praticante, PDO::PARAM_INT);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return []; //se não tiver ficha alguma

    }

    public function excluir($id_ficha){
        $query = "DELETE FROM " . $this->tabela . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':id', $id_ficha, PDO::PARAM_INT);
        return $stmt->execute();
    }
}