<?php

abstract class BaseModel{
    protected $conn;
    protected $tabela;

    public function __construct($db){
        $this->conn = $db;
    }

    protected function executar($query, $params = []){ //prepara e executa as operações, retornando um booleano
        $stmt = $this->conn->prepare($query);
        return $stmt->execute($params); //deu boa = true, deu ruim = false
    }

    protected function consultar($query, $params = []){ //realiza SELECT e retorna o statement 
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    protected function buscarUm($query, $params = []){ //uma linha ou false
        return $this->consultar($query, $params)->fetch(PDO::FETCH_ASSOC);
    }

    protected function buscarTodos($query, $params = []){ //array (vazio se não houver)
        return $this->consultar($query, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    protected function limpar($texto){ //higieniza o texto
        return trim(strip_tags((string)$texto));
    }

    protected function proximaOrdem($colunaPai, $valorPai){ //ultima ordem + 1
        $row = $this->buscarUm(
            "SELECT MAX(ordem) AS max_ordem FROM " . $this->tabela . " WHERE $colunaPai = :pai",
            ['pai' => $valorPai]
        );

        return (int)$row['max_ordem'] + 1;
    }

    protected function excluirPorId($id){ //exclui por id
        return $this->executar("DELETE FROM " . $this->tabela . "  WHERE id = :id LIMIT 1", ['id' => $id]);
    }

    public function buscarPorId($id){ //busca por id
        return $this->buscarUm("SELECT * FROM " . $this->tabela . " WHERE id = :id LIMIT 1", ['id' => $id]);
    }
}