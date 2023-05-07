<?php

namespace App\Controller;

use App\DAO\FornecedorDAO;
use App\Model\FornecedorModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class FornecedorController {

    public function getFornecedores(Request $request, Response $response, array $args) {

        $fornecedorDAO = new FornecedorDAO();
        $fornecedores = $fornecedorDAO->getAllFornecedores();

        $response->getBody()->write(json_encode($fornecedores));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getFornecedor(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $fornecedorDAO = new FornecedorDAO();
        $fornecedorModel = new FornecedorModel();
        $fornecedorModel->setId($id);
        $fornecedor = $fornecedorDAO->getFornecedor($fornecedorModel);

        $response->getBody()->write(json_encode($fornecedor));
        return $response->withHeader('Content-Type', 'application/json');
        

    }

    public function insertFornecedor(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $fornecedorDAO = new FornecedorDAO();
        $fornecedor = new FornecedorModel();
        $fornecedor->setNomeFantasia($data['nome_fantaia'])
                    ->setTelefone($data['telefone'])
                    ->setEndereco($data['endereco'])
                    ->setEmail($data['email'])
                    ->setCnpj($data['cnpj']);
        $fornecedorDAO->insertFornecedor($fornecedor);

        
        $response->getBody()->write(json_encode(['message' => 'Fornecedor inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function updateFornecedor(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $fornecedorDAO = new FornecedorDAO();
       $fornecedorModel = new FornecedorModel();
       $fornecedorModel->setId($id)
                        ->setNomeFantasia($data['nome_fantasia'])
                        ->setTelefone($data['telefone'])
                        ->setEndereco($data['enedereco'])
                        ->setEmail($data['email'])
                        ->setCnpj($data['cnpj']);
       $fornecedorDAO->updateFornecedor($fornecedorModel);

       $response->getBody()->write(json_encode(['message' => 'Fornecedor atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deleteFornecedor(Request $request, Response $response, array $args) {

        $id = $args['id'];
    

        $fornecedorDAO = new FornecedorDAO();
        $fornecedor = new FornecedorModel();
        $fornecedor->setId($id);
        $fornecedorDAO->deleteFornecedor($fornecedor);

        $response->getBody()->write(json_encode(['message' => 'Fornecedor deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}