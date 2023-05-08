<?php

namespace App\Controller;

use App\DAO\AnimalDAO;
use App\Model\AnimalModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class animalController {

    public function getAnimais(Request $request, Response $response, array $args) {

        $animalDAO = new AnimalDAO();
        $animais = $animalDAO->getAllAnimais();

        $response->getBody()->write(json_encode($animais));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getAnimal(Request $request, Response $response, array $args) {

        $id = $args['id'];
    
        $animalDAO = new AnimalDAO();
        $animalModel = new AnimalModel();
        $animalModel->setId($id);
        $animal = $animalDAO->getAnimal($animalModel);

        $response->getBody()->write(json_encode($animal));
        return $response->withHeader('Content-Type', 'application/json');
        

    }

    public function insertAnimal(Request $request, Response $response, array $args) {
        $data = $request->getParsedBody();

        $animalDAO = new AnimalDAO();
        $animal = new AnimalModel();
        $animal->setNome($data['pet'])
               ->setRaca($data['raca'])
               ->setPelagem($data['pelagem'])
               ->getPorte($data['porte'])
               ->setSexo($data['sexo'])
               ->setPeso($data['peso'])
               ->setNascimento($data['nascimento'])
               ->setEspecie($data['especie'])
               ->setAltura($data['altura']);
        $animalDAO->insertAnimal($animal);

        
        $response->getBody()->write(json_encode(['message' => 'animal inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function updateAnimal(Request $request, Response $response, array $args) {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $animalDAO = new AnimalDAO();
       $animalModel = new AnimalModel();
       $animalModel->setId($id)
                    ->setNome($data['nome'])
                    ->setRaca($data['raca'])
                    ->setPelagem($data['pelagem'])
                    ->setPorte($data['porte'])
                    ->setSexo($data['sexo'])
                    ->setPeso($data['peso'])
                    ->setNascimento($data['nascimento'])
                    ->setEspecie($data['especie'])
                    ->setAltura($data['altura']);
       $animalDAO->updateAnimal($animalModel);

       $response->getBody()->write(json_encode(['message' => 'animal atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }
    
    public function deleteanimal(Request $request, Response $response, array $args) {

        $id = $args['id'];
    

        $animalDAO = new AnimalDAO();
        $animal = new AnimalModel();
        $animal->setId($id);
        $animalDAO->deleteAnimal($animal);

        $response->getBody()->write(json_encode(['message' => 'animal deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}