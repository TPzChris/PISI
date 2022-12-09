<?php

class Cart{

    private $idCart;
    private $idUser;
    private $idProd;
    private $cant;
    private $idOrder;

    function set_idCart($idCart) {
        $this->idCart = $idCart;
    }
    function get_idCart() {
        return $this->idCart;
    }

    function set_idUser($idUser) {
        $this->idUser = $idUser;
    }
    function get_idUser() {
        return $this->idUser;
    }

    function set_idProd($idProd) {
        $this->idProd = $idProd;
    }
    function get_idProd() {
        return $this->idProd;
    }

    function set_cant($cant) {
        $this->cant = $cant;
    }
    function get_cant() {
        return $this->cant;
    }

    function set_idOrder($idOrder) {
        $this->idOrder = $idOrder;
    }
    function get_idOrder() {
        return $this->idOrder;
    }

    
    
}
