<?php

namespace App\Controller;

use App\DAO\ServicoDAO;
use App\Model\ServicoModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class ServicoController {

    public function getServicos(Request $request, Response $response, array $args) {

        $servicoDAO = new ServicoDAO();
        $servicos = $servicoDAO->getAllServicos();

        $response->getBody()->write(json_encode($servicos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getServico(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $servicoDAO = new ServicoDAO();
        $servicoModel = new ServicoModel();
        $servicoModel->setId($id);
        $servico = $servicoDAO->getServico($servicoModel);

        $response->getBody()->write(json_encode($servico));
        return $response->withHeader('Content-Type', 'application/json');
        
    }

    public function insertServico(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $servicoDAO = new ServicoDAO();
        $servico = new ServicoModel();
        $servico->setDescricao($data['descricao'])
                ->setValor($data['valor']);
        $servicoDAO->insertServico($servico);

        
        $response->getBody()->write(json_encode(['message' => 'Servico inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function updateServico(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $servicoDAO = new ServicoDAO();
       $servicoModel = new ServicoModel();
       $servicoModel->setId($id)
                    ->setDescricao($data['descricao'])
                    ->setValor($data['valor']);
       $servicoDAO->updateServico($servicoModel);

       $response->getBody()->write(json_encode(['message' => 'Servico atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deleteServico(Request $request, Response $response, array $args) {

        $id = $args['id'];
    

        $servicoDAO = new ServicoDAO();
        $servico = new ServicoModel();
        $servico->setId($id);
        $servicoDAO->deleteServico($servico);

        $response->getBody()->write(json_encode(['message' => 'Servico deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}