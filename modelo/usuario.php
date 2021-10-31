<?php

class usuario
{
    private $idUsuario;
    private $usNombre;
    private $usPass;
    private $usMail;
    private $usDesabilitado;
    private $mensajeOperacion;

    public function __construct(){
        $this->idUsuario = 0;
        $this->usNombre = '';
        $this->usPass = '';
        $this->usMail = '';
        $this->usDesabilitado = '';
        $this->mensajeOperacion = '';
    }
    public function setear($datos){
        $this->setIdUsuario($datos['idUsuario']);
        $this->setUsNombre($datos['usNombre']);
        $this->setUsPass($datos['usPass']);
        $this->setUsMail($datos['usMail']);
        $this->setUsDesabilitado($datos['usDesabilitado']);
    }


    public function setIdUsuario($idUsuario){
        $this->idUsuario = $idUsuario;
    }
    public function setUsNombre($usNombre){
        $this->usNombre = $usNombre;
    }
    public function setUsPass($usPass){
        $this->usPass = $usPass;
    }
    public function setUsMail($usMail){
        $this->usMail = $usMail;
    }
    public function setUsDesabilitado($usDesabilitado){
        $this->usDesabilitado = $usDesabilitado;
    }
    public function setMensajeOperacion($mensajeOperacion){
        $this->mensajeOperacion = $mensajeOperacion;
    }
    public function getIdUsuario(){
        return $this->idUsuario;
    }
    public function getUsNombre(){
        return $this->usNombre;
    }
    public function getUsPass(){
        return $this->usPass;
    }
    public function getUsMail(){
        return $this->usMail;
    }
    public function getUsDesabilitado(){
        return $this->usDesabilitado;
    }
    public function getMensajeOperacion(){
        return $this->mensajeOperacion;
    }



    public function cargar(){
        $resp = false;
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario WHERE idusuario = " . $this->getIdUsuario();
        if ($base->Iniciar()) {
            $res = $base->Ejecutar($sql);
            if ($res > -1) {
                if ($res > 0) {
                    $row = $base->Registro();
                    $this->setear(['idUsuario' => $row['idUsuario'], 'usNombre' => $row['usNombre'], 'usPass' => $row['usPass'], 'usMail' => $row['usMail'], 'usDesabilitado' => $row['usDesabilitado']]);
                }
            }
        } else {
            $this->setMensajeOperacion("usuario->listar: " . $base->getError());
        }
        return $resp;
    }

    public function listar($parametro = ""){
        $arreglo = array();
        $base = new BaseDatos();
        $sql = "SELECT * FROM usuario ";
        if ($parametro != "") {
            $sql = $sql . 'WHERE ' . $parametro;
        }
        $res = $base->Ejecutar($sql);
        if ($res > -1) {
            if ($res >= 0) {
                while ($row = $base->Registro()) {
                    $obj = new usuario();
                    $obj->setear(['idUsuario' => $row['idUsuario'], 'usNombre' => $row['usNombre'], 'usPass' => $row['usPass'], 'usMail' => $row['usMail'], 'usDesabilitado' => $row['usDesabilitado']]);
                    array_push($arreglo, $obj);
                }
            }
        } else {
            $this->setMensajeOperacion("usuario->listar: " . $base->getError());
        }
        return $arreglo;
    }
    public function insertar(){
        $base = new BaseDatos();
        $resp = false;
        $idUsuario = $this->getIdUsuario();
        $usNombre = $this->getUsNombre();
        $usPass = $this->getUsPass();
        $usMail = $this->getUsMail();
        $usDeshabilitado = $this->getUsDesabilitado();
        $sql = "INSERT INTO usuario(idusuario,usnombre, uspass, usmail, usdeshabilitado)
                VALUES ('$idUsuario','$usNombre', '$usPass', '$usMail', '$usDeshabilitado')";

        if ($base->Iniciar()) {
            if ($elid = $base->Ejecutar($sql)) {
                $this->setIdUsuario($elid);
                $resp = true;
            } else {
                $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->insertar: " . $base->getError());
        }

        return $resp;
    }


    public function modificar()
    {
        $resp = false;
        $base = new BaseDatos();
        $idUsuario = $this->getIdUsuario();
        $usNombre = $this->getUsNombre();
        $usPass = $this->getUsPass();
        $usMail = $this->getUsMail();
        $usDeshabilitado = $this->getUsDesabilitado();
        $sql = "UPDATE usuario SET usmombre = '$usNombre', uspass = '$usPass'
        , usmail = '$usMail', usdeshabilitado = '$usDeshabilitado' WHERE idusuario = '$idUsuario'";
        if ($base->Iniciar()) {
            if ($base->Ejecutar($sql)) {
                $resp =  true;
            } else {
                $this->setMensajeOperacion("Usuario->modificar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->modificar: " . $base->getError());
        }
        return $resp;
    }

    public function eliminar(){
        $base = new BaseDatos();
        $resp = false;
        $idUsuario = $this->getIdUsuario();
        if ($base->Iniciar()) {
            $sql = "DELETE FROM usuario WHERE idusuario = '$idUsuario'";
            if ($base->Ejecutar($sql)) {
                $resp =  true;
            } else {
                $this->setMensajeOperacion("Usuario->eliminar: " . $base->getError());
            }
        } else {
            $this->setMensajeOperacion("Usuario->eliminar: " . $base->getError());
        }
        return $resp;
    }
}

?>