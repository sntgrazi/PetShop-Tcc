<?php

namespace App\Controller;

use App\DAO\ColaboradorDAO;
use App\Model\ColaboradorModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class ColaboradorController {

    public function getColaboradores(Request $request, Response $response, array $args) {

        $colaboradorDAO = new ColaboradorDAO();
        $colaboradores = $colaboradorDAO->getAllColaboradores();

        $response->getBody()->write(json_encode($colaboradores));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getColaborador(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $colaboradorDAO = new ColaboradorDAO();
        $colaboradorModel = new ColaboradorModel();
        $colaboradorModel->setId($id);
        $colaborador = $colaboradorDAO->getColaborador($colaboradorModel);

        $response->getBody()->write(json_encode($colaborador));
        return $response->withHeader('Content-Type', 'application/json');
        

    }

    public function insertColaborador(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $colaboradorDAO = new ColaboradorDAO();
        $colaborador = new ColaboradorModel();
        $colaborador->setNome($data['nome'])
                    ->setTelefone($data['telefone'])
                    ->setCpf($data['cpf'])
                    ->setEndereco($data['endereco'])
                    ->setEmail($data['email'])
                    ->setCargo($data['cargo']);
        $colaboradorDAO->insertColaborador($colaborador);

        
        $response->getBody()->write(json_encode(['message' => 'Colaborador inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function updateColaborador(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $colaboradorDAO = new ColaboradorDAO();
       $colaboradorModel = new ColaboradorModel();
       $colaboradorModel->setId($id)
                    ->setNome($data['nome'])
                    ->setTelefone($data['telefone'])
                    ->setCpf($data['cpf'])
                    ->setEndereco($data['enedereco'])
                    ->setEmail($data['email'])
                    ->setCargo($data['cargo']);
       $colaboradorDAO->updateColaborador($colaboradorModel);

       $response->getBody()->write(json_encode(['message' => 'Colaborador atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deleteColaborador(Request $request, Response $response, array $args) {

        $id = $args['id'];
    

        $colaboradorDAO = new ColaboradorDAO();
        $colaborador = new ColaboradorModel();
        $colaborador->setId($id);
        $colaboradorDAO->deleteColaborador($colaborador);

        $response->getBody()->write(json_encode(['message' => 'Colaborador deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}