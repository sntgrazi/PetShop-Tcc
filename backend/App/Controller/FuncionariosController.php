<?php

namespace App\Controller;

use App\DAO\FuncionariosDAO;
use App\Model\FuncionarioModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class FuncionariosController{

    public function getAllFuncionarios(Request $request, Response $response, array $args){
        $funcionariosDAO = new FuncionariosDAO();
        $funcionarios = $funcionariosDAO->getAllFuncionarios();

        $response->getBody()->write(json_encode($funcionarios));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getAllCargos(Request $request, Response $response, array $args){
        $funcionariosDAO = new FuncionariosDAO();
        $cargos = $funcionariosDAO->getAllCargos();

        $response->getBody()->write(json_encode($cargos));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getFuncionarioById(Request $request, Response $response, array $args){
        $id = $args['id'];
    
        $funcionariosDAO = new FuncionariosDAO();
        $funcionarioModel = new FuncionarioModel();
        $funcionarioModel->setId($id);
        $funcionario = $funcionariosDAO->getFuncionarioById($funcionarioModel);

        $response->getBody()->write(json_encode($funcionario));
        return $response->withHeader('Content-Type', 'application/json');
    }


    public function CadastroFuncionario(Request $request, Response $response, array $args){

        $data = $request->getParsedBody();

        $funcionariosDAO = new FuncionariosDAO();
        $funcionariosM = new FuncionarioModel();
        $funcionariosM ->setNome($data['nome'])
                       ->setTelefone($data['telefone'])
                       ->setCpf($data['cpf'])
                       ->setEndereco($data['endereco'])
                       ->setCargo($data['cargo_id']);
        $funcionariosDAO->cadastrarFuncionario($funcionariosM);

        $response->getBody()->write(json_encode(['message' => 'Funcionário inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');

    }

    public function EditarFuncionario(Request $request, Response $response, array $args){

        $id = $args['id'];
        $data = $request->getParsedBody();

        $funcionariosDAO = new FuncionariosDAO();
        $funcionariosM = new FuncionarioModel();
        $funcionariosM -> setId($id)
        -> setNome($data['nome'])
        -> setTelefone($data['telefone'])
        -> setCpf($data['cpf'])
        -> setEndereco($data['endereco'])
        -> setCargo($data['cargo_id']);
        $funcionariosDAO->editarFuncionario($funcionariosM);

        $response->getBody()->write(json_encode(['message' => 'Funcionário atualizado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');

    }

    public function deleteFuncionario(Request $request, Response $response, array $args){

        $id = $args['id'];
    

        $funcionariosDAO = new FuncionariosDAO();
        $funcionariosM = new FuncionarioModel();
        $funcionariosM->setId($id);
        $funcionariosDAO->deleteFuncionario($funcionariosM);

        $response->getBody()->write(json_encode(['message' => 'Funcionário deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}
