<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="./../css/admin.css" />

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
$query="select u.id_user, u.name, u.email from user u";

$result=mysqli_query($con,$query);

$users = array();
while($row = mysqli_fetch_assoc($result)){
    $user = new User();
    $user->set_id($row['id_user']);
    $user->set_name($row['name']);
    $user->set_email($row['email']); 
    array_push($users, $user);
}

foreach($users as $user){
  $query="select a.name from authority a, user_authority ua 
  where ua.id_authority = a.id_authority
  and ua.user_id = {$user->get_id()}";

  $result=mysqli_query($con,$query);

  $roles = array();
  while($row = mysqli_fetch_assoc($result)){
    array_push($roles, $row['name']);
  }

  $user->set_roles($roles);
}


?>

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
?>

  <div class="main-div">

    <?php if(!(isset($_SESSION['roles']) && in_array("ROLE_ADMIN", $_SESSION['roles']))){ ?>

      <div>
        <span style="color: red">
          <i class="fa-solid fa-7x fa-exclamation-triangle"></i>
        </span>
        <h1>Oops...</h1>
      </div>
      <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

    <?php }else{ ?>

      <div style="margin-left: 20%;">
          <h2>Utilizatori</h3>
      </div>
      <hr>
      <br>
      <div class="main-div">

        <?php foreach($users as $user){ ?>
          
          <div class="card w-100" style="width: 20rem;">
            <div class="card-body">
              <h2 class="card-title"><a href="./../pages/account.php?id=<?php echo $user->get_id(); ?>" style="text-decoration: none; color: inherit;"><?php echo $user->get_name(); ?></a></h2>
              <p class="card-text"><?php echo $user->get_email(); ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
              <button type="button" class="btn btn-warning" style="display: inline-block">User</button>
              <form method="post" action="./../php/changeRolePHP.php" style="display: inline-block">
                <input type="hidden" name="userId" value="<?php echo $user->get_id(); ?>">
                <button type="button submit" name="submitRoleChange" class="btn btn-<?php if(!in_array("ROLE_ADMIN", $user->get_roles())){ ?>outline-<?php } ?>primary" value="admin">Admin</button>
              </form>
              <form method="post" action="./../php/changeRolePHP.php" style="display: inline-block">
                <input type="hidden" name="userId" value="<?php echo $user->get_id(); ?>">
                <button type="button submit" name="submitRoleChange" class="btn btn-<?php if(!in_array("ROLE_SALES", $user->get_roles())){ ?>outline-<?php } ?>success" value="sales">Sales</button>
              </form>
            </div>
          </div>
        
        <?php } ?>

          
      </div>
          <br><br><br>
      <?php
      }
      mysqli_close($con);
      ?>
  </div>
  </body>

</html> 