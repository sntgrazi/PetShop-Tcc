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
        $ordemM->setData_Inicio($data['data_inicio'])
             ->setData_Termino($data['data_termino'])
             ->setCliente_id($data['cliente_id'])
             ->setAnimal_id($data['animal_id'])
             ->setFuncionario_id($data['funcionario_id'])
             ->setServico_id($data['servico_id'])
             ->setHora_inicio($data['hora_inicio'])
             ->setHora_termino($data['hora_termino'])
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

    public function updateOrdem(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $ordemDAO = new OrdemServicoDAO();
       $ordemModel = new OrdemServicoModel();
       $ordemModel->setId($id)
                ->setData_Inicio($data['data_inicio'])
                ->setData_Termino($data['data_termino']) 
                ->setCliente_id($data['cliente_id'])
                ->setAnimal_id($data['animal_id'])
                ->setFuncionario_id($data['funcionario_id'])
                ->setServico_id($data['servico_id'])
                ->setHora_inicio($data['hora_inicio'])
                ->setHora_termino($data['hora_termino'])
                ->setDuracao($data['duracao']);
       $ordemDAO->updateOrdem($ordemModel);

       $response->getBody()->write(json_encode(['message' => 'Agendamento atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteOrdem(Request $request, Response $response, array $args){
        $id = $args['id'];

        $ordemDAO = new OrdemServicoDAO();
        $ordemM = new OrdemServicomodel();
        $ordemM->setId($id);
        $ordemDAO->deleteOrdem($ordemM);

        $response->getBody()->write(json_encode(['message' => 'Ordem deletada com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
}