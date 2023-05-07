<?php

namespace App\Model;

final class ClienteAnimalModel {

    private $id;

    private $clienteId;

    private $animalId;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): ClienteAnimalModel {
        $this->id = $id;
        return $this;
    }

    public function getClienteId(): int {
        return $this->clienteId;
    }

    public function setClienteId(int $clienteId): ClienteAnimalModel {
        $this->clienteId = $clienteId;
        return $this;
    }

    public function getAnimalId(): int {
        return $this->animalId;
    }

    public function setAnimalId(int $animalId): ClienteAnimalModel {
        $this->animalId = $animalId;
        return $this;
    }

}
