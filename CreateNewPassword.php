<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet" href="CreateNewPassword_style.css">
    </head>
    <body>
        <?php
        $pass_error=FALSE;
        
        include 'components/connect.php';

        if (isset($_POST["change_pass"])) {

            $email = $_SESSION['fp_email'];
            $npassword = $_POST['new_password'];
            $cpassword = $_POST['confirm_password'];

            if ($npassword === $cpassword) {
//                $temp = explode("@", $email);
//                if ($temp[1] == "gmail.com") {
                
                    $hashed_password = password_hash($npassword, PASSWORD_DEFAULT);
                    
                    $update = "UPDATE users  SET password='$hashed_password' WHERE email='$email' ;";
                    if(mysqli_query($conn, $update)){
                    header("Location:user_login.php");
                    }
                
            }
        }
        ?>

    </body>
    <div class="container">
        <div class="form">
            <form action="#" method="post">
                <h2>New Password</h2>
                <div class="inputBox">
                    <input type="password" name="new_password" <?php if (isset($_POST["change_pass"])) { echo "value='$npassword'"; } ?> required="reguired" id="myInput">
                    <i class="fa-solid fa-lock"></i>
                    <span>New Password</span>
                    <i id="hide1" class="fa-solid fa-eye eye" onclick="myFunction()"></i>
                    <i id="hide2" class="fa-solid fa-eye-slash eye" onclick="myFunction()"></i> 
                </diV>
                <div class="inputBox">
                    <input type="password" name="confirm_password" <?php if (isset($_POST["change_pass"])) { echo "value='$cpassword'"; } ?> required="reguired" id="myConfirmInput">
                    <i class="fa-solid fa-lock"></i>
                    <span>Confirm Password</span>
                    <i id="chide1" class="fa-solid fa-eye eye" onclick="myFunction('confirm')"></i>
                    <i id="chide2" class="fa-solid fa-eye-slash eye" onclick="myFunction('confirm')"></i> 

                    <?php
                    if (isset($_POST["change_pass"])) {
                        if ($pass_error) {
                            echo '<img src="photo/check.png"  height="22px"  width="22px"  >';
                        } else {
                            echo '<img src="photo/close.png"  height="18px"  width="18px"  >';
                        }
                    }
                    ?>
                </diV>
                <div class="inputBox">
                    <input type="submit" name="change_pass" value="Change">
                </diV>
            </form>
        </div>
    </div>
    <script src="Script/eye.js"></script>
</html>
