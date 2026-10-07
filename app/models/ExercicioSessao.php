<?php
class ExercicioSessao{
    private $conn;
    private $tabela = 'exercicio_sessao';

    public function __construct($db){
        $this->conn = $db;
    }

    public function cadastrar($id_sessao, $id_treino_exercicio, $id_exercicio, $carga_utilizada){
        $query = "INSERT INTO " . $this->tabela . " 
                  (id_sessao, id_treino_exercicio, id_exercicio, carga_utilizada) 
                  VALUES (:sessao, :treino_ex, :ex, :carga)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sessao', $id_sessao, PDO::PARAM_INT);
        $stmt->bindParam(':treino_ex', $id_treino_exercicio, PDO::PARAM_INT);
        $stmt->bindParam(':ex', $id_exercicio, PDO::PARAM_INT);
        $stmt->bindParam(':carga', $carga_utilizada);
        
        return $stmt->execute();
    }
}