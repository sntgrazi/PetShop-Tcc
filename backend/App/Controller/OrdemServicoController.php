<?php

namespace App\Controller;

use App\DAO\OrdemServicoDAO;
use App\Model\OrdemServicoModel;
use DateTime;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class OrdemServicoController {

    public function getOrdensById(Request $request, Response $response, array $args){

        $id = $args['id'];

        $ordemDAO = new OrdemServicoDAO();
        $ordemM = new OrdemServicoModel();
        $ordemM ->setId($id);
        $ordens = $ordemDAO->getOrdensById($ordemM);

        $response->getBody()->write(json_encode($ordens));
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function getAllOrdens(Request $request, Response $response, array $args){
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
        $ordemM->setData_Inicio(DateTime::createFromFormat('d/m/Y', $data['dataInicio'])->format('Y-m-d')) 
             ->setData_Termino(DateTime::createFromFormat('d/m/Y', $data['dataTermino'])->format('Y-m-d')) 
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

    public function updateStatus(Request $request, Response $response, array $args){
        $id = $args['id'];
        $data = $request->getParsedBody();


        $ordemDAO = new OrdemServicoDAO();
        $ordemM = new OrdemServicoModel();

        $ordemM->setId($id)
                ->setStatus($data['status']);
    
        $ordemDAO->updateStatus($ordemM);

        $response->getBody()->write(json_encode(['message' => 'Status atualizado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
}