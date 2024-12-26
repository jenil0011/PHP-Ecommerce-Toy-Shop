<?php
error_reporting(0);

include '../components/connect.php';

session_start();

$staff_id = $_SESSION['staff_id'];

if(!isset($staff_id)){
   header('location:staff_login.php');
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/staff_header.php'; ?>


<section class="show-products">

   <h1 class="heading">products added</h1>

   <div class="box-container">

   <?php

      $query = "SELECT * FROM products";
      $select_products = mysqli_query($conn, $query);
            
      if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) { 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="price">Rs. <span><?= $fetch_products['price']; ?></span>/-</div>
      <div class="price"><span><?= $fetch_products['brand']; ?></span></div>
      <div class="details"><span><?= $fetch_products['details']; ?></span></div>
      
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>
   
   </div>

</section>


<script src="../js/admin_script.js"></script>
   
</body>
</html>