<?php

class Personal{
    private $conn;
    private $tabela = 'personal';

    public function __construct($db){
        $this->conn = $db;
    }
}