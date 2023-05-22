<?php

namespace App\Model;

final class ClienteAnimalModel{

    private $tutor_id;
    private $animal_id;


    public function getAnimal_id(): int{
        return $this->animal_id;
    }

    public function setAnimal_id(int $animal_id):  ClienteAnimalModel{
        $this->animal_id = $animal_id;
        return $this;
    }

    
    public function getTutor_id(): int
    {
        return $this->tutor_id;
    }

    public function setTutor_id($tutor_id): ClienteAnimalModel
    {
        $this->tutor_id = $tutor_id;

        return $this;
    }
}