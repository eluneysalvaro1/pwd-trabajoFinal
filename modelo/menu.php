<?php

class menu{

    private $idMenu; 
    private $meNombre; 
    private $meDescripcion;
    private $idPadre;
    private $meDeshabilitado;  
    private $mensajeOperacion; 


    public function __construct(){
        $this->idMenu = 0;
        $this->meNombre = '';
        $this->meDescripcion = '';
        $this->idPadre = '';
        $this->meDeshabilitado = '';
        $this->mensajeOperacion = ''; 
    }


    public function setear($datos){
        $this->setIdMenu($datos['idmenu']);
        $this->setMeNombre($datos['menombre']);
        $this->setMeDescripcion($datos['medescripcion']);
        $this->setIdPadre($datos['idpadre']);
        $this->setMeDeshabilitado($datos['medeshabilitado']);
    }

    public function getIdMenu(){
        return $this->idMenu;
    }
    public function setIdMenu($idMenu){
        $this->idMenu = $idMenu;
    }
    public function getMeNombre(){
        return $this->meNombre;
    }
    public function setMeNombre($meNombre){
        $this->meNombre = $meNombre;
    }
    public function getMeDescripcion(){
        return $this->meDescripcion;
    }
    public function setMeDescripcion($meDescripcion){
        $this->meDescripcion = $meDescripcion;
    }
    public function getIdPadre(){
        return $this->idPadre;
    }
    public function setIdPadre($idPadre){
        $this->idPadre = $idPadre;
    }
    public function getMeDeshabilitado(){
        return $this->meDeshabilitado;
    }
    public function setMeDeshabilitado($meDeshabilitado){
        $this->meDeshabilitado = $meDeshabilitado;
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
        $idMenu = $this->getIdMenu();
        $sql = "SELECT * FROM menu WHERE idmenu = '$idMenu'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $datos = [
                        $row['idmenu'], 
                        $row['menombre'],
                        $row['medescripcion'],
                        $row['idpadre'],
                        $row['medeshabilitado']
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
        $sql = "SELECT * FROM rol ";
        if ($parametro != "") {
            $sql .= 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $obj = new menu();
                    $datos = [
                        $row['idmenu'], 
                        $row['menombre'],
                        $row['medescripcion'],
                        $row['idpadre'],
                        $row['medeshabilitado']
                    ];
                    $obj->setear($datos);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeoperacion("rol->Listar: ".$base->getError());
        }

        return $arreglo;
    }

    public function insertar(){
        $resp = false;
        $base = new BaseDatos();

        $meNombre = $this->getMeNombre();
        $meDescripcion = $this->getMeDescripcion();
        $idPadre = $this->getIdPadre();
        $meDeshabilitado = $this->getMeDeshabilitado(); 

        $sql = "INSERT INTO menu(menombre,medescripcion,idpadre,medeshabilitado) 
                VALUES('$meNombre' , '$meDescripcion' , '$idPadre' , '$meDeshabilitado')";
        if ($base->Iniciar()) {
            if ($idMenu = $base->Ejecutar($sql)) {
                $this->setIdMenu($idMenu);
                $resp = true;
            } else {
                $this->setmensajeoperacion("menu->insertar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("menu->insertar: " . $base->getError());
            $resp = false;
        }
        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();

        $idMenu = $this->getIdMenu();

        $meNombre = $this->getMeNombre();
        $meDescripcion = $this->getMeDescripcion();
        $idPadre = $this->getIdPadre();
        $meDeshabilitado = $this->getMeDeshabilitado();

        $sql = "UPDATE menu SET menombre ='$meNombre' , medescripcion = '$meDescripcion' , idpadre = '$idPadre' , medeshabilitado = '$meDeshabilitado' 
                WHERE idmenu = '$idMenu'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("menu->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menu->modificar: " . $base->getError());
        }
        return $resp;
    }
    public function eliminar(){
        $resp = false;
        $base = new BaseDatos();
        $idMenu = $this->getIdMenu();
        $sql = "DELETE * FROM menu WHERE idMenu='$idMenu'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("menu->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("menu->eliminar: " . $base->getError());
        }
        return $resp;
    }
}

?>