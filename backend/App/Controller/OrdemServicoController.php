<?php

namespace App\Controller;

use App\DAO\OrdemServicoDAO;
use App\DAO\OrdemServicoModel;

final class OrdemServicoController {

    public function getFuncionarios(Request $request, Response $response, array $args){
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
             ->setCliente_id($data['cliente_id'])
             ->setAnimal_id($data['animal_id'])
             ->setFuncionario_id($data['funcionario_id'])
             ->setServico_id($data['servico_id'])
             ->setHora_inicio($data['hora_inicio'])
             ->setHora_termino($data['hora_termino'])
             ->setDuracao($data['duracao']);
        $clienteDAO->insertOrdem($ordemM);

        
        $response->getBody()->write(json_encode(['message' => 'Ordem feita com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
}