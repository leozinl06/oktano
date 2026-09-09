<?php

class FichaTreino{
    private $conn;
    private $tabela = 'ficha_treino';

    public function __construct($db){
        $this->conn = $db;
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
}