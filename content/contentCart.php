<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="./../css/product.css" />

</head>

<body style="background-color: #717171;">

<?php
if(isset($_SESSION['error'])){
?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <h3><?php echo $_SESSION['error']; ?></h3>
      <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
      </button>
  </div> 
<?php     
    unset($_SESSION['error']);
}

$cartGateway = new CartGateway();

$cart = $cartGateway->getCartByUserId($_SESSION['idUser']);

if(count($cart) == 0){
?>
  <div class="main-div">
    <div>
      <span style="color: red">
        <i class="fa-solid fa-7x fa-exclamation-triangle"></i>
      </span>
      <h1>Cosul este gol...</h1>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>
<?php
} else{ ?>
  <div style="margin-left: 20%;">
      <h2>Cos de cumparaturi</h3>
  </div>
  <hr>
  <br>
  <div class="container">
    <div class="row">
      <div class="col-sm-8">
        <div class="main-div">
          <ul class="list-group">
          <?php
          foreach($cart as $cartProduct){

            $likedStatus = "danger"; 
            if(!(isset($_SESSION['roles']) && count($_SESSION['roles']) > 0)){
                $disabled = "disabled"; 
            }
            else{
                $query="select * from user_prod where id_user = {$_SESSION['idUser']} and id_prod = {$cartProduct['id_prod']}";

                $result=mysqli_query($con,$query);
                $row = mysqli_fetch_assoc($result);
                if(!$row){
                    $likedStatus = "danger"; 
                }
                else{
                    $likedStatus = "secondary";
                }
                $disabled = "";
            }
          ?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <div class="container">
                <div class="row">
                  <div class="col-sm-2">
                    <img class="card-img-top my-image" src="data:image/<?php echo $cartProduct['imagine_content_type']; ?>;base64,<?php echo base64_encode($cartProduct['imagine']) ?>" 
                      alt="Card image cap" style="height: 12rem; width: auto">      
                  </div>
                  <div class="col-sm-6">
                    <button type="button" onclick="redirect(<?php echo $cartProduct['id_prod']; ?>)" style="border:none; background-color: white"><h3><?php echo $cartProduct['denumire'] ?></h3></button>
                    <h5><?php echo $cartProduct['producator'] ?></h5>
                    <h1><?php echo (float)$cartProduct['pret'] * (int)$cartProduct['cant'] ?></h1> RON
                  </div>
                  <div class="col-sm-2">
                    <form method="post" action="./../php/favPHP.php">
                        <button type="submit" name="fav" class="btn btn-<?php echo $likedStatus; ?>" <?php echo $disabled; ?> value="<?php echo $cartProduct['id_prod'].",_,".$cartProduct['denumire']; ?>">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        </button>
                    </form>
                  </div>
                  <div class="col-sm-2">
                    <div class="col-sm">
                        <form method="post" action="./../php/cartPHP.php">
                            <div class="input-group col-sm-10">
                                <div class="input-group-prepend">
                                    <input type="hidden" name="idProd" value="<?php echo $cartProduct['id_prod']; ?>"/>
                                    <button type="submit" name="cart" class="btn btn-info">
                                        <i class="fa fa-cart-plus" aria-hidden="true" style="color: white"></i>
                                    </button>
                                </div>
                                <input type="number" name="cant" min="0" max="<?php echo $cartProduct['stoc']; ?>" class="col-sm-10 form-control-sm" value="<?php echo ($cartProduct['cant'] != null) ? $cartProduct['cant'] : 0 ?>"/>
                            </div>
                        </form>
                    </div> 
                  </div>
                </div>  
              </div>
            </li>
          
          <?php } ?>
          </ul>
        </div>
      </div>
      <?php 
      
      require './../php/gateway/KeyValueGateway.php';

      $keyValueGateway = new KeyValueGateway();     
      
      $tva = $keyValueGateway->getValueByKey("tva");
      $transport = $keyValueGateway->getValueByKey("transport");
      $cartPrice = $cartGateway->getCartPrice($_SESSION['idUser']);
      $finalPrice = (float)$cartPrice + (float)$transport;
      ?>
      <div class="col-sm-4">
        <div class="parent">
          <h3>TVA: <?php echo $tva; ?> %</h3>
          <h3>Transport: <?php echo $transport; ?> RON</h3> 
          <hr>
          <h1>Pret total: <?php echo $finalPrice; ?> RON</h1>
          <br>
        </div>
      </div>
    </div>
  </div>
  <br><br><br>
  <div class="container">
    <div class="row">
      <div class="parent col-sm-10">
        <h2>Date de facturare</h2>
        <hr>
        <?php 
        require './../pojo/user.php';
        require './../php/gateway/UserGateway.php';
        $userGateway = new UserGateway(); 
        $user = $userGateway->getUserById($_SESSION['idUser']);
        ?>
        <div class="bottom-div">
          <form action="./../php/orderPHP.php" method="post">
            <div class="form-group">
              <label for="nume" class="col-form-label">Nume:</label>
              <input type="text" class="form-control" name="nume" id="nume">
              <label for="prenume" class="col-form-label">Prenume:</label>
              <input type="text" class="form-control" name="prenume" id="prenume">
              <label for="email" class="col-form-label">Email:</label>
              <input type="text" class="form-control" name="email" id="email" value="<?php echo $user->get_email(); ?>">
              <label for="adresa" class="col-form-label">Adresa:</label>
              <input type="text" class="form-control" name="adresa" id="adresa">
              <label for="nrTel" class="col-form-label">Telefon:</label>
              <input type="tel" class="form-control" name="nrTel" id="nrTel">
              <input type="hidden" name="idUser" id="idUser" value="<?php echo $_SESSION['idUser'] ?>">
              <input type="hidden" name="finalPrice" id="finalPrice" value="<?php echo $finalPrice ?>">
              <br>
              <button type="submit" name="order" class="btn btn-primary">Plaseaza comanda</button>
              <br>
            </div>
          </form>
          <br>
        </div>
      </div>
    </div>
  </div>  
<?php } ?>
<br><br><br>

<script>
  const redirect = (idProd) => {
    window.location.href = `./../pages/product.php?prod=${idProd}`;
  }
</script>
</body>  
</html> 