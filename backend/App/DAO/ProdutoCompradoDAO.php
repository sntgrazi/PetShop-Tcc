<?php

namespace App\DAO;

use App\Model\ProdutoCompradoModel;

class ProdutoCompradoDAO extends ConexaoDAO {
    
    public function __construct(){
        parent::__construct();
    }
    
    public function getAllProdutosComprados(): array {
        $sql = 'SELECT * FROM produtos_comprados';
        $produtosComprados = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        return $produtosComprados;
    }
    
    public function getProdutoComprado(ProdutoCompradoModel $produtoComprado): array {
        $sql = 'SELECT * FROM produtos_comprados WHERE id = :id';
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $produtoComprado->getId()]);
        $produtoComprado = $stm->fetch(\PDO::FETCH_ASSOC);
        
        return $produtoComprado;
    }
    
    public function insertProdutoComprado(ProdutoCompradoModel $produtoComprado): void {
        $sql = 'INSERT INTO produtos_comprados VALUES (null, :produto_id, :compra_id, :quantidade)';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'produto_id' => $produtoComprado->getProdutoId(),
            'compra_id' => $produtoComprado->getCompraId(),
            'quantidade' => $produtoComprado->getQuantidade()
        ]);
    }
    
    public function updateProdutoComprado(ProdutoCompradoModel $produtoComprado): void {
        $sql = 'UPDATE produtos_comprados SET produto_id = :produto_id, compra_id = :compra_id, quantidade = :quantidade WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $produtoComprado->getId(),
            'produto_id' => $produtoComprado->getProdutoId(),
            'compra_id' => $produtoComprado->getCompraId(),
            'quantidade' => $produtoComprado->getQuantidade()
        ]);
    }
    
    public function deleteProdutoComprado(ProdutoCompradoModel $produtoComprado): void {
        $sql = 'DELETE FROM produtos_comprados WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $produtoComprado->getId()]);
    }
    
}
