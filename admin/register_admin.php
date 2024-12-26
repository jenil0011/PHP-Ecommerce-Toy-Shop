<?php
error_reporting(0);
include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}


if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $pass = sha1($_POST['pass']);
    $cpass = sha1($_POST['cpass']);

    $select_admin = "SELECT * FROM `admins` WHERE name = '$name'";
    $result = mysqli_query($conn, $select_admin);

    if (mysqli_num_rows($result) > 0) {
        $message[] = 'Username already exists!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Confirm password does not match!';
        } else {
            $insert_admin = "INSERT INTO `admins` (name, password) VALUES ('$name', '$cpass')";
            if (mysqli_query($conn, $insert_admin)) {
                $message[] = 'New admin registered successfully!';
            } else {
                $message[] = 'Error: ' . mysqli_error($conn);
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
   <title>register admin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="form-container">

<form name="adminregister" action="" method="post" onsubmit="return validateForm()">
    <h3>Register Now</h3>
    <input type="text" name="name" required placeholder="Enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" name="pass" required placeholder="Enter your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" name="cpass" required placeholder="Confirm your password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="submit" value="Register Now" class="btn" name="submit">
</form>

</section>

<script src="../js/admin_script.js"></script>

<script>
function validateForm() {
    var password = document.getElementsByName('pass')[0].value;
    var confirmPassword = document.getElementsByName('cpass')[0].value;

    // Regular expressions to validate password
    var hasNumber = /\d/;
    var hasAlphabet = /[a-zA-Z]/;

    // Name validation
    var name = document.forms["adminregister"]["name"].value;
    if (!/^[a-zA-Z\s]*$/.test(name)) {
        alert("Name should contain only alphabets.");
        return false;
    }

    if (password.length < 6 || !/\d/.test(password) || !/[a-zA-Z]/.test(password)) {
        alert("Password must be at least 6 characters long and contain at least one number and one alphabet.");
        return false;
    }

    if (!hasNumber.test(password) || !hasAlphabet.test(password)) {
        alert("Password must contain at least one number and one alphabet");
        return false;
    }

    if (password !== confirmPassword) {
        alert("Passwords do not match");
        return false;
    }

    return true;
}
</script>
   
</body>
</html>