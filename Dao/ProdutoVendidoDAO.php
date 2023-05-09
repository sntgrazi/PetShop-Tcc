<?php

namespace App\DAO;

use App\Model\ProdutoVendidoModel;

class ProdutoVendidoDAO extends ConexaoDAO {

    public function __construct(){
        parent::__construct();
    }

    public function getAllProdutosVendidos(): array {
        $sql = 'SELECT * FROM produtos_vendidos';
        $produtosVendidos = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $produtosVendidos;
    }

    public function getProdutoVendido(ProdutoVendidoModel $produtoVendido): array {
        $sql = 'SELECT * FROM produtos_vendidos WHERE id = :id';
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $produtoVendido->getId()]);
        $produtoVendido = $stm->fetch(\PDO::FETCH_ASSOC);

        return $produtoVendido;
    }

    public function insertProdutoVendido(ProdutoVendidoModel $produtoVendido): void {
        $sql = 'INSERT INTO produtos_vendidos (id, venda_id, produto_id, quantidade) VALUES (null, :venda_id, :produto_id, :quantidade)';

        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'venda_id' => $produtoVendido->getVendaId(),
            'produto_id' => $produtoVendido->getProdutoId(),
            'quantidade' => $produtoVendido->getQuantidade()
        ]);
    }

    public function updateProdutoVendido(ProdutoVendidoModel $produtoVendido): void {
        $sql = 'UPDATE produtos_vendidos SET venda_id = :venda_id, produto_id = :produto_id, quantidade = :quantidade WHERE id = :id';

        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $produtoVendido->getId(),
            'venda_id' => $produtoVendido->getVendaId(),
            'produto_id' => $produtoVendido->getProdutoId(),
            'quantidade' => $produtoVendido->getQuantidade()
        ]);
    }

    public function deleteProdutoVendido(ProdutoVendidoModel $produtoVendido): void {
        $sql = 'DELETE FROM produtos_vendidos WHERE id = :id';

        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $produtoVendido->getId()]);
    }

}
