<?php

namespace App\DAO;

use App\Model\CompraModel;

class CompraDAO extends ConexaoDAO{

    public function __construct(){
        parent::__construct();
    }

    public function getAllCompras(): array{
        $sql = 'SELECT * from compras';
        $compras = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $compras;
    }

    public function getCompra(CompraModel $compraM): array{
        $sql = 'SELECT * from compras WHERE id = :id';
    
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $compraM->getId()
        ]);
        $compra = $stm->fetch(\PDO::FETCH_ASSOC);
        return $compra;
    }

    public function insertCompra(CompraModel $compra): void {
        $sql = 'INSERT INTO compras VALUES (null, :data_compra, :valor_total)';

        $stm = $this->pdo
        ->prepare($sql);

        $stm->execute([
            'data_compra' => $compra->getDataCompra(),
            'valor_total' => $compra->getValorTotal()
        ]);
    }

    public function updateCompra(CompraModel $compra): void {
        $sql = 'UPDATE compras SET data_compra = :data_compra, valor_total = :valor_total WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute([
            'data_compra' => $compra->getDataCompra(),
            'valor_total' => $compra->getValorTotal(),
            'id' => $compra->getId()
        ]);
    }

    public function deleteCompra(CompraModel $compra): void{
        $sql = 'DELETE FROM compras WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute(['id' => $compra->getId()]);
    }
}
