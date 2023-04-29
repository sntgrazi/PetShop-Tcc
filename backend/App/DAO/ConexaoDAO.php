<?php

namespace App\DAO;
use Dotenv\Dotenv;


abstract class ConexaoDAO{

    protected $pdo;

    public function __construct(){

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();    

        $host = $_ENV['DB_HOST'];
        $port = $_ENV['DB_PORT'];
        $user = $_ENV['DB_USER'];
        $pass = $_ENV['DB_PASS'];
        $db = $_ENV['DB_NAME'];   

        $dsn = "mysql:host={$host};dbname={$db};port={$port}";

        $this->pdo = new \PDO ($dsn, $user, $pass);
        $this->pdo->setAttribute(
            \PDO::ATTR_ERRMODE,
            \PDO::ERRMODE_EXCEPTION
        );
    }
}