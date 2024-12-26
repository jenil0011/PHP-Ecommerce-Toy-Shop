<?php
error_reporting(0);
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])) {
   $delete_id = $_GET['delete'];
   // Check if the user exists before deleting
   // $check_user_query = "SELECT id FROM users WHERE id = $delete_id";
   // $check_user_result = mysqli_query($conn, $check_user_query);

   // if(mysqli_num_rows($check_user_result) > 0) {
       // Delete user-related data
       $delete_user_query = "DELETE FROM users WHERE id = $delete_id";
       mysqli_query($conn, $delete_user_query);
       
       $delete_orders_query = "DELETE FROM orders WHERE user_id = $delete_id";
       mysqli_query($conn, $delete_orders_query);
       
       $delete_messages_query = "DELETE FROM messages WHERE user_id = $delete_id";
       mysqli_query($conn, $delete_messages_query);
       
       $delete_cart_query = "DELETE FROM cart WHERE user_id = $delete_id";
       mysqli_query($conn, $delete_cart_query);
       
       $delete_wishlist_query = "DELETE FROM wishlist WHERE user_id = $delete_id";
       mysqli_query($conn, $delete_wishlist_query);
       header('Location: users_accounts.php');
   }
   // Redirect to users_accounts.php
  
   // exit; // Ensure to stop script execution after redirection
// }


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>users accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">user accounts</h1>


   <div class="box-container">

   <?php
      // $select_accounts = $conn->prepare("SELECT * FROM `users`");
      // $select_accounts->execute();
      // if($select_accounts->rowCount() > 0){
      //    while($fetch_accounts = $select_accounts->fetch(PDO::FETCH_ASSOC)){
         
      $select_accounts = "SELECT * FROM `users`";
      $result = mysqli_query($conn, $select_accounts);
         
      if (mysqli_num_rows($result) > 0) {
         while ($fetch_accounts = mysqli_fetch_assoc($result)) {    
   ?>
   <div class="box">
      <p> user id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> username : <span><?= $fetch_accounts['name']; ?></span> </p>
      <p> email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <a href="users_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account? the user related information will also be delete!')" class="delete-btn">delete</a>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no accounts available!</p>';
      }
   ?>

   </div>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>