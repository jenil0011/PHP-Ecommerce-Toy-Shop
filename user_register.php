
<?php
error_reporting(0);
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if (isset($_POST['submit'])) {
   $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
   $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
   $password = $_POST['pass'];
   $confirm_password = $_POST['cpass'];

   // Check if the email already exists
   $select_user = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'");
   if (mysqli_num_rows($select_user) > 0) {
       $message[] = 'Email already exists!';
   } else {
       if ($password !== $confirm_password) {
           $message[] = 'Confirm password does not match!';
       } else {
           // Hash the password securely
           $hashed_password = password_hash($password, PASSWORD_DEFAULT);

           // Insert the user into the database
           $insert_user = mysqli_query($conn, "INSERT INTO `users` (name, email, password) VALUES ('$name', '$email', '$hashed_password')");

           if ($insert_user) {
               $message[] = 'Registered successfully. Please login now!';
           } else {
               $message[] = 'Registration failed. Please try again.';
           }
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
   <title>register</title>
   
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
   </style>
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

<form name="registrationForm" onsubmit="return validateForm()" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <!-- Your existing form fields -->
    <img src="images/register.png" alt="">
    <h3>register now</h3>
    <input type="text" name="name" required placeholder="enter your username" maxlength="20" class="box">
    <input type="email" name="email" required placeholder="enter your email" maxlength="50" class="box">
    <input type="password" name="pass" required placeholder="enter your password" maxlength="20" class="box">
    <input type="password" name="cpass" required placeholder="confirm your password" maxlength="20" class="box">

    <input type="submit" value="register now" class="btn" name="submit">
    <p>already have an account?</p>
    <a href="user_login.php" class="option-btn">login now</a>
</form>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

<script>
        function validateForm() {
            var email = document.forms["registrationForm"]["email"].value;
            var password = document.forms["registrationForm"]["pass"].value;
            // Validation for the email (no double @@ and standard email structure)
            var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

              // Name validation
            var name = document.getElementsByName("name")[0].value;
            if (!/^[a-zA-Z\s]*$/.test(name)) {
                alert("Name should contain only alphabets.");
                    return false;
            }

            if (email.includes('@@') || !email.match(emailRegex)) {
                alert("Please enter a valid email address without double @@.");
                return false;
            }

            // Validation for the password (at least one number, one alphabet, and minimum 6 characters)
            var passwordRegex = /^(?=.*\d)(?=.*[a-zA-Z]).{6,}$/;

            if (!password.match(passwordRegex)) {
                alert("Password should contain at least one number, one alphabet, and be at least 6 characters long.");
                return false;
            }
        }
    </script>

</body>
</html>