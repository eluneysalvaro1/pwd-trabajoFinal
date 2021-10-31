<?php

class rol{

    private $idRol; 
    private $idMenu; 
    private $mensajeOperacion; 

    public function __construct(){
        $this->idRol = 0;
        $this->idMenu = 0;
        $this->mensajeOperacion = '';
    }


    public function setear($datos){
        $this->setIdRol($datos['idmenu']);
        $this->setRolDescripcion($datos['idrol']);
    }
    public function setIdRol($idRol){
        $this->idRol = $idRol;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }
    public function getIdMenu(){
        return $this->idMenu;
    }
    public function setIdMenu($idMenu){
        $this->idMenu = $idMenu;
    }
    public function getIdRol(){
        return $this->idRol;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }

    
// CONSULTAS A LA BASE DE DATOS
    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $idMenu = $this->getIdMenu();
        $idRol = $this->getIdRol(); 
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
                    $obj = new rol();
                    $obj->setear(['idmenu'=>$row['idmenu'], 'idrol'=>$row['idrol']]);
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
        $idRol=$this->getIdRol();
        $idMenu = $this->getIdMenu();
        $sql = "INSERT INTO menurol(idmenu , idrol) VALUES('$idMenu' , '$idRol' )";
        if ($base->Iniciar()) {
            if ($idRol = $base->Ejecutar($sql)) {
                $this->setIdRol($idRol);
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
        $idRol = $this->getIdRol();
        $idMenu = $this->getIdMenu();
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
        $idRol = $this->getIdRol();
        $idMenu = $this->getIdMenu();
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