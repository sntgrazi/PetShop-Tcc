<?php

namespace App\DAO;

use App\Model\OrdemDeServicoModel;

class OrdemDeServicoDAO extends ConexaoDAO {
    
    public function __construct(){
        parent::__construct();
    }
    
    public function getAllOrdensDeServico(): array {
        $sql = 'SELECT * FROM ordem_de_servico';
        $ordens = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        return $ordens;
    }
    
    public function getOrdemDeServico(OrdemDeServicoModel $ordemDeServico): array {
        $sql = 'SELECT * FROM ordem_de_servico WHERE id = :id';
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $ordemDeServico->getId()]);
        $ordem = $stm->fetch(\PDO::FETCH_ASSOC);
        
        return $ordem;
    }
    
    public function insertOrdemDeServico(OrdemDeServicoModel $ordem): void {
        $sql = 'INSERT INTO ordem_de_servico VALUES (null, :data_ordem_servico, :animal_id, :colaborador_id, :cliente_id, :servico_id, :hora_inicio, :hora_termino, :status)';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'data_ordem_servico' => $ordem->getDataOrdemServico(),
            'animal_id' => $ordem->getAnimalId(),
            'colaborador_id' => $ordem->getColaboradorId(),
            'cliente_id' => $ordem->getClienteId(),
            'servico_id' => $ordem->getServicoId(),
            'hora_inicio' => $ordem->getHoraInicio(),
            'hora_termino' => $ordem->getHoraTermino(),
            'status' => $ordem->getStatus()
        ]);
    }
    
    public function updateOrdemDeServico(OrdemDeServicoModel $ordem): void {
        $sql = 'UPDATE ordem_de_servico SET data_ordem_servico = :data_ordem_servico, animal_id = :animal_id, colaborador_id = :colaborador_id, cliente_id = :cliente_id, servico_id = :servico_id, hora_inicio = :hora_inicio, hora_termino = :hora_termino, status = :status WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $ordem->getId(),
            'data_ordem_servico' => $ordem->getDataOrdemServico(),
            'animal_id' => $ordem->getAnimalId(),
            'colaborador_id' => $ordem->getColaboradorId(),
            'cliente_id' => $ordem->getClienteId(),
            'servico_id' => $ordem->getServicoId(),
            'hora_inicio' => $ordem->getHoraInicio(),
            'hora_termino' => $ordem->getHoraTermino(),
            'status' => $ordem->getStatus()
        ]);
    }
    
    public function deleteOrdemDeServico(OrdemDeServicoModel $ordemDeServico): void {
        $sql = 'DELETE FROM ordem_de_servico WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $ordemDeServico->getId()]);
    }
    
}