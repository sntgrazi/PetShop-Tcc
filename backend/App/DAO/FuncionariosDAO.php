<?php

namespace App\DAO;

class FuncionariosDAO extends ConexaoDAO{
    public function __construct(){
        parent::__construct();
    }

    public function getAllFuncionarios(): array{
        $sql = 'SELECT * from funcionarios';
        $funcionarios = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $funcionarios;
    }
}