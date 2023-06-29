<?php

namespace App\Model;

final class VendasModel{
    private $id;
    private $valor_total;
    private $quantidade_produtos;
    private $formasPagamento;
    private $parcelas;
    private $data_venda;
    private $produtosSelecionados;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): VendasModel
    {
        $this->id = $id;
        return $this;
    }

    public function getValorTotal(): string
    {
        return $this->valor_total;
    }

    public function setValorTotal(string $valor_total): VendasModel
    {
        $this->valor_total = $valor_total;
        return $this;
    }

    public function getQuantidadeProdutos(): int
    {
        return $this->quantidade_produtos;
    }

    public function setQuantidadeProdutos(int $quantidade_produtos): VendasModel
    {
        $this->quantidade_produtos = $quantidade_produtos;
        return $this;
    }

    public function getFormasPagamento(): array
    {
        return $this->formas_pagamento;
    }

    public function setFormasPagamento(array $formas_pagamento): VendasModel
    {
        $this->formas_pagamento = $formas_pagamento;
        return $this;
    }

    public function getProdutosSelecionados(): array
    {
        return $this->produtosSelecionados;
    }

    public function setProdutosSelecionados(array $produtosSelecionados): VendasModel
    {
        $this->produtosSelecionados = $produtosSelecionados;
        return $this;
    }

 
    public function getParcelas(): string{
        return $this->parcelas;
    }

    public function setParcelas(string $parcelas): VendasModel{
        $this->parcelas = $parcelas;

        return $this;
    }


    public function getData_venda(): string{
        return $this->data_venda;
    }


    public function setData_venda(string $data_venda): VendasModel{
        $this->data_venda = $data_venda;

        return $this;
    }
}
