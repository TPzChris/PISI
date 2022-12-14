<?php

    class OrderGateway{

        public function insertOrder(OrderDTO $orderDTO){
            $con=mysqli_connect('localhost','root','','pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $operationQuery = "insert into `order`(last_name, first_name, email, address, phone_no, cost) 
                values ('{$orderDTO->get_lastName()}', '{$orderDTO->get_firstName()}', '{$orderDTO->get_email()}', '{$orderDTO->get_address()}', '{$orderDTO->get_phoneNo()}', {$orderDTO->get_cost()})";
            

            if(!mysqli_query($con, $operationQuery)){
                $_SESSION['error'] = "Error description: " . mysqli_error($con);
                echo $_SESSION['error'];
            }
    

            mysqli_close($con);
        }

        public function findById($idOrder){
            $con=mysqli_connect('localhost','root','','pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query = "select * from `order` where id_order = {$idOrder}";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $order = new Order();
            $order->set_idOrder($row['id_order']);
            $order->set_lastName($row['last_name']);
            $order->set_firstName($row['first_name']);
            $order->set_email($row['email']);
            $order->set_address($row['address']);
            $order->set_phoneNo($row['phone_no']);
            $order->set_cost($row['cost']);

            mysqli_close($con);

            return $order;
        }

        public function findLatestOrder(){
            $con=mysqli_connect('localhost','root','','pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query = "select * from `order` where id_order = (select max(id_order) from `order`)";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $order = new Order();
            $order->set_idOrder($row['id_order']);
            $order->set_lastName($row['last_name']);
            $order->set_firstName($row['first_name']);
            $order->set_email($row['email']);
            $order->set_address($row['address']);
            $order->set_phoneNo($row['phone_no']);
            $order->set_cost($row['cost']);

            mysqli_close($con);

            return $order;
        }

    }

?>