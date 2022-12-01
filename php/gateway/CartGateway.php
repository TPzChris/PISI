
<?php
    class CartGateway{

        public function getCartNumber($id){
            $con=mysqli_connect('localhost', 'root', '', 'pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query="select sum(cant) as sum from cart where id_user = {$id}";

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

            $query = "select count(1) as count from cart where id_user = {$idUser} and id_prod = {$idProd}";
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

            

            mysqli_close($con);
        }

    }
?>