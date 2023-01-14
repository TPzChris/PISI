<?php
session_start();
if(isset($_POST['cancelOrder']))
{
    require './gateway/OrderGateway.php';
    $orderGateway = new OrderGateway();
    $orderGateway->updateOrderStatus($_POST['idOrder'], "canceled");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

if(isset($_POST['finalizeOrder']))
{
    require './gateway/OrderGateway.php';
    $orderGateway = new OrderGateway();
    $orderGateway->updateOrderStatus($_POST['idOrder'], "finalized");
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>