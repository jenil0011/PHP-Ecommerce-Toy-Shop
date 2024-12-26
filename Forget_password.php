<?php

error_reporting(0);
include 'components/connect.php';

$email_error = " ";

if (isset($_POST["sendOTP"])) {
    // if (empty($_POST['email'])) {
    //     $email_error = "Invalid email id";
    // } else {
    //     $email = $_POST["email"];
    //     $select = "select * from users where email='$email'; ";
    //     $result = mysqli_query($conn, $select);

    //     $row = mysqli_fetch_array($result);
    //     $check_email = $row['email'];

        // if ($_POST['email'] == $check_email) {
            session_start();
            $_SESSION['fp_email'] = $_POST['email'];
            $otp = random_int(100000, 999999);
            $to_email = $_POST['email'];
            $subject = "OTP VERIFICATION FOR FORGOT PASSWORD FUNCTIONALITY.";
            $body = "your otp is : $otp";
            $headers = "From: harshfree034@gmail.com";

            if (mail($to_email, $subject, $body, $headers)) {
                $_SESSION['otp'] = $otp;
                $time = $_SERVER['REQUEST_TIME'];
                $_SESSION['time'] = $time;
                header('location:verify_otp.php');
           }
        //     echo "<script>location.href='verify_otp.php'</script>";
        // } else {
        //     $email_error = "Invalid email id";
        // }
    //}
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>login</title>
   
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

a{
    font-size: 17px;
    align-items: center;
}
   </style>

</head>
    <body>

<section class="form-container">

   <form action="Forget_password.php" method="post">
        <img src="images/user.png" alt="">
            <h3>forgot password</h3>
            <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">

            <input type="submit" value="send OTP" class="btn" name="sendOTP">
   </form>

</section>

        <script src="script.js"></script>
    </body>
</html>
