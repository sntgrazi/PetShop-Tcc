<?php

namespace App\Controller;

use App\DAO\OrdemServicoDAO;
use App\Model\OrdemServicoModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class OrdemServicoController {

    public function getOrdens(Request $request, Response $response, array $args){
        $ordemDAO = new OrdemServicoDAO();
        $ordens = $ordemDAO->getAllOrdens();

        $response->getBody()->write(json_encode($ordens));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function insertOrdem(Request $request, Response $response, array $args)
    {
        $data = $request->getParsedBody();

        $ordemDAO = new OrdemServicoDAO();
        $ordemM = new OrdemServicoModel();
        $ordemM->setData($data['data']) 
             ->setCliente_id($data['cliente'])
             ->setAnimal_id($data['pet'])
             ->setFuncionario_id($data['funcionario'])
             ->setServico_id($data['servico'])
             ->setHora_inicio($data['horaInicio'])
             ->setHora_termino($data['horaTermino'])
             ->setDuracao($data['duracao']);
        $ordemDAO->insertOrdem($ordemM);

        
        $response->getBody()->write(json_encode(['message' => 'Ordem feita com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
}