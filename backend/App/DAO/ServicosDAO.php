<?php

namespace App\DAO;

use App\Model\ServicosModel;

class ServicosDAO extends ConexaoDAO{
    public function __construct(){
        parent::__construct();
    }

    public function getAllServicos(): array{
        $sql = 'SELECT * from servicos';
        $servicos = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $servicos;
    }

    public function getServicoById(ServicosModel $servicoM) {
        $sql = 'SELECT * FROM servicos WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $servicoM->getId()]);
        $servico = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $servico;
    }

    public function cadastrarServico(ServicosModel $servico): void{
        $sql = 'INSERT INTO servicos (nome_servico, valor) VALUES (:nome_servico, :valor)';

        $stm = $this->pdo->prepare($sql);

        $stm->execute([
            'nome_servico' => $servico->getNomeServico(),
            'valor' => $servico->getValor()
        ]);
    }

    public function atualizarServico(ServicosModel $servico): void {
        $sql = 'UPDATE servicos SET nome_servico = :nome_servico, valor = :valor WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute([
            'id' => $servico->getId(),
            'nome_servico' => $servico->getNomeServico(),
            'valor' => $servico->getValor()
        ]);
    }

    public function deletarServico(ServicosModel $servico): void {
        $sql = 'DELETE FROM servicos WHERE id = :id';

        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $servico->getId()
        ]);
    }
}