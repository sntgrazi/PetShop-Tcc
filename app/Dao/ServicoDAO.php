<?php

namespace App\DAO;

use App\Model\ServicoModel;

class ServicoDAO extends ConexaoDAO {
    public function __construct() {
        parent::__construct();
    }

    public function getAllServicos(): array {
        $sql = 'SELECT * from servicos';
        $servicos = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $servicos;
    }

    public function getServico(ServicoModel $servico): array {
        $sql = 'SELECT * from servicos WHERE id = :id';

        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $servico->getId()
        ]);
        $servico = $stm->fetch(\PDO::FETCH_ASSOC);
        return $servico;
    }

    public function insertServico(ServicoModel $servico): void {
        $sql = 'INSERT INTO servicos VALUES (null, :descricao, :valor)';

        $stm = $this->pdo
            ->prepare($sql);

        $stm->execute([
            'descricao' => $servico->getDescricao(),
            'valor' => $servico->getValor()
        ]);
    }

    public function updateServico(ServicoModel $servico): void {
        $sql = 'UPDATE servicos SET descricao = :descricao, valor = :valor WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute([
            'descricao' => $servico->getDescricao(),
            'valor' => $servico->getValor(),
            'id' => $servico->getId()
        ]);
    }

    public function deleteServico(ServicoModel $servico): void {
        $sql = 'DELETE FROM servicos WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute(['id' => $servico->getId()]);
    }
}
