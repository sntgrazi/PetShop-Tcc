<?php

namespace App\Model;

final class ServicosModel{

    private $id;
    private $nome_servico;
    private $valor;


    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): ServicosModel
    {
        $this->id = $id;
        return $this;
    }

    public function getNomeServico(): string
    {
        return $this->nome_servico;
    }

    public function setNomeServico(string $nome_servico): ServicosModel
    {
        $this->nome_servico = $nome_servico;
        return $this;
    }

    public function getValor(): string
    {
        return $this->valor;
    }

    public function setValor(string $valor): ServicosModel
    {
        $this->valor = $valor;
        return $this;
    }
}