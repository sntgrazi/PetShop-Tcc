<?php

namespace App\Controller;

use App\DAO\CompraDAO;
use App\Model\CompraModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class CompraController {

    public function getCompras(Request $request, Response $response, array $args) {

        $compraDAO = new CompraDAO();
        $compras = $compraDAO->getAllCompras();

        $response->getBody()->write(json_encode($compras));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getCompra(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $compraDAO = new CompraDAO();
        $compraModel = new CompraModel();
        $compraModel->setId($id);
        $compra = $compraDAO->getCompra($compraModel);

        $response->getBody()->write(json_encode($compra));
        return $response->withHeader('Content-Type', 'application/json');
        

    }

    public function insertCompra(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $compraDAO = new CompraDAO();
        $compra = new CompraModel();
        $compra->setDataCompra($data['data_compra'])
               ->setValorTotal($data['valor_total']);
        $compraDAO->insertCompra($compra);
        
        $response->getBody()->write(json_encode(['message' => 'Compra inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function updateCompra(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $compraDAO = new CompraDAO();
       $compraModel = new CompraModel();
       $compraModel->setId($id)
                   ->setDataCompra($data['data_compra'])
                   ->setValorTotal($data['valor_total']);
       $compraDAO->updateCompra($compraModel);

       $response->getBody()->write(json_encode(['message' => 'Compra atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deleteCompra(Request $request, Response $response, array $args) {

        $id = $args['id'];
    

        $compraDAO = new CompraDAO();
        $compra = new CompraModel();
        $compra->setId($id);
        $compraDAO->deleteCompra($compra);

        $response->getBody()->write(json_encode(['message' => 'Compra deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}