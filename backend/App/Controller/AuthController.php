<?php

namespace App\Controller;
use App\DAO\UserDAO;
use App\Model\UserModel;
use Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;


final class AuthController{

    public function login(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
    
        $userDAO = new UserDAO();
        $userModel = new UserModel();
        $userModel->setEmail($data['email'])
                  ->setSenha($data['senha']);
    
        $user = $userDAO->getUserByEmail($userModel);
        if (!$user) {
            $response = $response->withStatus(401);
            $response->getBody()->write(json_encode(['error' => 'Invalid credentials']));
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        // Define a senha recuperada no objeto $userModel
        $userModel->setSenha($user['senha']);
    
    
        if (password_verify($userModel->getSenha(), $user['senha'])) {
            $response = $response->withStatus(401);
            $response->getBody()->write(json_encode(['error' => 'Senha inválida']));
            return $response->withHeader('Content-Type', 'application/json');
        }
    
        $tokenPayLoad = [
            'email' => $user['email']
        ];
    
        $secretKey = 'e#CQ9j1e@k3p$S0cT5uH*oG8g!zL';
        $algorithm = 'HS256';
    
        $token = \Firebase\JWT\JWT::encode($tokenPayLoad, $secretKey, $algorithm);
    
        $response = $response->withStatus(200);
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode(['token' => $token]));
    
        return $response;
    }
    

    public function verificaSenha(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        
        $userDAO = new UserDAO();
        $userModel = new UserModel();
        $userModel->setEmail($data['email']);
        $senhadigitada = $data['senha'];
    
        $senhaArmazenada = $userDAO->getSenhaAcesso($userModel);

        if ($senhadigitada == $senhaArmazenada['senhaAcesso']) {
            $senhaCorreta = true;
            $response = $response->withStatus(200)
                ->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(['senhaCorreta' => $senhaCorreta]));
        } else {
            $senhaCorreta = false;
            $response = $response->withStatus(401)
                ->withHeader('Content-Type', 'application/json');
            $response->getBody()->write(json_encode(['senhaCorreta' => $senhaCorreta]));
        }
    
        return $response;
    }

    public function inserirUser(Request $request, Response $response, $args)
{
    $data = $request->getParsedBody();
    $userDAO = new UserDAO();
    $userModel = new UserModel();
    $userModel->setEmail($data['email'])
        ->setSenha(password_hash($data['senha'], PASSWORD_DEFAULT));

    $userDAO->inserirUser($userModel);

    $response->getBody()->write(json_encode(['message' => 'Usuário cadastrado com sucesso']));
    return  $response->withHeader('Content-Type', 'application/json');
}

}