
<?php

    class CartGateway{

        
        public function getCartNumber($id){
            $con=mysqli_connect('localhost', 'root', '', 'pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query="select sum(cant) as sum from cart where id_user = {$id} and id_order is null";

            $result = mysqli_query($con, $query);
            $sum = mysqli_fetch_assoc($result);

            mysqli_close($con);

            return $sum['sum'] != null ? $sum['sum'] : 0;
        }


        public function updateCart($idUser, $idProd, $cant){
            $con=mysqli_connect('localhost', 'root', '', 'pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query = "select count(1) as count from cart where id_user = {$idUser} and id_prod = {$idProd} and id_order is null";
            $result = mysqli_query($con, $query);
            $count = mysqli_fetch_assoc($result);

            if($count['count'] == 0){
                $operationQuery = "insert into cart(id_user, id_prod, cant) values ({$idUser}, {$idProd}, {$cant})";
            } else{
                $operationQuery = "update cart set cant = {$cant} where id_user = {$idUser} and id_prod = {$idProd}";
            }

            if(!mysqli_query($con, $operationQuery)){
                $_SESSION['error'] = "Error description: " . mysqli_error($con);
                echo $_SESSION['error'];
            }

            mysqli_close($con);
        }

        public function getCartByUserId($id){
            $con=mysqli_connect('localhost','root','','pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query = "select p.*, c.cant from prod p, cart c where c.id_user = {$id} and c.id_prod = p.id_prod and c.id_order is null and c.cant > 0";
            $result = mysqli_query($con, $query);
            $cart = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($cart, $row);
            }

            mysqli_close($con);

            return $cart;
        }

        public function getCartPrice($id){
            $con=mysqli_connect('localhost','root','','pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query = "select sum(p.pret * c.cant) as sum from prod p, cart c where p.id_prod = c.id_prod and p.hidden <> 1 and c.id_order is null and c.id_user = {$id} and c.cant > 0";
            $result = mysqli_query($con, $query);
            $cart = mysqli_fetch_assoc($result);
                
            mysqli_close($con);

            return $cart['sum'];
        }

        public function updateCartOrder($idOrder, $idUser){
            $con=mysqli_connect('localhost','root','','pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $operationQuery = "update cart set id_order = {$idOrder} where id_user = {$idUser} and id_order is null";

            if(!mysqli_query($con, $operationQuery)){
                $_SESSION['error'] = "Error description: " . mysqli_error($con);
                echo $_SESSION['error'];
            }

            mysqli_close($con);
        }

        public function getCartElementsOfOrder($idOrder){
            $con=mysqli_connect('localhost','root','','pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query = "select c.* from cart c where c.id_order = {$idOrder}";
            $result = mysqli_query($con, $query);
            $orderContent = array();
            while($row = mysqli_fetch_assoc($result)){
                $cart = new Cart();
                $cart->set_idCart($row['id_cart']);
                $cart->set_idUser($row['id_user']);
                $cart->set_idProd($row['id_prod']);
                $cart->set_cant($row['cant']);
                $cart->set_idOrder($row['id_order']);
                $cartDTO = new CartDTO();
                $cartDTO->fromCartToCartDTO($cart);
                array_push($orderContent, $cartDTO);
            }

            mysqli_close($con);

            return $orderContent;
        }


    }
?>