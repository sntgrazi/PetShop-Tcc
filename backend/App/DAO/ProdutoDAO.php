<?php

namespace App\DAO;
use App\Model\ProdutoModel;

class ProdutoDAO extends ConexaoDAO{
    public function __construct(){
        parent::__construct();
    }

    public function getAllProdutos(): array{
        $sql = 'SELECT p.*, f.nome_fantasia
        FROM produtos p 
        JOIN fornecedores f ON p.fornecedor_id = f.id ORDER BY id';
        $produtos = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        
        return $produtos;
    }

    public function cadastrarProduto(ProdutoModel $produtoM): void{
        $sql = 'INSERT INTO produtos VALUES (null, :nome, :quantidade,:data_validade ,:valor_compra, :valor_venda ,:cod_barras, :fornecedor_id)';

        $stm = $this->pdo
        ->prepare($sql);

        $stm->execute([
            'nome' => $produtoM->getNome(),
            'quantidade' => $produtoM->getQuantidade(),
            'data_validade' => $produtoM->getData_validade(),
            'valor_compra' => $produtoM->getValor_compra(),
            'valor_venda' => $produtoM->getValor_venda(),
            'cod_barras' => $produtoM->getCod_barras(),
            'fornecedor_id' => $produtoM->getFornecedor_id(),
        ]);

    }

    public function getProdutoWithFornecedorById(ProdutoModel $produtoM): array {
        $sql = 'SELECT p.*, f.nome_fantasia AS fornecedor_nome
                FROM produtos p
                JOIN fornecedores f ON p.fornecedor_id = f.id
                WHERE p.id = :id';
    
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $produtoM->getId()
        ]);
    
        $produto = $stm->fetch(\PDO::FETCH_ASSOC);
        return $produto;
    }
    

    public function atualizarProduto(ProdutoModel $produtoM): void {
        $sql = 'UPDATE produtos SET 
                nome = :nome,
                quantidade = :quantidade,
                data_validade = :data_validade,
                valor_compra = :valor_compra,
                valor_venda = :valor_venda,
                cod_barras = :cod_barras,
                fornecedor_id = :fornecedor_id
                WHERE id = :id';
    
        $stm = $this->pdo->prepare($sql);
    
        $stm->execute([
            'id' => $produtoM->getId(),
            'nome' => $produtoM->getNome(),
            'quantidade' => $produtoM->getQuantidade(),
            'data_validade' => $produtoM->getData_validade(),
            'valor_compra' => $produtoM->getValor_compra(),
            'valor_venda' => $produtoM->getValor_venda(),
            'cod_barras' => $produtoM->getCod_barras(),
            'fornecedor_id' => $produtoM->getFornecedor_id(),
        ]);
    }

    public function deletarProduto(ProdutoModel $produtoM): void {
        $sql = 'DELETE FROM produtos WHERE id = :id';
    
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $produtoM->getId()
        ]);
    }
    
    
}