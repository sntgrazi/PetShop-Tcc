<?php

namespace App\DAO;

use App\Model\AnimalModel;

class AnimalDAO extends ConexaoDAO {
    
    public function __construct(){
        parent::__construct();
    }
    
    public function getAllAnimais(): array {
        $sql = 'SELECT * FROM animais';
        $animais = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        return $animais;
    }
    
    public function getAnimal(AnimalModel $animalM): array {
        $sql = 'SELECT * FROM animais WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $animalM->getId()]);
        
        $animal = $stm->fetch(\PDO::FETCH_ASSOC);
        
        return $animal;
    }
    
    public function insertAnimal(AnimalModel $animal): void {
        $sql = 'INSERT INTO animais VALUES (null, :nome, :raca, :pelagem, :porte, :sexo, :peso, :nascimento, :especie, :altura, :img_animal)';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'nome' => $animal->getNome(),
            'raca' => $animal->getRaca(),
            'pelagem' => $animal->getPelagem(),
            'porte' => $animal->getPorte(),
            'sexo' => $animal->getSexo(),
            'peso' => $animal->getPeso(),
            'nascimento' => $animal->getNascimento(),
            'especie' => $animal->getEspecie(),
            'altura' => $animal->getAltura(),
            'img_animal' => $animal->getImgAnimal()
        ]);
    }
    
    public function updateAnimal(AnimalModel $animal): void {
        $sql = 'UPDATE animais SET nome = :nome, raca = :raca, pelagem = :pelagem, porte = :porte, sexo = :sexo, peso = :peso, nascimento = :nascimento, especie = :especie, altura = :altura, img_animal = :img_animal WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $animal->getId(),
            'nome' => $animal->getNome(),
            'raca' => $animal->getRaca(),
            'pelagem' => $animal->getPelagem(),
            'porte' => $animal->getPorte(),
            'sexo' => $animal->getSexo(),
            'peso' => $animal->getPeso(),
            'nascimento' => $animal->getNascimento(),
            'especie' => $animal->getEspecie(),
            'altura' => $animal->getAltura(),
            'img_animal' => $animal->getImgAnimal()
        ]);
    }
    
    public function deleteAnimal(AnimalModel $animal): void {
        $sql = 'DELETE FROM animais WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $animal->getId()]);
    }

}
