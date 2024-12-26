<?php
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};

if(isset($_POST['order'])){

$name = mysqli_real_escape_string($conn, $_POST['name']);
$number = mysqli_real_escape_string($conn, $_POST['number']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$method = mysqli_real_escape_string($conn, $_POST['method']);

$flat = mysqli_real_escape_string($conn, $_POST['flat']);
$street = mysqli_real_escape_string($conn, $_POST['street']);
$city = mysqli_real_escape_string($conn, $_POST['city']);
$state = mysqli_real_escape_string($conn, $_POST['state']);
$country = mysqli_real_escape_string($conn, $_POST['country']);
$pin_code = mysqli_real_escape_string($conn, $_POST['pin_code']);
$address = 'flat no. ' . $flat . ', ' . $street . ', ' . $city . ', ' . $state . ', ' . $country . ' - ' . $pin_code;

$total_products = mysqli_real_escape_string($conn, $_POST['total_products']);
$total_price = mysqli_real_escape_string($conn, $_POST['total_price']);

// $user_id = 1; // Replace this with the actual user ID after proper authentication

$check_cart_query = "SELECT * FROM `cart` WHERE user_id = $user_id";
$check_cart_result = mysqli_query($conn, $check_cart_query);

if (mysqli_num_rows($check_cart_result) > 0) {

    $insert_order_query = "INSERT INTO `orders` (user_id, name, number, email, method, address, total_products, total_price) VALUES ($user_id, '$name', '$number', '$email', '$method', '$address', '$total_products', '$total_price')";

    if (mysqli_query($conn, $insert_order_query)) {
        $delete_cart_query = "DELETE FROM `cart` WHERE user_id = $user_id";
        mysqli_query($conn, $delete_cart_query);
        $message[] = 'Order placed successfully!';
    } else {
        $message[] = 'Error in placing order: ' . mysqli_error($conn);
    }
} else {
    $message[] = 'Your cart is empty';
}

} 


?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

   <style>
       body {
  background: #76b4c8;
  background: url("toy.jpg");
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

<section class="checkout-orders">

   <form action="" method="POST" onsubmit="return validateForm()">

   <h3>your orders</h3>

      <div class="display-orders">
      <?php
         $grand_total = 0;
         $total_products = ''; // String to store all cart item details
     
         $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
     
         if (mysqli_num_rows($select_cart) > 0) {
             while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                 $total_products .= $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                 $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
                 ?>
                 <p><?= $fetch_cart['name']; ?> <span>(<?= 'Rs. '.$fetch_cart['price'].'/- x '. $fetch_cart['quantity']; ?>)</span></p>
                 <?php
             }
         } else {
             echo '<p class="empty">Your cart is empty!</p>';
         }
         // mysqli_close($conn);
         ?>
         <input type="hidden" name="total_products" value="<?= htmlspecialchars($total_products); ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
         <div class="grand-total">Grand Total: <span>Rs. <?= $grand_total; ?>/-</span></div>
     </div>

      <h3>place your orders</h3>

      <div class="flex">
         <div class="inputBox">
            <span>your name :</span>
            <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" required>
         </div>
         <div class="inputBox">
            <span>your number :</span>
            <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
         </div>
         <div class="inputBox">
            <span>your email :</span>
            <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>payment method :</span>
            <select name="method" class="box" required>
               <option value="cash on delivery">cash on delivery</option>
               <option value="credit card">credit card</option>
               <option value="debit card">debit card</option>
               <option value="paytm">paytm</option>
            </select>
         </div>
         <div class="inputBox">
            <span>address line 01 :</span>
            <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>address line 02 :</span>
            <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>city :</span>
            <input type="text" name="city" placeholder="e.g. mumbai" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>state :</span>
            <input type="text" name="state" placeholder="e.g. maharashtra" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>country :</span>
            <input type="text" name="country" placeholder="e.g. India" class="box" maxlength="50" required>
         </div>
         <div class="inputBox">
            <span>pin code :</span>
            <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
         </div>
      </div>

      <input type="submit" name="order" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>" value="place order">

   </form>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

<script>
function validateForm() {

     // name validation
     var name = document.getElementsByName("name")[0].value;
   if (!/^[a-zA-Z\s]*$/.test(name)) {
      alert("Name should contain only alphabets.");
         return false;
   }

    // Email validation
    var email = document.getElementsByName('email')[0].value;
    if (email.trim() === '' || email.indexOf('@') === -1 || email.split('@').length > 2) {
        alert('Please enter a valid email address without double \'@\'.');
        return false;
    }

    // Phone number validation
    var phoneNumber = document.getElementsByName('number')[0].value;
    if (phoneNumber.trim() === '' || phoneNumber.length !== 10 || isNaN(phoneNumber)) {
        alert('Please enter a 10-digit numeric phone number.');
        return false;
    }

   // City validation
   var city = document.getElementsByName("city")[0].value;
   if (!/^[a-zA-Z\s]*$/.test(city)) {
      alert("City should contain only alphabets.");
         return false;
   }

   // State validation
   var state = document.getElementsByName("state")[0].value;
   if (!/^[a-zA-Z\s]*$/.test(state)) {
      alert("State should contain only alphabets.");
         return false;
   }

   // Country validation
   var country = document.getElementsByName("country")[0].value;
   if (!/^[a-zA-Z\s]*$/.test(country)) {
      alert("Country should contain only alphabets.");
         return false;
   }

    // Pin code validation
    var pinCode = document.getElementsByName('pin_code')[0].value;
    if (pinCode.trim() === '' || pinCode.length !== 6 || isNaN(pinCode)) {
        alert('Please enter a 6-digit numeric pin code.');
        return false;
    }

    return true; // All validations passed
}
</script>

</body>
</html>