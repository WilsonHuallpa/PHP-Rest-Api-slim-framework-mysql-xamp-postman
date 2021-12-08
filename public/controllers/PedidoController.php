<?php

require_once './models/Pedido.php';
require_once './models/Pdf.php';

require_once './interfaces/IApiUsable.php';

class PedidoController extends Pedido implements IApiUsable {

    public function CargarUno($request, $response, $args) {

   
      try {

        $parametros = $request->getParsedBody();
        $id_mesa  = $parametros['id_mesa'];
        $id_producto = $parametros['id_producto'];
        $cantidad = $parametros['cantidad'];
        $cliente = $parametros['cliente'];
        $codigo = $parametros['codigo'];
        $id_estado_pedido = 1;
        $fecha = date("Y/m/d");
        $dir_subida = 'FotosPedidos/';

        $pedido = new Pedido();
        $pedido->id_mesa = $id_mesa;
        $pedido->id_producto = $id_producto;
        $pedido->cantidad = $cantidad;
        $pedido->cliente = $cliente;
        $pedido->codigo = $codigo;
        $pedido->id_estado_pedido = $id_estado_pedido;
        $pedido->id_empleado = 0;
        $pedido->fecha = $fecha;


        if($_FILES){
          Archivo::VerificarTipoImagen($_FILES["foto"]);
          $nombreImagen =  Archivo::SubirAchivo($dir_subida,$_FILES["foto"],$codigo,$cliente);
          $pedido->nombre_foto = $nombreImagen;
        
        }else{
          throw new Exception('¡Debe de colocar una foto!');
        }

        $pedido->crearPedido();
        $payload = json_encode(array("mensaje" => "El pedido se registró correctamente", "Código de pedido" => $codigo));
  
      }catch(Exception $e) {
          $payload = json_encode(array("Estado" => "ERROR", "Mensaje" => $e->getMessage()));
      }
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();

      $codigoMesa = $parametros['codigo'];
      $numeroPedido = $parametros['numero'];
  
      $lista = Pedido::ObtenerTiempoDePedido($numeroPedido,$codigoMesa);


        $payload = json_encode(array("mensaje" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Pedido::obtenerTodos();
        $payload = json_encode(array("listasPedidos" => $lista));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }

    public function TraerPedidoPendiente($request, $response, $args){

      $header = $request->getHeaderLine('Authorization');
      $token = trim(explode("Bearer", $header)[1]);

      $payload =  AutentificadorJWT::ObtenerData($token);

      $sector = $payload->perfil;
      
      switch ($payload->perfil) {
        case '3':
          $lista = Pedido::ListaDePendiente(3);
          $payload = json_encode(array("Cocina" => $lista));
          break;

        case '4':
          $lista = Pedido::ListaDePendiente(4);
          $payload = json_encode(array("Barra de Tragos y Vinos" => $lista));
          break;
        case '5';
          $lista = Pedido::ListaDePendiente(5);
          $payload = json_encode(array("Barra de Cervezas" => $lista));
          break;
        case '5';
          $lista = Pedido::ListaDePendiente(6);
          $payload = json_encode(array("Candy Bar" => $lista));
          break;
        default:
          $payload = json_encode(array("Mesaje" => "Solo pueden ingresar los empleados de cocina, Barra de tragos o Cerveza o Candy Bar."));
          break;
      }

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');

    }


    public function tomarPedido($request, $response, $args){

      $header = $request->getHeaderLine('Authorization');
      $token = trim(explode("Bearer", $header)[1]);
      try{  
        $parametros = $request->getParsedBody();
        $payload =  AutentificadorJWT::ObtenerData($token);

        $codigo  = $parametros['codigo'];
        $tiempo = $parametros['tiempo'];
        $id_empleado = $payload->id;
        $sector =$payload->perfil;

        $TomarPedido = Pedido::TraerUnPedido($codigo);
        $auxProd = Producto::obtenerUno($TomarPedido->id_producto);
        if($TomarPedido){
          if($auxProd->id_sector == $sector){
            if($TomarPedido->id_estado_pedido == 1){
              $TomarPedido->id_estado_pedido = 2;
              $TomarPedido->tiempo = $tiempo;
              $TomarPedido->id_empleado = $id_empleado;
              $TomarPedido->modificarPedido();
              $payload = json_encode(array("mesaje" => "Codigo de pedido: " . $codigo ."  En preparacion"));
            }else{
              $payload = json_encode(array("mesaje" => "Pedido en preparacion"));
            }
          }else{
            $payload = json_encode(array("mesaje" => "Empleado no puede tomar este pedido"));
          }
        }else{
          $payload = json_encode(array("mesaje" => "No existe el codigo, por favor ingrese el codigo correcto."));

        }
        
      }catch(Exception $e) {
        $payload = json_encode(array("Estado" => "ERROR", "Mensaje" => $e->getMessage()));
      }
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');

    }

  public function cambiarEstados($request, $response, $args){
    $header = $request->getHeaderLine('Authorization');
    $token = trim(explode("Bearer", $header)[1]);
    try{  
      $parametros = $request->getParsedBody();
      $payload =  AutentificadorJWT::ObtenerData($token);
      $codigo = $args['codigo'];
      $estado = $parametros['estado'];
      $tiempo = $parametros['tiempo'];
      $id_empleado = $payload->id;
      $sector =$payload->perfil;

      $auxPedido = Pedido::TraerUnPedido($codigo);
      if($auxPedido){
        $auxProd = Producto::obtenerUno($auxPedido->id_producto);
        if($auxProd->id_sector == $sector){
          switch ($estado) {
            case 'preparacion':
              if($auxPedido->id_estado_pedido == 1){

                $auxPedido->id_estado_pedido = 2;
                $auxPedido->tiempo = $tiempo;
                $auxPedido->id_empleado = $id_empleado;
                $auxPedido->modificarPedido();
                $payload = json_encode(array("mesaje" => "Codigo de pedido: " . $codigo ."  En preparacion"));
              }else{
                $payload = json_encode(array("mesaje" => "Pedido enpreparacion"));
              }
                                
              break;
            case 'servir':
              if($auxPedido->id_estado_pedido == 2 || $auxPedido->id_estado_pedido == 3 ){
                $auxPedido->id_estado_pedido = 3;
                $auxPedido->modificarPedido();
                $payload = json_encode(array("mesaje" => "Codigo de pedido: " . $auxPedido->codigo . " Listo para servir."));
              }else{  
                $payload = json_encode(array("mesaje" => "Codigo de pedido: " . $auxPedido->codigo . " no se se encuetra listo."));
              }
              break;
            default:
            $payload = json_encode(array("mesaje" => "Estado no encontrado."));

              break;
          }
        }else{
          $payload = json_encode(array("mesaje" => "Empleado no puede tomar este pedido"));
        }
      }else{
        $payload = json_encode(array("mesaje" => "No existe el pedido."));

      }
      
    }catch(Exception $e) {
      $payload = json_encode(array("Estado" => "ERROR", "Mensaje" => $e->getMessage()));
    }
  $response->getBody()->write($payload);
  return $response->withHeader('Content-Type', 'application/json');
  }
  

    public function ModificarUno($request, $response, $args)
    {
    }


    public function BorrarUno($request, $response, $args)
    {

    }
    
    public function DescargarPDFMayorImpor($request, $response, $args){

      $lista = Pedido::obtenerTodosParaPDF();
      $pdf = new PDF();
      $pdf->AliasNbPages();
      $pdf->AddPage();
      $pdf->SetFont('Times','',16);

      foreach ($lista as $key => $row) {
        $pdf->cell(30,10,$row['fecha'],1,0,'C',0);
        $pdf->cell(40,10,$row['producto'],1,0,'C',0);
        $pdf->cell(30,10,$row['cantidad'],1,1,'C',0);
      }
  
      $content = $pdf->Output('Archivos/pedidos.pdf', 'S');
      
      $stream = fopen('php://memory','w+');
      fwrite($stream, $content);
      rewind($stream);
      $response->getBody()->write(fread($stream,(int)fstat($stream)['size']));
      return $response->withHeader('Content-Type', 'application/pdf')->withHeader('Content-Disposition','attachment; filename="filename.pdf"');
    }


}