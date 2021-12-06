<?php

session_start();

require_once ('php/CreateDb.php');
require_once ('./php/component.php');


$database = new CreateDb("Productdb", "Producttb");

if (isset($_POST['add'])){
    if(isset($_SESSION['cart'])){

        $item_array_id = array_column($_SESSION['cart'], "product_id");

        if(in_array($_POST['product_id'], $item_array_id)){
            echo "<script>window.location = 'index.php'</script>";
        }else{

            $count = count($_SESSION['cart']);
            $item_array = array(
                'product_id' => $_POST['product_id']
            );

            $_SESSION['cart'][$count] = $item_array;
        }

    }else{

        $item_array = array(
                'product_id' => $_POST['product_id']
        );

        // Create new session variable
        $_SESSION['cart'][0] = $item_array;
        print_r($_SESSION['cart']);
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Shopping</title>
    <link rel="icon" href="icon.jpg">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <?php require_once ("php/header.php"); ?>
  <div class="container">
            <?php
                $counter=0;
                $result = $database->getData();
                while ($row = mysqli_fetch_assoc($result)){

                    if ($counter==4) {
                      echo ("<br>");
                      $counter=1;
                    }
                    else {
                      $counter=$counter+1;
                    }
                    component($row['product_name'], $row['product_price'], $row['product_image'], $row['id'], $row['product_category']);
                }
            ?>
  </div>
  <footer>
    <p>Creators: Maciej Lebkowski, Jakub Wolny, Dawid Prusiecki 3ipG</p>
  </footer>
</body>
</html>
