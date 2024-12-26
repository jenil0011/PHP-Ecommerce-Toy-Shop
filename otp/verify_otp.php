<?php
session_start();
/*
if (isset($_POST["sendOTP"])) {

    $_SESSION['fp_email']=$_POST['email'];
    
    $otp = random_int(100000, 999999);
    $to_email = $_POST['email'];
    $subject = "OTP VERIFICATION";
    $body = "your otp is $otp";
    $headers = "From: 21bmiit031@gmail.com";

    if (mail($to_email, $subject, $body, $headers)) {
        $_SESSION['otp'] = $otp;
        $time = $_SERVER['REQUEST_TIME'];
        $_SESSION['time'] = $time;
    }
    
    $otp_error = " ";
}*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="forgot_password.css">
</head>
<body>
        <div class="container mt-5">
            <h6>Verify OTP </h6><br>
            <form action="#" method="POST" id="login-form">
                <div class="form-group">
                    <label for="otp"><b>Enter otp:</b></label>
                    <input type="tel" maxlength="6" class="form-control" name="V_otp" required><br>
                </div>
                <div>
                <input type="submit" name="verify" class="btn btn-primary" value="Verify">
                </div>
                 </form>
        </div>

    
    <?php
        $timestamp = $_SERVER['REQUEST_TIME'];

        if (isset($_POST["verify"])) {
            $otp = $_POST['V_otp'];
            if ($timestamp - $_SESSION['time'] < 300) {
                if ($otp == $_SESSION['otp']) {
                    header("location:create_new_password.php");
                } else {
                    header("location:verify_otp.php");
                    $otp_error = "Invalid otp";
                }
            } 
            else {
                header("location:create_new_password.php");
            }
        }
        ?>
</body>
</html>
