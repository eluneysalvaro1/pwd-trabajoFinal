<?php

class abmUsuario{

    private function cargarObjeto($param){
        $obj = null;
        if (array_key_exists('idssuario', $param) and 
            array_key_exists('usnombre', $param) and 
            array_key_exists('uspass', $param) and 
            array_key_exists('usmail', $param) and 
            array_key_exists('usdeshabilitado', $param)) {
            $obj = new usuario();
            $datos = [
                "idusuario" => $param["idusuario"],
                "usnombre" => $param["usnombre"],
                "uspass" => $param["uspass"],
                "usmail" => $param['usmail'],
                "usdeshabilitado" => $param['usdeshabilitado']
            ];
            $obj->setear($datos);
        }
        return $obj;
    }

    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */
    private function seteadosCamposClaves($param)
    {
        $resp = false;
        if (isset($param)) {
            $resp = true;
        }
        return $resp;
    }

    /**
     * 
     * @param array $param
     */
    public function alta($param)
    {
        $resp = false;
        $elObjtTabla = $this->cargarObjeto($param);
        if ($elObjtTabla != null and $elObjtTabla->insertar()) {
            $resp = true;
        }
        return $resp;
    }
    /**
     * permite eliminar un objeto 
     * @param array $param
     * @return boolean
     */
    public function baja($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $objUsuario = $this->cargarObjeto($param);
            $abmUsuariorol = new abmUsuarioRol();
            $arregloRoles = $abmUsuariorol->buscar($param);
            foreach ($arregloRoles as $objRol) {
                $abmUsuariorol->baja($param);
            }
            if ($objUsuario != null and $objUsuario->eliminar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite modificar un objeto
     * @param array $param
     * @return boolean
     */
    public function modificacion($param){
        $resp = false;
        if ($this->seteadosCamposClaves($param)) {
            $elObjtTabla = $this->cargarObjeto($param);
            if ($elObjtTabla != null and $elObjtTabla->modificar()) {
                $resp = true;
            }
        }
        return $resp;
    }

    /**
     * permite buscar un objeto
     * @param array $param
     * @return boolean
     */
    public function buscar($param){
        $where = " true ";
        if ($param <> NULL) {
            if (isset($param['idusuario']))
                $where .= ' and idusuario = ' . "'" . $param['idusuario'] . "'";
            if (isset($param['usnombre']))
                $where .= ' and usnombre =' . "'" . $param['usnombre'] . "'";
            if (isset($param['uspass']))
                $where .= ' and uspass =' . "'" . $param['uspass'] . "'";
            if (isset($param['usmail']))
                $where .= ' and usmail =' . "'" . $param['usmail'] . "'";
            if (isset($param['usdeshabilitado']))
                $where .= ' and usdeshabilitado =' . $param['usdeshabilitado'] . "'";
        }

        $arreglo = usuario::listar($where);

        return $arreglo;
    }
}

?>