<?php

namespace App\Model;

final class AnimalModel{

    private $id;
    private $nome_pet;
    private $data_nascimento;
    private $sexo;
    private $altura;
    private $peso;
    private $especie;
    private $raca;
    private $pelagem;
    private $porte;
    private $tutor_id;

    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id): AnimalModel{
        $this->id = $id;
        return $this;
    }

    public function getNome_pet(): string{
        return $this->nome_pet;
    }

    public function setNome_pet(string $nome_pet): AnimalModel{
        $this->nome_pet = $nome_pet;
        return $this;
    }

    public function getData_nascimento(): string{
        return $this->data_nascimento;
    }

    public function setData_nascimento(string $data_nascimento): AnimalModel{
        $this->data_nascimento = $data_nascimento;
        return $this;
    }

    public function getSexo(): String{
        return $this->sexo;
    }

    public function setSexo(string $sexo): AnimalModel{
        $this->sexo = $sexo;
        return $this;
    }

    public function getAltura(): String{
        return $this->altura;
    }

    public function setAltura(String $altura): AnimalModel{
        $this->altura = $altura;
        return $this;
    }
    
    public function getPeso(): String{
        return $this->peso;
    }

    public function setPeso(String $peso): AnimalModel{
        $this->peso = $peso;
        return $this;
    }

    public function getEspecie(): String{
        return $this->especie;
    }

    public function setEspecie(String $especie): AnimalModel{
        $this->especie = $especie;
        return $this;
    }
    public function getRaca(): String{
        return $this->raca;
    }

    public function setRaca(String $raca): AnimalModel{
        $this->raca = $raca;
        return $this;
    }
    public function getPelagem(): String{
        return $this->pelagem;
    }

    public function setPelagem(String $pelagem): AnimalModel{
        $this->pelagem = $pelagem;
        return $this;
    }

    public function getPorte(): String{
        return $this->porte;
    }

    public function setPorte(String $porte): AnimalModel{
        $this->porte = $porte;
        return $this;
    }

    public function getTutor_id(): int{
        return $this->tutor_id;
    }

    public function setTutor_id(int $tutor_id):  AnimalModel{
        $this->tutor_id = $tutor_id;
        return $this;
    }

}