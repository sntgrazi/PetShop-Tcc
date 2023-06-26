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
use App\Controller\AuthController;
use App\Controller\ProdutoController;
use App\Controller\FornecedoresController;
 use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\RequestInterface as Request;

require "vendor/autoload.php";

header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');

header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');


$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$app->AddErrorMiddleware(true,true,true);

$app->post('/', AuthController::class . ':login');
$app->post('/senhaAcesso', AuthController::class . ':verificaSenha');

$app->get('/animais', AnimalController::class . ':getAnimais');    
$app->get('/animal/{id}', AnimalController::class . ':getAnimal');                            
$app->post('/inserirAnimal', AnimalController::class . ':insertAnimal');
$app->put('/updateAnimal/{id}', AnimalController::class . ':updateAnimal');
$app->delete('/deleteAnimal/{id}', AnimalController::class . ':deleteAnimal');
$app->get('/buscarRaca/{especie}', AnimalController::class . ':buscarRaca');
$app->get('/buscarPortes', AnimalController::class . ':buscarPorte');
$app->get('/buscarPelagens', AnimalController::class . ':buscarPelagem');


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

$app->get('/cargos', FuncionariosController::class . ':getAllCargos');   

$app->get('/funcionarios', FuncionariosController::class . ':getAllFuncionarios'); 
$app->get('/funcionario/{id}', FuncionariosController::class . ':getFuncionarioById'); 
$app->post('/inserirFuncionario', FuncionariosController::class . ':CadastroFuncionario');
$app->put('/updateFuncionario/{id}', FuncionariosController::class . ':editarFuncionario');   
$app->delete('/deleteFuncionario/{id}', FuncionariosController::class . ':deleteFuncionario');      


// CompraController

// FornecedorController
$app->get('/fornecedores', FornecedoresController::class . ':getAllFornecedores');
$app->get('/fornecedor/{id}', FornecedoresController::class . ':getFornecedorById');
$app->post('/cadastrarFornecedores', FornecedoresController::class . ':cadastrarFornecedor');
$app->put('/atualizarFornecedor/{id}', FornecedoresController::class . ':atualizarFornecedor');
$app->delete('/deletarFornecedor/{id}', FornecedoresController::class . ':deletarFornecedor');


// OrdemDeServicoController

$app->get('/ordem/{id}', OrdemServicoController::class . ':getOrdensById'); 
$app->get('/Allordens', OrdemServicoController::class . ':getAllOrdens');
$app->post('/inserirOrdem', OrdemServicoController::class . ':insertOrdem');
$app->put('/atualizarStatus/{id}', OrdemServicoController::class . ':updateStatus');
$app->put('/updateOrdem/{id}', OrdemServicoController::class . ':updateOrdem');
$app->delete('/deleteOrdem/{id}', OrdemServicoController::class . ':deleteOrdem');


// ProdutoCompradoController

// ProdutoController
$app->get('/Allprodutos', ProdutoController::class . ':getAllProdutos');
$app->post('/cadastrarProduto', ProdutoController::class . ':cadastrarProduto');
$app->get('/produto/{id}', ProdutoController::class . ':getProdutoWithFornecedorById');
$app->put('/atualizarProduto/{id}', ProdutoController::class . ':atualizarProduto');
$app->delete('/deletarProduto/{id}', ProdutoController::class . ':deletarProduto');


// ProdutoVendidoController

// ServicoController
$app->get('/servicos', ServicosController::class . ':getServicos');
$app->get('/servicoById/{id}', ServicosController::class . ':getServicoById');
$app->post('/cadastrarServico', ServicosController::class . ':cadastrarServico');
$app->put('/atualizarServico/{id}', ServicosController::class . ':atualizarServico');
$app->delete('/deletarServico/{id}', ServicosController::class . ':deletarServico');


// VendaController


$app->run();