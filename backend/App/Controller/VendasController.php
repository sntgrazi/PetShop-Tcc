<?php

namespace App\Controller;

use App\Model\VendasModel;
use App\DAO\VendasDAO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


final class VendasController{

    public function cadastrarVenda(Request $request, Response $response, array $args){
        $data = $request->getParsedBody();
        var_dump($data);
        $vendasDAO = new VendasDAO();
        $vendasM = new VendasModel();
        $vendasM->setValorTotal($data['valor_total'])
                ->setFormasPagamento($data['metodos_pagamento'])
                ->setParcelas($data['parcelas'])
                ->setProdutosSelecionados($data['produtos']);
    
        $vendasDAO->cadastrarVenda($vendasM);
    
    
        $response->getBody()->write(json_encode(['message' => 'Venda armazenada com sucesso']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }

    public function getHistoricoVendas(Request $request, Response $response, array $args) {
        $vendasDAO = new VendasDAO();
        $historicoVendas = $vendasDAO->getHistoricoVendas();
    
        $response->getBody()->write(json_encode($historicoVendas));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    }
    

}

