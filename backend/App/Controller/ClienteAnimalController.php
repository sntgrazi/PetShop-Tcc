<?php

namespace App\Controller;

use App\DAO\ClienteAnimalDAO;
use App\Model\AnimalModel;
use App\Model\ClienteAnimalModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class ClienteAnimalController {

    public function getAllClienteAnimal(Request $request, Response $response, array $args) {

        $tabelaDAO = new ClienteAnimalDAO();
        $tabela = $tabelaDAO->getAllClienteAnimal();

        $response->getBody()->write(json_encode($tabela));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getClienteVinculadoById(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $tabelaDAO = new ClienteAnimalDAO();
        $animalM = new AnimalModel();
        $animalM->setId($id);
        $tabela = $tabelaDAO->getClienteVinculadoById($animalM);

        $response->getBody()->write(json_encode($tabela));
        return $response->withHeader('Content-Type', 'application/json');
        
    }

    public function insertClienteAnimal(Request $request, Response $response, array $args) {
        
        $data = $request->getParsedBody();

        var_dump($data);

        $tabelaDAO = new ClienteAnimalDAO();
        $tabelaM = new ClienteAnimalModel();
        $tabelaM->setCliente_id($data['cliente_id'])
                ->setAnimal_id($data['animal_id']);
        $tabelaDAO->insertClienteAnimal($tabelaM);
        
        $response->getBody()->write(json_encode(['message' => 'Cliente e Animal vinculado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    

}