<?php

namespace App\Controller;

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

}