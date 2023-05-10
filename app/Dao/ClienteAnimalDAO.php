<?php

namespace App\DAO;

use App\Model\ClienteAnimalModel;

class ClienteAnimalDAO extends ConexaoDAO {
    
    public function __construct(){
        parent::__construct();
    }
    
    public function getAllClientesAnimais(): array {
        $sql = 'SELECT * FROM cliente_animal';
        $clientesAnimais = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        return $clientesAnimais;
    }
    
    public function getClienteAnimalById(int $id): array {
        $sql = 'SELECT * FROM cliente_animal WHERE id = :id';
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $id]);
        $clienteAnimal = $stm->fetch(\PDO::FETCH_ASSOC);
        
        return $clienteAnimal;
    }
    
    public function insertClienteAnimal(ClienteAnimalModel $clienteAnimal): void {
        $sql = 'INSERT INTO cliente_animal (id, cliente_id, animal_id) VALUES (null, :cliente_id, :animal_id)';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'cliente_id' => $clienteAnimal->getClienteId(),
            'animal_id' => $clienteAnimal->getAnimalId()
        ]);
    }
    
    public function updateClienteAnimal(ClienteAnimalModel $clienteAnimal): void {
        $sql = 'UPDATE cliente_animal SET cliente_id = :cliente_id, animal_id = :animal_id WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $clienteAnimal->getId(),
            'cliente_id' => $clienteAnimal->getClienteId(),
            'animal_id' => $clienteAnimal->getAnimalId()
        ]);
    }
    
    public function deleteClienteAnimal(int $id): void {
        $sql = 'DELETE FROM cliente_animal WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $id]);
    }
    
}
