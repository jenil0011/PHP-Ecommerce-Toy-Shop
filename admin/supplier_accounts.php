<?php
error_reporting(0);

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_supplier = "DELETE FROM `tblsupplier` WHERE id = $delete_id";
   $delete_supplier = mysqli_query($conn, $delete_supplier);
   header('Location: supplier_accounts.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>supplier accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">supplier accounts</h1>

   <div class="box-container">

   <div class="box">
      <p>add new supplier</p>
      <a href="register_supplier.php" class="option-btn">register supplier</a>
   </div>

   <?php 
         $query = "SELECT * FROM tblsupplier";
         $select_accounts = mysqli_query($conn, $query);
         if (mysqli_num_rows($select_accounts) > 0) {
            while ($fetch_accounts = mysqli_fetch_assoc($select_accounts)) { 
   ?>
   <div class="box">
      <p> supplier id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> supplier name : <span><?= $fetch_accounts['name']; ?></span> </p>
      <p> shop name : <span><?= $fetch_accounts['shopname']; ?></span> </p>
      <p> shop address : <span><?= $fetch_accounts['shopaddress']; ?></span> </p>
      <p> shop city : <span><?= $fetch_accounts['shopcity']; ?></span> </p>
      <p> contact no : <span><?= $fetch_accounts['contactno']; ?></span> </p>
      <p> email id : <span><?= $fetch_accounts['emailid']; ?></span> </p>
            
      
      <div class="flex-btn">
         <a href="supplier_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
      </div>
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