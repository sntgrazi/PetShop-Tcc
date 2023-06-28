<?php

namespace App\Controller;

use App\Model\ServicosModel;
use App\DAO\ServicosDAO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class ServicosController{

    public function getServicos(Request $request, Response $response, array $args){
        $servicosDAO = new ServicosDAO();
        $servicos = $servicosDAO->getAllServicos();

        $response->getBody()->write(json_encode($servicos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getServicoById(Request $request, Response $response, array $args){
        $id = $args['id'];
        $servicosDAO = new ServicosDAO();
        $servicoM = new ServicosModel();
        $servicoM->setId($id);
        $servico = $servicosDAO->getServicoById($servicoM);
    
        if ($servico === null) {
            $response->getBody()->write(json_encode(['error' => 'Servico nao encontrado']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    
        $response->getBody()->write(json_encode($servico));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function cadastrarServico(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $servico = new ServicosModel();
        $servico->setNomeServico($data['nome_servico'])
            ->setValor($data['valor']);

        $servicosDAO = new ServicosDAO();
        $servicosDAO->cadastrarServico($servico);

        $response->getBody()->write(json_encode(['message' => 'Serviço cadastrado com sucesso']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function atualizarServico(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $data = $request->getParsedBody();

        $servico = new ServicosModel();
        $servico->setId($id)
            ->setNomeServico($data['nome_servico'])
            ->setValor($data['valor']);

        $servicosDAO = new ServicosDAO();
        $servicosDAO->atualizarServico($servico);

        $response->getBody()->write(json_encode(['message' => 'Serviço atualizado com sucesso']));
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function deletarServico(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        $servico = new ServicosModel();
        $servico->setId($id);

        $servicosDAO = new ServicosDAO();
        $servicosDAO->deletarServico($servico);

        $response->getBody()->write(json_encode(['message' => 'Serviço deletado com sucesso']));
        return $response->withHeader('Content-Type', 'application/json');
    }

}