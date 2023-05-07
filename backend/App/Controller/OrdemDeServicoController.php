<?php

namespace App\Controller;

use App\DAO\OrdemDeServicoDAO;
use App\Model\OrdemDeServicoModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class OrdemDeServicoController {

    public function getOrdemDeServicos(Request $request, Response $response, array $args) {

        $ordemDeServicoDAO = new OrdemDeServicoDAO();
        $ordemDeServicos = $ordemDeServicoDAO->getAllOrdensDeServico();

        $response->getBody()->write(json_encode($ordemDeServicos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getOrdemDeServico(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $ordemDeServicoDAO = new OrdemDeServicoDAO();
        $ordemDeServicoModel = new OrdemDeServicoModel();
        $ordemDeServicoModel->setId($id);
        $ordemDeServico = $ordemDeServicoDAO->getOrdemDeServico($ordemDeServicoModel);

        $response->getBody()->write(json_encode($ordemDeServico));
        return $response->withHeader('Content-Type', 'application/json');
        

    }

    public function insertOrdemDeServico(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $ordemDeServicoDAO = new OrdemDeServicoDAO();
        $ordemDeServico = new OrdemDeServicoModel();
        $ordemDeServico->setDataOrdemServico($data['data_ordem_servico'])
                       ->setAnimalId($data['animal_id'])
                       ->setColaboradorId($data['colaborador_id'])
                       ->setClienteId($data['cliente_id'])
                       ->setServicoId($data['servico_id'])
                       ->setHoraInicio($data['hora_inicio'])
                       ->setHoraTermino($data['hora_termino'])
                       ->setStatus($data['status']);
        $ordemDeServicoDAO->insertOrdemDeServico($ordemDeServico);

        
        $response->getBody()->write(json_encode(['message' => 'OrdemDeServico inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function updateOrdemDeServico(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $ordemDeServicoDAO = new OrdemDeServicoDAO();
       $ordemDeServicoModel = new OrdemDeServicoModel();
       $ordemDeServicoModel->setId($id)
                    ->setDataOrdemServico($data['data_ordem_servico'])
                    ->setAnimalId($data['animal_id'])
                    ->setColaboradorId($data['colaborador_id'])
                    ->setClienteId($data['cliente_id'])
                    ->setServicoId($data['servico_id'])
                    ->setHoraInicio($data['hora_inicio'])
                    ->setHoraTermino($data['hora_termino'])
                    ->setStatus($data['status']);
       $ordemDeServicoDAO->updateOrdemDeServico($ordemDeServicoModel);

       $response->getBody()->write(json_encode(['message' => 'OrdemDeServico atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deleteOrdemDeServico(Request $request, Response $response, array $args) {

        $id = $args['id'];
    

        $ordemDeServicoDAO = new OrdemDeServicoDAO();
        $ordemDeServico = new OrdemDeServicoModel();
        $ordemDeServico->setId($id);
        $ordemDeServicoDAO->deleteOrdemDeServico($ordemDeServico);

        $response->getBody()->write(json_encode(['message' => 'OrdemDeServico deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}