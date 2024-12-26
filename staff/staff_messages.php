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
   <title>messages</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/staff_header.php'; ?>

<section class="contacts">

<h1 class="heading">contact us messages</h1>

<div class="box-container">

   <?php
         $select_messages = mysqli_query($conn, "SELECT * FROM messages");
         if (mysqli_num_rows($select_messages) > 0) {
             while ($fetch_message = mysqli_fetch_assoc($select_messages)) {
   ?>
   <div class="box">
   <p> user id : <span><?= $fetch_message['user_id']; ?></span></p>
   <p> name : <span><?= $fetch_message['name']; ?></span></p>
   <p> email : <span><?= $fetch_message['email']; ?></span></p>
   <p> number : <span><?= $fetch_message['number']; ?></span></p>
   <p> message : <span><?= $fetch_message['message']; ?></span></p>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">you have no messages</p>';
      }
   ?>

</div>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>