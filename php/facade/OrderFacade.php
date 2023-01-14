<?php 

    require_once(__DIR__.'/../gateway/CartGateway.php');
    require_once(__DIR__.'/../gateway/OrderGateway.php');
    require_once(__DIR__.'/../gateway/KeyValueGateway.php');
    require_once(__DIR__.'/../../utils/mail.php');
    require_once('../php/dto/OrdersByTypeDTO.php');
    require_once('../php/dto/CartDTO.php');

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

        public function getOrders($idUser){
            $cartGateway = new CartGateway();
            $orderGateway = new OrderGateway();
            $finalizedOrders = array();
            $ongoingOrders = array();
            $canceledOrders = array();

            $orders = array();
            $orders = $orderGateway->findOrdersOfUser($idUser);

            foreach($orders as $order){
                $cartElements = $cartGateway->getCartElementsOfOrder($order->get_idOrder());
                $order->set_cartElements($cartElements);
                switch($order->get_status()){
                    case "finalized":
                        array_push($finalizedOrders, $order);
                        break;
                    case "active":
                        array_push($ongoingOrders, $order);
                        break;
                    case "canceled":
                        array_push($canceledOrders, $order);
                        break;
                }
            }

            $ordersByTypeDTO = new OrdersByTypeDTO($ongoingOrders, $finalizedOrders, $canceledOrders);

            return $ordersByTypeDTO;
        }

    }

?>