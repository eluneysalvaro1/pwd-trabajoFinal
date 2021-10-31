<?php

class usuarioRol
{

    //Atributos (Politica un usuario puede tener un solo rol, por eso se implementa el objRol y no coleccion de Roles)
    private $objUsuario;
    private $colObjRol;
    private $mensajeOperacion;

    public function __construct(){
        $this->objUsuario;
        $this->colObjRol;
    }

    public function setear($datos){
        $this->setObjUsuario($datos['objUsuario']);
        $this->setColObjRol($datos['colObjRol']);
    }

    public function getObjUsuario(){
        return $this->objUsuario;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }
    public function setObjUsuario($objUsuario){
        $this->objUsuario = $objUsuario;
    }
    public function getColObjRol(){
        return $this->colObjRol;
    } 
    public function setColObjRol($colObjRol){
        $this->colObjRol = $colObjRol;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }


    //CONSULTAS A BBDD
    public function cargar()
    {
        $resp = false;
        $base = new BaseDatos();
        $objUsuario = $this->getObjUsuario();
        $idUsuario = $objUsuario->getIdUsuario();
        $colObjRol = $this->getColObjRol();
        $idRol = $colObjRol->getIdRol();
        $sql = "SELECT * FROM usuariorol WHERE idusuario = '$idUsuario' AND idrol = '$idRol'";

        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $usuario = new usuario();
                    $rol = new rol();
                    $usuario->setIdUsuario($row["idUsuario"]);
                    $usuario->cargar();
                    $rol->setIdRol($row["idRol"]);
                    $rol->cargar();

                    $this->setear(['objUsuario' => $usuario, 'colObjRol' => $rol]);
                }
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->listar: " . $base->getError());
        }
        return $resp;
    }

    public function listar($condicion = ""){
        $arregloUsuarioRol = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuariorol ";
        if ($condicion != "") {
            $sql = $sql . ' where ' . $condicion;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res > 0) {
                while ($row = $base->Registro()) {
                    $objUsuarioRol = new usuarioRol();
                    $objUsuario = new usuario();
                    $objUsuario->setIdUsuario($row['idUsuario']);
                    $objUsuario->cargar();
                    $objRol = new rol();
                    $objRol->setIdRol($row['idRol']);
                    $objRol->cargar();
                    $objUsuarioRol->setear(['objUsuario' => $objUsuario, 'colObjRol' => $objRol]);
                    array_push($arregloUsuarioRol, $objUsuarioRol);
                }
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->listar: " . $base->getError());
        }
        return $arregloUsuarioRol;
    }


    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        $objUsuario = $this->getObjUsuario();
        $idUsuario = $objUsuario->getIdUsuario();
        $objRol = $this->getColObjRol();
        $idRol = $objRol->getIdRol();
        $sql = "INSERT INTO usuariorol(idUsuario, idrol) 
                VALUES ('$idUsuario', '$idRol')";
        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                //$this->setId($elid);
                $resp = true;
            } else {
                $this->setmensajeoperacion("UsuarioRol->insertar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->insertar: " . $base->getError());
        }

        return $resp;
    }

    public function modificar(){
        $resp = false;
        $base = new BaseDatos();
        $objUsuario = $this->getObjUsuario();
        $idUsuario = $objUsuario->getIdUsuario();
        $objRol = $this->getColObjRol();
        $idRol = $objRol->getIdRol();
        $sql = "UPDATE usuariorol SET idusuario = '$idUsuario', idrol = '$idRol' WHERE idusuario = '$idUsuario' AND idrol = '$idRol'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion("UsuarioRol->modificar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $base = new BaseDatos();
        $resp = false;
        $objUsuario = $this->getObjUsuario();
        $idUsuario = $objUsuario->getIdUsuario();
        $objRol = $this->getColObjRol();
        $idRol = $objRol->getIdRol();
        if ($base->Iniciar()) {
            $sql = "DELETE FROM usuariorol WHERE idusuario = '$idUsuario' AND idrol = '$idRol'";
            if ($base->Ejecutar($sql)) {
                $resp =  true;
            } else {
                $this->setmensajeoperacion("UsuarioRol->eliminar: " . $base->getError());
            }
        } else {
            $this->setmensajeoperacion("UsuarioRol->eliminar: " . $base->getError());
        }
        return $resp;
    }
}

?>