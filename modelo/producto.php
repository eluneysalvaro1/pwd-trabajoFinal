<?php

class producto{
    private $idProducto;
    private $proNombre; 
    private $proDetalle;
    private $proCantStock;
    private $precio; 
    private $mensajeOperacion; 

    public function __construct(){
        $this->idProducto = 0;
        $this->proNombre = '';
        $this->proDetalle = '';
        $this->proCantStock = '';
        $this->precio = ''; 
        $this->mensajeOperacion = '';
    }

    public function setear($datos){
        $this->setIdProducto($datos['idProducto']);
        $this->setProNombre($datos['proNombre']);
        $this->setProDetalle($datos['proDetalle']);
        $this->setProCantStock($datos['proCantStock']);
        $this->setPrecio($datos['precio']);
    }

    public function getIdProducto(){
        return $this->idProducto;
    }
    public function setIdProducto($idProducto){
        $this->idProducto = $idProducto;
    }
    public function getProNombre(){
        return $this->proNombre;
    }
    public function setProNombre($proNombre){
        $this->proNombre = $proNombre;
    }
    public function getProDetalle(){
        return $this->proDetalle;
    }
    public function setProDetalle($proDetalle){
        $this->proDetalle = $proDetalle;
    }
    public function getProCantStock(){
        return $this->proCantStock;
    }
    public function setProCantStock($proCantStock){
        $this->proCantStock = $proCantStock;
    }
    public function getPrecio(){
        return $this->precio;
    }
    public function setPrecio($precio){
        $this->precio = $precio;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }



    public function cargar(){
    $resp = false;
    $base = new BaseDatos();
    $idProducto = $this->getIdProducto();
    $sql="SELECT * FROM producto WHERE idproducto = '$idProducto'";
    if ($base->Iniciar()) {
        $res = $base->Ejecutar($sql);
        if($res>-1){
            if($res>0){
                $row = $base->Registro();
                $datos = [
                    $row['idProducto'],
                    $row['proNombre'],
                    $row['proDetalle'],
                    $row['proCantStock'],
                    $row['precio']
                ]; 
                $this->setear($datos);
            }
        }
    } else {
        $this->setMensajeoperacion("Rol->cargar: ".$base->getError());
    }
    return $resp;
}

    public function listar($parametro = ""){
    $arreglo = array();
    $base = new BaseDatos();
    $sql = "SELECT * FROM producto ";
    if ($parametro != "") {
        $sql .= 'WHERE ' . $parametro;
    }
    $res = $base->Ejecutar($sql);
    if ($res > -1) {
        if ($res > 0) {

            while ($row = $base->Registro()) {
                $obj = new producto();
                $datos = [
                    $row['idProducto'],
                    $row['proNombre'],
                    $row['proDetalle'],
                    $row['proCantStock'],
                    $row['precio']
                ]; 
                $obj->setear($datos);
                array_push($arreglo, $obj);
            }
        }
    } else {
        $this->setMensajeoperacion("producto->Listar: ".$base->getError());
    }

    return $arreglo;
}

public function insertar(){
    $resp = false;
    $base = new BaseDatos();

    $proNombre = $this->getProNombre();
    $proDetalle = $this->getProDetalle();
    $proCantStock = $this->getProCantStock();
    $precio = $this->getPrecio();
    $sql = "INSERT INTO producto(pronombre, prodetalle, procantstock, precio) 
            VALUES('$proNombre' , '$proDetalle' , '$proCantStock' , '$precio')";
    if ($base->Iniciar()) {
        if ($idProducto = $base->Ejecutar($sql)) {
            $this->setIdProducto($idProducto);
            $resp = true;
        } else {
            $this->setmensajeoperacion("producto->insertar: " . $base->getError());
            $resp = false;
        }
    } else {
        $this->setmensajeoperacion("producto->insertar: " . $base->getError());
        $resp = false;
    }
    return $resp;
}

public function modificar(){
    $resp = false;
    $base = new BaseDatos();
    $idProducto = $this->getIdProducto();

    $proNombre = $this->getProNombre();
    $proDetalle = $this->getProDetalle();
    $proCantStock = $this->getProCantStock();
    $precio = $this->getPrecio(); 

    $sql = "UPDATE producto SET  ='$proNombre' , '$proDetalle' , '$proCantStock' , '$precio' WHERE idproducto='$idProducto'";
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            $resp = true;
        } else {
            $this->setmensajeoperacion("Producto->modificar: " . $base->getError());
        }
    } else {
        $this->setmensajeoperacion("Producto->modificar: " . $base->getError());
    }
    return $resp;
}

public function eliminar()
{
    $resp = false;
    $base = new BaseDatos();
    $idProducto = $this->getIdProducto();
    $sql = "DELETE FROM producto WHERE idproducto='$idProducto'";
    if ($base->Iniciar()) {
        if ($base->Ejecutar($sql)) {
            return true;
        } else {
            $this->setmensajeoperacion("Producto->eliminar: " . $base->getError());
        }
    } else {
        $this->setmensajeoperacion("Producto->eliminar: " . $base->getError());
    }
    return $resp;
}

}

?>