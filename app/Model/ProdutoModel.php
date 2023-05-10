<?php

namespace App\Model;

final class ProdutoModel
{
    private int $id;
    private string $nome;
    private int $quantidade;
    private float $valorCompra;
    private float $valorVenda;
    private ?string $imgProduto;
    private string $codigoBarras;
    private int $fornecedorId;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): ProdutoModel {
        $this->id = $id;
        return $this;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): ProdutoModel {
        $this->nome = $nome;
        return $this;
    }

    public function getQuantidade(): int {
        return $this->quantidade;
    }

    public function setQuantidade(int $quantidade): ProdutoModel {
        $this->quantidade = $quantidade;
        return $this;
    }

    public function getValorCompra(): float {
        return $this->valorCompra;
    }

    public function setValorCompra(float $valorCompra): ProdutoModel {
        $this->valorCompra = $valorCompra;
        return $this;
    }

    public function getValorVenda(): float {
        return $this->valorVenda;
    }

    public function setValorVenda(float $valorVenda): ProdutoModel {
        $this->valorVenda = $valorVenda;
        return $this;
    }

    public function getImgProduto(): ?string {
        return $this->imgProduto;
    }

    public function setImgProduto(?string $imgProduto): ProdutoModel {
        $this->imgProduto = $imgProduto;
        return $this;
    }

    public function getCodigoBarras(): string {
        return $this->codigoBarras;
    }

    public function setCodigoBarras(string $codigoBarras): ProdutoModel {
        $this->codigoBarras = $codigoBarras;
        return $this;
    }

    public function getFornecedorId(): int {
        return $this->fornecedorId;
    }

    public function setFornecedorId(int $fornecedorId): ProdutoModel {
        $this->fornecedorId = $fornecedorId;
        return $this;
    }
}
