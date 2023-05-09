<?php

namespace App\Model;

final class ColaboradorModel {
    private $id;
    private $nome;
    private $telefone;
    private $cpf;
    private $endereco;
    private $email;
    private $cargo;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): ColaboradorModel {
        $this->id = $id;
        return $this;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): ColaboradorModel {
        $this->nome = $nome;
        return $this;
    }

    public function getTelefone(): string {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): ColaboradorModel {
        $this->telefone = $telefone;
        return $this;
    }

    public function getCpf(): string {
        return $this->cpf;
    }

    public function setCpf(string $cpf): ColaboradorModel {
        $this->cpf = $cpf;
        return $this;
    }

    public function getEndereco(): string {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): ColaboradorModel {
        $this->endereco = $endereco;
        return $this;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): ColaboradorModel {
        $this->email = $email;
        return $this;
    }

    public function getCargo(): string {
        return $this->cargo;
    }

    public function setCargo(string $cargo): ColaboradorModel {
        $this->cargo = $cargo;
        return $this;
    }
}
