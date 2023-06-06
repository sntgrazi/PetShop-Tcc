<?php 

use Slim\Factory\AppFactory;
use Slim\Middleware\BodyParsingMiddleware;
use Slim\Middleware\CorsMiddleware;
use App\Controller\ClienteController;
use App\Controller\AnimalController;
use App\Controller\ClienteAnimalController;
use App\Controller\ServicosController;
use App\Controller\FuncionariosController;
use App\Controller\OrdemServicoController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

require "vendor/autoload.php";

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');

header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');


$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->AddErrorMiddleware(true,true,true);


$app->get('/animais', AnimalController::class . ':getAnimais');    
$app->get('/animal/{id}', AnimalController::class . ':getAnimal');                            
$app->post('/inserirAnimal', AnimalController::class . ':insertAnimal');
$app->put('/updateAnimal/{id}', AnimalController::class . ':updateAnimal');
$app->delete('/deleteAnimal/{id}', AnimalController::class . ':deleteAnimal');

$app->get('/clienteAnimais', ClienteAnimalController::class . ':getAllClienteAnimal');    
$app->get('/clientevinculado/{id}', ClienteAnimalController::class . ':getClienteVinculadoById');   
$app->get('/animalvinculado/{id}', ClienteAnimalController::class . ':getPetVinculadoById'); 
$app->get('/buscarClienteTabela', ClienteAnimalController::class . ':buscarClienteTabelaAuxiliar'); 
$app->post('/adicionarvinculo', ClienteAnimalController::class . ':adicionarVinculo');                         
$app->delete('/deletevinculo/{cliente_id}/{animal_id}', ClienteAnimalController::class . ':deletevinculo');


$app->get('/clientes', ClienteController::class . ':getClientes');    
$app->get('/cliente/{id}', ClienteController::class . ':getCliente');                            
$app->post('/inserirCliente', ClienteController::class . ':insertCliente');
$app->put('/updateCliente/{id}', ClienteController::class . ':updateCliente');
$app->delete('/deleteCliente/{id}', ClienteController::class . ':deleteCliente');

// ColaboradorController

$app->get('/funcionarios', FuncionariosController::class . ':getFuncionarios');    
//$app->get('/colaborador/{id}', ColaboradorController::class . ':getColaborador');                            
// $app->post('/inserirFuncionario', FuncionariosController::class . ':insertFuncionario');
//$app->put('/update/{id}', ColaboradorController::class . ':updateColaborador');
//$app->delete('/delete/{id}', ColaboradorController::class . ':deleteColaborador');

// CompraController

// FornecedorController
//$app->get('/fornecedores', FornecedorController::class . ':getFornecedores');    
//$app->get('/fornecedor/{id}', FornecedorController::class . ':getFornecedor');                            
//$app->post('/inserir', FornecedorController::class . ':insertFornecedor');
//$app->put('/update/{id}', FornecedorController::class . ':updateFornecedor');
//$app->delete('/delete/{id}', FornecedorController::class . ':deleteFornecedor');

// OrdemDeServicoController

$app->get('/ordem/{id}', OrdemServicoController::class . ':getOrdensById'); 
$app->get('/Allordens', OrdemServicoController::class . ':getAllOrdens');
$app->post('/inserirOrdem', OrdemServicoController::class . ':insertOrdem'); 

// ProdutoCompradoController

// ProdutoController
//$app->get('/produtos', ProdutoController::class . ':getProdutos');    
//$app->get('/produto/{id}', ProdutoController::class . ':getProduto');                            
//$app->post('/inserir', ProdutoController::class . ':insertProduto');
//$app->put('/update/{id}', ProdutoController::class . ':updateProduto');
//$app->delete('/delete/{id}', ProdutoController::class . ':deleteProduto');

// ProdutoVendidoController

// ServicoController
$app->get('/servicos', ServicosController::class . ':getServicos');    
//$app->get('/servico/{id}', ServicoController::class . ':getServico');                            
//$app->post('/inserir', ServicoController::class . ':insertServico');
//$app->put('/update/{id}', ServicoController::class . ':updateServico');
//$app->delete('/delete/{id}', ServicoController::class . ':deleteServico');

// VendaController


$app->run();