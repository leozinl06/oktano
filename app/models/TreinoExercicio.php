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
                'repeticoes' => $repeticoes,
                'tempo_descanso' => $tempo_descanso,
                'ordem' => $this->proximaOrdem('id_treino', $id_treino), //novo exercício vai para o final
                'observacoes' => $observacoes
            ]
        );
    }

    public function buscarPorTreino($id_treino){
        return $this->buscarTodos(
            "SELECT te.*, e.nome, e.musculo,
                    (SELECT es.carga_utilizada
                     FROM exercicio_sessao es
                     INNER JOIN sessao s ON es.id_sessao = s.id
                     WHERE es.id_treino_exercicio = te.id
                     ORDER BY s.data_realizacao DESC
                     LIMIT 1) AS ultima_carga
             FROM " . $this->tabela . " te
             INNER JOIN exercicio e ON te.id_exercicio = e.id
             WHERE te.id_treino = :id_treino
             ORDER BY te.ordem ASC",
            ['id_treino' => $id_treino]
        );
    }
}