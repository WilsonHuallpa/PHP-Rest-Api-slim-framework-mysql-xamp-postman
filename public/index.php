<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\Routing\RouteContext;

require __DIR__ . '/../vendor/autoload.php';
require_once './controllers/UsuarioController.php';
require_once './controllers/ProductoController.php';
require_once './controllers/MesaController.php';
require_once './controllers/PedidoController.php';
require_once './middlewares/Credencial.php';
require_once './db/AccesoDatos.php';
require_once './middlewares/AutentificadorJWT.php';
require_once './middlewares/MWComanda.php';
require_once './models/Archivos.php';
require_once './models/operacion.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$app = AppFactory::create();
//$app->setBasePath('/public');
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

$app->post('/login',\UsuarioController::class . ':LoginEmpleado');

$app->group('/users', function (RouteCollectorProxy $group) {
    $group->get('/', \UsuarioController::class . ':TraerTodos')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
    $group->get('/reportescsv', \UsuarioController::class . ':Mostrarcsv');
    $group->get('/{id}', \UsuarioController::class . ':TraerUno')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
    $group->post('/', \UsuarioController::class . ':CargarUno')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
    $group->post('/addCsv', \UsuarioController::class . ':AltaPorCsv')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
    $group->delete('/{id}', \UsuarioController::class . ':BorrarUno')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
    $group->patch('/{id}', \UsuarioController::class . ':ModificarUno')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
});
$app->group('/products', function (RouteCollectorProxy $group) {
    $group->get('/', \ProductoController::class . ':TraerTodos')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
    $group->get('/{id}', \ProductoController::class . ':TraerUno')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
    $group->post('/', \ProductoController::class . ':CargarUno')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
    $group->put('/', \ProductoController::class . ':ModificarUno')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
    $group->delete('/{id}', \ProductoController::class . ':BorrarUno')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
});

$app->group('/mesas', function (RouteCollectorProxy $group) {
  $group->get('/', \MesaController::class . ':TraerTodos')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
  $group->get('/masUsado', \MesaController::class . ':BuscarMesaMasUsada')->add(\MWComanda::class . ':SumarOperacion')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
  $group->get('/comentarios/mejores', \MesaController::class . ':MejoresComentarios')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
  $group->post('/', \MesaController::class . ':CargarUno')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
  $group->post('/encuesta', \MesaController::class . ':RegistrarEncuesta'); 
  $group->delete('/cerrar/{codigo}', \MesaController::class . ':BorrarUno')->add(\MWComanda::class . ':SumarOperacion')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
  $group->patch('/{codigo}', \MesaController::class . ':ModificarUno')->add(\MWComanda::class . ':SumarOperacion')->add(\MWComanda::class . ':ValidarMozo')->add(\MWComanda::class . ':ValidarToken');

});

$app->group('/pedidos', function (RouteCollectorProxy $group) {
  $group->get('/', \PedidoController::class . ':TraerTodos')->add(\MWComanda::class . ':SumarOperacion')->add(\MWComanda::class . ':ValidarSocio')->add(\MWComanda::class . ':ValidarToken');
  $group->get('/pendientes', \PedidoController::class . ':TraerPedidoPendiente')->add(\MWComanda::class . ':ValidarToken');
  $group->post('/', \PedidoController::class . ':CargarUno')->add(\MWComanda::class . ':SumarOperacion')->add(\MWComanda::class . ':ValidarMozo')->add(\MWComanda::class . ':ValidarToken');
  $group->patch('/tomarPedido/{codigo}', \PedidoController::class . ':cambiarEstados')->add(\MWComanda::class . ':SumarOperacion')->add(\MWComanda::class . ':ValidarToken');
  $group->post('/VerMiPedido', \PedidoController::class . ':TraerUno');
  $group->get('/pdf', \PedidoController::class . ':DescargarPDFMayorImpor');

});

$app->run();

