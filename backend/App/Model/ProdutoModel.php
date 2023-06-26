<?php

namespace App\Model;


final class ProdutoModel {

    private $id;
    private $nome;
    private $quantidade;
    private $valor_compra;
    private $valor_venda;
    private $cod_barras;
    private $fornecedor_id;
    private $data_validade;

    public function getId(): int{
        return $this->id;
    }

 
    public function setId(int $id): ProdutoModel{
        $this->id = $id;

        return $this;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function setNome(string $nome): ProdutoModel{
        $this->nome = $nome;

        return $this;
    }



    public function getQuantidade(): int{
        return $this->quantidade;
    }


    public function setQuantidade(int $quantidade): ProdutoModel{
        $this->quantidade = $quantidade;

        return $this;
    }

    public function getValor_compra(): string{
        return $this->valor_compra;
    }

    public function setValor_compra(string $valor_compra): ProdutoModel{
        $this->valor_compra = $valor_compra;

        return $this;
    }


    public function getValor_venda(): string{
        return $this->valor_venda;
    }

    public function setValor_venda(string $valor_venda): ProdutoModel{
        $this->valor_venda = $valor_venda;

        return $this;
    }

    public function getCod_barras(): int{
        return $this->cod_barras;
    }


    public function setCod_barras(int $cod_barras): ProdutoModel{
        $this->cod_barras = $cod_barras;

        return $this;
    }

    public function getFornecedor_id(): int{
        return $this->fornecedor_id;
    }

    public function setFornecedor_id(int $fornecedor_id): ProdutoModel{
        $this->fornecedor_id = $fornecedor_id;

        return $this;
    }


    public function getData_validade(): string{
        return $this->data_validade;
    }

    public function setData_validade(string $data_validade): ProdutoModel{
        $this->data_validade = $data_validade;

        return $this;
    }
}