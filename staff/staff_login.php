<?php
error_reporting(0);

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = sha1($_POST['pass']);
    $email = mysqli_real_escape_string($conn, $email); // Escape input to prevent SQL injection
    
    $select_user = mysqli_query($conn, "SELECT id, password FROM `staff` WHERE email = '$email'");
    
    if(mysqli_num_rows($select_user) > 0){
        $row = mysqli_fetch_assoc($select_user);
          //   session_start();
            $_SESSION['staff_id'] = $row['id'];
            header('Location: staff_dashboard.php');
          //   exit();
    }
    else
    {
        $message[] = "error";
    }
       
    }

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
   <title>staff login</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">
   
</head>
<body>

<?php
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<section class="form-container">

<form action="" method="post" onsubmit="return validateForm()">
        <h3>Staff Login</h3>
        <input type="email" name="email" required placeholder="Enter your email"  class="box">
        <input type="password" name="password" required placeholder="Enter your password"  class="box">
        <input type="submit" value="Login Now" class="btn" name="submit">
    </form>
</section>

<script>
        function validateForm() {
            // Validating Email
            let email = document.querySelector('input[name="email"]').value;
            let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
            if (email.includes('@@') || !emailRegex.test(email)) {
                alert("Please enter a valid email address following the standard email structure.");
                return false;
            }

            // Validating Password
            let password = document.querySelector('input[name="password"]').value;
            let passwordRegex = /^(?=.*[A-Za-z])(?=.*\d).{6,}$/;

            if (!passwordRegex.test(password)) {
                alert("Password must be at least 6 characters long and contain at least one letter and one number.");
                return false;
            }

            return true;
        }
    </script>

</body>
</html>