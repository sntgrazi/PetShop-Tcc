<?php

namespace App\Controller;

use App\DAO\VendaDAO;
use App\Model\VendaModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class VendaController {

    public function getVendas(Request $request, Response $response, array $args) {

        $vendaDAO = new VendaDAO();
        $vendas = $vendaDAO->getAllVendas();

        $response->getBody()->write(json_encode($vendas));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getVenda(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $vendaDAO = new VendaDAO();
        $vendaModel = new VendaModel();
        $vendaModel->setId($id);
        $venda = $vendaDAO->getVenda($vendaModel);

        $response->getBody()->write(json_encode($venda));
        return $response->withHeader('Content-Type', 'application/json');
        

    }

    public function insertVenda(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $vendaDAO = new VendaDAO();
        $venda = new VendaModel();
        $venda->setDataVenda($data['data_venda'])
              ->setValorTotal($data['valor_total'])
              ->setClienteId($data['cliente_id'])
              ->setColaboradorId($data['colaborador_id']);
        $vendaDAO->insertVenda($venda);
        
        $response->getBody()->write(json_encode(['message' => 'Venda inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function updateVenda(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $vendaDAO = new VendaDAO();
       $vendaModel = new VendaModel();
       $vendaModel->setId($id)
                  ->setDataVenda($data['data_venda'])
                  ->setValorTotal($data['valor_total'])
                  ->setClienteId($data['cliente_id'])
                  ->setColaboradorId($data['colaborador_id']);
       $vendaDAO->updateVenda($vendaModel);

       $response->getBody()->write(json_encode(['message' => 'Venda atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deleteVenda(Request $request, Response $response, array $args) {

        $id = $args['id'];
    

        $vendaDAO = new VendaDAO();
        $venda = new VendaModel();
        $venda->setId($id);
        $vendaDAO->deleteVenda($venda);

        $response->getBody()->write(json_encode(['message' => 'Venda deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}