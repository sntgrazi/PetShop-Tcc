<?php

namespace App\Controller;

use App\DAO\ProdutoVendidoDAO;
use App\Model\ProdutoVendidoModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class ProdutoVendidoController {

    public function getProdutoVendidos(Request $request, Response $response, array $args) {

        $produtoVendidoDAO = new ProdutoVendidoDAO();
        $produtoVendidos = $produtoVendidoDAO->getAllProdutosVendidos();

        $response->getBody()->write(json_encode($produtoVendidos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getProdutoVendido(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $produtoVendidoDAO = new ProdutoVendidoDAO();
        $produtoVendidoModel = new ProdutoVendidoModel();
        $produtoVendidoModel->setId($id);
        $produtoVendido = $produtoVendidoDAO->getProdutoVendido($produtoVendidoModel);

        $response->getBody()->write(json_encode($produtoVendido));
        return $response->withHeader('Content-Type', 'application/json');
        
    }

    public function insertProdutoVendido(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $produtoVendidoDAO = new ProdutoVendidoDAO();
        $produtoVendido = new ProdutoVendidoModel();
        $produtoVendido->setProdutoId($data['produto_id'])
                        ->setVendaId($data['venda_id'])
                        ->setQuantidade($data['quantidade']);
        $produtoVendidoDAO->insertProdutoVendido($produtoVendido);

        $response->getBody()->write(json_encode(['message' => 'ProdutoVendido inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function updateProdutoVendido(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $produtoVendidoDAO = new ProdutoVendidoDAO();
       $produtoVendidoModel = new ProdutoVendidoModel();
       $produtoVendidoModel->setId($id)
                            ->setProdutoId($data['produto_id'])
                            ->setVendaId($data['compra_id'])
                            ->setQuantidade($data['quantidade']);
       $produtoVendidoDAO->updateProdutoVendido($produtoVendidoModel);

       $response->getBody()->write(json_encode(['message' => 'ProdutoVendido atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deleteProdutoVendido(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $produtoVendidoDAO = new ProdutoVendidoDAO();
        $produtoVendido = new ProdutoVendidoModel();
        $produtoVendido->setId($id);
        $produtoVendidoDAO->deleteProdutoVendido($produtoVendido);

        $response->getBody()->write(json_encode(['message' => 'ProdutoVendido deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}