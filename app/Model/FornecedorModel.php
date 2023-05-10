<?php

namespace App\Model;

final class FornecedorModel {
    private int $id;
    private string $nomeFantasia;
    private string $telefone;
    private string $email;
    private string $endereco;
    private string $cnpj;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): FornecedorModel {
        $this->id = $id;
        return $this;
    }

    public function getNomeFantasia(): string {
        return $this->nomeFantasia;
    }

    public function setNomeFantasia(string $nomeFantasia): FornecedorModel {
        $this->nomeFantasia = $nomeFantasia;
        return $this;
    }

    public function getTelefone(): string {
        return $this->telefone;
    }

    public function setTelefone(string $telefone): FornecedorModel {
        $this->telefone = $telefone;
        return $this;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): FornecedorModel {
        $this->email = $email;
        return $this;
    }

    public function getEndereco(): string {
        return $this->endereco;
    }

    public function setEndereco(string $endereco): FornecedorModel {
        $this->endereco = $endereco;
        return $this;
    }

    public function getCnpj(): string {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): FornecedorModel {
        $this->cnpj = $cnpj;
        return $this;
    }
}
