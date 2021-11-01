<?php
class abmUsuarioRol
{
    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto
     * @param array $param
     * @return object
     */
    private function cargarObjeto($param)
    {
        $objUsuarioRol = null;
        if (array_key_exists('idrol', $param) and 
            array_key_exists('idusuario', $param)) {
            $objUsuarioRol = new usuarioRol();
            $abmUsuario = new abmUsuario();
            $objUsuario = $abmUsuario->buscar(['idusuario' => $param['idusuario']]);
            $abmRol = new abmRol();
            $objRol = $abmRol->buscar(['idrol' => $param['idrol']]);
            $objUsuarioRol->setear($objUsuario[0], $objRol[0]);
        }
        return $objUsuarioRol;
    }


    /**
     * Espera como parametro un arreglo asociativo donde las claves coinciden con los nombres de las variables instancias del objeto que son claves
     * @param array $param
     * @return object
     */
    private function cargarObjetoConClave($param){
        $objUsuarioRol = null;
        if (isset($param['objusuario']) && isset($param['objrol'])) {
            $objUsuarioRol = new usuarioRol();
            $objUsuarioRol->setear($param['objusuario'], $param['objrol']);
        }
        return $objUsuarioRol;
    }
    /**
     * Corrobora que dentro del arreglo asociativo estan seteados los campos claves
     * @param array $param
     * @return boolean
     */

    private function seteadosCamposClaves($param){
        $resp = false;
        if (isset($param['objusuario']) && isset($param['objrol'])){
            $resp = true;
        }
        return $resp;
    }


    public function alta($param){
        $resp = false;
        $objUsuarioRol = $this->cargarObjeto($param);
        if ($objUsuarioRol != null and $objUsuarioRol->insertar()) {
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
            $objUsuarioRol = $this->cargarObjeto($param);
            if ($objUsuarioRol != null and $objUsuarioRol->eliminar()) {
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
            $objUsuarioRol = $this->cargarObjeto($param);
            if ($objUsuarioRol != null and $objUsuarioRol->modificar()) {
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
                $where .= " and idusuario='" . $param['idusuario'] . "'";
            if (isset($param['idrol']))
                $where .= " and idrol ='" . $param['idrol'] . "'";
        }
        $objUsuarioRol = new usuarioRol();
        $arreglo = $objUsuarioRol->listar($where);
        return $arreglo;
    }
}
