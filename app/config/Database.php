<?php

class Database{
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct(){
        $caminhoEnv = __DIR__ . '/../../.env';

        if(file_exists($caminhoEnv)){
            $env = parse_ini_file($caminhoEnv); //le e transforma em array

            $this->host = $env['DB_HOST'];
            $this->port = $env['DB_PORT'];
            $this->db_name = $env['DB_NAME'];
            $this->username = $env['DB_USER'];
            $this->password = $env['DB_PASS'];
        } else{
            error_log('Erro Crítico: Arquivo de configuração .env não encontrado no caminho: ' . $caminhoEnv);
            
            die("O sistema está passando por uma manutenção temporária. Por favor, tente novamente mais tarde.");
        }
    }

    public function conectar() {
        $this->conn = null;

        try{
            $this->conn = new PDO('mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn->exec("set names utf8mb4");
        } catch (PDOException $e){
            error_log("Falha na conexão com o banco de dados Oktano: " . $e->getMessage());

            die("Estamos passando por uma instabilidade. Por favor, tente novamente mais tarde.");
        }

        return $this->conn;
    }
}