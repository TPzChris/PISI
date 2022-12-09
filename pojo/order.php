<?php

class Order{

    private $idOrder;
    private $lastName;
    private $firstName;
    private $email;
    private $address;
    private $phoneNo;
    private $cost;

    function set_idOrder($idOrder) {
        $this->idOrder = $idOrder;
    }
    function get_idOrder() {
        return $this->idOrder;
    }

    function set_lastName($lastName) {
        $this->lastName = $lastName;
    }
    function get_lastName() {
        return $this->lastName;
    }

    function set_firstName($firstName) {
        $this->firstName = $firstName;
    }
    function get_firstName() {
        return $this->firstName;
    }

    function set_email($email) {
        $this->email = $email;
    }
    function get_email() {
        return $this->email;
    }

    function set_address($address) {
        $this->address = $address;
    }
    function get_address() {
        return $this->address;
    }

    function set_phoneNo($phoneNo) {
        $this->phoneNo = $phoneNo;
    }
    function get_phoneNo() {
        return $this->phoneNo;
    }

    function set_cost($cost) {
        $this->cost = $cost;
    }
    function get_cost() {
        return $this->cost;
    }
    
}
