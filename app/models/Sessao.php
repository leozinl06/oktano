<?php

require_once __DIR__ . '/../core/BaseModel.php';

class Sessao extends BaseModel{
    protected $tabela = 'sessao';

    public function cadastrar($id_treino, $duracao_segundos, $nivel_fadiga){
        $sucesso = $this->executar(
            "INSERT INTO " . $this->tabela . " (id_treino, data_realizacao, duracao_segundos, nivel_fadiga) VALUES (:id_treino, NOW(), :duracao, :fadiga)",
            ['id_treino' => $id_treino, 'duracao' => $duracao_segundos, 'fadiga' => $nivel_fadiga]
        );

        return $sucesso ? $this->conn->lastInsertId() : false;
    }

    public function buscarSessoesPorPersonal($id_personal){
        return $this->buscarTodos(
            "SELECT s.id, s.data_realizacao, s.duracao_segundos, s.nivel_fadiga,
                    t.titulo AS treino_titulo, t.id AS treino_id,
                    f.titulo AS ficha_titulo, f.id AS ficha_id,
                    p.nome AS aluno_nome, p.id AS aluno_id
             FROM " . $this->tabela . " s
             INNER JOIN treino t ON s.id_treino = t.id
             INNER JOIN ficha_treino f ON t.id_ficha_treino = f.id
             INNER JOIN praticante p ON f.id_praticante = p.id
             WHERE p.id_personal = :id_personal
             ORDER BY p.nome ASC, f.id DESC, t.ordem ASC, s.data_realizacao DESC",
            ['id_personal' => $id_personal]
        );
    }
}