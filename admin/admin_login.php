<?php
error_reporting(0);

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $pass = sha1($_POST['pass']); // Not recommended; use a more secure hashing algorithm

    $query = "SELECT * FROM `admins` WHERE name = '$name' AND password = '$pass'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) > 0) {
        $_SESSION['admin_id'] = $row['id'];
        header('location:dashboard.php');
    } else {
        $message[] = 'Incorrect username or password!';
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

<form name="adminlogin" action="" method="post" onsubmit="return validateForm()">
    <h3>Login Now</h3>
    <p>Default username = <span>admin</span> & password = <span>admin123</span></p>
    <input type="text" name="name" required placeholder="Enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="submit" value="Login Now" class="btn" name="submit">
</form>

</section>
   
<script>
function validateForm() {
    var password = document.getElementsByName('pass')[0].value;

    // Regular expressions to validate password
    var hasNumber = /\d/;
    var hasAlphabet = /[a-zA-Z]/;

     // Name validation
    var name = document.forms["adminlogin"]["name"].value;
    if (!/^[a-zA-Z\s]*$/.test(name)) {
        alert("Name should contain only alphabets.");
            return false;
        }

    if (password.length < 6) {
        alert("Password should be at least 6 characters long");
        return false;
    }

    if (!hasNumber.test(password) || !hasAlphabet.test(password)) {
        alert("Password must contain at least one number and one alphabet");
        return false;
    }

    return true;
}
</script>

</body>
</html>

