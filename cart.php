<?php
error_reporting(0);
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:user_login.php');
};


if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = mysqli_query($conn, "DELETE FROM `cart` WHERE id = '$cart_id'");
}



if(isset($_GET['delete_all'])){
   // $user_id = /* Assuming $user_id is retrieved/initialized */;
   $delete_cart_item = mysqli_query($conn, "DELETE FROM `cart` WHERE user_id = '$user_id'");
   header('location:cart.php');
}


if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = mysqli_real_escape_string($conn, $qty); // Sanitize input
   $update_qty = mysqli_query($conn, "UPDATE `cart` SET quantity = '$qty' WHERE id = '$cart_id'");
   $message[] = 'cart quantity updated';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>
   
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

<section class="products shopping-cart">

   <h3 class="heading">cart</h3>

   <div class="box-container">

   <?php

      $grand_total = 0;      
      // $user_id = 1; // Assuming a user ID, change this according to your user authentication logic
         
      $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = $user_id");
         
      if (mysqli_num_rows($select_cart) > 0) {
         while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {    
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
      <a href="quick_view.php?pid=<?= $fetch_cart['pid']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
      <div class="name"><?= $fetch_cart['name']; ?></div>
      <div class="flex">
         <div class="price">Rs. <?= $fetch_cart['price']; ?>/-</div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="<?= $fetch_cart['quantity']; ?>">
         <button type="submit" class="fas fa-edit" name="update_qty"></button>
      </div>
      <div class="sub-total"> sub total : <span>Rs. <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>/-</span> </div>
      <input type="submit" value="delete item" onclick="return confirm('delete this from cart?');" class="delete-btn" name="delete">
   </form>
   <?php
   $grand_total += $sub_total;
      }
   }else{
      echo '<p class="empty"><img src="images/delete.png" alt="">Your Cart Is Empty</p>';
   }
   ?>
   </div>

   <div class="cart-total">
      <p>grand total : <span>Rs. <?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <a href="cart.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from cart?');">delete all item</a>
      <a href="checkout.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">proceed to checkout</a>
   </div>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>