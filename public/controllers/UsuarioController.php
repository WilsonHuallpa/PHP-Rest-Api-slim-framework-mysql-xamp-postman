<?php
require_once './models/Usuario.php';
require_once './interfaces/IApiUsable.php';


class UsuarioController extends Usuario implements IApiUsable
{
    public function CargarUno($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $nombre = $parametros['nombre'];
        $mail = $parametros['mail'];
        $clave = $parametros['clave'];
        $tipoEmpleado =  strtolower($parametros['tipo_empleado']);
        $id_tipoEmpleado;

        switch($tipoEmpleado) {
            case 'socio':
                $id_tipoEmpleado = 1;
                break;
            case 'mozo':
                $id_tipoEmpleado = 2;
                break;
            case 'cocinero':
                $id_tipoEmpleado = 3;
                break;
            case 'bartender':
                $id_tipoEmpleado = 4;
                break;
            case 'cervecero':
                $id_tipoEmpleado = 5;
                break;
            case 'pastelero':
                $id_tipoEmpleado = 6;
                break;
        }
         $aux = Usuario::obtenerUsuario($nombre);

         if($aux){
            $payload = json_encode(array("mensaje" => "Usuario ya existe"));
         }else{
            $usr = new Usuario();
            $usr->nombre = $nombre;
            $usr->mail = $mail;
            $usr->clave = $clave;
            $usr->id_tipo_empleado = $id_tipoEmpleado;
            $usr->estado = "activo";
            $usr->crearUsuario();
            $headers = $response->getHeaders();
            foreach ($headers as $name => $values) {
                echo $name . ": " . implode(", ", $values);
            }
            $payload = json_encode(array("mensaje" => "ok"));
         }
        $response->getBody()->write($payload);

        return $response->withStatus(201)->withHeader('Content-type', 'application/json');
    }

    public function TraerUno($request, $response, $args)
    {
        $usr = $args['usuario'];
        $usuario = Usuario::obtenerUsuario($usr);
        $payload = json_encode($usuario);
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
          
    }

    public function TraerTodos($request, $response, $args)
    {
        $lista = Usuario::obtenerTodos();

        $payload = json_encode(array("ListadoEmpleado" => $lista ));

        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }
    
    public function ModificarUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody();
      $usuarioid = $args['id'];
      $estado = $parametros['estado'];
    
      $auxUsser=Usuario::obtenerUsuarioid($usuarioid);
      if($auxUsser){
        $auxUsser->ModificarEstado($estado);
        $payload = json_encode(array("mensaje" => "200"));
      }else{
        $payload = json_encode(array("mensaje" => "404"));
      }
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }


    public function BorrarUno($request, $response, $args)
    {

        $usuarioid = $args['id'];
    
        $auxUsser=Usuario::obtenerUsuarioid($usuarioid);
        if($auxUsser){

          $estado = $auxUsser->estado;

          if($estado != "baja"){
            $auxUsser->estado = "baja";
            $auxUsser->ModificarEstado();
            $payload = json_encode(array("mensaje" => "Usuario borrado con exito"));
          }else{
            $payload = json_encode(array("mensaje" => "Usuario ya se encuentra aliminado."));
          }

        }else{
          $payload = json_encode(array("mensaje" => "EL USUARIO No se encuentra en el sistema."));
        }
        $response->getBody()->write($payload);
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function LoginEmpleado($request, $response, $args) {

      try{
        $parametros = $request->getParsedBody();
        $usuario = $parametros['nombre'];
        $clave = $parametros['clave'];
  
        $usser =  Usuario::VerificarDatos($usuario, $clave);

        $usuario = $usser->nombre;
        $perfil = $usser->id_tipo_empleado;
        $id = $usser->id;
        $datos = array('id'=> $id ,'usuario' => $usuario, 'perfil' => $perfil);
  
        $token = AutentificadorJWT::CrearToken($datos);
        $payload = json_encode(array('jwt' => $token));

      }catch (Exception $e) {
          $payload = json_encode(array('error' => $e->getMessage()));
      }
   
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }

    public function AltaPorCsv($request, $response, $args){

      if ( isset($_FILES["archivo"])) {

        if ($_FILES["archivo"]["error"] > 0) {
          echo "Return Code: " . $_FILES["archivo"]["error"] . "<br />";
      
        }
        $tmpName = $_FILES['archivo']['tmp_name'];
        $csv = array_map('str_getcsv', file($tmpName));
        array_walk($csv, function(&$a) use ($csv) {
          $a = array_combine($csv[0], $a);
        });
        array_shift($csv);
       foreach ($csv as $key => $value) {

        $usr = new Usuario();
        $usr->nombre = $value['nombre'];
        $usr->mail = $value['mail'];
        $usr->clave = $value['clave'];
        $usr->id_tipo_empleado = $value['id_tipo_empleado'];
        $usr->estado = "a";
        $usr->crearUsuario();
      }
      $payload = json_encode(array("mensaje" => "Usuario creado con exito"));
      $response->getBody()->write($payload);
      return $response
      ->withHeader('Content-Type', 'application/json');
    }
  }
  public function Mostrarcsv($request, $response, $args){

    $lista = Usuario::obtenerTodoscsv();

    $out = fopen('php://temp', 'w');
    fputcsv($out, array_keys(reset($lista)));
    foreach ($lista as $fields) {
        fputcsv($out, $fields);
    }
    rewind($out);
    $csvData = stream_get_contents($out);
    fclose($out);
    
    $response->getBody()->rewind();
    $response->getBody()->write($csvData);
    return $response->withHeader('Content-Type', 'application/force-download')->withHeader('Content-Disposition','attachment; filename="filename.csv"');
   
  }
  

}