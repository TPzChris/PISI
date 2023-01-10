<?php 

    require_once(__DIR__.'/../gateway/CartGateway.php');
    require_once(__DIR__.'/../gateway/OrderGateway.php');
    require_once(__DIR__.'/../gateway/KeyValueGateway.php');
    require_once(__DIR__.'/../../utils/mail.php');

    class OrderFacade{

        public function createOrder(OrderDTO $orderDTO, $idUser){

            $cartGateway = new CartGateway();
            $orderGateway = new OrderGateway();
            $mailUtil = new MailUtil();

            $orderGateway->insertOrder($orderDTO);

            $order = $orderGateway->findLatestOrder();

            $mailResult = $mailUtil->sendOrderConfirmationMail($order->get_email(), "Order confirmation", $order->get_idOrder());

            $cartGateway->updateCartOrder($order->get_idOrder(), $idUser);

            echo $mailResult;

        }

    }

?>