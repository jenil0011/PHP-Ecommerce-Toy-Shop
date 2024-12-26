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
   
   $delete_id = mysqli_real_escape_string($conn, $delete_id);
   $query = "DELETE FROM `staff` WHERE id = '$delete_id'";
   $delete_admins = mysqli_query($conn, $query);

   if($delete_admins) {
       // Check if any row was affected (deleted)
       if (mysqli_affected_rows($conn) > 0) {
           // Row was deleted
           header('location:staff_accounts.php');
       } else {
           // No rows were affected (probably the ID wasn't found)
         //   echo "No rows were affected.";
       }
   } else {
       // Deletion query execution failed
      //  echo "Error deleting record: " . mysqli_error($conn);
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>staff accounts</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="accounts">

   <h1 class="heading">staff accounts</h1>

   <div class="box-container">

   <div class="box">
      <p>add new staff</p>
      <a href="register_staff.php" class="option-btn">register staff</a>
   </div>

   <?php
         $query = "SELECT * FROM staff";
         $select_accounts = mysqli_query($conn, $query);
         if (mysqli_num_rows($select_accounts) > 0) {
            while ($fetch_accounts = mysqli_fetch_assoc($select_accounts)) { 
   ?>
   <div class="box">
      <p> id : <span><?= $fetch_accounts['id']; ?></span> </p>
      <p> name : <span><?= $fetch_accounts['name']; ?></span> </p>
      <p> address : <span><?= $fetch_accounts['address']; ?></span> </p>
      <p> city : <span><?= $fetch_accounts['city']; ?></span> </p>
      <p> Contact : <span><?= $fetch_accounts['contact']; ?></span> </p>
      <p> email : <span><?= $fetch_accounts['email']; ?></span> </p>
      <p> date of joining : <span><?= $fetch_accounts['doj']; ?></span> </p>
      <p> salary : <span><?= $fetch_accounts['salary']; ?></span> </p>
      <div class="flex-btn">
         <a href="staff_accounts.php?delete=<?= $fetch_accounts['id']; ?>" onclick="return confirm('delete this account?')" class="delete-btn">delete</a>
         <?php
            if($fetch_accounts['id'] == $admin_id){
               echo '<a href="staff_update_profile.php" class="option-btn">update</a>';
            }
         ?>
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