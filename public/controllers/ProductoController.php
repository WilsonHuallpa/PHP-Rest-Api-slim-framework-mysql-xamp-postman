<?php
require_once './models/Producto.php';
require_once './interfaces/IApiUsable.php';

class ProductoController extends Producto implements IApiUsable
{
  
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();

        $sector = $parametros['id_sector'];
        $nombre = $parametros['nombre'];
        $precio = $parametros['precio'];
        $stock = $parametros['stock'];
        
        $prod = new Producto();
        $prod->id_sector = $sector;
        $prod->nombre = $nombre;
        $prod->precio = $precio;
        $prod->stock = $stock;
        $prod->crearProducto();

        $payload = json_encode(array("mensaje" => "Producto creado con exito"));

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    public function TraerTodos($request, $response, $args)
    {
          $lista = Producto::obtenerTodos();
          $payload = json_encode(array("listaProductos" => $lista));
  
          $response->getBody()->write($payload);
          return $response
            ->withHeader('Content-Type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $productId = $args['id'];
        $product = Producto::obtenerUno($productId);
        $product ?  $payload = json_encode($product) :  $payload = json_encode( Array("error" => "no exite el producto"));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }


    public function ModificarUno($request, $response, $args)
    {
      
        $parametros = $request->getParsedBody();
        $product = new Producto();
        $product->id= $parametros['id'];
        $product->id_sector= $parametros['sector'];
        $product->nombre= $parametros['nombre'];
        $product->precio= $parametros['precio'];
        $product->stock= $parametros['stock'];

        $product->modificar();
        $payload = json_encode(array("mensaje" => "Producto modificado con exito"));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }


    public function BorrarUno($request, $response, $args)
    {
        $productoid = $args['id'];

        $producto = Producto::obtenerUno($productoid);
        if($producto){
          Producto::darDeBaja($productoid);
          $payload = json_encode(array("mensaje" => "producto borrado con exito"));
  
        }else{
          $payload = json_encode(array("error" => "producto no exite"));
        }
    
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
          
    }

}