<?php

class Database{
    private $host = 'localhost';
    private $db_name = 'oktano';
    private $username = 'root';
    private $password = '';
    private $port = '3307';
    private $conn;

    public function conectar() {
        $this->conn = null;

        try{
            $this->conn = new PDO('mysql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn->exec("set names utf8mb4");
        } catch (PDOException $e){
            error_log("Falha na conexão com o banco de dados Oktano: " . $e->getMessage());

            die("Estamos passando por uma instabilidade. POr favor, tente novamente mais tarde.");
        }

        return $this->conn;
    }
}