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

include 'components/wishlist_cart.php';
 


if (isset($_POST['delete'])) {
   $wishlist_id = $_POST['wishlist_id'];
   $delete_wishlist_item_query = "DELETE FROM `wishlist` WHERE id = $wishlist_id";
   $delete_wishlist_item=mysqli_query($conn, $delete_wishlist_item_query);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete_all'])) {
   // $user_id = 1;
   $delete_wishlist_items_query = "DELETE FROM `wishlist` WHERE user_id = $user_id";
   $delete_wishlist_item = mysqli_query($conn, $delete_wishlist_items_query);
   header('Location: wishlist.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>wishlist</title>
   
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


</style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h3 class="heading">wishlist</h3>

   <div class="box-container">

   <?php
      
      $grand_total = 0;
      $select_wishlist = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = $user_id");

      if(mysqli_num_rows($select_wishlist) > 0) {
         while ($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)) {
         $grand_total += $fetch_wishlist['price']; 
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="pid" value="<?= $fetch_wishlist['pid']; ?>">
      <input type="hidden" name="wishlist_id" value="<?= $fetch_wishlist['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_wishlist['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_wishlist['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_wishlist['image']; ?>">
      <a href="quick_view.php?pid=<?= $fetch_wishlist['pid']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_wishlist['image']; ?>" alt="">
      <div class="name"><?= $fetch_wishlist['name']; ?></div>
      <div class="flex">
         <div class="price">Rs. <?= $fetch_wishlist['price']; ?>/-</div>
         <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
      </div>
      <input type="submit" value="add to cart" class="btn" name="add_to_cart">
      <input type="submit" value="delete item" onclick="return confirm('delete this from wishlist?');" class="delete-btn" name="delete">
   </form>
   <?php
      }
   }else{
      echo '<p class="empty"><img src="images/wishlist.png" alt="">  your wishlist is empty</p>';
   }
   ?>
   </div>

   <div class="wishlist-total">
      <p>grand total : <span>Rs. <?= $grand_total; ?>/-</span></p>
      <a href="shop.php" class="option-btn">continue shopping</a>
      <a href="wishlist.php?delete_all" class="delete-btn <?= ($grand_total > 1)?'':'disabled'; ?>" onclick="return confirm('delete all from wishlist?');">delete all item</a>
   </div>

</section>


<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>