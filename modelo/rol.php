<?php

class rol{

    private $idRol; 
    private $rolDescripcion; 
    private $mensajeOperacion; 

    public function __construct(){
        $this->idRol = 0;
        $this->rolDescripcion = '';
    }
// METODOS SETTERS
    public function setear($datos){
        $this->setIdRol($datos['idrol']);
        $this->setRolDescripcion($datos['roldescripcion']);
    }

    public function setIdRol($idRol){
        $this->idRol = $idRol;
    }
    public function setRolDescripcion($rolDescripcion){
        $this->rolDescripcion = $rolDescripcion;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }
    
    // METODOS GETTERS
    public function getRolDescripcion(){
        return $this->rolDescripcion;
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
        $idRol=$this->getIdRol();
        $sql="SELECT * FROM rol WHERE idrol = '$idRol'";
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if($res>-1){
                if($res>0){
                    $row = $base->Registro();
                    $this->setear([$row['idrol'],$row['roldescripcion']]);
                }
            }
        } else {
            $this->setMensajeoperacion("Rol->cargar: ".$base->getError());
        }
        return $resp;
    }

    public function listar($parametro = "")
    {
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
                    $obj = new rol();
                    $obj->setear(['idrol'=>$row['idrol'], 'roldescripcion'=>$row['roldescripcion']]);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeoperacion("rol->Listar: ".$base->getError());
        }

        return $arreglo;
    }

    public function insertar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idRol=$this->getIdRol();
        $rolDescripcion=$this->getRolDescripcion();
        $sql = "INSERT INTO rol(roldescripcion) VALUES('$rolDescripcion')";
        if ($base->Iniciar()) {
            if ($idRol = $base->Ejecutar($sql)) {
                $this->setIdRol($idRol);
                $resp = true;
            } else {
                $this->setmensajeoperacion("rol->insertar: " . $base->getError());
                $resp = false;
            }
        } else {
            $this->setmensajeoperacion("rol->insertar: " . $base->getError());
            $resp = false;
        }
        return $resp;
    }

    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idRol=$this->getIdRol();
        $rolDescripcion = $this->getRolDescripcion();
        $sql = "UPDATE rol SET roldescripcion ='$rolDescripcion' WHERE idrol='$idRol'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp = true;
            } else {
                $this->setmensajeoperacion("Rol->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Rol->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idRol=$this->getIdRol();
        $sql = "DELETE * FROM rol WHERE idrol='$idRol'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                return true;
            } else {
                $this->setmensajeoperacion("Rol->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("Rol->eliminar: " . $base->getError());
        }
        return $resp;
    }
}

?>