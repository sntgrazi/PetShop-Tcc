<?php

namespace App\Model;

final class ServicoModel {
    private int $id;
    private string $descricao;
    private float $valor;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): ServicoModel {
        $this->id = $id;
        return $this;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): ServicoModel {
        $this->descricao = $descricao;
        return $this;
    }

    public function getValor(): float {
        return $this->valor;
    }

    public function setValor(float $valor): ServicoModel {
        $this->valor = $valor;
        return $this;
    }
}
