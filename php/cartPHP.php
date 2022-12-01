<?php
require './gateway/CartGateway.php';
session_start();
if(isset($_POST['cart']))
{
    $cartGateway = new CartGateway();
    $cartGateway->updateCart($_SESSION['idUser'], $_POST['idProd'], $_POST['cant']);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>