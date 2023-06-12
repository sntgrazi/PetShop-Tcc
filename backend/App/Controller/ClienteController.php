<?php

namespace App\Controller;

use App\DAO\ClienteDAO;
use App\Model\ClienteModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class ClienteController {

    public function getClientes(Request $request, Response $response, array $args)
    {

        $clienteDAO = new ClienteDAO();
        $clientes = $clienteDAO->getAllClientes();

        $response->getBody()->write(json_encode($clientes));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getCliente(Request $request, Response $response, array $args)
    {

        $id = $args['id'];
    
        $clienteDAO = new ClienteDAO();
        $clienteModel = new ClienteModel();
        $clienteModel->setId($id);
        $cliente = $clienteDAO->getCliente($clienteModel);

        $response->getBody()->write(json_encode($cliente));
        return $response->withHeader('Content-Type', 'application/json');
        

    }

    public function insertCliente(Request $request, Response $response, array $args)
    {
        $data = $request->getParsedBody();

        $clienteDAO = new ClienteDAO();
        $cliente = new ClienteModel();
        $cliente->setNome($data['nome']) 
             ->setTelefone($data['telefone'])
             ->setCpf($data['cpf'])
             ->setEmail($data['email'])
             ->setCep($data['cep'])
             ->setBairro($data['bairro'])
             ->setRua($data['rua'])
             ->setCidade($data['cidade'])
             ->setUf($data['uf'])
             ->setN_casa($data['n_casa']);
        $clienteDAO->insertCliente($cliente);

        
        $response->getBody()->write(json_encode(['message' => 'Cliente inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function updateCliente(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $clienteDAO = new ClienteDAO();
       $clienteModel = new ClienteModel();
       $clienteModel->setId($id)
                    ->setNome($data['nome']) 
                    ->setTelefone($data['telefone'])
                    ->setCpf($data['cpf'])
                    ->setEmail($data['email'])
                    ->setCep($data['cep'])
                    ->setBairro($data['bairro'])
                    ->setRua($data['rua'])
                    ->setCidade($data['cidade'])
                    ->setUf($data['uf'])
                    ->setN_casa($data['n_casa']);
       $clienteDAO->updateCliente($clienteModel);

       $response->getBody()->write(json_encode(['message' => 'Cliente atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deleteCliente(Request $request, Response $response, array $args){

        $id = $args['id'];
    

        $clienteDAO = new ClienteDAO();
        $cliente = new ClienteModel();
        $cliente->setId($id);
        $clienteDAO->deleteCliente($cliente);

        $response->getBody()->write(json_encode(['message' => 'Cliente deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}