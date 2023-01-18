<?php 
    
    class UserGateway{
        
        public function getUserById($id){
            $con=mysqli_connect('localhost','root','','tia_2_php');

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

        public function getRoles($idUser){

            $con=mysqli_connect('localhost','root','','tia_2_php');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query="select a.name from user_authority ua, authority a where ua.id_authority = a.id_authority and ua.user_id = {$idUser}";

            $result=mysqli_query($con, $query);

            $roles = array();

            while($row = mysqli_fetch_assoc($result))
            {
                array_push($roles, $row['name']);
                $flagOK = true;
            }
            
            mysqli_close($con);

            return $roles;
        }

        public function userExists($idUser){
            $con=mysqli_connect('localhost','root','','tia_2_php');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query = "select count(1) as count from user u where u.id_user = {$idUser}";
            $result = mysqli_query($con, $query);
            $row = mysqli_fetch_assoc($result);

            mysqli_close($con);

            return (int)$row['count'] > 0;
        }

        public function getUsers(){
            $con=mysqli_connect('localhost','root','','tia_2_php');

            if(!$con){
                die(' Please Check Your Connection');
            }

            $query = "select u.* from user u";
            $result = mysqli_query($con, $query);
            $users = array();
            while($row = mysqli_fetch_assoc($result)){
                $user = new User();
                $user->set_id($row['id_user']);
                $user->set_name($row['name']);
                $user->set_email($row['email']);
                array_push($users, $user);
            }


            foreach($users as $user){
                $roles = array();
                $query = "select a.name as authority from authority a, user_authority ua where ua.user_id = {$user->get_id()} and ua.id_authority = a.id_authority";
                $result = mysqli_query($con, $query);
                while($row = mysqli_fetch_assoc($result)){
                    array_push($roles, $row['authority']);
                }

                $user->set_roles($roles);
            }

            mysqli_close($con);

            return $users;
        }

    }

?>