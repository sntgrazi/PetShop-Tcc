<?php

namespace App\Model;

final class ClienteModel{

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

    public function getEmail(): string{
        return $this->email;
    }

    public function setEmail(string $email): ClienteModel{
        $this->email = $email;
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

    public function getCep(): string{
        return $this->cep;
    }

    public function setCep(string $cep): ClienteModel{
        $this->cep = $cep;
        return $this;
    }

    public function getBairro(): string{
        return $this->bairro;
    }

    public function setBairro(string $bairro): ClienteModel{
        $this->bairro = $bairro;
        return $this;
    }

    public function getRua(): string{
        return $this->rua;
    }

    public function setRua(string $rua): ClienteModel{
        $this->rua = $rua;
        return $this;
    }

    public function getCidade(): string{
        return $this->cidade;
    }

    public function setCidade(string $cidade): ClienteModel{
        $this->cidade = $cidade;
        return $this;
    }

    public function getUf(): string{
        return $this->uf;
    }

    public function setUf(string $uf): ClienteModel{
        $this->uf = $uf;
        return $this;
    }

    public function getN_casa(): string{
        return $this->n_casa;
    }

    public function setN_casa(string $n_casa): ClienteModel{
        $this->n_casa = $n_casa;
        return $this;
    }

}