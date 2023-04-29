<?php 

use Slim\Factory\AppFactory;
use Slim\Middleware\BodyParsingMiddleware;
use App\Controller\ClienteController;
use Slim\Middleware\CorsMiddleware;

require "../vendor/autoload.php";


$app = AppFactory::create();

$app->add(new CorsMiddleware([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "DELETE"],
    "headers.allow" => ["Authorization", "Content-Type", "X-Requested-With"],
]));

$app->addBodyParsingMiddleware();

$app->AddErrorMiddleware(true,true,true);

$app->get('/clientes', ClienteController::class . ':getClientes');    
$app->get('/cliente/{id}', ClienteController::class . ':getCliente');                            
$app->post('/inserir', ClienteController::class . ':insertCliente');
$app->put('/update/{id}', ClienteController::class . ':updateCliente');
$app->delete('/delete/{id}', ClienteController::class . ':deleteCliente');

$app->run();