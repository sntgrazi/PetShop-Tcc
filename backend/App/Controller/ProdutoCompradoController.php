<?php

namespace App\Controller;

use App\DAO\ProdutoCompradoDAO;
use App\Model\ProdutoCompradoModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class ProdutoCompradoController {

    public function getProdutoComprados(Request $request, Response $response, array $args) {

        $produtoCompradoDAO = new ProdutoCompradoDAO();
        $produtoComprados = $produtoCompradoDAO->getAllProdutosComprados();

        $response->getBody()->write(json_encode($produtoComprados));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getProdutoComprado(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $produtoCompradoDAO = new ProdutoCompradoDAO();
        $produtoCompradoModel = new ProdutoCompradoModel();
        $produtoCompradoModel->setId($id);
        $produtoComprado = $produtoCompradoDAO->getProdutoComprado($produtoCompradoModel);

        $response->getBody()->write(json_encode($produtoComprado));
        return $response->withHeader('Content-Type', 'application/json');
        

    }

    public function insertProdutoComprado(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $produtoCompradoDAO = new ProdutoCompradoDAO();
        $produtoComprado = new ProdutoCompradoModel();
        $produtoComprado->setProdutoId($data['produto_id'])
                        ->setCompraId($data['compra_id'])
                        ->setQuantidade($data['quantidade']);
        $produtoCompradoDAO->insertProdutoComprado($produtoComprado);

        $response->getBody()->write(json_encode(['message' => 'ProdutoComprado inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function updateProdutoComprado(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $produtoCompradoDAO = new ProdutoCompradoDAO();
       $produtoCompradoModel = new ProdutoCompradoModel();
       $produtoCompradoModel->setId($id)
                            ->setProdutoId($data['produto_id'])
                            ->setCompraId($data['compra_id'])
                            ->setQuantidade($data['quantidade']);
       $produtoCompradoDAO->updateProdutoComprado($produtoCompradoModel);

       $response->getBody()->write(json_encode(['message' => 'ProdutoComprado atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deleteProdutoComprado(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $produtoCompradoDAO = new ProdutoCompradoDAO();
        $produtoComprado = new ProdutoCompradoModel();
        $produtoComprado->setId($id);
        $produtoCompradoDAO->deleteProdutoComprado($produtoComprado);

        $response->getBody()->write(json_encode(['message' => 'ProdutoComprado deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}