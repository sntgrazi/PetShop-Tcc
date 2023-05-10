<?php

namespace App\DAO;

use App\Model\ProdutoModel;

class ProdutoDAO extends ConexaoDAO {
    
    public function __construct(){
        parent::__construct();
    }
    
    public function getAllProdutos(): array {
        $sql = 'SELECT * FROM produtos';
        $produtos = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        return $produtos;
    }
    
    public function getProduto(ProdutoModel $produtoM): array {
        $sql = 'SELECT * FROM produtos WHERE id = :id';
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $produtoM->getId()]);
        $produto = $stm->fetch(\PDO::FETCH_ASSOC);
        
        return $produto;
    }
    
    public function insertProduto(ProdutoModel $produto): void {
        $sql = 'INSERT INTO produtos (id, nome, quantidade, valor_compra, valor_venda, img_produto, codigo_de_barras, fornecedor_id) VALUES (null, :nome, :quantidade, :valor_compra, :valor_venda, :img_produto, :codigo_de_barras, :fornecedor_id)';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'nome' => $produto->getNome(),
            'quantidade' => $produto->getQuantidade(),
            'valor_compra' => $produto->getValorCompra(),
            'valor_venda' => $produto->getValorVenda(),
            'img_produto' => $produto->getImgProduto(),
            'codigo_de_barras' => $produto->getCodigoBarras(),
            'fornecedor_id' => $produto->getFornecedorId()
        ]);
    }
    
    public function updateProduto(ProdutoModel $produto): void {
        $sql = 'UPDATE produtos SET nome = :nome, quantidade = :quantidade, valor_compra = :valor_compra, valor_venda = :valor_venda, img_produto = :img_produto, codigo_de_barras = :codigo_de_barras, fornecedor_id = :fornecedor_id WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $produto->getId(),
            'nome' => $produto->getNome(),
            'quantidade' => $produto->getQuantidade(),
            'valor_compra' => $produto->getValorCompra(),
            'valor_venda' => $produto->getValorVenda(),
            'img_produto' => $produto->getImgProduto(),
            'codigo_de_barras' => $produto->getCodigoBarras(),
            'fornecedor_id' => $produto->getFornecedorId()
        ]);
    }
    
    public function deleteProduto(ProdutoModel $produto): void {
        $sql = 'DELETE FROM produtos WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $produto->getId()]);
    }
    
}
