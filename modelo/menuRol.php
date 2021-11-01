<?php

class menuRol{

    private $objRol; 
    private $objMenu; 
    private $mensajeOperacion; 

    public function __construct(){
        $this->objRol = null;
        $this->objMenu = null;
        $this->mensajeOperacion = '';
    }


    public function setear($datos){
        $this->setObjMenu($datos['objmenu']);
        $this->setObjRol($datos['objrol']);
    }
    public function getObjMenu(){
        return $this->objMenu;
    }
    public function setObjMenu($objMenu){
        $this->objMenu = $objMenu;
    }
    public function getObjRol(){
        return $this->objRol;
    }
    public function setObjRol($objRol){
        $this->objRol = $objRol;
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
        $idMenu = $this->getObjMenu()->getIdMenu();
        $idRol = $this->getObjRol()->getIdRol(); 
        $sql = "SELECT * FROM menurol WHERE idmenu = '$idMenu' AND idrol = '$idRol'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear([$row['idmenu'],$row['idrol']]);
                }
            }
        } else {
            $this->setMensajeoperacion("menurol->cargar: ".$base->getError());
        }
        return $resp;
    }

    public function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM menurol";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new menuRol();
                    $objMenu = new menu();
                    $objRol = new rol(); 
                    $oMenu = $objMenu->listar($row['idmenu']);
                    $oRol = $objRol->listar($row['idrol']);
                    $datos = [
                        "objmenu" => $oMenu,
                        "objrol" => $oRol 
                    ]; 
                    $obj->setear($datos);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeoperacion("menurol->Listar: ".$base->getError());
        }
        return $arreglo;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();
        $idRol = $this->getObjRol()->getIdRol();
        $idMenu = $this->getObjMenu()->getIdMenu();
        $sql = "INSERT INTO menurol(idmenu , idrol) VALUES('$idMenu' , '$idRol' )";
        if ($base->Iniciar()) {
            if ($idMenuRol = $base->Ejecutar($sql)) {
                // $this->setIdRol($idRol);
                $resp = true;
            } else {
                $this->setmensajeoperacion("menurol->insertar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("menurol->insertar: " . $base->getError());
            $resp = false;
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $idRol = $this->getObjRol()->getIdRol();
        $idMenu = $this->getObjMenu()->getIdMenu();
        $sql = "UPDATE menurol SET idmenu ='$idMenu' , idrol = '$idRol' WHERE idmenu = '$idMenu' AND idrol = '$idRol' ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("menuRol->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menuRol->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $idRol = $this->getObjRol()->getIdRol();
        $idMenu = $this->getObjMenu()->getIdMenu();
        $sql = "DELETE * FROM menurol WHERE idmenu = '$idMenu' AND idrol = '$idRol' ";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("menuRol->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menuRol->eliminar: " . $base->getError());
        }
        return $resp;
    }


    


    


    
}

?>