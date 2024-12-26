<?php
error_reporting(0);
include '../components/connect.php';

session_start();

$staff_id = $_SESSION['staff_id'];

if(!isset($staff_id)){
   header('location:staff_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>placed orders</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/staff_header.php'; ?>

<section class="orders">

<h1 class="heading">placed orders</h1>

<div class="box-container">

   <?php
     
      $select_orders_query = "SELECT * FROM `orders`";
      $select_orders_result = mysqli_query($conn, $select_orders_query);
         
            if (mysqli_num_rows($select_orders_result) > 0) {
               while ($fetch_orders = mysqli_fetch_assoc($select_orders_result)) {   
   ?>
   <div class="box">
      <p> placed on : <span><?= $fetch_orders['placed_on']; ?></span> </p>
      <p> name : <span><?= $fetch_orders['name']; ?></span> </p>
      <p> number : <span><?= $fetch_orders['number']; ?></span> </p>
      <p> address : <span><?= $fetch_orders['address']; ?></span> </p>
      <p> total products : <span><?= $fetch_orders['total_products']; ?></span> </p>
      <p> total price : <span>Rs. <?= $fetch_orders['total_price']; ?>/-</span> </p>
      <p> payment method : <span><?= $fetch_orders['method']; ?></span> </p>
      <form action="" method="post">
         <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
      </form>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no orders placed yet!</p>';
      }
   ?>

</div>

</section>

</section>


<script src="../js/admin_script.js"></script>
   
</body>
</html>