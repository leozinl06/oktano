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

    public function buscarSessoesPorPersonal($id_personal) {
        $query = "SELECT s.id, s.data_realizacao, s.duracao_minutos, s.nivel_fadiga,
                         t.titulo AS treino_titulo, t.id AS treino_id,
                         f.titulo AS ficha_titulo, f.id AS ficha_id,
                         p.nome AS aluno_nome, p.id AS aluno_id
                  FROM " . $this->tabela . " s
                  INNER JOIN treino t ON s.id_treino = t.id
                  INNER JOIN ficha_treino f ON t.id_ficha_treino = f.id
                  INNER JOIN praticante p ON f.id_praticante = p.id
                  WHERE p.id_personal = :id_personal
                  ORDER BY p.nome ASC, f.id DESC, t.ordem ASC, s.data_realizacao DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_personal', $id_personal, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}