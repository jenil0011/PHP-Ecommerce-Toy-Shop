<?php
error_reporting(0);

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

?>

<?php
// Define a function to validate an email address
function validateEmail($email) {
    // Use PHP's built-in filter_var function with FILTER_VALIDATE_EMAIL filter
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    // Validate the email address
    if (validateEmail($email)) {
        // Email address is valid
//        echo "Email address is valid: " . $email;
        // Further processing or database insertion can be done here
    } else {
        // Email address is not valid
         $message[] = 'Invalid email address. Please enter a valid email address.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>feedback</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="contacts">

<h1 class="heading">feedback messages</h1>

<div class="box-container">

   <?php
         $select_messages = mysqli_query($conn, "SELECT * FROM feedback");

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