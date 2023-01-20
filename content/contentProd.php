<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="./../css/product.css" />


<script>

let showImageInsert = (event) => {
    var image = document.getElementById('imageProd');
	image.src = URL.createObjectURL(event.target.files[0]);
    image.value = URL.createObjectURL(event.target.files[0]);
    document.getElementById('imgTypeProd').value= event.target.files[0].type;
    console.table(document.getElementById('imgFileProd'));
}

let showImageUpdate = (event, idProd) => {
    var image = document.getElementById('imageProdUpdate_' + idProd);
	image.src = URL.createObjectURL(event.target.files[0]);
    image.value = URL.createObjectURL(event.target.files[0]);
    document.getElementById('imgTypeProdUpdate_' + idProd).value= event.target.files[0].type;
    console.table(document.getElementById('imgFileProdUpdate_' + idProd));
}

</script>

<?php 
require './../php/alert.php';
$con=mysqli_connect('localhost','root','','tia_2_php');

if(!$con){
    die(' Please Check Your Connection');
}
$msg = "";
$page = "";
$row = null;
if(isset($_GET['prod']))
{


    if(isset($_SESSION['idUser'])){
        $extraQuery = ", (select ifnull(c.cant, 0) from cart c where c.id_prod = p.id_prod and c.id_user = {$_SESSION['idUser']} and c.id_order is null) as cant";
    }
    else{
        $extraQuery = " ";
    }

    $query="select p.*".
            $extraQuery
            ." from prod p where p.id_prod = {$_GET['prod']} and p.hidden <> 1 ";

    $result=mysqli_query($con,$query);

    $row = mysqli_fetch_assoc($result);


    $query = "select den from categ where id_categ = (select categ_id from prod where id_prod = '{$_GET['prod']}')";

    $result=mysqli_query($con,$query);

    $categ = mysqli_fetch_assoc($result)['den'];
    
}
?>


<?php
  $likedStatus = "danger"; 
  if(!(isset($_SESSION['roles']) && count($_SESSION['roles']) > 0)){
      $disabled = "disabled"; 
  }
  else{
      $query="select * from user_prod where id_user = {$_SESSION['idUser']} and id_prod = {$row['id_prod']}";

      $result=mysqli_query($con,$query);
      $row1 = mysqli_fetch_assoc($result);
      if(!$row1){
          $likedStatus = "danger"; 
      }
      else{
          $likedStatus = "secondary";
      }
      $disabled = "";
  }

?>

</head>
<body style="background-color: #717171;">


<div class="main-div">

<?php if(!$row){ ?>

  <div>
    <span style="color: red">
      <i class="fa-solid fa-7x fa-exclamation-triangle"></i>
    </span>
    <h1>Produsul căutat nu există...</h1>
  </div>
  <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php }else{ ?>

  <div style="margin-left: 20%;">
      <h2><?php echo $row['denumire']; ?></h3>
  </div>

  <div class="parent">
    <hr>
    <div class="left-div">
      <img class="card-img-top my-image" src="data:image/<?php echo $row['imagine_content_type']; ?>;base64,<?php echo base64_encode($row['imagine']) ?>" alt="Card image cap" style="height: 30rem; width: auto">
    </div>
    <div class="right-div">
      <h3>Producător: <?php echo $row['producator']; ?></h3>
      <h3>Preț: <?php echo $row['pret']; ?> RON</h3> 
      <h3>Stoc: <?php echo $row['stoc']; ?></h3>
      <h3>Data apariției: <?php echo $row['data_aparitiei']; ?></h3>
    </div>
    <div class="bottom-div">
        <hr>
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <form method="post" action="./../php/favPHP.php">
                        <button type="submit" name="fav" class="btn btn-<?php echo $likedStatus; ?>" <?php echo $disabled; ?> value="<?php echo $row['id_prod'].",_,".$row['denumire']; ?>">
                            <i class="fa fa-heart" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
                <div class="col-sm-2">
                    <?php if(isset($_SESSION['roles']) && count($_SESSION['roles']) > 0){ ?>
                    <div class="col-sm">
                        <form method="post" action="./../php/cartPHP.php">
                            <div class="input-group col-sm-10">
                                <div class="input-group-prepend">
                                    <input type="hidden" name="idProd" value="<?php echo $row['id_prod']; ?>"/>
                                    <button type="submit" name="cart" class="btn btn-info">
                                        <i class="fa fa-cart-plus" aria-hidden="true" style="color: white"></i>
                                    </button>
                                </div>
                                <input type="number" name="cant" min="0" max="<?php echo $row['stoc']; ?>" class="col-sm-10 form-control-sm" value="<?php echo ($row['cant'] != null) ? $row['cant'] : 0 ?>"/>
                            </div>
                        </form>
                    </div> 
                    <?php } ?> 
                </div>
            </div>
            <br>
            <?php if(isset($_SESSION['roles']) && in_array("ROLE_ADMIN", $_SESSION['roles'])){?>
            <div class="row">
                <div class="col-sm-2">    
                    <button type="submit" name="delete" class="btn btn-danger" value="<?php echo $prod['id_prod']; ?>" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="fa fa-x" aria-hidden="true"></i>
                    </button>
                </div>
                <div class="col-sm-2">  
                    <button type="submit" name="update" class="btn btn-primary" value="<?php echo $prod['id_prod']; ?>" data-bs-toggle="modal" data-bs-target="#updateModal">
                        <i class="fa fa-refresh" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            <?php } ?>
      <h2>Descriere: <?php echo $row['descriere']; ?></h2>
    </div>
    
  </div>

  <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Modificare produs</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <form action="./../php/updateProdPHP.php" method="post" enctype="multipart/form-data">
                  <div class="modal-body">
                      <div class="form-group">
                          <label for="denProd" class="col-form-label">Denumire:</label>
                          <input type="text" class="form-control" name="updateProdDen" id="denProd" value="<?php echo $row['denumire']; ?>">
                          <label for="prodProd" class="col-form-label">Producător:</label>
                          <input type="text" class="form-control" name="updateProdProd" id="prodProd" value="<?php echo $row['producator']; ?>">
                          <label for="stocProd" class="col-form-label">Stoc:</label>
                          <input type="number" min="0" max="100" class="form-control" name="updateProdStoc" id="stocProd" value="<?php echo $row['stoc']; ?>">
                          <label for="pretProd" class="col-form-label">Preț:</label>
                          <input type="number" step="any" min="0" class="form-control" name="updateProdPret" id="pretProd" value="<?php echo $row['pret']; ?>">
                          <label for="dataProd" class="col-form-label">Data apariției:</label>
                          <input type="date" class="form-control" name="updateProdData" id="dataProd" value="<?php echo $row['data_aparitiei']; ?>">
                          <label for="imageProd" class="col-form-label">Imagine:</label>
                          <input type="file" class="col-form-btn" name="updateProdImgFile" id="imgFileProdUpdate_<?php echo $row['id_prod']; ?>" onchange="showImageUpdate(event, <?php echo $row['id_prod']; ?>)">
                          <input type="image" class="form-control" name="updateProdImg" id="imageProdUpdate_<?php echo $row['id_prod']; ?>" src="data:image/<?php echo $row['imagine_content_type']; ?>;base64,<?php echo base64_encode($row['imagine']) ?>">
                          <label for="descProd" class="col-form-label">Descriere:</label>
                          <input type="text" class="form-control" name="updateProdDesc" id="descProd" value="<?php echo $row['descriere']; ?>">
                          <input type="hidden" name="updateProdId" value="<?php echo $row['id_prod']; ?>">
                          <input type="hidden" name="updateProdImgType" id="imgTypeProdUpdate_<?php echo $row['id_prod']; ?>" value="<?php echo $row['imagine_content_type']; ?>">
                          <input type="hidden" name="updateProdCateg" id="categProd" value="<?php echo $categ ?>">
                      </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Anulează</button>
                      <button type="submit button" class="btn btn-primary" name="submitUpdateFromProdPage">Confirmă</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title">Ștergere produs</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <p>Sigur dorești să ștergi produsul cu denumirea <span style="color: red"><?php echo $row['denumire']; ?></span>? </p>
              </div>
              <div class="modal-footer">
                  <form method="post" action="./../php/deleteProdPHP.php">
                      <input type="hidden" name="deleteProdId" value="<?php echo $row['id_prod']; ?>">
                      <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Anulare</button>
                      <button type="button submit" name="submitDeleteFromProdPage" class="btn btn-danger">Confirm</button>
                  </form>
              </div>
          </div>
      </div>
  </div>

<?php } 
mysqli_close($con);
?>

</div>
  

</body>

</html> 