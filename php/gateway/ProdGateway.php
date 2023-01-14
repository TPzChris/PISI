<?php

    class ProdGateway{

        public function getProdById($id){
            $con=mysqli_connect('localhost','root','','pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query = "select p.* from prod p where p.id_prod = {$id}";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            mysqli_close($con);

            return $row;
        }

    }

?>