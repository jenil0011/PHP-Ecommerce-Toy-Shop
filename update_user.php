<?php
error_reporting(0);
//ini_set('display_errors', 1);

include 'components/connect.php';
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Fetch current user details
    $select_profile = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'");
    $fetch_profile = mysqli_fetch_assoc($select_profile);

    // Update name and email
    $update_profile = "UPDATE `users` SET name = '$name', email = '$email' WHERE id = '$user_id'";
    mysqli_query($conn, $update_profile);

    // Password update logic
    $empty_pass = 'da39a3ee5e6b4b0d3255bfef95601890afd80709'; // Hash for empty password
    $prev_pass = mysqli_real_escape_string($conn, $_POST['prev_pass']);
    $old_pass = mysqli_real_escape_string($conn, sha1($_POST['old_pass']));
    $new_pass = mysqli_real_escape_string($conn, sha1($_POST['new_pass']));
    $cpass = mysqli_real_escape_string($conn, sha1($_POST['cpass']));

    // Check the old password
    $get_user_query = "SELECT * FROM `users` WHERE id = '$user_id' AND password = '$old_pass'";
    $result = mysqli_query($conn, $get_user_query);
    $num_rows = mysqli_num_rows($result);

    if ($old_pass == $empty_pass) {
        $message[] = 'Please enter old password!';
    } elseif ($num_rows != 1) {
        $message[] = 'Old password not matched!';
    } elseif ($new_pass != $cpass) {
        $message[] = 'Confirm password not matched!';
    } else {
        if ($new_pass != $empty_pass) {
            // Update the password
            $update_admin_pass = "UPDATE `users` SET password = '$new_pass' WHERE id = '$user_id'";
            mysqli_query($conn, $update_admin_pass);
            $message[] = 'Password updated successfully!';
        } else {
            $message[] = 'Please enter a new password!';
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
   <title>Update Profile</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="css/style.css">
   <style>
       body {
           background: url("toy.jpg") center no-repeat;
           background-size: cover;
       }
   </style>
</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="form-container">
    <form action="" method="post" onsubmit="return validateForm()">
        <img src="images/update.png" alt="">
        <h3>Update Now</h3>
        <input type="hidden" name="prev_pass" value="<?= htmlspecialchars($fetch_profile["password"]); ?>">
        <input type="text" name="name" required placeholder="Enter your username" maxlength="20" class="box" value="<?= htmlspecialchars($fetch_profile["name"]); ?>">
        <input type="email" name="email" required placeholder="Enter your email" maxlength="50" class="box" value="<?= htmlspecialchars($fetch_profile["email"]); ?>" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="old_pass" placeholder="Enter your old password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="new_pass" placeholder="Enter your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="password" name="cpass" placeholder="Confirm your new password" maxlength="20" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
        <input type="submit" value="Update Now" class="btn" name="submit">
    </form>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

<script>
    function validateForm() {
        var email = document.getElementsByName('email')[0].value;
        var password = document.getElementsByName('new_pass')[0].value;
        var confirmPassword = document.getElementsByName('cpass')[0].value;

        if (email.includes("@@") || !isValidEmail(email)) {
            alert("Please enter a valid email address.");
            return false;
        }

        if (password !== confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }

        return true;
    }

    function isValidEmail(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
</script>

</body>
</html>
