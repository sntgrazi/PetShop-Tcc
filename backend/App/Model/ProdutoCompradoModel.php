<?php

namespace App\Model;

final class ProdutoCompradoModel {

    private $id;

    private $compraId;

    private $produtoId;

    private $quantidade;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): ProdutoCompradoModel {
        $this->id = $id;
        return $this;
    }

    public function getCompraId(): int {
        return $this->compraId;
    }

    public function setCompraId(int $compraId): ProdutoCompradoModel {
        $this->compraId = $compraId;
        return $this;
    }

    public function getProdutoId(): int {
        return $this->produtoId;
    }

    public function setProdutoId(int $produtoId): ProdutoCompradoModel {
        $this->produtoId = $produtoId;
        return $this;
    }

    public function getQuantidade(): int {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): ProdutoCompradoModel {
        $this->quantidade = $quantidade;
        return $this;
    }

}
