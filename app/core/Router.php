<?php

class Router{
    private $rotas = [];

    public function adicionar($caminho, $controller, $acao){
        $this->rotas[$caminho] = [
            'controller' => $controller,
            'acao' => $acao
        ];
    }

    public function despachar($url){ //le a URL e executa o codigo
        $url = rtrim($url, '/'); //remove barra final se houver
        $url = filter_var($url, FILTER_SANITIZE_URL); //limpa string

        if(empty($url)){
            $url = '/'; //se estiver vazio = pagina inicial
        }

        if(array_key_exists($url, $this->rotas)){ //verifica existencia da rota 
            $nomeController = $this->rotas[$url]['controller'];
            $nomeAcao = $this->rotas[$url]['acao'];

            require_once __DIR__ . '/../controllers/' . $nomeController . '.php'; //importa o controller
            $controller = new $nomeController(); //instancia o controller

            $controller->$nomeAcao(); //executa funcao dentro do controller
        } else{
            http_response_code(404);
            echo "<h1>Error 404 - Pagina não encontrada</h1>";
        }
    }
}