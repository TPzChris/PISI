<?php 

    require './../gateway/CartGateway.php';
    require './../gateway/OrderGateway.php';

    class OrderFacade{

        public function createOrder(OrderDTO $orderDTO, $idUser){

            $cartGateway = new CartGateway();
            $orderGateway = new OrderGateway();

            $orderGateway->insertOrder($orderDTO);

            $order = $orderGateway->findLatestOrder();

            $cartGateway->updateCartOrder($order->get_idOrder(), $idUser);

        }

    }

?>