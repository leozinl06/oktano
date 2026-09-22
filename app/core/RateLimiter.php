<?php

class RateLimiter{
    private $maxTentativas = 5;
    private $tempoBloqueio = 900;

    private function getCaminhoFicheiro($ip){ //gera um caminho de ficheiro unico e seguro no diretório temporario do sistema baseado no IP 
        //utiliza md5 para sanitizar o IP e criar um nome de ficheiro válido
        return sys_get_temp_dir() . '/oktano_rl_' . md5($ip) . '.json';
    }

    public function limpar($ip){
        $ficheiro = $this->getCaminhoFicheiro($ip);
        if(file_exists($ficheiro)){
            unlink($ficheiro); //limpa o historico de falha do IP (apos login bem-sucedido)
        }
    }

    public function verificar($ip){ //verifica se o IP esta bloqueado
        $ficheiro = $this->getCaminhoFicheiro($ip);

        if(!file_exists($ficheiro)){
            return true; //IP livre
        }

        $dados = json_decode(file_get_contents($ficheiro), true);

        if($dados['tempo_desbloqueio'] > time()){
            return false; //se o tempo atual for menor que o tempo de bloqueio, continua bloquado
        }

        if($dados['tempo_desbloqueio'] > 0 && $dados['tempo_desbloqueio'] <= time()){
            $this->limpar($ip); //se o tempo ja expirou, limpamos o ficheiro
        }

        return true;
    }

    public function registrarFalha($ip){
        $ficheiro = $this->getCaminhoFicheiro($ip);
        $dados = ['tentativa' => 0, 'tempo_desbloqueio' => 0];

        if(file_exists($ficheiro)){
            $dados = json_decode(file_get_contents($ficheiro), true);
        }

        $dados['tentativas']++;

        if($dados['tentativas'] >= $this->maxTentativas){
            $dados['tempo_desbloqueio'] = time() + $this->tempoBloqueio;
        }

        file_put_contents($ficheiro, json_encode($dados));
    }

    public function getMinutosRestantes($ip){
        $ficheiro = $this->getCaminhoFicheiro($ip);
        if(!file_exists($ficheiro)) return 0;

        $dados = json_decode(file_get_contents($ficheiro), true);
        $segundos = max(0, $dados['tempo_desbloqueio'] - time());

        return ceil($segundos / 60);
    }
}