<?php

namespace App\Model;

final class CompraModel {
    private int $id;
    private string $dataCompra;
    private int $produtoId;
    private int $quantidade;
    private float $valorProduto;
    private float $valorTotal;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): CompraModel {
        $this->id = $id;
        return $this;
    }

    public function getDataCompra(): string {
        return $this->dataCompra;
    }

    public function setDataCompra(string $dataCompra): CompraModel {
        $this->dataCompra = $dataCompra;
        return $this;
    }

    public function getValorTotal(): float {
        return $this->valorTotal;
    }

    public function setValorTotal(float $valorTotal): CompraModel {
        $this->valorTotal = $valorTotal;
        return $this;
    }
}
