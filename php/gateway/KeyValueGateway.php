<?php

    class KeyValueGateway{

        public function getValueByKey($key){
            $con=mysqli_connect('localhost','root','','tia_2_php');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query = "select kv.val as val from key_value kv where upper(kv.key) = upper('{$key}')";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            mysqli_close($con);

            return $row['val'];
        }

    }

?>