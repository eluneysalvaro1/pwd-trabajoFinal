<?php

class session{
    
    public function __construct(){
        session_start();
    }

    /**
     * Actualiza las variables de sesión con los valores ingresados
     */
    public function iniciar($usNombre, $usPass){
        $exito = false;
        $usPass = md5($usPass);
        if ($this->validar($usNombre, $usPass)) {
            $exito = true;
        }
        return $exito;
    }

    /**
     *  Valida si la sesión actual tiene usuario y psw válidos. Devuelve true o false.
     */
    public function validar($usNombre, $usPass){
        $exito = false;
        $abmUsuario = new abmUsuario();
        $listaUsuario = $abmUsuario->buscar(['usNombre' => $usNombre, 'usPass' => $usPass]);
        if (count($listaUsuario) > 0) {
            if ($listaUsuario[0]->getUsDeshabilitado() == NULL || $listaUsuario[0]->getUsDeshabilitado() == 1) {
                $_SESSION['idUsuario'] = $listaUsuario[0]->getIdUsuario();
                $exito = true;
            }
        }
        return $exito;
    }

    /**
     * Devuelve true o false si la sesión está activa o no.
     */
    public function activa(){
        $activa = false;
        if (isset($_SESSION['idUsuario'])) {
            $activa = true;
        }
        return $activa;
    }

    /**
     * Devuelve el usuario logeado
     */
    public function getUsuario(){
        $usuario = null;
        $abmUsuario = new abmUsuario();
        $list = $abmUsuario->buscar(['idUsuario' => $_SESSION['idUsuario']]);
        if (count($list) > 0) {
            $usuario = $list[0];
        }
        return $usuario;
    }


    /**
     * Devuelve el rol del usuario logeado
     */
    public function getRol(){
        $roles = array();
        $abmUsuarioRol = new abmUsuarioRol();
        $abmRol = new abmRol();
        $usuario = $this->getUsuario();
        $list = $abmUsuarioRol->buscar(['idUsuario' => $usuario->getIdUsuario()]);
        if (count($list) > 0) {
            foreach ($list as $UR) {
                $objRol = $abmRol->buscar(['idRol' => $UR->getObjRol()->getIdRol()]);
                array_push($roles, $objRol[0]);
            }
        }
        return $roles;
    }

    /**
     * Cierra la sesión actual
     */
    public function cerrar(){
        $cerrar = false;
        if (session_destroy()) {
            $cerrar = true;
        }
        return $cerrar;
    }
}

?>