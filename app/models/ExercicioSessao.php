<?php
class ExercicioSessao{
    private $conn;
    private $tabela = 'exercicio_sessao';

    public function __construct($db){
        $this->conn = $db;
    }

    public function cadastrar($id_sessao, $id_treino_exercicio, $id_exercicio, $numero_serie, $carga_utilizada, $repeticoes_realizadas){
        $query = "INSERT INTO " . $this->tabela . " 
                  (id_sessao, id_treino_exercicio, id_exercicio, numero_serie, carga_utilizada, repeticoes_realizadas) 
                  VALUES (:sessao, :treino_ex, :ex, :serie, :carga, :reps)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':sessao', $id_sessao, PDO::PARAM_INT);
        $stmt->bindParam(':treino_ex', $id_treino_exercicio, PDO::PARAM_INT);
        $stmt->bindParam(':ex', $id_exercicio, PDO::PARAM_INT);
        $stmt->bindParam(':serie', $numero_serie, PDO::PARAM_INT);
        $stmt->bindParam(':carga', $carga_utilizada);
        $stmt->bindParam(':reps', $repeticoes_realizadas, PDO::PARAM_INT);
        
        return $stmt->execute();
    }
}