<?php
error_reporting(0);

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

   <style>
   
   body{
   background: url("backimg.png");
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
   }

   </style>

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="dashboard">

   <div class="box-container">

      <div class="box">
         <h3>Current User: <?= $fetch_profile['name']; ?></h3>
         <a href="update_profile.php" class="btn">update profile</a>
      </div>

      <div>
      <div class="box">
         <?php
          
         $total_pendings = 0;

         $pending_status = 'pending'; // Variable for the status

         $select_pendings = "SELECT * FROM orders WHERE payment_status = '$pending_status'";
         $select_pendings = mysqli_query($conn, $select_pendings);

         if(mysqli_num_rows($select_pendings) > 0){

            while($fetch_pendings = mysqli_fetch_assoc($select_pendings)){
                  $total_pendings += $fetch_pendings['total_price'];
            }
         }
         ?>
         <h3>Total Pending Amount : Rs. <?= $total_pendings; ?>/-</h3>
         <a href="placed_orders.php" class="btn">see orders</a>
      </div>
      </div>
      
      <div>
      <div class="box">
         <?php
         
               $total_completes = 0;

            $select_completes = "SELECT * FROM `orders` WHERE payment_status = 'completed'";

            $result = mysqli_query($conn, $select_completes);

            // Check if there are completed orders
            if (mysqli_num_rows($result) > 0) {
               while ($row = mysqli_fetch_assoc($result)) {
                  $total_completes += $row['total_price'];
               }
            }

         ?>
         <h3>Total Completed Orders : Rs. <?= $total_completes; ?>/-</h3>
         <a href="placed_orders.php" class="btn">see orders</a>
      </div>
      </div>

      <div>
      <div class="box">
         <?php

            $sql = "SELECT * FROM `orders`";
            $select_orders = mysqli_query($conn, $sql);
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
         <h3>Total Placed Orders : <?= $number_of_orders; ?></h3>
         <a href="placed_orders.php" class="btn">see orders</a>
      </div>
      </div>

      <div>
      <div class="box">
         <?php
        
            $sql = "SELECT * FROM `products`";
            $select_products = mysqli_query($conn, $sql);
            $number_of_products = mysqli_num_rows($select_products);
         ?>
         <h3>Total Products added: <?= $number_of_products; ?></h3>
         <a href="products.php" class="btn">see products</a>
      </div>
      </div>

      <div>
      <div class="box">
         <?php
            $sql = "SELECT * FROM `users`";
            $select_users = mysqli_query($conn, $sql);
            $number_of_users = mysqli_num_rows($select_users);
         ?>
         <h3>Number of users: <?= $number_of_users; ?></h3>
         <a href="users_accounts.php" class="btn">see users</a>
      </div>
      </div>

      <div>
      <div class="box">
         <?php
            $sql = "SELECT * FROM `admins`";
            $select_admins = mysqli_query($conn, $sql);
            $number_of_admins = mysqli_num_rows($select_admins);
         ?>
         <h3>Admin Users: <?= $number_of_admins; ?></h3>
         <a href="admin_accounts.php" class="btn">see admins</a>
      </div>
      </div>

      <div>
      <div class="box">
         <?php
            $sql = "SELECT * FROM `tblsupplier`";
            $select_supplier = mysqli_query($conn, $sql);
            $number_of_admins = mysqli_num_rows($select_supplier);
         ?>
         <h3>Suppliers : <?= $number_of_admins; ?></h3>
         <a href="supplier_accounts.php" class="btn">see suppliers</a>
      </div>
      </div>

      <div>
      <div class="box">
         <?php
            $sql = "SELECT * FROM `messages`";
            $select_messages = mysqli_query($conn, $sql);

            // Get the number of messages
            $number_of_messages = mysqli_num_rows($select_messages);
         ?>
         <h3>Contact us Messages: <?= $number_of_messages;?></h3>
         <a href="messages.php" class="btn">see messages</a>
      </div>
      </div>

      <div>
      <div class="box">
         <?php
            $sql = "SELECT * FROM `feedback`";
            $select_feedbacks = mysqli_query($conn, $sql);
            // Get the number of messages
            $number_of_feedbacks = mysqli_num_rows($select_feedbacks);
         ?>
         <h3>Feedback Messages: <?= $number_of_feedbacks;?></h3>
         <a href="feedback.php" class="btn">see feedbacks</a>
      </div>
      </div>

      <div>
      <div class="box">
         <?php
            $sql = "SELECT * FROM `staff`";
            $select_staff = mysqli_query($conn, $sql);
            $number_of_staff = mysqli_num_rows($select_staff);
         ?>
         <h3>Staff Users: <?= $number_of_staff; ?></h3>
         <a href="staff_accounts.php" class="btn">see staff</a>
      </div>
      </div>
      
   
   </div>

</section>



<script src="../js/admin_script.js"></script>
   
</body>
</html>