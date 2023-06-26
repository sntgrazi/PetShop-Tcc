<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\DAO\ProdutoDAO;
use App\Model\ProdutoModel;

class ProdutoController
{
    public function getAllProdutos(Request $request, Response $response, array $args): Response
    {
        $produtoDAO = new ProdutoDAO();
        $produtos = $produtoDAO->getAllProdutos();

        $response->getBody()->write(json_encode($produtos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function cadastrarProduto(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $produtoDAO = new ProdutoDAO();
        $produtoM = new ProdutoModel();
        $produtoM->setNome($data['nome'])
            ->setQuantidade($data['quantidade'])
            ->setData_validade($data['data_validade'])
            ->setValor_compra($data['valor_compra'])
            ->setValor_venda($data['valor_venda'])
            ->setCod_barras($data['cod_barras'])
            ->setFornecedor_id($data['fornecedor_id']);

        $produtoDAO->cadastrarProduto($produtoM);

        $response->getBody()->write(json_encode(['message' => 'Produto cadastrado com sucesso']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getProdutoWithFornecedorById(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        $produtoDAO = new ProdutoDAO();
        $produtoM = new ProdutoModel();
        $produtoM->setId($id);

        $produto = $produtoDAO->getProdutoWithFornecedorById($produtoM);

        $response->getBody()->write(json_encode($produto));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function atualizarProduto(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $data = $request->getParsedBody();

        $produtoDAO = new ProdutoDAO();
        $produtoM = new ProdutoModel();
        $produtoM->setId($id)
            ->setNome($data['nome'])
            ->setQuantidade($data['quantidade'])
            ->setData_validade($data['data_validade'])
            ->setValor_compra($data['valor_compra'])
            ->setValor_venda($data['valor_venda'])
            ->setCod_barras($data['cod_barras'])
            ->setFornecedor_id($data['fornecedor_id']);

        $produtoDAO->atualizarProduto($produtoM);

        $response->getBody()->write(json_encode(['message' => 'Produto atualizado com sucesso']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deletarProduto(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        $produtoDAO = new ProdutoDAO();
        $produtoM = new ProdutoModel();
        $produtoM->setId($id);

        $produtoDAO->deletarProduto($produtoM);

        $response->getBody()->write(json_encode(['message' => 'Produto deletado com sucesso']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
