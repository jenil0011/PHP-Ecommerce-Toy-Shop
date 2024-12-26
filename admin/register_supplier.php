<?php
 error_reporting(0);
 include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['submit'])){

$name = $_POST['name'];
$shopname = $_POST['shopname'];
$shopaddress = $_POST['shopaddress'];
$shopcity = $_POST['shopcity'];
$contactno = $_POST['contactno'];
$emailid = $_POST['emailid'];

$insert_supplier = "INSERT INTO tblsupplier (`name`,shopname,shopaddress,shopcity,contactno,emailid) VALUES ('$name','$shopname','$shopaddress','$shopcity','$contactno','$emailid')";
if (mysqli_query($conn, $insert_supplier)) {
    $message[] = 'New Supplier registered successfully!';
} else {
    $message[] = 'Error:';
}
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>register supllier</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="form-container">

<form action="" method="post" onsubmit="return validateSupplierForm()">
        <h3>Register Supplier Now</h3>
        <input type="text" name="name" required placeholder="Enter supplier name" class="box" required>
        <input type="text" name="shopname" required placeholder="Enter supplier shop name" class="box" required>
        <input type="text" name="shopaddress" required placeholder="Enter supplier shop address" class="box" required>
        <input type="text" name="shopcity" required placeholder="Enter shop city" class="box">
        <input type="tel" name="contactno" required placeholder="Enter contact no" class="box" required>
        <input type="email" name="emailid" required placeholder="Enter supplier emailid" class="box" required>
        <input type="submit" value="Register Now" class="btn" name="submit">
    </form>

</section>

<script src="../js/admin_script.js"></script>

<script>
        function validateSupplierForm() {
            
            // Name validation
            var name = document.getElementsByName("name")[0].value;
            if (!/^[a-zA-Z\s]*$/.test(name)) {
                alert("Name should contain only alphabets.");
                return false;
            }

            // ShopName validation
            var shopname = document.getElementsByName("shopname")[0].value;
            if (!/^[a-zA-Z\s]*$/.test(shopname)) {
                alert("Shop Name should contain only alphabets.");
                return false;
            }
            
            // Email validation
            var email = document.getElementsByName("emailid")[0].value;
            if (email.includes('@@') || !/\S+@\S+\.\S+/.test(email)) {
                alert("Please enter a valid email address.");
                return false;
            }

            // Password validation
            var password = document.getElementsByName("pass")[0].value;
            if (password.length < 6 || !/\d/.test(password) || !/[a-zA-Z]/.test(password)) {
                alert("Password must be at least 6 characters long and contain at least one number and one alphabet.");
                return false;
            }

            // City validation
            var city = document.getElementsByName("shopcity")[0].value;
            if (!/^[a-zA-Z\s]*$/.test(city)) {
                alert("City should contain only alphabets.");
                return false;
            }

            // Contact number validation
            var contact = document.getElementsByName("contactno")[0].value;
            if (contact.length !== 10 || isNaN(contact)) {
                alert("Contact number should contain exactly 10 digits.");
                return false;
            }

            // If all validations pass, the form will be submitted
            return true;
        }
    </script>
   
</body>
</html>