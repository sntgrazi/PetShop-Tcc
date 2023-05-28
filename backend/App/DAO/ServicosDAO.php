<?php

namespace App\DAO;

class ServicosDAO extends ConexaoDAO{
    public function __construct(){
        parent::__construct();
    }

    public function getAllServicos(): array{
        $sql = 'SELECT * from servicos';
        $servicos = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $servicos;
    }
}