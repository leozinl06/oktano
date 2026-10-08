<?php

require_once __DIR__ . '/../core/BaseModel.php';

class FichaTreino extends BaseModel{
    protected $tabela = 'ficha_treino';

    public function cadastrar($id_praticante, $titulo, $descricao, $status = 'rascunho'){
        $sucesso = $this->executar(
            "INSERT INTO " . $this->tabela . " (id_praticante, titulo, descricao, status) VALUES (:id_praticante, :titulo, :descricao, :status)",
            ['id_praticante' => $id_praticante, 'titulo' => $this->limpar($titulo), 'descricao' => $this->limpar($descricao), 'status' => $this->limpar($status)]
        );

        return $sucesso ? $this->conn->lastInsertId() : false; //retorna o ID da ficha criada
    }

    public function buscarFichasPorPersonal($id_personal){
        return $this->fichasDoPersonal($id_personal, "f.status != 'arquivada'");
    }

    public function buscarFichasArquivadasPorPersonal($id_personal){
        return $this->fichasDoPersonal($id_personal, "f.status = 'arquivada'");
    }

    private function fichasDoPersonal($id_personal, $filtroStatus){
        return $this->buscarTodos(
            "SELECT f.id, f.titulo, f.descricao, f.status, p.nome AS nome_aluno
             FROM " . $this->tabela . " f
             INNER JOIN praticante p ON f.id_praticante = p.id
             WHERE p.id_personal = :id_personal AND $filtroStatus
             ORDER BY f.id DESC",
            ['id_personal' => $id_personal]
        );
    }

    public function buscarFichasPorAluno($id_praticante){
        return $this->buscarTodos(
            "SELECT id, titulo, descricao, status FROM " . $this->tabela . " WHERE id_praticante = :id_praticante AND status != 'arquivada' ORDER BY id DESC",
            ['id_praticante' => $id_praticante]
        );
    }

    public function alterarStatusArquivamento($id_ficha, $novo_status){
        return $this->executar("UPDATE " . $this->tabela . " SET status = :status WHERE id = :id", 
        ['status' => $this->limpar($novo_status), 'id' => $id_ficha]);
    }

    public function atualizar($id_ficha, $titulo, $descricao, $status){
        return $this->executar(
            "UPDATE " . $this->tabela . " SET titulo = :titulo, descricao = :descricao, status = :status WHERE id = :id",
            ['titulo' => $this->limpar($titulo), 'descricao' => $this->limpar($descricao), 'status' => $this->limpar($status), 'id' => $id_ficha]
        );
    }

    public function excluir($id_ficha){
        return $this->excluirPorId($id_ficha);
    }
}