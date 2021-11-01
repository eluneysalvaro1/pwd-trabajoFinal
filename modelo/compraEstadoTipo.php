<?php

class compraEstadoTipo{

    private $idCompraEstadoTipo; 
    private $cetDescripcion;
    private $cetDetalle; 
    private $mensajeOperacion; 

    public function __construct(){
        $this->idCompraEstadoTipo = '';
        $this->cetDescripcion = '';
        $this->cetDetalle = '';
        $this->mensajeOperacion = '';
    }


    public function setear($datos){
        $this->setIdCompraEstadoTipo($datos['idcompraestadotipo']);
        $this->setCetDescripcion($datos['cetdescripcion']);
        $this->setCetDetalle($datos['cetdetalle']); 
    }

    public function getIdCompraEstadoTipo(){
        return $this->idCompraEstadoTipo;
    }
    public function setIdCompraEstadoTipo($idCompraEstadoTipo){
        $this->idCompraEstadoTipo = $idCompraEstadoTipo;
    }
    public function getCetDescripcion(){
        return $this->cetDescripcion;
    }
    public function setCetDescripcion($cetDescripcion){
        $this->cetDescripcion = $cetDescripcion;
    }
    public function getCetDetalle(){
        return $this->cetDetalle;
    }
    public function setCetDetalle($cetDetalle){
        $this->cetDetalle = $cetDetalle;
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
        $idCompraEstadoTipo = $this->getIdCompraEstadoTipo();
        $sql="SELECT * FROM compraestadotipo WHERE idcompraestadotipo = '$idCompraEstadoTipo'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $datos = [
                        "idcompraestadotipo" => $row['idcompraestadotipo'], 
                        "cetdescripcion" => $row['cetdescripcion'],
                        "cetdetalle" => $row['cetdetalle']
                    ];
                    $this->setear($datos);
                }
            }
        } else {
            $this->setMensajeoperacion("compraestadotipo->cargar: ".$base->getError());
        }
        return $resp;
    }

    public function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestadotipo ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new compraEstadoTipo();
                    $datos = [
                        "idcompraestadotipo" => $row['idcompraestadotipo'], 
                        "cetdescripcion" => $row['cetdescripcion'],
                        "cetdetalle" => $row['cetdetalle']
                    ];
                    $obj->setear($datos);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeoperacion("compraestadotipo->Listar: ".$base->getError());
        }

        return $arreglo;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstadoTipo = $this->getIdCompraEstadoTipo();
        $cetDescripcion = $this->getCetDescripcion();
        $cetDetalle = $this->getCetDetalle(); 
        $sql = "INSERT INTO compraestadotipo(idcompraestadotipo,cetdescripcion,cetdetalle) 
                VALUES('$idCompraEstadoTipo' , '$cetDescripcion' , '$cetDetalle')";
        if ($base->Iniciar()) {
            if ($idCompra = $base->Ejecutar($sql)) {
                $this->setIdCompraEstadoTipo($idCompra);
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraestadotipo->insertar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("compraestadotipo->insertar: " . $base->getError());
            $resp = false;
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstadoTipo = $this->getIdCompraEstadoTipo();
        $cetDescripcion = $this->getCetDescripcion();
        $cetDetalle = $this->getCetDetalle();
        $sql = "UPDATE compraestadotipo 
                SET cetdescripcion ='$cetDescripcion', cetdetalle = '$cetDetalle' 
                WHERE idcompraestadotipo='$idCompraEstadoTipo'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraestadotipo->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestadotipo->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstadoTipo = $this->getIdCompraEstadoTipo();
        $sql = "DELETE * FROM compraestadotipo WHERE idcompraestadotipo = '$idCompraEstadoTipo'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("compraestadotipo->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestadotipo->eliminar: " . $base->getError());
        }
        return $resp;
    }

    
}

?>