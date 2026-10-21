<?php 

require_once __DIR__ . '/../core/BaseModel.php';

class TreinoExercicio extends BaseModel{
    protected $tabela = 'treino_exercicio';

    public function cadastrar($id_treino, $id_exercicio, $series, $repeticoes, $tempo_descanso, $observacoes){
        return $this->executar(
            "INSERT INTO " . $this->tabela . " (id_treino, id_exercicio, series, repeticoes, tempo_descanso_seg, ordem, observacoes)
             VALUES (:id_treino, :id_exercicio, :series, :repeticoes, :tempo_descanso, :ordem, :observacoes)",
            [
                'id_treino' => $id_treino,
                'id_exercicio' => $id_exercicio,
                'series' => $series,
                'repeticoes' => $this->limpar($repeticoes),
                'tempo_descanso' => $tempo_descanso,
                'ordem' => $this->proximaOrdem('id_treino', $id_treino), //novo exercício vai para o final
                'observacoes' => $this->limpar($observacoes)
            ]
        );
    }

    public function salvarAlternativo($id_treino_exercicio, $id_treino, $id_exercicio_alternativo, $series, $repeticoes, $tempo_descanso, $observacoes){
        return $this->executar(
            "UPDATE " . $this->tabela . " 
             SET id_exercicio_alternativo = :id_exercicio_alt,
                 series_alternativo = :series_alt,
                 repeticoes_alternativo = :repeticoes_alt,
                 tempo_descanso_seg_alternativo = :descanso_alt,
                 observacoes_alternativo = :observacoes_alt
             WHERE id = :id AND id_treino = :id_treino",
            [
                'id_exercicio_alt' => $id_exercicio_alternativo,
                'series_alt' => $series,
                'repeticoes_alt' => $this->limpar($repeticoes),
                'descanso_alt' => $tempo_descanso,
                'observacoes_alt' => $this->limpar($observacoes),
                'id' => $id_treino_exercicio,
                'id_treino' => $id_treino
            ]
        );
    }

    public function buscarPorIdETreino($id_treino_exercicio, $id_treino){
        return $this->buscarUm(
            "SELECT te.*, e.nome AS nome_principal 
             FROM " . $this->tabela . " te
             INNER JOIN exercicio e ON te.id_exercicio = e.id
             WHERE te.id = :id AND te.id_treino = :id_treino 
             LIMIT 1",
            [
                'id' => $id_treino_exercicio,
                'id_treino' => $id_treino
            ]
        );
    }

    public function buscarPorTreino($id_treino){
        return $this->buscarTodos(
            "SELECT te.*, 
                    e.nome, 
                    e.musculo,
                    ea.nome AS nome_alternativo, 
                    ea.musculo AS musculo_alternativo,
                    (SELECT es.carga_utilizada 
                     FROM exercicio_sessao es 
                     INNER JOIN sessao s ON es.id_sessao = s.id 
                     WHERE es.id_treino_exercicio = te.id 
                       AND es.id_exercicio = te.id_exercicio
                     ORDER BY s.data_realizacao DESC 
                     LIMIT 1) AS ultima_carga,
                    (SELECT es.carga_utilizada 
                     FROM exercicio_sessao es 
                     INNER JOIN sessao s ON es.id_sessao = s.id 
                     WHERE es.id_treino_exercicio = te.id 
                       AND es.id_exercicio = te.id_exercicio_alternativo
                     ORDER BY s.data_realizacao DESC 
                     LIMIT 1) AS ultima_carga_alternativo
             FROM " . $this->tabela . " te 
             INNER JOIN exercicio e ON te.id_exercicio = e.id 
             LEFT JOIN exercicio ea ON te.id_exercicio_alternativo = ea.id
             WHERE te.id_treino = :id_treino 
             ORDER BY te.ordem ASC",
            ['id_treino' => $id_treino]
        );
    }

    public function excluir($id){
        return $this->excluirPorId($id);
    }
}