<link rel="stylesheet" type="text/css" href="./../css/header.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
<script src="./../js/header.js"></script>


<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
  
<?php
    require_once './../php/dto/OrderDTO.php';
    require_once './../pojo/order.php';
    require_once './../pojo/cart.php';
    require './../php/gateway/CartGateway.php';
    require_once './../php/gateway/OrderGateway.php';

?>


<div class="navbar-header">
    <a class="home" href="./../pages/home.php">Home</a>

    <div class="ui-widget" style="float: left; padding-left: 45%">
        <input id="tags"><i class="fa fa-search" aria-hidden="true" style="color: white;"></i>
    </div>
    

    <?php if(isset($_SESSION['roles']) && in_array("ROLE_USER", $_SESSION['roles'])){ ?>
    <div class="dropdown-header">
        
        <button class="dropbtn"><?php echo $_SESSION['user']; ?> 
            <i class="fa fa-caret-down"></i>
        </button>
        <div class="dropdown-content">
            <a href="./../pages/account.php?id=<?php echo $_SESSION['idUser']; ?>">Contul meu</a>
            <a href="./../pages/orders.php">Comenzile mele</a>
            <a href="./../php/logoutPHP.php">Logout</a>
        </div>
    </div> 

    <?php
    
    $cartGateway = new CartGateway();
    $cartNumber = $cartGateway->getCartNumber($_SESSION['idUser']);
    ?>

    
    <a id="shopBtn" class="fa-layers fa-fw"
        href="./../pages/cart.php">
        <i class="fas fa-cart-shopping" style="color:white; font-size: 24px"></i>
        <span class="fa-layers-counter"><?php echo $cartNumber; ?></span>
    </a>
    <?php } ?>
    <?php if(!isset($_SESSION['idUser'])){?>
    <a class="a-header" href="./../pages/login.php">Autentificare</a>
    <?php } ?>


    <?php if(isset($_SESSION['roles']) && in_array("ROLE_MARKETING", $_SESSION['roles'])){?>
    <a class="a-header" href="./../pages/statistics.php">Statistici</a>
    <?php } ?>
    <?php if(isset($_SESSION['roles']) && in_array("ROLE_ADMIN", $_SESSION['roles'])){?>
    <a class="a-header" href="./../pages/admin.php">Administrare conturi</a>
    <?php } ?>
    
</div>

<script>
    resp(document.getElementById("tags"));         
</script>

