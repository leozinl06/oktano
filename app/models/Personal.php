<?php

require_once __DIR__ . '/../core/BaseModel.php';
require_once __DIR__ . '/../core/ContaUsuario.php';
require_once __DIR__ . '/../core/EstatisticasMensais.php';

class Personal extends BaseModel{
    use ContaUsuario, EstatisticasMensais;
    
    protected $tabela = 'personal';

    public function verificaExistencia($email, $registro, $codigo_vinculo){ //checa duplicidade
        return (bool) $this->buscarUm(
            "SELECT id FROM " . $this->tabela . ' WHERE email = :email OR registro_profissional = :registro OR codigo_vinculo = :codigo LIMIT 1',
            ['email' => $email, 'registro' => $registro, 'codigo' => $codigo_vinculo]
        );
    }

    public function cadastrar($nome, $email, $registro, $codigo_vinculo, $senha){
        return $this->cadastrarConta([
            'nome' => $nome,
            'email' => $email,
            'registro_profissional' => $registro,
            'codigo_vinculo' => $codigo_vinculo,
            'senha' => $senha
        ]);
    }
}