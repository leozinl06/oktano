<?php

require_once __DIR__ . '/../core/BaseModel.php';
require_once __DIR__ . '/../core/ContaUsuario.php';
require_once __DIR__ . '/../core/EstatisticasMensais.php';

class Praticante extends BaseModel{
    use ContaUsuario, EstatisticasMensais;

    protected $tabela = 'praticante';

    public function buscarIdPersonalPorCodigo($codigo_vinculo){
        $row = $this->buscarUm("SELECT id FROM personal WHERE codigo_vinculo = :codigo LIMIT 1", ['codigo' => $codigo_vinculo]);
        return $row ? $row['id'] : false; //se der certo, volta o id, senão false   
    }

    public function cadastrar($id_personal, $nome, $email, $senha){
        return $this->cadastrarConta(['id_personal' => $id_personal, 'nome' => $nome, 'email' => $email, 'senha' => $senha]);
    }

    public function buscarAlunosPorPersonal($id_personal){
        return $this->buscarTodos(
            "SELECT id, nome FROM " . $this->tabela . " WHERE id_personal = :id_personal ORDER BY nome ASC",
            ['id_personal' => $id_personal]
        );
    }
}