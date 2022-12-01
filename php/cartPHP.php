<?php
session_start();
if(isset($_POST['cart']))
{
    require './gateway/CartGateway.php';
    $cartGateway = new CartGateway();
    $cartGateway->updateCart($_SESSION['idUser'], $_POST['idProd'], $_POST['cant']);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>