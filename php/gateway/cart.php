
<?php
    class Cart{

        public function getCartByUserId($id){
            $con=mysqli_connect('localhost','root','','pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            

            mysqli_close($con);
        }

    }
?>