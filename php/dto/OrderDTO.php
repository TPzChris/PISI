<?php 

    class OrderDTO{

        private $idOrder;
        private $lastName;
        private $firstName;
        private $email;
        private $address;
        private $phoneNo;
        private $cost;
        private $cartElements = array();
        private $status;

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

        function set_cartElements($cartElements) {
            $this->cartElements = $cartElements;
        }
    
        function get_cartElements() {    
            return $this->cartElements;
        }

        function set_status($status) {
            $this->status = $status;
        }
        function get_status() {
            return $this->status;
        }
        
        
        function fromOrderToOrderDTO(Order $order){
            $this->set_idOrder($order->get_idOrder());
            $this->set_lastName($order->get_lastName());
            $this->set_firstName($order->get_firstName());
            $this->set_email($order->get_email());
            $this->set_address($order->get_address());
            $this->set_phoneNo($order->get_phoneNo());
            $this->set_cost($order->get_cost());
            $this->set_status($order->get_status());
        }

    }

?>