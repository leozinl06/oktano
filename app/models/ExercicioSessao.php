<?php

require_once __DIR__ . '/../core/BaseModel.php';

class ExercicioSessao extends BaseModel{
    protected $tabela = 'exercicio_sessao';

    public function cadastrar($id_sessao, $id_treino_exercicio, $id_exercicio, $carga_utilizada){
        return $this->executar(
            "INSERT INTO " . $this->tabela . " (id_sessao, id_treino_exercicio, id_exercicio, carga_utilizada) VALUES (:sessao, :treino_ex, :ex, :carga)",
            ['sessao' => $id_sessao, 'treino_ex' => $id_treino_exercicio, 'ex' => $id_exercicio, 'carga' => $carga_utilizada]
        );
    }
}