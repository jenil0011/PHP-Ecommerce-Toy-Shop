<?php

include '../components/connect.php';

$email_error = " ";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sendOTP"])) {
    if (empty($_POST['email'])) {
        $email_error = "Invalid email id";
    } else {
        $email = $_POST["email"];
        $select = "select * from user where email='$email'; ";
        $result = mysqli_query($connect, $select);

        $row = mysqli_fetch_array($result);
        $check_email = $row['email'];

        if ($_POST['email'] == $check_email) {
            session_start();
            $_SESSION['fp_email'] = $_POST['email'];
            $otp = random_int(100000, 999999);
            $to_email = $_POST['email'];
            $subject = "OTP VERIFICATION FOR FORGOT PASSWORD FUNCTIONALITY.";
            $body = "your otp is : $otp";
            $headers = "From: 21bmiit031@gmail.com";

            if (mail($to_email, $subject, $body, $headers)) {
                $_SESSION['otp'] = $otp;
                $time = $_SERVER['REQUEST_TIME'];
                $_SESSION['time'] = $time;
            }
            echo "<script>location.href='verify_otp.php'</script>";
        } else {
            $email_error = "Invalid email id";
        }
    }
}
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
            <h6>Forgot Password </h6><br>
            <form action="#" method="POST" id="login-form">
                <div class="form-group">
                    <label for="email"><b>Email:</b></label>
                    <input type="email" class="form-control" name="email" >
                    <span class="error"><?php echo $email_error; ?></span>
                </div>
                <div>
                    <input type="submit" name="sendOTP" class="btn btn-primary" value="send OTP">
                </div>
            </form>
        </div>

        <script src="script.js"></script>
    </body>
</html>
