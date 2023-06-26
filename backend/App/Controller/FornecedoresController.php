<?php

namespace App\Controller;

use App\Model\FornecedoresModel;
use App\DAO\FornecedoresDAO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class FornecedoresController
{
    public function getAllFornecedores(Request $request, Response $response, array $args): Response
    {
        $fornecedoresDAO = new FornecedoresDAO();
        $fornecedores = $fornecedoresDAO->getAllFornecedores();

        $response->getBody()->write(json_encode($fornecedores));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getFornecedorById(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        $fornecedoresDAO = new FornecedoresDAO();
        $fornecedorM = new FornecedoresModel();
        $fornecedorM->setId($id);

        $fornecedor = $fornecedoresDAO->getFornecedorById($fornecedorM);

        $response->getBody()->write(json_encode($fornecedor));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function cadastrarFornecedor(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();

        $fornecedoresDAO = new FornecedoresDAO();
        $fornecedor = new FornecedoresModel();
        $fornecedor->setNomeFantasia($data['nome_fantasia'])
            ->setTelefone($data['telefone'])
            ->setEmail($data['email'])
            ->setEndereco($data['endereco'])
            ->setCnpj($data['cnpj']);

        $fornecedoresDAO->cadastrarFornecedor($fornecedor);

        $response->getBody()->write(json_encode(['message' => 'Fornecedor cadastrado com sucesso']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function atualizarFornecedor(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        var_dump($data);
        $fornecedoresDAO = new FornecedoresDAO();
        $fornecedorM = new FornecedoresModel();
        $fornecedorM->setId($id)
            ->setNomeFantasia($data['nome_fantasia'])
            ->setTelefone($data['telefone'])
            ->setEmail($data['email'])
            ->setEndereco($data['endereco'])
            ->setCnpj($data['cnpj']);

        $fornecedoresDAO->atualizarFornecedor($fornecedorM);

        $response->getBody()->write(json_encode(['message' => 'Fornecedor atualizado com sucesso']));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function deletarFornecedor(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        $fornecedoresDAO = new FornecedoresDAO();
        $fornecedor = new FornecedoresModel();
        $fornecedor->setId($id);

        $fornecedoresDAO->deletarFornecedor($fornecedor);

        $response->getBody()->write(json_encode(['message' => 'Fornecedor deletado com sucesso']));
        return $response->withHeader('Content-Type', 'application/json');
    }
}







