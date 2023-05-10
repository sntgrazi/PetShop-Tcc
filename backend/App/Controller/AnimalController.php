<?php

namespace App\Controller;

use App\DAO\AnimalDAO;
use App\Model\AnimalModel;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

final class AnimalController {

    public function getAnimais(Request $request, Response $response, array $args)
    {
        $animalDAO = new AnimalDAO();
        $animais = $animalDAO->getAllAnimais();

        $response->getBody()->write(json_encode($animais));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getAnimal(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
    
        $animalDAO = new AnimalDAO();
        $animalModel = new AnimalModel();
        $animalModel->setId($id);
        $animal = $animalDAO->getAnimal($animalModel);

        $response->getBody()->write(json_encode($animal));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function insertAnimal(Request $request, Response $response, array $args)
    {
        $data = $request->getParsedBody();

        $animalDAO = new AnimalDAO();
        $animalModel = new AnimalModel();
        $animalModel->setNome_pet($data['nome_pet']) 
             ->setData_nascimento($data['data_nascimento'])
             ->setSexo($data['sexo'])
             ->setAltura($data['altura'])
             ->setPeso($data['peso'])
             ->setEspecie($data['especie'])
             ->setRaca($data['raca'])
             ->setPelagem($data['pelagem'])
             ->setPorte($data['porte']);
        $animalDAO->insertAnimal($animalModel);

        
        $response->getBody()->write(json_encode(['message' => 'Animal inserido com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

    public function updateAnimal(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $data = $request->getParsedBody();

       $animalDAO = new AnimalDAO();
       $animalModel = new AnimalModel();
       $animalModel->setId($id)
                ->setNome_pet($data['nome_pet']) 
                ->setData_nascimento($data['data_nascimento'])
                ->setSexo($data['sexo'])
                ->setAltura($data['altura'])
                ->setPeso($data['peso'])
                ->setEspecie($data['especie'])
                ->setRaca($data['raca'])
                ->setPelagem($data['pelagem'])
                ->setPorte($data['porte']);
       $animalDAO->updateAnimal($animalModel);

       $response->getBody()->write(json_encode(['message' => 'Animal atualizado com sucesso']));
       return  $response->withHeader('Content-Type', 'application/json');
    }

    public function deleteAnimal(Request $request, Response $response, array $args){

        $id = $args['id'];
    

        $animalDAO = new AnimalDAO();
        $animalModel = new AnimalModel();
        $animalModel->setId($id);
        $animalDAO->deleteAnimal($animalModel);

        $response->getBody()->write(json_encode(['message' => 'Animal deletado com sucesso']));
        return  $response->withHeader('Content-Type', 'application/json');
    }

}