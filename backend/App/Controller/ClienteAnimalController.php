<?php

namespace App\Controller;

use App\DAO\ClienteAnimalDAO;
use App\Model\ClienteAnimalModel;
use App\Model\AnimalModel;
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

   public function deletevinculo(Request $request, Response $response, array $args){

    $clienteId = $args['cliente_id'];
    $animalId = $args['animal_id'];

     $clienteanimalDAO = new ClienteAnimalDAO();
     $clienteanimalModel = new ClienteAnimalModel();
     $clienteanimalModel->setTutor_id($clienteId)
                        ->setAnimal_id($animalId);
     $clienteanimalDAO->deleteVinculo($clienteanimalModel);

     $response->getBody()->write(json_encode(['message' => 'Vinculo deletado com sucesso']));
     return  $response->withHeader('Content-Type', 'application/json');

   }

   public function adicionarVinculo(Request $request, Response $response, array $args){
        $data = $request->getParsedBody();
        
        $tutorId = $data['cliente_id'];
        $animalId = $data['animal_id'];
        
        $clienteanimalDAO = new ClienteAnimalDAO();
        $clienteanimalModel = new ClienteAnimalModel();
        $clienteanimalModel->setTutor_id($tutorId)
                           ->setAnimal_id($animalId);
        $clienteanimalDAO->adicionarVinculo($clienteanimalModel);
   
        $response->getBody()->write(json_encode(['message' => 'Vinculo adicionado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');

   }


    

}