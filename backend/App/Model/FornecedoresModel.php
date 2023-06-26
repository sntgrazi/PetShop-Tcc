<?php

namespace App\Model;

final class FornecedoresModel {
    private $id;
    private $nome_fantasia;
    private $telefone;
    private $email;
    private $endereco;
    private $cnpj;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): FornecedoresModel {
        $this->id = $id;
        return $this;
    }

    public function getNomeFantasia(): string {
        return $this->nome_fantasia;
    }

    public function setNomeFantasia(string $nome_fantasia): FornecedoresModel {
        $this->nome_fantasia = $nome_fantasia;
        return $this;
    }

    public function getTelefone(): string {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): FornecedoresModel {
        $this->telefone = $telefone;
        return $this;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): FornecedoresModel {
        $this->email = $email;
        return $this;
    }

    public function getEndereco(): string {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): FornecedoresModel {
        $this->endereco = $endereco;
        return $this;
    }

    public function getCnpj(): string {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): FornecedoresModel {
        $this->cnpj = $cnpj;
        return $this;
    }
}
