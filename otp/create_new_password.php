<?php
error_reporting(0);
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

//    $email = $_POST['email'];
//    $email = filter_var($email, FILTER_SANITIZE_STRING);
//    $pass = sha1($_POST['pass']);
//    $pass = filter_var($pass, FILTER_SANITIZE_STRING);

//    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
//    $select_user->execute([$email, $pass]);
//    $row = $select_user->fetch(PDO::FETCH_ASSOC);

//    if($select_user->rowCount() > 0){ 
//       $_SESSION['user_id'] = $row['id'];
//       echo "<script>alert('Login successful!');</script>";
//       header('location:home.php');
//    }else{
//       $message[] = 'incorrect username or password!'; 
// }

$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = $_POST['pass'];

$email = mysqli_real_escape_string($conn, $email); // Escape input to prevent SQL injection

// Hash the password securely
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$select_user = mysqli_query($conn, "SELECT id, password FROM `users` WHERE email = '$email'");

if(mysqli_num_rows($select_user) > 0){
    $row = mysqli_fetch_assoc($select_user);

    if($row && password_verify($password, $row['password'])){
      //   session_start();
        $_SESSION['user_id'] = $row['id'];
        header('Location: home.php');
      //   exit();
    } else {
        $message[] = 'Incorrect username or password!';
    }
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
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">

   <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
       <img src="images/user.png" alt="">
      <h3>login now</h3>
      <input type="email" name="email" required placeholder="enter your email" maxlength="50"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" required placeholder="enter your password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <div>
     <p>Forgot Your Password?<a href="Forget_password.php"> Click Here</a></p>
      </div>
      <input type="submit" value="login now" class="btn" name="submit">
      <p>New To ToyMania?</p>
      <a href="user_register.php" class="option-btn">Register now</a>
   </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
