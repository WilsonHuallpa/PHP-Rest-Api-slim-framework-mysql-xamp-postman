<?php


class Encuesta{


    public $id;
    public $codigoMesa;
    public $num_pedido;
    public $punt_Mesa;
    public $punt_Restaurante; 
    public $punt_Mozo;
    public $punt_cocinero; 
    public $comentario;
    public $fecha;

    public function crearEncuesta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO encuesta (codigoMesa,num_pedido,punt_Mesa,punt_Restaurante,punt_Mozo,punt_cocinero,comentario,fecha ) VALUES (:codigoMesa, :num_pedido, :punt_Mesa, :punt_Restaurante, :punt_Mozo, :punt_cocinero, :comentario, :fecha )");
        $consulta->bindValue(':codigoMesa', $this->codigoMesa, PDO::PARAM_STR);
        $consulta->bindValue(':num_pedido', $this->num_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':punt_Mesa', $this->punt_Mesa, PDO::PARAM_INT);
        $consulta->bindValue(':punt_Restaurante', $this->punt_Restaurante, PDO::PARAM_INT);
        $consulta->bindValue(':punt_Mozo', $this->punt_Mozo, PDO::PARAM_INT);
        $consulta->bindValue(':punt_cocinero', $this->punt_cocinero, PDO::PARAM_INT);
        $consulta->bindValue(':comentario', $this->comentario, PDO::PARAM_STR);
        $consulta->bindValue(':fecha', $this->fecha, PDO::PARAM_STR);
        $consulta->execute();
        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function ObtenerMejoresComentario(){
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, codigoMesa, num_pedido,punt_Mesa,punt_Restaurante,punt_Mozo,punt_cocinero,comentario,fecha FROM encuesta WHERE punt_Mesa >=6 AND punt_Restaurante >=6 AND punt_Mozo >=6 AND punt_cocinero >=6");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Encuesta');
    }

}



?>