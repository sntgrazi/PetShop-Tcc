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

        // Validar campos obrigatórios
        $requiredFields = ['nome', 'telefone', 'cpf', 'email', 'n_casa'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                return $response->withStatus(400)->getBody()->write(json_encode(['message' => 'Campo '.$field.' é obrigatório.']));
            }
        }

        // Validar formato do nome apenas letras e espaço
        if (!preg_match('/^[a-zA-Z\s]+$/', $data['nome'])) {
            return $response->withStatus(400)->getBody()->write(json_encode(['message' => 'Nome inválido.']));
        }

        // Validar formato do telefone Ex: (75)91111-2222
        if (!preg_match('/^\(\d{2}\)\d{4,5}-\d{4}$/', $data['telefone'])) {
            return $response->withStatus(400)->getBody()->write(json_encode(['message' => 'Telefone inválido.']));
        }

        // Validar formato do CPF Ex: 111.222.333-55
        if (!preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$/', $data['cpf'])) {
            return $response->withStatus(400)->getBody()->write(json_encode(['message' => 'CPF inválido.']));
        }

        // Validar formato do email (Só funciona se tiver @)
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return $response->withStatus(400)->getBody()->write(json_encode(['message' => 'Email inválido.']));
        }

        // Validar formato do número da casa
        if (!is_numeric($data['n_casa'])) {
            return $response->withStatus(400)->getBody()->write(json_encode(['message' => 'Número da casa inválido.']));
        }


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