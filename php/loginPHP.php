<?php 
require 'alert.php';
require './../php/gateway/UserGateway.php';
$con=mysqli_connect('localhost','root','','tia_2_php');

if(!$con){
    die(' Please Check Your Connection');
}
$msg = "";
$page = "";
session_start();
if(isset($_POST['Login']))
{

    $flagOK = false;

    $query="select * from user where name='".$_POST['username']."' and pass='".$_POST['password']."'";
    
    $result=mysqli_query($con,$query);

    if($row = mysqli_fetch_assoc($result))
    {
        $_SESSION['idUser'] = $row['id_user'];
        $_SESSION['user'] = $_POST['username'];
        $flagOK = true;
    }
    else
    {
        $msg = "Utilizator inexistent";
        $page = "./../pages/login.php?Invalid=Failed-Auth";
        phpAlert($msg, $page);
    }

    $userGateway = new UserGateway();

    $_SESSION['roles'] = $userGateway->getRoles($_SESSION['idUser']);
    

    if($flagOK){
        header("location:./../pages/home.php");
    }

}
else{
    
    $msg = "Eroare";
    $page = "./../pages/login.php?Invalid=Error";
    phpAlert($msg, $page);
}
