<?php
error_reporting(0);
include '../components/connect.php';

session_start();

$staff_id = $_SESSION['staff_id'];

if(!isset($staff_id)){
   header('location:staff_login.php');
}

if (isset($_POST['submit'])) {
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $address = mysqli_real_escape_string($conn, $_POST['address']);
   $city = mysqli_real_escape_string($conn, $_POST['city']);
   $contact = mysqli_real_escape_string($conn, $_POST['contact']);
   $staff_id = mysqli_real_escape_string($conn, $staff_id);

   $update_profile_name = "UPDATE staff SET name = '$name' WHERE id = $staff_id";
   $result_name = mysqli_query($conn, $update_profile_name);

   $update_profile_address = "UPDATE staff SET address = '$address' WHERE id = $staff_id";
   $result_name = mysqli_query($conn, $update_profile_address);

   $update_profile_city = "UPDATE staff SET city = '$city' WHERE id = $staff_id";
   $result_name = mysqli_query($conn, $update_profile_city);

   $update_profile_contact = "UPDATE staff SET contact = '$contact' WHERE id = $staff_id";
   $result_name = mysqli_query($conn, $update_profile_contact);

   if ($result_name) {
       $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
       $prev_pass = mysqli_real_escape_string($conn, $_POST['prev_pass']);
       $old_pass = sha1(mysqli_real_escape_string($conn, $_POST['old_pass']));
       $new_pass = sha1(mysqli_real_escape_string($conn, $_POST['new_pass']));
       $confirm_pass = sha1(mysqli_real_escape_string($conn, $_POST['confirm_pass']));

       $check_pass_query = "SELECT password FROM admins WHERE id = $staff_id";
       $result_pass = mysqli_query($conn, $check_pass_query);

       if ($result_pass && mysqli_num_rows($result_pass) > 0) {
           $row = mysqli_fetch_assoc($result_pass);
           $db_password = $row['password'];

           if ($old_pass === $empty_pass) {
               $message[] = 'Please enter the old password!';
           } elseif ($old_pass !== $db_password) {
               $message[] = 'Old password does not match!';
           } elseif ($new_pass !== $confirm_pass) {
               $message[] = 'Confirm password does not match the new password!';
           } else {
               if ($new_pass !== $empty_pass) {
                   $update_admin_pass = "UPDATE staff SET password = '$confirm_pass' WHERE id = $staff_id";
                   $result_update_pass = mysqli_query($conn, $update_admin_pass);

                   if ($result_update_pass) {
                       $message[] = 'Password updated successfully!';
                   } else {
                       $message[] = 'Error updating password.';
                   }
               } else {
                   $message[] = 'Please enter a new password!';
               }
           }
       } else {
        //    $message[] = 'Error fetching the password from the database.';
       }
   } else {
       $message[] = 'Error updating name.';
   }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update staff profile</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/staff_header.php'; ?>

<section class="form-container">

   <form name="updatestaff" action="" method="post" onsubmit="return validateForm()">
      <h3>update staff profile</h3>
      <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
      <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="address" value="<?= $fetch_profile['address']; ?>" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="city" value="<?= $fetch_profile['city']; ?>" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="text" name="contact" value="<?= $fetch_profile['contact']; ?>" required placeholder="enter your username" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="old_pass" placeholder="enter old password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" placeholder="enter new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="confirm_pass" placeholder="confirm new password" maxlength="20"  class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="update now" class="btn" name="submit">
   </form>

</section>


<script src="../js/admin_script.js"></script>
   
<script>
        function validateForm() {

            // Name validation
            var name = document.forms["updatestaff"]["name"].value;
            if (!/^[a-zA-Z\s]*$/.test(name)) {
                alert("Staff Name should contain only alphabets.");
                return false;
            }

            // Password validation
            var password = document.forms["updatestaff"]["pass"].value;
            if (password.length < 6 || !/\d/.test(password) || !/[a-zA-Z]/.test(password)) {
                alert("Password must be at least 6 characters long and contain at least one number and one alphabet.");
                return false;
            }

            // Password validation
            var passwordc = document.forms["updatestaff"]["confirm_pass"].value;
            if (passwordc.length < 6 || !/\d/.test(passwordc) || !/[a-zA-Z]/.test(passwordc)) {
                alert("Password must be at least 6 characters long and contain at least one number and one alphabet.");
                return false;
            }

            // City validation
            var city = document.forms["updatestaff"]["city"].value;
            if (!/^[a-zA-Z\s]*$/.test(city)) {
                alert("City should contain only alphabets.");
                return false;
            }

            // Contact number validation
            var contact = document.forms["updatestaff"]["contact"].value;
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