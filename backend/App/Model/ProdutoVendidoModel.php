<?php

namespace App\Model;

final class ProdutoVendidoModel {

    private $id;

    private $vendaId;

    private $produtoId;

    private $quantidade;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): ProdutoVendidoModel {
        $this->id = $id;
        return $this;
    }

    public function getVendaId(): int {
        return $this->vendaId;
    }

    public function setVendaId(int $vendaId): ProdutoVendidoModel {
        $this->vendaId = $vendaId;
        return $this;
    }

    public function getProdutoId(): int {
        return $this->produtoId;
    }

    public function setProdutoId(int $produtoId): ProdutoVendidoModel {
        $this->produtoId = $produtoId;
        return $this;
    }

    public function getQuantidade(): int {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): ProdutoVendidoModel {
        $this->quantidade = $quantidade;
        return $this;
    }

}
