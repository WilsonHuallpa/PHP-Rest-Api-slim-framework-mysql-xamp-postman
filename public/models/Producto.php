<?php

class Producto
{
    public $id;
    public $id_sector;
    public $nombre;
    public $precio;
    public $stock;

    public function crearProducto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO productos (id_sector, nombre, precio, stock ) VALUES (:id_sector, :nombre, :precio, :stock)");
        $consulta->bindValue(':id_sector', $this->id_sector, PDO::PARAM_INT);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerTodos()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, id_sector, nombre, precio, stock FROM productos");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Producto');
    }

    public static function obtenerUno($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT id, id_sector, nombre, precio, stock  FROM productos WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchObject('Producto');
    }
    public function modificar(){

        $objAccesoDatos = AccesoDatos::obtenerInstancia(); 
        $consulta =$objAccesoDatos->prepararConsulta("
            update productos 
            set id_sector=:id_sector,
            nombre=:nombre,
            precio=:precio,
            stock=:stock
            WHERE id=:id");
        $consulta->bindValue(':id_sector',$this->id_sector, PDO::PARAM_INT);
        $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
        $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
        return $consulta->execute();
    }

    public static function darDeBaja($id){
    
        $objAccesoDatos = AccesoDatos::obtenerInstancia(); 
        $consulta =$objAccesoDatos->prepararConsulta("UPDATE productos SET fechaBaja = :fechaBaja WHERE id = :id");
        $fecha = new DateTime(date("d-m-Y"));
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->bindValue(':fechaBaja', date_format($fecha, 'Y-m-d H:i:s'));
        $consulta->execute();
    }
}