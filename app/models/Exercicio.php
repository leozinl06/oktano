<?php

require_once __DIR__ . '/../core/BaseModel.php';

class Exercicio extends BaseModel{
    protected $tabela = 'exercicio';

    public function buscarPorApiId($api_id){
        $row = $this->buscarUm("SELECT id FROM " . $this->tabela . " WHERE api_id = :api_id LIMIT 1", ['api_id' => $api_id]);
        return $row ? $row['id'] : false;
    }

    public function buscarCustomizadoPorNome($nome, $musculo){
        $row = $this->buscarUm(
            "SELECT id FROM " . $this->tabela . " 
             WHERE api_id IS NULL 
               AND LOWER(nome) = LOWER(:nome) 
               AND LOWER(musculo) = LOWER(:musculo) 
             LIMIT 1",
            [
                'nome' => $this->limpar($nome),
                'musculo' => $this->limpar($musculo)
            ]
        );
        return $row ? $row['id'] : false;
    }

    public function cadastrar($api_id, $nome, $musculo, $imagem_url = null){
        $apiIdLimpo = !empty($api_id) ? $this->limpar($api_id) : null;

        $sucesso = $this->executar(
            "INSERT INTO " . $this->tabela . " (api_id, nome, musculo, imagem_url, url_video) 
            VALUES (:api_id, :nome, :musculo, :imagem_url, '')",
            [
                'api_id' => $apiIdLimpo, 
                'nome' => $this->limpar($nome), 
                'musculo' => $this->limpar($musculo), 
                'imagem_url' => $imagem_url
            ]
        );

        return $sucesso ? $this->conn->lastInsertId() : false;
    }

    public function obterOuCadastrar($api_id, $nome, $musculo){
        if(!empty($api_id)){
            $idExistente = $this->buscarPorApiId($api_id);
        } else{
            $idExistente = $this->buscarCustomizadoPorNome($nome, $musculo);
        }

        if($idExistente){
            return $idExistente;
        }

        return $this->cadastrar($api_id, $nome, $musculo);
    }
}