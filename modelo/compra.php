<?php

class compra{

    private $idCompra; 
    private $coFecha;
    private $objUsuario; 
    private $mensajeOperacion; 

    public function __construct(){
        $this->idCompra = 0;
        $this->coFecha = '';
        $this->objUsuario = '';
        $this->mensajeOperacion = ''; 
    }

    public function setear($datos){
        $this->setIdCompra($datos['idcompra']);
        $this->setCoFecha($datos['cofecha']);
        $this->setObjUsuario($datos['objusuario']);
    }

    public function getIdCompra(){
        return $this->idCompra;
    }
    public function setIdCompra($idCompra){
        $this->idCompra = $idCompra;
    }
    public function getCoFecha(){
        return $this->coFecha;
    } 
    public function setCoFecha($coFecha){
        $this->coFecha = $coFecha;
    }
    public function getObjUsuario(){
        return $this->objUsuario;
    }
    public function setObjUsuario($objUsuario){
        $this->objUsuario = $objUsuario;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }
    

    
// CONSULTAS A LA BASE DE DATOS
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompra = $this->getIdCompra();
        $sql="SELECT * FROM compra WHERE idcompra = '$idCompra'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    
                    $objUsuario = new usuario();
                    $oUsuario = $objUsuario->listar($row['idusuario']); 
                    $datos = [
                        "idcompra" => $row['idcompra'],
                        "cofecha" => $row['cofecha'],
                        "objusuario" => $oUsuario
                    ];
                    $this->setear($datos);
                }
            }
        } else {
            $this->setMensajeoperacion("compra->cargar: ".$base->getError());
        }
        return $resp;
    }

    public function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM compra ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new compra();
                    $objUsuario = new usuario();
                    $oUsuario = $objUsuario->listar($row['idusuario']); 
                    $datos = [
                        "idcompra" => $row['idcompra'],
                        "cofecha" => $row['cofecha'],
                        "objusuario" => $oUsuario
                    ];
                    $obj->setear($datos);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeoperacion("compra->Listar: ".$base->getError());
        }

        return $arreglo;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();

        $coFecha = $this->getCoFecha();
        $idUsuario = $this->getObjUsuario()->getIdUsuario(); 
        $sql = "INSERT INTO compra(cofecha, idusuario) 
                VALUES('$coFecha' , '$idUsuario')";
        if ($base->Iniciar()) {
            if ($idCompra = $base->Ejecutar($sql)) {
                $this->setIdCompra($idCompra);
                $resp = true;
            } else {
                $this->setmensajeoperacion("compra->insertar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("compra->insertar: " . $base->getError());
            $resp = false;
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompra = $this->getIdCompra();
        $coFecha = $this->getCoFecha();
        $idUsuario = $this->getObjUsuario()->getIdUsuario(); 
        $sql = "UPDATE compra 
                SET cofecha = '$coFecha' , idusuario = $idUsuario  
                WHERE idcompra = '$idCompra'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("compra->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compra->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $idCompra = $this->getIdCompra();
        $sql = "DELETE * FROM compra WHERE idcompra = '$idCompra'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("compra->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("compra->eliminar: " . $base->getError());
        }
        return $resp;
    }
}

?>