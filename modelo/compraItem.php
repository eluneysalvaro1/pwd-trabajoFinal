<?php

class compraItem{

    private $idCompraItem; 
    private $objProducto; 
    private $objCompra;
    private $ciCantidad; 
    private $mensajeOperacion; 

    public function __construct(){
        $this->idCompraItem = 0;
        $this->objProducto = null;
        $this->objCompra = null;
        $this->ciCantidad = ''; 
    }
// METODOS SETTERS
    public function setear($datos){
        $this->setIdCompraItem($datos['idcompraitem']);
        $this->setObjProducto($datos['objProducto']);
        $this->setObjCompra($datos['objCompra']); 
        $this->setCiCantidad($datos['cicantidad']);
    }

    public function getIdCompraItem(){
        return $this->idCompraItem;
    }
    public function setIdCompraItem($idCompraItem){
        $this->idCompraItem = $idCompraItem;
    }
    public function getObjProducto(){
        return $this->objProducto;
    }
    public function setObjProducto($objProducto){
        $this->objProducto = $objProducto;
    }
    public function getObjCompra(){
        return $this->objCompra;
    }
    public function setObjCompra($objCompra){
        $this->objCompra = $objCompra;
    }
    public function getCiCantidad(){
        return $this->ciCantidad;
    }
    public function setCiCantidad($ciCantidad){
        $this->ciCantidad = $ciCantidad;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    
// CONSULTAS A LA BASE DE DATOS
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraItem = $this->getIdCompraItem();
        $sql="SELECT * FROM compraitem WHERE idcompraitem = '$idCompraItem'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $objCompra = new compra();
                    $objProducto = new producto(); 
                    $oCompra = $objCompra->listar($row['idcompra']); 
                    $oProducto = $objProducto->listar($row['idproducto']); 
                    $datos = [
                        "idcompraitem" => $row['idcompraitem'],
                        "objProducto" => $oProducto,
                        "objCompra" => $oCompra,
                        "cicantidad" => $row['cicantidad']
                    ];
                    $this->setear($datos);
                }
            }
        } else {
            $this->setMensajeoperacion("compraitem->cargar: ".$base->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraitem";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new compraItem();
                    $objCompra = new compra();
                    $objProducto = new producto(); 
                    $oCompra = $objCompra->listar($row['idcompra']); 
                    $oProducto = $objProducto->listar($row['idproducto']); 
                    $datos = [
                        "idcompraitem" => $row['idcompraitem'],
                        "objProducto" => $oProducto,
                        "objCompra" => $oCompra,
                        "cicantidad" => $row['cicantidad']
                    ];
                    $obj->setear($datos);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeoperacion("compraitem->Listar: ".$base->getError());
        }

        return $arreglo;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $idProducto = $this->getObjProducto()->getIdProducto();
        $idCompra = $this->getObjCompra()->getIdCompra(); 
        $ciCantidad = $this->getCiCantidad(); 
        $sql = "INSERT INTO compraitem(idproducto,idcompra,cicantidad) 
                VALUES('$idProducto' , '$idCompra' , '$ciCantidad')";
        if ($base->Iniciar()) {
            if ($idCompraItem = $base->Ejecutar($sql)) {
                $this->setIdCompraItem($idCompraItem);
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraitem->insertar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("compraitem->insertar: " . $base->getError());
            $resp = false;
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraItem = $this->getIdCompraItem();
        $idProducto = $this->getObjProducto()->getIdProducto();
        $idCompra = $this->getObjCompra()->getIdCompra(); 
        $ciCantidad = $this->getCiCantidad(); 
        $sql = "UPDATE rol 
                SET idproducto ='$idProducto' , idcompra = '$idCompra' , cicantidad = '$ciCantidad' 
                WHERE idcompraitem='$idCompraItem'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraitem->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraitem->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraItem = $this->getIdCompraItem();
        $sql = "DELETE * 
                FROM compraitem 
                WHERE idcompraitem='$idCompraItem'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("compraitem->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraitem->eliminar: " . $base->getError());
        }
        return $resp;
    }

    
}

?>