<?php

namespace App\DAO;

use App\Model\ClienteAnimalModel;

class  ClienteAnimalDAO extends ConexaoDAO{

    public function __contruct(){
        parent::__contruct();
    }

    public function getAllClienteAnimal(): array {
        $sql = 'SELECT * FROM cliente_animal';
        $clientesAnimais = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        return $clientesAnimais;
    }
    
    public function getClienteAnimalById(ClienteAnimalModel $tabelaM): array {
        $sql = 'SELECT * from cliente_animal WHERE id = :id';
    
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $tabela->getId()
        ]);
        $tabela = $stm->fetch(\PDO::FETCH_ASSOC);
        return $tabela;
    }
    
    public function insertClienteAnimal(ClienteAnimalModel $clienteAnimalM): void {
        $sql = 'INSERT INTO cliente_animal VALUES (:cliente_id, :animal_id)';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'cliente_id' => $clienteAnimalM->getCliente_id(),
            'animal_id' => $clienteAnimalM->getAnimal_id()
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