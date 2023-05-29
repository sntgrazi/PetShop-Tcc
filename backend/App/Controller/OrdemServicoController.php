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
    
}