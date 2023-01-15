<?php

if(isset($_POST['searchProd'])){
    print_r($_POST);
    header("Location: ./../../pages/product.php?prod={$_POST['idProd']}");
}

?>