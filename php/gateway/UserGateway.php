<?php 
    
    class UserGateway{
        
        public function getUserById($id){
            $con=mysqli_connect('localhost','root','','pisi');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query = "select u.id_user, u.name, u.email from user u where u.id_user = {$id}";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            $user = new User();
            $user->set_id($row['id_user']);
            $user->set_name($row['name']);
            $user->set_email($row['email']);

            $roles = array();
            $query = "select a.name as authority from authority a, user_authority ua where ua.user_id = {$id} and ua.id_authority = a.id_authority";
            $result = mysqli_query($con, $query);
            while($row = mysqli_fetch_assoc($result)){
                array_push($roles, $row['authority']);
            }

            $user->set_roles($roles);

            mysqli_close($con);

            return $user;
        }

    }

?>