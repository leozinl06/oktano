<?php

trait EstatisticasMensais{

    public function obterTotal(){
        return $this->buscarUm("SELECT COUNT(id) AS total FROM " . $this->tabela)['total'] ?? 0;
    }

    public function obterEstatisticasMensais($inicio = null, $fim = null){
        $filtrado = $inicio && $fim;

        $query = "SELECT DATE_FORMAT(data_cadastro, '%m/%Y') AS mes_ano,
                         DATE_FORMAT(data_cadastro, '%Y-%m') AS ordenacao,
                         COUNT(id) AS total
                  FROM " . $this->tabela . " "
               . ($filtrado ? "WHERE DATE_FORMAT(data_cadastro, '%Y-%m') BETWEEN :inicio AND :fim " : '')
               . "GROUP BY mes_ano, ordenacao ORDER BY ordenacao ASC"
               . ($filtrado ? '' : ' LIMIT 12'); //sem filtro: limita a 12 meses

        return $this->buscarTodos($query, $filtrado ? ['inicio' => $inicio, 'fim' => $fim] : []);
    }
}