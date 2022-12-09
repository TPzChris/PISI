<?php
session_start();
if(isset($_POST['order']))
{
    
    require './facade/OrderFacade.php';
    require './../pojo/order.php';
    require './dto/OrderDTO.php';
    $orderFacade = new OrderFacade();

    $order = new Order();
    $order->set_lastName($_POST['nume']);
    $order->set_firstName($_POST['prenume']);
    $order->set_email($_POST['email']);
    $order->set_address($_POST['adresa']);
    $order->set_phoneNo($_POST['nrTel']);
    $order->set_cost($_POST['finalPrice']);

    $orderDTO = new OrderDTO();
    $orderDTO->fromOrderToOrderDTO($order);

    $orderFacade->createOrder($orderDTO, $_POST['idUser']);
    
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>