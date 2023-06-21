<?php

namespace App\Model;

final class FuncionarioModel {
    private $id;
    private $nome;
    private $telefone;
    private $cpf;
    private $email;
    private $cep;
    private $bairro;
    private $rua;
    private $cidade;
    private $uf;
    private $n_casa;
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

    
    public function setNome(string $nome): FuncionarioModel{
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

   public function getCep(): string{
        return $this->cep;
    }

    public function setCep(string $cep): FuncionarioModel{
        $this->cep = $cep;
        return $this;
    }

    public function getBairro(): string{
        return $this->bairro;
    }

    public function setBairro(string $bairro): FuncionarioModel{
        $this->bairro = $bairro;
        return $this;
    }

    public function getRua(): string{
        return $this->rua;
    }

    public function setRua(string $rua): FuncionarioModel{
        $this->rua = $rua;
        return $this;
    }

    public function getCidade(): string{
        return $this->cidade;
    }

    public function setCidade(string $cidade): FuncionarioModel{
        $this->cidade = $cidade;
        return $this;
    }

    public function getUf(): string{
        return $this->uf;
    }

    public function setUf(string $uf): FuncionarioModel{
        $this->uf = $uf;
        return $this;
    }

    public function getN_casa(): string{
        return $this->n_casa;
    }

    public function setN_casa(string $n_casa): FuncionarioModel{
        $this->n_casa = $n_casa;
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

    public function getEmail(): string{
        return $this->email;
    }

    public function setEmail(string $email): FuncionarioModel{
        $this->email = $email;

        return $this;
    }
}