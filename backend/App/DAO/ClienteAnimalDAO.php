<?php

namespace App\DAO;
use App\Model\AnimalModel;
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
    
    public function getClienteVinculadoById(AnimalModel $animalM): array {
        $sql = 'SELECT clientes.nome
        FROM clientes
        JOIN cliente_animal ON clientes.id = cliente_animal.cliente_id
        WHERE cliente_animal.animal_id = :id';
    
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $animalM->getId()
        ]);
        $tabela = $stm->fetchAll(\PDO::FETCH_ASSOC);
        return $tabela;
    }
    
   
    

}