<?php

namespace App\Controller;

use App\DAO\ProdutoDAO;
use App\Model\ProdutoModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class ProdutoController {

    public function getProdutos(Request $request, Response $response, array $args) {

        $produtoDAO = new ProdutoDAO();
        $produtos = $produtoDAO->getAllProdutos();

        $response->getBody()->write(json_encode($produtos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getProduto(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $produtoDAO = new ProdutoDAO();
        $produtoModel = new ProdutoModel();
        $produtoModel->setId($id);
        $produto = $produtoDAO->getProduto($produtoModel);

        $response->getBody()->write(json_encode($produto));
        return $response->withHeader('Content-Type', 'application/json');
        

    }

    public function insertProduto(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $produtoDAO = new ProdutoDAO();
        $produto = new ProdutoModel();
        $produto->setNome($data['nome'])
                ->setQuantidade($data['quantidade'])
                ->setValorCompra($data['valor_compra'])
                ->setValorVenda($data['valor_venda'])
                ->setImgProduto($data['img_produto'])
                ->setCodigoBarras($data['codigo_de_barras'])
                ->setFornecedorId($data['fornecedor_id']);
        $produtoDAO->insertProduto($produto);

        
        $response->getBody()->write(json_encode(['message' => 'Produto inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function updateProduto(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $produtoDAO = new ProdutoDAO();
       $produtoModel = new ProdutoModel();
       $produtoModel->setId($id)
                    ->setNome($data['nome'])
                    ->setQuantidade($data['quantidade'])
                    ->setValorCompra($data['valor_compra'])
                    ->setValorVenda($data['valor_venda'])
                    ->setImgProduto($data['img_produto'])
                    ->setCodigoBarras($data['codigo_de_barras'])
                    ->setFornecedorId($data['fornecedor_id']);
       $produtoDAO->updateProduto($produtoModel);

       $response->getBody()->write(json_encode(['message' => 'Produto atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deleteProduto(Request $request, Response $response, array $args) {

        $id = $args['id'];
    

        $produtoDAO = new ProdutoDAO();
        $produto = new ProdutoModel();
        $produto->setId($id);
        $produtoDAO->deleteProduto($produto);

        $response->getBody()->write(json_encode(['message' => 'Produto deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}