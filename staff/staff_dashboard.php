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

<?php include '../components/staff_header.php'; ?>

<section class="dashboard">

   <div class="box-container">

      <div class="box">
         <h3>Current User: <?= $fetch_profile['name']; ?></h3>
         <a href="update_staff.php" class="btn">update profile</a>
      </div>

      <div>
      <div class="box">
         <?php

            $sql = "SELECT * FROM `orders`";
            $select_orders = mysqli_query($conn, $sql);
            $number_of_orders = mysqli_num_rows($select_orders);
         ?>
         <h3>Total Placed Orders : <?= $number_of_orders; ?></h3>
         <a href="orders.php" class="btn">see orders</a>
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
         <a href="staff_messages.php" class="btn">see messages</a>
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
         <a href="staff_feedback.php" class="btn">see feedbacks</a>
      </div>
      </div>

     
      
   
   </div>

</section>



<script src="../js/admin_script.js"></script>
   
</body>
</html>