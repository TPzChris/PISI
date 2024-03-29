<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="./../css/product.css" />

</head>

<body style="background-color: #717171;">

<?php
require './../php/gateway/UserGateway.php';
require './../pojo/user.php';
$userGateway = new UserGateway();
if(!(!isset($_SESSION['roles']) || isset($_SESSION['roles']) && in_array("ROLE_SALES", $_SESSION['roles']))){
  $_SESSION['error'] = "Acces neautorizat";
}
?>



<?php
if(isset($_SESSION['error'])){
?>
  <div class="alert alert-danger alert fade show" role="alert">
      <h3><?php echo $_SESSION['error']; ?></h3>
  </div> 
<?php     
}
?>

<?php
if(isset($_SESSION['error'])){
?>
  <div class="main-div">
    <div>
      <span style="color: red">
        <i class="fa-solid fa-7x fa-exclamation-triangle"></i>
      </span>
      <h1><?php echo $_SESSION['error']; ?></h1>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
  </div>
<?php
  unset($_SESSION['error']);
} else{ ?>
<div class="container" style="min-height: 15rem;">
  <div class="row">
    <div class="parent col-sm-10" style="min-height: 15rem;">
      <h2>Utilizatori</h2>
      <?php 
      foreach($userGateway->getUsers() as $index=>$user){ 
        $colour = ($index % 2) ? "white" : "secondary";  
      ?>
      <nav class="navbar navbar-<?php echo $colour; ?> bg-<?php echo $colour; ?>">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent_<?php echo $user->get_id(); ?>" aria-controls="navbarToggleExternalContent_<?php echo $user->get_id(); ?>" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span><?php echo $user->get_name(); ?>
          </button>
          <div style="justify-content: right">
            <?php foreach($user->get_roles() as $role){
              $roleColour = "";
              $roleText = "";
              switch($role){
                case "ROLE_USER":
                  $roleColour = "warning";
                  $roleText = "User";
                  break;
                case "ROLE_ADMIN":
                  $roleColour = "primary";
                  $roleText = "Admin";
                  break;
                case "ROLE_SALES":
                  $roleColour = "success";
                  $roleText = "Sales";
                  break;
              }
            ?>
            <span class="badge text-bg-<?php echo $roleColour; ?>"><?php echo $roleText; ?></span>
            <?php } ?>
          </div>
        </div>
      </nav>
      <div class="collapse" id="navbarToggleExternalContent_<?php echo $user->get_id(); ?>">
        <div class="bg-<?php echo $colour; ?> p-4">
        <a class="btn btn-primary" type="button" href="./../pages/account.php?id=<?php echo $user->get_id(); ?>">
          Vezi cont
        </a>
        <a class="btn btn-info" type="button" href="./../pages/orders.php?id=<?php echo $user->get_id(); ?>">
          Vezi comenzi
        </a>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
<?php } ?>
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