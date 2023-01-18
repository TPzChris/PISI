<link rel="stylesheet" type="text/css" href="./../css/header.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
<script src="./../js/header.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


  
<?php
    require_once './../php/dto/OrderDTO.php';
    require_once './../pojo/order.php';
    require_once './../pojo/cart.php';
    require './../php/gateway/CartGateway.php';
    require_once './../php/gateway/OrderGateway.php';

?>

<nav class="navbar navbar-dark bg-dark fixed-top d-flex">
  <div class="container-fluid">
    <a class="navbar-brand" href="./../pages/home.php">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Meniu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
            <form class="d-flex mt-3" role="search" action="./../php/prodRedirectPHP.php" method="post">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" id="tags" list="prods" name="tags">
                <input type="hidden" name="idProd" id="idProd">
                <datalist id="prods" name="prods">
                </datalist>
                <button class="btn btn-success" type="submit" name="searchProd">Cauta</button>
            </form>
            </li>
            <?php
            
            $cartGateway = new CartGateway();
            $cartNumber = isset($_SESSION['idUser']) ? $cartGateway->getCartNumber($_SESSION['idUser']) : 0;
            ?>
            <li class="nav-item">
                <?php if(isset($_SESSION['idUser'])){?>
                <a id="shopBtn" class="dropdown-item" href="./../pages/cart.php">
                    <i class="fas fa-cart-shopping" style="color:white; font-size: 24px"></i>
                    <span class="fa-layers-counter"><?php echo $cartNumber; ?></span>
                </a>
                <?php }else{ ?>
                <a class="dropdown-item" type="button" class="btn btn-lg btn-danger" data-bs-placement="left" data-bs-toggle="popover" data-bs-title="Acces nepermis" data-bs-content="Trebuie sa va autentificati pentru a accesa aceasta pagina">
                    <i class="fas fa-cart-shopping" style="color:white; font-size: 24px"></i>
                    <span class="fa-layers-counter"><?php echo $cartNumber; ?></span>
                </a>
                <?php } ?>
            </li>
            <?php if(!isset($_SESSION['idUser'])){?>
            <li class="nav-item">
                <a class="dropdown-item" href="./../pages/login.php">Autentificare</a>
            </li>
            <?php } ?>
            <?php if(isset($_SESSION['roles']) && in_array("ROLE_MARKETING", $_SESSION['roles'])){?>
            <li class="nav-item">
                <a class="dropdown-item" href="./../pages/statistics.php">Statistici</a>
            </li>
            <?php } ?>
            <?php if(isset($_SESSION['roles']) && in_array("ROLE_ADMIN", $_SESSION['roles'])){?>
            <li class="nav-item">
                <a class="dropdown-item" href="./../pages/admin.php">Administrare conturi</a>
            </li>
            <?php } ?>
            <?php if(isset($_SESSION['roles']) && in_array("ROLE_SALES", $_SESSION['roles'])){?>
            <li class="nav-item">
                <a class="dropdown-item" href="./../pages/adminOrders.php">Administrare comenzi</a>
            </li>
            <?php } ?>
            <?php if(isset($_SESSION['roles']) && in_array("ROLE_USER", $_SESSION['roles'])){ ?>
            <li class="nav-item">
                <a class="dropdown-item" href="./../pages/account.php?id=<?php echo $_SESSION['idUser']; ?>">Contul meu</a>
            </li>
            <li>
                <a class="dropdown-item" href="./../pages/orders.php?id=<?php echo $_SESSION['idUser']; ?>">Comenzile mele</a>
            </li>
            <li>
                <hr class="divider">
            </li>
            <li>
                <a class="dropdown-item" href="./../php/logoutPHP.php">Logout</a>
            </li>
            <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</nav>

<script>
    resp(document.getElementById("prods")); 
    $('#tags').on('input', function() {
        const value = $(this).val();
        const data_value = $('#prods [value="' + value + '"]').data('value');
        document.getElementById("idProd").value = data_value;
    });     

    
</script>

<script>
    $(document).ready(function(){
        const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
        const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))
    })
</script> 

