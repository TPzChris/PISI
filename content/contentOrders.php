<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="./../css/product.css" />

</head>

<body style="background-color: #717171;">

<?php
if(isset($_SESSION['error'])){
?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <h3><?php echo $_SESSION['error']; ?></h3>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div> 
<?php     
    unset($_SESSION['error']);
}
?>

<?php 
require_once(__DIR__.'/../php/facade/OrderFacade.php');
require_once(__DIR__.'/../php/gateway/ProdGateway.php');
$orderFacade = new OrderFacade();
$prodGateway = new ProdGateway();
$orders = $orderFacade->getOrders($_SESSION['idUser']);
?>


<div class="container" style="min-height: 15rem;">
  <div class="row">
    <div class="parent col-sm-10" style="min-height: 15rem;">
      <h2>Comenzi</h2>

      <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item active"><a class="nav-link active" data-toggle="tab" href="#ongoing">Comenzi Active</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#finalized">Comenzi Finalizate</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#canceled">Comenzi Anulate</a></li>
      </ul>

      <div class="tab-content">
        <div id="ongoing" class="tab-pane fade in show active">
          <?php foreach($orders->get_ongoingArray() as $activeOrder){?>  
          <br>
          <div class="card" style="width: 100%;">
            <div class="card-body">
              <h5 class="card-title">Comanda #<?php echo $activeOrder->get_idOrder(); ?></h5>
              <p class="card-text">Pret final: <?php echo $activeOrder->get_cost(); ?></p>
              <div class="container text-center">
                <div class="row">
                  <div class="col">
                    <h4><span class="badge bg-warning">Activa</span></h4>
                  </div>
                  <div class="col">
                  <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling_<?php echo $activeOrder->get_idOrder(); ?>" aria-controls="offcanvasScrolling">Produse</button>
                  </div>
                  <div class="col">
                    <form method="post" action="./../php/cancelOrderPHP.php">
                      <input type="hidden" name="idOrder" value="<?php echo $activeOrder->get_idOrder(); ?>" >
                      <button class="btn btn-danger" type="submit" name="cancelOrder">Anuleaza comanda</button>
                    </form>
                  </div>
                </div> 
              </div>
              <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling_<?php echo $activeOrder->get_idOrder(); ?>" aria-labelledby="offcanvasScrollingLabel">
                <div class="offcanvas-header">
                  <h2 class="offcanvas-title" id="offcanvasScrollingLabel_<?php echo $activeOrder->get_idOrder(); ?>">Comanda #<?php echo $activeOrder->get_idOrder(); ?></h2>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <?php foreach($activeOrder->get_cartElements() as $cartElements){
                    $prod = $prodGateway->getProdById($cartElements->get_idProd());
                  ?>
                  <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="data:image/<?php echo $prod['imagine_content_type']; ?>;base64,<?php echo base64_encode($prod['imagine']) ?>" class="img-fluid rounded-start" alt="Prod_<?php echo $cartElements->get_idOrder(); ?>">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title"><?php echo $prod['denumire']; ?></h5>
                          <p class="card-text">x<?php echo $cartElements->get_cant(); ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>

            </div>
          </div>
          <br>
          <?php } ?>
        </div>
        <div id="finalized" class="tab-pane fade">
          <?php foreach($orders->get_finalizedArray() as $finalizedOrder){?>  
          <br>
          <div class="card" style="width: 100%;">
            <div class="card-body">
              <h5 class="card-title">Comanda #<?php echo $finalizedOrder->get_idOrder(); ?></h5>
              <p class="card-text">Pret final: <?php echo $finalizedOrder->get_cost(); ?></p>
              <div class="container text-center">
                <div class="row">
                  <div class="col">
                    <h4><span class="badge bg-success">Finalizata</span></h4>
                  </div>
                  <div class="col">
                    <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling_<?php echo $finalizedOrder->get_idOrder(); ?>" aria-controls="offcanvasScrolling">Produse</button>
                  </div>
                </div>
              </div>
              <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling_<?php echo $finalizedOrder->get_idOrder(); ?>" aria-labelledby="offcanvasScrollingLabel">
                <div class="offcanvas-header">
                  <h2 class="offcanvas-title" id="offcanvasScrollingLabel_<?php echo $finalizedOrder->get_idOrder(); ?>">Comanda #<?php echo $finalizedOrder->get_idOrder(); ?></h2>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <?php foreach($finalizedOrder->get_cartElements() as $cartElements){
                    $prod = $prodGateway->getProdById($cartElements->get_idProd());
                  ?>
                  <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="data:image/<?php echo $prod['imagine_content_type']; ?>;base64,<?php echo base64_encode($prod['imagine']) ?>" class="img-fluid rounded-start" alt="Prod_<?php echo $cartElements->get_idOrder(); ?>">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title"><?php echo $prod['denumire']; ?></h5>
                          <p class="card-text">x<?php echo $cartElements->get_cant(); ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>

            </div>
          </div>
          <br>
          <?php } ?>
        </div>
        <div id="canceled" class="tab-pane fade">
          <?php foreach($orders->get_canceledArray() as $canceledOrder){?> 
          <br>
          <div class="card" style="width: 100%;">
            <div class="card-body">
              <h5 class="card-title">Comanda #<?php echo $canceledOrder->get_idOrder(); ?></h5>
              <p class="card-text">Pret final: <?php echo $canceledOrder->get_cost(); ?></p>
              <h4><span class="badge bg-danger">Anulata</span></h4>
              <button class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling_<?php echo $canceledOrder->get_idOrder(); ?>" aria-controls="offcanvasScrolling">Produse</button>
              <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling_<?php echo $canceledOrder->get_idOrder(); ?>" aria-labelledby="offcanvasScrollingLabel">
                <div class="offcanvas-header">
                  <h2 class="offcanvas-title" id="offcanvasScrollingLabel_<?php echo $canceledOrder->get_idOrder(); ?>">Comanda #<?php echo $canceledOrder->get_idOrder(); ?></h2>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                  <?php foreach($canceledOrder->get_cartElements() as $cartElements){
                    $prod = $prodGateway->getProdById($cartElements->get_idProd());
                  ?>
                  <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                      <div class="col-md-4">
                        <img src="data:image/<?php echo $prod['imagine_content_type']; ?>;base64,<?php echo base64_encode($prod['imagine']) ?>" class="img-fluid rounded-start" alt="Prod_<?php echo $cartElements->get_idOrder(); ?>">
                      </div>
                      <div class="col-md-8">
                        <div class="card-body">
                          <h5 class="card-title"><?php echo $prod['denumire']; ?></h5>
                          <p class="card-text">x<?php echo $cartElements->get_cant(); ?></p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>

            </div>
          </div>
          <br>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
<br><br>
</body>  
</html> 