<?php
error_reporting(0);
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $email = mysqli_real_escape_string($conn, $_POST['email']);
   $number = mysqli_real_escape_string($conn, $_POST['number']);
   $msg = mysqli_real_escape_string($conn, $_POST['msg']);

   $select_message = "SELECT * FROM `messages` WHERE name = '$name' AND email = '$email' AND number = '$number' AND message = '$msg'";
   $result = mysqli_query($conn, $select_message);

   if(mysqli_num_rows($result) > 0){
       $message[] = 'already sent message!';
   } else {
      //  $user_id = 1; // Replace this with the actual user ID

       $insert_message = "INSERT INTO `messages` (user_id, name, email, number, message) VALUES ('$user_id', '$name', '$email', '$number', '$msg')";
       if (mysqli_query($conn, $insert_message)) {
           $message[] = 'sent message successfully!';
       } else {
           $message[] = 'Error: ' . mysqli_error($conn);
       }
   }
   
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
       body {
  background: #76b4c8;
  background: url("hotwheel.png");
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
}

/*body::before {
  content: "";
  position: absolute;
  left: 0;
  top: 0;
  opacity: 0.5;
  width: 100%;
  height: 100%;
  
}*/

/* a{
    font-size: 17px;
    align-items: center;
} */
   </style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="contact">

<form name="feedbackForm" onsubmit="return validateForm()" method="post">
    <img src="images/contact.png" alt="">
    <h3>Get in touch</h3>
    <input type="text" name="name" id="name" placeholder="Enter your name" required maxlength="20" class="box">
    <input type="email" name="email" id="email" placeholder="Enter your email" required maxlength="50" class="box">
    <input type="text" name="number" id="number" placeholder="Enter your number" required class="box" oninput="validatePhoneNumber(this)">
    <textarea name="msg" id="msg" class="box" placeholder="Enter your message" cols="30" rows="10"></textarea>
    <input type="submit" value="Send message" name="send" class="btn">
</form>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

<script>
function validateForm() {
    var email = document.getElementById("email").value;
    var number = document.getElementById("number").value;

    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email.includes('@@') || !email.match(emailRegex)) {
        alert("Please enter a valid email address without double '@@' and following standard email structure.");
        return false;
    }

    // Phone number validation
    const phoneRegex = /^\d{10}$/;
    if (number.length !== 10 || !number.match(phoneRegex)) {
        alert("Please enter a 10-digit phone number.");
        return false;
    }

    return true; // If all validations pass, the form will be submitted
}

function validatePhoneNumber(input) {
    if (input.value.length > 10) {
        input.value = input.value.slice(0, 10);
    }
}
</script>


</body>
</html>