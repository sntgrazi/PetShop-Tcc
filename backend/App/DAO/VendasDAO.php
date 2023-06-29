<?php

namespace App\DAO;

use App\Model\VendasModel;

class VendasDAO extends ConexaoDAO{
    public function __construct(){
        parent::__construct();
    }


    public function cadastrarVenda(VendasModel $vendaM) {
        try {
            $this->pdo->beginTransaction();
    
            $sql = "INSERT INTO Vendas (quantidade_produtos, valor_total, metodos_pagamento, parcelas) VALUES (:quantidade_produtos, :valor_total, :metodos_pagamento, :parcelas)";
            $stm = $this->pdo->prepare($sql);
            
            // Somar os valores de quantity de todos os produtos
            $quantidadeProdutos = 0;
            foreach ($vendaM->getProdutosSelecionados() as $item) {
                $quantidadeProdutos += $item['quantity'];
            }
            
            $stm->execute([
                'quantidade_produtos' => $quantidadeProdutos,
                'valor_total' => $vendaM->getValorTotal(),
                'metodos_pagamento' => implode(', ', $vendaM->getFormasPagamento()),
                'parcelas' => $vendaM->getParcelas()
            ]);
    
            $vendaId = $this->pdo->lastInsertId();
    
            $sqlProdutos = "INSERT INTO produtos_venda (venda_id, produto_id, quantidade_vendida) VALUES (:venda_id, :produto_id, :quantidade_vendida)";
            $stmProdutos = $this->pdo->prepare($sqlProdutos);
    
            $sqlServicos = "INSERT INTO servico_venda (venda_id, servico_id, quantidade_vendida) VALUES (:venda_id, :servico_id, :quantidade_vendida)";
            $stmServicos = $this->pdo->prepare($sqlServicos);
    
            foreach ($vendaM->getProdutosSelecionados() as $item) {
                $tabela = $item['tabela'];
                $id = $item['id'];
                $quantidade_vendida = $item['quantity'];
    
                if ($tabela === 'produtos') {
                    $stmProdutos->execute([
                        'venda_id' => $vendaId,
                        'produto_id' => $id,
                        'quantidade_vendida' => $quantidade_vendida
                    ]);
                    $sqlDecrement = "UPDATE produtos SET quantidade = quantidade - :quantity WHERE id = :id";
                    $stmDecrement = $this->pdo->prepare($sqlDecrement);
                    $stmDecrement->execute([
                        'quantity' => $item['quantity'],
                        'id' => $id
                    ]);
                } elseif ($tabela === 'servicos') {
                    $stmServicos->execute([
                        'venda_id' => $vendaId,
                        'servico_id' => $id,
                        'quantidade_vendida' => $quantidade_vendida
                    ]);
                }
            }
            
            $this->pdo->commit();
    
            return $vendaId;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    
    
}