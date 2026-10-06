<?php 

class TreinoExercicio{
    private $conn;
    private $tabela = 'treino_exercicio';

    public function __construct($db){
        $this->conn = $db;
    }

    public function cadastrar($id_treino, $id_exercicio, $series, $repeticoes, $tempo_descanso, $observacoes){
        // Descobre a última ordem inserida para colocar o novo exercício no final da lista
        $queryOrdem = "SELECT MAX(ordem) as max_ordem FROM " . $this->tabela . " WHERE id_treino = :id_treino";
        $stmtOrdem = $this->conn->prepare($queryOrdem);
        $stmtOrdem->bindParam(':id_treino', $id_treino, PDO::PARAM_INT);
        $stmtOrdem->execute();
        $row = $stmtOrdem->fetch(PDO::FETCH_ASSOC);
        $ordem = ($row['max_ordem'] !== null) ? (int)$row['max_ordem'] + 1 : 1;

        $query = "INSERT INTO " . $this->tabela . " 
                  (id_treino, id_exercicio, series, repeticoes, tempo_descanso_seg, ordem, observacoes)
                  VALUES (:id_treino, :id_exercicio, :series, :repeticoes, :tempo_descanso, :ordem, :observacoes)";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_treino', $id_treino, PDO::PARAM_INT);
        $stmt->bindParam(':id_exercicio', $id_exercicio, PDO::PARAM_INT);
        $stmt->bindParam(':series', $series, PDO::PARAM_INT);
        $stmt->bindParam(':repeticoes', $repeticoes);
        $stmt->bindParam(':tempo_descanso', $tempo_descanso, PDO::PARAM_INT);
        $stmt->bindParam(':ordem', $ordem, PDO::PARAM_INT);
        $stmt->bindParam(':observacoes', $observacoes);
        
        return $stmt->execute();
    }

    public function buscarPorTreino($id_treino) {
        $query = "SELECT te.*, e.nome, e.musculo,
                         (SELECT es.carga_utilizada 
                          FROM exercicio_sessao es 
                          INNER JOIN sessao s ON es.id_sessao = s.id 
                          WHERE es.id_treino_exercicio = te.id 
                          ORDER BY s.data_realizacao DESC 
                          LIMIT 1) AS ultima_carga
                  FROM " . $this->tabela . " te
                  INNER JOIN exercicio e ON te.id_exercicio = e.id
                  WHERE te.id_treino = :id_treino
                  ORDER BY te.ordem ASC";
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_treino', $id_treino, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}