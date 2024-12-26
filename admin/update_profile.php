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
   $admin_id = mysqli_real_escape_string($conn, $admin_id);

   $update_profile_name = "UPDATE admins SET name = '$name' WHERE id = $admin_id";
   $result_name = mysqli_query($conn, $update_profile_name);

   if ($result_name) {
       $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709';
       $prev_pass = mysqli_real_escape_string($conn, $_POST['prev_pass']);
       $old_pass = sha1(mysqli_real_escape_string($conn, $_POST['old_pass']));
       $new_pass = sha1(mysqli_real_escape_string($conn, $_POST['new_pass']));
       $confirm_pass = sha1(mysqli_real_escape_string($conn, $_POST['confirm_pass']));

       $check_pass_query = "SELECT password FROM admins WHERE id = $admin_id";
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
                   $update_admin_pass = "UPDATE admins SET password = '$confirm_pass' WHERE id = $admin_id";
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
           $message[] = 'Error fetching the password from the database.';
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
   <title>update profile</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="form-container">

<form action="" method="post" id="updateProfileForm">
    <h3>update profile</h3>
    <input type="hidden" name="prev_pass" value="<?= $fetch_profile['password']; ?>">
    <input type="text" name="name" value="<?= $fetch_profile['name']; ?>" required placeholder="enter your username" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" name="old_pass" placeholder="enter old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" name="new_pass" placeholder="enter new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="password" name="confirm_pass" placeholder="confirm new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
    <input type="submit" value="update now" class="btn" name="submit" onclick="validateProfileUpdate()">
</form>

</section>


<script src="../js/admin_script.js"></script>
   
<script>
function validateProfileUpdate() {
    const form = document.getElementById('updateProfileForm');
    const oldPassword = form.elements['old_pass'].value;
    const newPassword = form.elements['new_pass'].value;
    const confirmPassword = form.elements['confirm_pass'].value;

    // Validation for Password (At least one alphabet and one number, 6 characters long)
    if (!/(?=.*[A-Za-z])(?=.*\d).{6,}/.test(newPassword)) {
        alert('Password must contain at least 1 letter, 1 number, and be 6 characters long.');
        return false;
    }

    // Confirmation of the new password
    if (newPassword !== confirmPassword) {
        alert('New password and confirm password do not match.');
        return false;
    }

    // If all validations pass, the form will be submitted
    form.submit();
}
</script>

</body>
</html>