<?php

namespace App\Model;

final class ClienteModel{

    private $id;

    private $nome;

    private $pets;

    private $cpf;

    private $telefone;

    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id): ClienteModel{
        $this->id = $id;
        return $this;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function setNome(string $nome): ClienteModel{
        $this->nome = $nome;
        return $this;
    }

    public function getPets(): string{
        return $this->pets;
    }

    public function setPets(string $pets): ClienteModel{
        $this->pets = $pets;
        return $this;
    }

    public function getCpf(): string{
        return $this->cpf;
    }

    public function setCpf(string $cpf): ClienteModel{
        $this->cpf = $cpf;
        return $this;
    }


    public function getTelefone(): string{
        return $this->telefone;
    }

    public function setTelefone(string $telefone): ClienteModel{
        $this->telefone = $telefone;
        return $this;
    }

}


