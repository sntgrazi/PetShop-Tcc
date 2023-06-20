<?php

namespace App\Model;

final class FuncionarioModel {
    private $id;
    private $nome;
    private $telefone;
    private $cpf;
    private $endereco;
    private $cargo_id;

     
    public function getId(): int{
        return $this->id;
    }
 
    public function setId(int $id): FuncionarioModel{
        $this->id = $id;

        return $this;
    }


    public function getNome(): string{
        return $this->nome;
    }

    
    public function setNome( string $nome): FuncionarioModel{
        $this->nome = $nome;

        return $this;
    }
 
    public function getTelefone(): string{
        return $this->telefone;
    }
 
    public function setTelefone(string $telefone): FuncionarioModel{
        $this->telefone = $telefone;

        return $this;
    }

    public function getCpf(): string{
        return $this->cpf;
    }


    public function setCpf(string $cpf): FuncionarioModel{
        $this->cpf = $cpf;

        return $this;
    }


    public function getEndereco(): string{
        return $this->endereco;
    }

     
    public function setEndereco(string $endereco): FuncionarioModel{
        $this->endereco = $endereco;

        return $this;
    }

  
    public function getCargo(): int{
        return $this->cargo_id;
    }

    /**
     * Set the value of cargo
     *
     * @return  self
     */ 
    public function setCargo(int $cargo_id): FuncionarioModel{
        $this->cargo_id = $cargo_id;

        return $this;
    }
}