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
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = sha1($_POST['pass']);
    $cpass = sha1($_POST['cpass']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $salary = mysqli_real_escape_string($conn, $_POST['salary']);

    $select_admin = "SELECT * FROM `staff` WHERE email = '$email'";
    $result = mysqli_query($conn, $select_admin);

    if (mysqli_num_rows($result) > 0) {
        $message[] = 'email already exists!';
    } else {
        if ($pass != $cpass) {
            $message[] = 'Confirm password does not match!';
        } else {
            $insert_admin = "INSERT INTO `staff` (name, address, city, contact, email, password, doj, salary) VALUES ('$name', '$address', '$city', '$contact', '$email', '$cpass', '$date', '$salary')";
            if (mysqli_query($conn, $insert_admin)) {
                $message[] = 'New staff registered successfully!';
            } else {
                $message[] = 'Error: ' . mysqli_error($conn);
            }
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
   <title>register admin</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="form-container">

<form name="registrationForm" action="" method="post" onsubmit="return validateForm()">
        <h3>Register Now</h3>
        <input type="text" name="name" required placeholder="Enter staff username" class="box">
        <input type="text" name="address" required placeholder="Enter staff address" class="box">
        <input type="text" name="city" required placeholder="Enter staff city" class="box">
        <input type="tel" name="contact" required placeholder="Enter staff contact" class="box">
        <input type="email" name="email" required placeholder="Enter staff email" class="box">
        <input type="password" name="pass" required placeholder="Enter your password" class="box">
        <input type="password" name="cpass" required placeholder="Confirm your password" class="box">
        <input type="date" name="date" required placeholder="Enter staff joining date" class="box">
        <input type="number" name="salary" required placeholder="Enter staff salary" class="box">
        <input type="submit" value="Register Now" class="btn" name="submit">
    </form>

</section>

<script src="../js/admin_script.js"></script>

<script>
        function validateForm() {

            // Name validation
            var name = document.forms["registrationForm"]["name"].value;
            if (!/^[a-zA-Z\s]*$/.test(name)) {
                alert("Name should contain only alphabets.");
                return false;
            }

            // Email validation
            var email = document.forms["registrationForm"]["email"].value;
            if (email.includes('@@') || !/\S+@\S+\.\S+/.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            // Password validation
            var password = document.forms["registrationForm"]["pass"].value;
            if (password.length < 6 || !/\d/.test(password) || !/[a-zA-Z]/.test(password)) {
                alert("Password must be at least 6 characters long and contain at least one number and one alphabet.");
                return false;
            }

            // City validation
            var city = document.forms["registrationForm"]["city"].value;
            if (!/^[a-zA-Z\s]*$/.test(city)) {
                alert("City should contain only alphabets.");
                return false;
            }

            // Contact number validation
            var contact = document.forms["registrationForm"]["contact"].value;
            if (contact.length !== 10 || isNaN(contact)) {
                alert("Contact number should contain exactly 10 digits.");
                return false;
            }

            // Salary validation
            var salary = document.forms["registrationForm"]["salary"].value;
            if (!/^[0-9]+$/.test(salary)) {
                alert("Salary should contain only numeric values.");
                return false;
            }

            // If all validations pass, the form will be submitted
            return true;
        }
    </script>
   
</body>
</html>