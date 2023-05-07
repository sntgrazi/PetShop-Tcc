<?php

namespace App\DAO;

use App\Model\VendaModel;

class VendaDAO extends ConexaoDAO {
    
    public function __construct(){
        parent::__construct();
    }
    
    public function getAllVendas(): array {
        $sql = 'SELECT * FROM vendas';
        $vendas = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        return $vendas;
    }
    
    public function getVenda(VendaModel $venda): array {
        $sql = 'SELECT * FROM vendas WHERE id = :id';
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $venda->getId()]);
        $venda = $stm->fetch(\PDO::FETCH_ASSOC);
        
        return $venda;
    }
    
    public function insertVenda(VendaModel $venda): void {
        $sql = 'INSERT INTO vendas (id, data_venda, valor_total, cliente_id, colaborador_id) VALUES (null, :data_venda, :valor_total, :cliente_id, :colaborador_id)';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'data_venda' => $venda->getDataVenda(),
            'valor_total' => $venda->getValorTotal(),
            'cliente_id' => $venda->getClienteId(),
            'colaborador_id' => $venda->getColaboradorId()
        ]);
    }
    
    public function updateVenda(VendaModel $venda): void {
        $sql = 'UPDATE vendas SET data_venda = :data_venda, valor_total = :valor_total, cliente_id = :cliente_id, colaborador_id = :colaborador_id WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $venda->getId(),
            'data_venda' => $venda->getDataVenda(),
            'valor_total' => $venda->getValorTotal(),
            'cliente_id' => $venda->getClienteId(),
            'colaborador_id' => $venda->getColaboradorId()
        ]);
    }
    
    public function deleteVenda(VendaModel $venda): void {
        $sql = 'DELETE FROM vendas WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $venda->getId()]);
    }
    
}
