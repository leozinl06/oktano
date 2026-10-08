<?php

require_once __DIR__ . '/../core/BaseModel.php';

class Exercicio extends BaseModel{
    protected $tabela = 'exercicio';

    public function buscarPorApiId($api_id){
        $row = $this->buscarUm("SELECT id FROM " . $this->tabela . " WHERE api_id = :api_id LIMIT 1", ['api_id' => $api_id]);
        return $row ? $row['id'] : false;
    }

    public function cadastrar($api_id, $nome, $musculo, $imagem_url = null){
        $sucesso = $this->executar(
            "INSERT INTO " . $this->tabela . " (api_id, nome, musculo, imagem_url, url_video) VALUES (:api_id, :nome, :musculo, :imagem_url, '')",
            ['api_id' => $api_id, 'nome' => $this->limpar($nome), 'musculo' => $this->limpar($musculo), 'imagem_url' => $imagem_url]
        );

        return $sucesso ? $this->conn->lastInsertId() : false;
    }
}