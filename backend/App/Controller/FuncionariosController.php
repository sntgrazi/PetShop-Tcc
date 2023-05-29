<?php

namespace App\Controller;

use App\DAO\FuncionariosDAO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class FuncionariosController{

    public function getFuncionarios(Request $request, Response $response, array $args){
        $funcionariosDAO = new FuncionariosDAO();
        $funcionarios = $funcionariosDAO->getAllFuncionarios();

        $response->getBody()->write(json_encode($funcionarios));
        return $response->withHeader('Content-Type', 'application/json');
    }

}
