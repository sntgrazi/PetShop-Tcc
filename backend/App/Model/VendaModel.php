<?php

namespace App\Model;

final class VendaModel {

    private $id;

    private $dataVenda;

    private $valorTotal;

    private $clienteId;

    private $colaboradorId;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): VendaModel {
        $this->id = $id;
        return $this;
    }

    public function getDataVenda(): string {
        return $this->dataVenda;
    }

    public function setDataVenda(string $dataVenda): VendaModel {
        $this->dataVenda = $dataVenda;
        return $this;
    }

    public function getValorTotal(): float {
        return $this->valorTotal;
    }

    public function setValorTotal(float $valorTotal): VendaModel {
        $this->valorTotal = $valorTotal;
        return $this;
    }

    public function getClienteId(): int {
        return $this->clienteId;
    }

    public function setClienteId(int $clienteId): VendaModel {
        $this->clienteId = $clienteId;
        return $this;
    }

    public function getColaboradorId(): int {
        return $this->colaboradorId;
    }

    public function setColaboradorId(int $colaboradorId): VendaModel {
        $this->colaboradorId = $colaboradorId;
        return $this;
    }

}
