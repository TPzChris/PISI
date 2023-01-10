<?php 

    class MailUtil{
        
        public function sendOrderConfirmationMail($to, $subject, $idOrder){
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: "E-Mail Administrator" <postmaster@localhost>' . "\r\n";
            
            //$headers .= "Content-Type: multipart/mixed;" . "\r\n";

            $cartGateway = new CartGateway();

            $cart = $cartGateway->getCartByUserId($_SESSION['idUser']);

            $orderGateway = new OrderGateway();

            $order = $orderGateway->findById($idOrder);

            $finalContent = "";
            
            foreach($cart as $cartProd){

                // $img = base64_encode($cartProd['imagine']);
                // $attchmentName  = "attachment_".$cartProd['id_prod'];
                

                
                $price = (float)$cartProd['pret'] * (int)$cartProd['cant'];
                //$imgSrc = "data:image/{$cartProd['imagine_content_type']};base64,{$img}";
                //echo $imgSrc;
                //<img class="card-img-top my-image" src="cid:{$attchmentName}" alt="Card image cap" style="height: 12rem; width: auto">
                $content = <<<END
                    <hr>
                    <div class="row rows-search">
                        <div class="col-sm-4">
                            <h1>{$price} RON</h1>
                        </div>
                        <div class="col-sm-8">
                            <h3>{$cartProd['denumire']}</h3>
                            <h5>{$cartProd['producator']}</h5>
                        </div> 
                    </div>            
END;

                // $attachment    = chunk_split($img);
                // $boundary      = "PHP-mixed-".md5(time());
                // $boundWithPre  = "\n--".$boundary;
                // $content .= $boundWithPre;
                // $content .= "\nContent-Type: image/jpeg; name=\"".$attchmentName."\"";
                // $content .= "\nContent-Transfer-Encoding: base64\n";
                // $content .= "\nContent-Disposition: inline;\n";
                // $content .= "\nContent-ID: <".$attchmentName.">\n";
                // $content .= $attachment;
                // $content .= $boundWithPre."--";

                $finalContent .= $content;
            }

            $keyValueGateway = new KeyValueGateway();     
      
            $delivery = $keyValueGateway->getValueByKey("transport");

            $message = <<<EOT
                    <html>
                        <head>
                            <title>Comanda plasata cu succes!</title>
                            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
                            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
                            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
                        </head>
                        <body>
                            <style>
                                .rows-search > div:nth-child(even) {
                                    background-color: #e4ff85;
                                }
                                
                                .rows-search > div:nth-child(odd) {
                                    background-color: white;
                                }
                                
                                .search-light-grey {
                                    color: darkgray;
                                }
                            </style>

                            <h3>Comanda plasata cu succes!</h3>
                            <div class="container search-light-grey">
                                {$finalContent}
                            </div>
                            <br><hr>
                            <div class="container">
                                <div class="row">
                                    <h4>Transport: {$delivery}</h4>
                                    <h3>Pret final: {$order->get_cost()}</h3>
                                </div>
                            </div>
                        </body>
                    </html>
EOT;

            $mail = mail($to, $subject, $message, $headers);

            return $mail;
        }
    }

?>