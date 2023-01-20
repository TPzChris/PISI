<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="./../css/account.css" />

<?php 
require './../php/alert.php';
require './../pojo/user.php';
$con=mysqli_connect('localhost','root','','tia_2_php');

if(!$con){
    die(' Please Check Your Connection');
}
$msg = "";
$page = "";
$row = null;
$query="select u.id_user, u.name, u.email from user u where u.id_user = {$_GET['id']}";

$result=mysqli_query($con,$query);

$row = mysqli_fetch_assoc($result);
$user = new User();
$user->set_id($row['id_user']);
$user->set_name($row['name']);
$user->set_email($row['email']); 

$query="select a.name from authority a, user_authority ua 
where ua.id_authority = a.id_authority
and ua.user_id = {$user->get_id()}";

$result=mysqli_query($con,$query);

$roles = array();
while($row = mysqli_fetch_assoc($result)){
  array_push($roles, $row['name']);
}

$user->set_roles($roles);
?>

</head>
<body style="background-color: #717171;">

<?php
require './../php/gateway/UserGateway.php';
$userGateway = new UserGateway();
if(!($_SESSION['idUser'] == $_GET['id'] || isset($_SESSION['roles']) && in_array("ROLE_SALES", $_SESSION['roles']))){
  $_SESSION['error'] = "Acces neautorizat";
}

if(!$userGateway->userExists($_GET['id'])){
  $_SESSION['error'] = "Utilizator inexistent";
}
?>

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
?>

  <div class="main-div">

   
      <div style="margin-left: 20%;">
          <h2><?php echo $user->get_name(); ?></h3>
      </div>
      <hr>
      <br>
      <div class="main-div">

        <div class="parent" style="margin-left: 10%; height: 20rem">
            <h1>E-mail: </h1><h2><?php echo $user->get_email(); ?></h2><br><br><br>
            <h1>Roluri: </h1>
            <button type="button" class="btn btn-warning" style="display: inline-block">User</button>
            <form method="post" action="./../php/changeRolePHP.php" style="display: inline-block">
              <input type="hidden" name="userId" value="<?php echo $user->get_id(); ?>">
              <button type="button submit" name="submitRoleChange" class="btn btn-<?php if(!in_array("ROLE_ADMIN", $user->get_roles())){ ?>outline-<?php } ?>primary" value="admin" <?php if(!in_array("ROLE_ADMIN", $user->get_roles())){ ?> disabled <?php } ?> >Admin</button>
            </form>
            <form method="post" action="./../php/changeRolePHP.php" style="display: inline-block">
              <input type="hidden" name="userId" value="<?php echo $user->get_id(); ?>">
              <button type="button submit" name="submitRoleChange" class="btn btn-<?php if(!in_array("ROLE_SALES", $user->get_roles())){ ?>outline-<?php } ?>success" value="sales" <?php if(!in_array("ROLE_ADMIN", $user->get_roles())){ ?> disabled <?php } ?> >Sales</button>
            </form>
        </div>         
      </div>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
      <?php
      mysqli_close($con);
      ?>
  </div>
  </body>

</html> 