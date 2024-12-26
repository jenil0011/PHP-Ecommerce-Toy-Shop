<?php
error_reporting(0);
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update_payment'])){
   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $payment_status = mysqli_real_escape_string($conn, $payment_status); // Escaping to prevent SQL injection
   
   $update_query = "UPDATE `orders` SET payment_status = '$payment_status' WHERE id = $order_id";
   $update_result = mysqli_query($conn, $update_query);

   if ($update_result) {
       $message[] = 'Payment status updated!';
   } else {
       $message[] = 'Error updating payment status: ' . mysqli_error($conn);
   }
}

// Delete Order
if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_query = "DELETE FROM `orders` WHERE id = $delete_id";
   $delete_result = mysqli_query($conn, $delete_query);

   if ($delete_result) {
       header('Location: placed_orders.php');
       exit;
   } else {
       echo 'Error deleting order: ' . mysqli_error($conn);
   }
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

<?php include '../components/admin_header.php'; ?>

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
         <select name="payment_status" class="select">
            <option selected disabled><?= $fetch_orders['payment_status']; ?></option>
            <option value="pending">pending</option>
            <option value="completed">completed</option>
         </select>
        <div class="flex-btn">
         <input type="submit" value="update" class="option-btn" name="update_payment">
         <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('delete this order?');">delete</a>
        </div>
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