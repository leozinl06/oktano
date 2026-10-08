<?php

require_once __DIR__ . '/../core/BaseModel.php';

class Treino extends BaseModel{
    protected $tabela = 'treino';

    public function cadastrar($id_ficha_treino, $titulo, $descricao){
        return $this->executar(
            "INSERT INTO " . $this->tabela . " (id_ficha_treino, titulo, descricao, ordem) VALUES (:id_ficha_treino, :titulo, :descricao, :ordem)",
            [
                'id_ficha_treino' => $id_ficha_treino,
                'titulo' => $this->limpar($titulo),
                'descricao' => $this->limpar($descricao),
                'ordem' => $this->proximaOrdem('id_ficha_treino', $id_ficha_treino)
            ]
        );
    }

    public function excluir($id){
        return $this->excluirPorId($id);
    }

    public function atualizar($id, $titulo, $descricao){
        return $this->executar(
            "UPDATE " . $this->tabela . " SET titulo = :titulo, descricao = :descricao WHERE id = :id",
            ['titulo' => $this->limpar($titulo), 'descricao' => $this->limpar($descricao), 'id' => $id]
        );
    }

    public function buscarPorFicha($id_ficha_treino){
        return $this->buscarTodos(
            "SELECT * FROM " . $this->tabela . " WHERE id_ficha_treino = :id_ficha_treino ORDER BY ordem ASC",
            ['id_ficha_treino' => $id_ficha_treino]
        );
    }

    public function atualizarOrdem($id_treino, $nova_ordem){
        return $this->executar(
            "UPDATE " . $this->tabela . " SET ordem = :ordem WHERE id = :id", 
            ['ordem' => $nova_ordem, 'id' => $id_treino]
        );
    }
}