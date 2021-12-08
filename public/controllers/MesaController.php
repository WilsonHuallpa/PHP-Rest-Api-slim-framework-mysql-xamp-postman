<?php
require_once './models/Mesa.php';
require_once './interfaces/IApiUsable.php';
require_once './models/Encuesta.php';

class MesaController extends Mesa implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $codigo = $parametros['codigo'];
        $estado = 0;

        $aux = Mesa::obtenerMesa($codigo);

        if(is_a($aux, 'Mesa')){
          $payload = json_encode(array("mensaje" => "mesa  ya fue creado."));
        }else{
          $mesa = new Mesa();
          $mesa->codigo = $codigo;
          $mesa->id_estado = $estado;
          $mesa->crearMesa();
          $payload = json_encode(array("mensaje" => "mesa creado con exito"));
        }

  
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
      
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Mesa::obtenerTodos();
        $payload = json_encode(array("listaMesas" => $lista));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      try {
        $codigo = $args['codigo'];
        $estado = $parametros['estado'];
        $numeroPedido = $parametros['pedido'];
        $auxMesa = Mesa::obtenerMesa($codigo);
        if($auxMesa){
          switch ($estado) {
            case 'comiendo':
                $auxPedido = Pedido::TraerUnPedido($numeroPedido);
                if($auxPedido->id_estado_pedido == 3 ){
                  Mesa::CambiarEstado($codigo, 2);
                  $payload = json_encode(array("mesaje" => "Codigo de pedido: " . $codigo ." comiendo."));  
                }else{
                  $payload = json_encode(array("mesaje" => "Codigo de pedido: " . $codigo ." No esta listo para servir."));
                }
              break;
            case 'pagando':
                if($auxMesa->id_estado == 2){
                  $totalPagar = Pedido::TraerPedidoApagar($auxMesa->id);
                  $total = $totalPagar[0]["totalApagar"];
                  Mesa::CambiarEstado($codigo, 3);
                  $payload = json_encode(array("mesaje" => "Codigo : ". $codigo . " Total A pagar: " . $total));
                }else{
                  $payload = json_encode(array("mesaje" => "Codigo : ". $codigo . " Ya pagaron"));
                }
              break;
            default:
              $payload = json_encode(array("Estado" => "ERROR", "Mensaje" => "No se encontro el estadoCorresponiente"));
              break;
          }

        }else{
            throw new Exception('¡codigo de mesa no exite!');
        }
      } catch(Exception $e) {
        $payload = json_encode(array("Estado" => "ERROR", "Mensaje" => $e->getMessage()));
      }       
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
        
    }


    public function BorrarUno($request, $response, $args)
    {
      
      $codigo = $args['codigo'];
      try {

          $mesaCerranda = Mesa::obtenerMesa($codigo);
          if($mesaCerranda){
              Mesa::CambiarEstado($codigo, 4);
              $payload = json_encode(array("mesaje" => "Codigo de pedido: " . $codigo ." cerrado."));
            
          }else{
            $payload = json_encode(array("mesaje" => "Codigo no existe."));
          }
        
      
      }
      catch(Exception $e) {
        $payload = json_encode(array("Estado" => "ERROR", "Mensaje" => $e->getMessage()));
      }       
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');

    }

    public function RegistrarEncuesta($request, $response, $args) {
      $parametros = $request->getParsedBody();

      $codigoMesa = $parametros['codigoMesa'];
      $num_pedido = $parametros['num_pedido'];
      $punt_Mesa = $parametros['punt_Mesa'];
      $punt_Restaurante = $parametros['punt_Restaurante'];
      $punt_Mozo = $parametros['punt_Mozo'];
      $punt_cocinero = $parametros['punt_cocinero'];
      $comentario = $parametros['comentario'];

      try {
        if(strlen($comentario) > 66) {
            $payload = json_encode(array("mesaje" => "El comentario debe de ser mas de 66 caracteres."));
        }

        $mesaActual =  Mesa::obtenerMesa($codigoMesa);

        if($mesaActual != null) {
          
              $encuesta =  new Encuesta();
              $fecha = date('Y-m-d');

              $encuesta->codigoMesa = $codigoMesa;
              $encuesta->num_pedido = $num_pedido; 
              $encuesta->punt_Mesa = $punt_Mesa;
              $encuesta->punt_Restaurante = $punt_Restaurante;
              $encuesta->punt_Mozo = $punt_Mozo;
              $encuesta->punt_cocinero = $punt_cocinero;
              $encuesta->comentario = $comentario;
              $encuesta->fecha = $fecha;

              $encuesta->crearEncuesta();
              $payload = json_encode(array("mesaje" => "Se guardo la encuesta correctamente."));
        }else {
          $payload = json_encode(array("Error" => "Se codigo de mesa no registrada."));
        }  
      }catch(Exception $e) {
        $payload = json_encode(array("Estado" => "ERROR", "Mensaje" => $e->getMessage()));
      }
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
  }

  public function MejoresComentarios($request, $response, $args) {
   
        $lista = Encuesta::ObtenerMejoresComentario();

        $payload = json_encode(array("Mejores comentarios" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    
  }

  public function BuscarMesaMasUsada($request, $response, $args) {
   
    $lista = Mesa::ObtenerCantidadDeMesausada();

    $max;
    $codigoMasUsado;
    foreach ($lista as $key => $value) {
      if($key !== 0){
        if($max < $value['cantidad']){
          $max = $value['cantidad'];
          $codigoMasUsado = $value['codigo'];
        }
      }else{
        $max = $value['cantidad'];
        $codigoMasUsado = $value['codigo'];
      }
    }
  
    $payload = json_encode(array( "mesaje" => "Mesa mas usada: " . $codigoMasUsado . " cantidad de veces: " . $max));

    $response->getBody()->write($payload);
    return $response
      ->withHeader('Content-Type', 'application/json');
  }
}