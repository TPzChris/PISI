<?php 
require 'alert.php';
$con=mysqli_connect('localhost','root','','pisi');

if(!$con){
    die(' Please Check Your Connection');
}
$msg = "";
$page = "";
session_start();
if(isset($_GET['prods']) && $_GET['prods'] == 'display')
{
    $query="select id_prod, denumire from prod where hidden <> 1";
    
    $result=mysqli_query($con,$query);

    $res = array();

    while($row = mysqli_fetch_assoc($result))
    {
        array_push($res, $row);
    }

    echo json_encode($res);
    
    mysqli_close($con);
}

