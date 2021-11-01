<?php

class compraEstado{

    private $idCompraEstado; 
    private $objCompra; 
    private $objCompraEstadoTipo;
    private $ceFechaIni;
    private $ceFechaFin; 
    private $mensajeOperacion; 

    public function __construct(){
        $this->idCompraEstado = 0;
        $this->objCompra = null;
        $this->objCompraEstadoTipo = null;
        $this->ceFechaIni = '';
        $this->ceFechaFin = '';
    }


    public function setear($datos){
        $this->setIdCompraEstado($datos['idcompraestado']);
        $this->setObjCompra($datos['objCompra']);
        $this->setObjCompraEstadoTipo($datos['objCompraEstadoTipo']);
        $this->setCeFechaIni($datos['cefechaini']);
        $this->setCeFechaFin($datos['cefechafin']);
    }

    public function getIdCompraEstado(){
        return $this->idCompraEstado;
    }
    public function setIdCompraEstado($idCompraEstado){
        $this->idCompraEstado = $idCompraEstado;
    }
    public function getObjCompra(){
        return $this->objCompra;
    }
    public function setObjCompra($objCompra){
        $this->objCompra = $objCompra;
    }
    public function getObjCompraEstadoTipo(){
        return $this->objCompraEstadoTipo;
    }
    public function setObjCompraEstadoTipo($objCompraEstadoTipo){
        $this->objCompraEstadoTipo = $objCompraEstadoTipo;
    }
    public function getCeFechaIni(){
        return $this->ceFechaIni;
    }
    public function setCeFechaIni($ceFechaIni){
        $this->ceFechaIni = $ceFechaIni;
    }
    public function getCeFechaFin(){
        return $this->ceFechaFin;
    }
    public function setCeFechaFin($ceFechaFin){
        $this->ceFechaFin = $ceFechaFin;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    

    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstado = $this->getIdCompraEstado();
        $sql="SELECT * FROM compraestado 
            WHERE idcompraestado = '$idCompraEstado'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $objCompra = new compra();
                    $objCompraEstadoTipo = new compraEstadoTipo();
                    $oCompra = $objCompra->listar($row['idcompra']);
                    $oetCompra = $objCompraEstadoTipo->listar($row['idcompraestadotipo']); 
                    $datos = [
                        "idcompraestado" => $row['idcompraestado'],
                        "objCompra" => $oCompra,
                        "objCompraEstadoTipo" => $oetCompra,
                        "cefechaini" => $row['cefechaini'],
                        "cefechafin" => $row['cefechafin']
                    ];
                    $this->setear($datos);
                }
            }
        } else {
            $this->setMensajeoperacion("compraestado->cargar: ".$base->getError());
        }
        return $resp;
    }

    public function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compraestado";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new compraEstado();
                    $objCompra = new compra();
                    $objCompraEstadoTipo = new compraEstadoTipo();
                    $oCompra = $objCompra->listar($row['idcompra']);
                    $oetCompra = $objCompraEstadoTipo->listar($row['idcompraestadotipo']); 
                    $datos = [
                        "idcompraestado" => $row['idcompraestado'],
                        "objCompra" => $oCompra,
                        "objCompraEstadoTipo" => $oetCompra,
                        "cefechaini" => $row['cefechaini'],
                        "cefechafin" => $row['cefechafin']
                    ];
                    $obj->setear($datos);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeoperacion("compraestado->Listar: ".$base->getError());
        }

        return $arreglo;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idCompra = $this->getObjCompra()->getIdCompra();
        $idCompraEstadoTipo = $this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
        $ceFechaFin = $this->getCeFechaFin();
        $ceFechaIni = $this->getCeFechaIni(); 
        $sql = "INSERT INTO compraestado(idcompra,idcompraestadotipo,cefechaini,cefechafin) 
                VALUES('$idCompra' , '$idCompraEstadoTipo' , '$ceFechaIni' , '$ceFechaFin')";
        if ($base->Iniciar()) {
            if ($idCompraEstado = $base->Ejecutar($sql)) {
                $this->setIdCompraEstado($idCompraEstado);
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraestado->insertar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("compraestado->insertar: " . $base->getError());
            $resp = false;
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstado = $this->getIdCompraEstado();
        $idCompra = $this->getObjCompra()->getIdCompra();
        $idCompraEstadoTipo = $this->getObjCompraEstadoTipo()->getIdCompraEstadoTipo();
        $ceFechaIni = $this->getCeFechaIni();
        $ceFechaFin = $this->getCeFechaFin(); 
        $sql = "UPDATE compraestado 
                SET idcompra ='$idCompra' , idcompraestadotipo = '$idCompraEstadoTipo' , cefechaini = '$ceFechaIni' , cefechafin = '$ceFechaFin' 
                WHERE idcompraestado='$idCompraEstado'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compraestado->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestado->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompraEstado = $this->getIdCompraEstado();
        $sql = "DELETE * 
                FROM compraestado 
                WHERE idcompraestado = '$idCompraEstado'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("compraestado->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compraestado->eliminar: " . $base->getError());
        }
        return $resp;
    }


    
}

?>