<?php
error_reporting(0);
//ini_set('display_errors', 1);

// Include the database connection file
include '../components/connect.php'; // Ensure this path is correct

session_start(); // Start the session

// Initialize user_id
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

// Display messages if set
if (isset($message)) {
    foreach ($message as $msg) {
        echo '
        <div class="message">
            <span>' . htmlspecialchars($msg) . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>

<style>
   /* Your existing CSS */
</style>

<header class="header">
   <section class="flex"> 
      <a href="home.php" class="logo">
          <h2>TOYMANIA</h2>
      </a>
      
      <nav class="navbar">
         <a href="home.php">HOME</a>
         <a href="orders.php">ORDERS</a>
         <a href="shop.php">PRODUCTS</a>
         <a href="contact.php">CONTACT</a>
         <a href="review.php">FEEDBACK</a>
         <a href="view_category.php">CATEGORY</a>
      </nav>
    
      <div class="icons">
         <?php
         // Check user ID before querying
         if ($user_id) {
             // Count wishlist items
             $count_wishlist_items = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE user_id = '$user_id'");
             $total_wishlist_counts = mysqli_num_rows($count_wishlist_items);

             // Count cart items
             $count_cart_items = mysqli_query($conn, "SELECT * FROM `cart` WHERE user_id = '$user_id'");
             $total_cart_counts = mysqli_num_rows($count_cart_items);
         } else {
             $total_wishlist_counts = 0;
             $total_cart_counts = 0;
         }
         ?>
         <div id="menu-btn" class="fas fa-bars"></div>
         <a href="search_page.php"><i class="fas fa-search"></i></a>
         <a href="wishlist.php"><i class="fas fa-heart"></i><span>(<?= $total_wishlist_counts; ?>)</span></a>
         <a href="cart.php"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_counts; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <a href="components/user_logout.php"><i class="fa fa-sign-out"></i></a>
      </div>
      
      <div class="profile">
         <?php
         if ($user_id) {
             // Fetch user profile
             $select_profile = mysqli_query($conn, "SELECT * FROM `users` WHERE id = '$user_id'");
             $row_count = mysqli_num_rows($select_profile);

             if ($row_count > 0) {
                 $fetch_profile = mysqli_fetch_assoc($select_profile);
         ?> 
                 <img src="images/man.png" alt="">
                 <p>Hey! <?= htmlspecialchars($fetch_profile["name"]); ?></p>
                 <a href="update_user.php" class="btn">Update Profile</a>
         <?php
             } else {
                 echo "<p>User not found.</p>";
             }
         } else {
         ?>
             <p>Please login or register first!</p>
             <div class="flex-btn">
                <a href="user_register.php" class="option-btn">Register</a>
                <a href="user_login.php" class="option-btn">Login</a>
             </div>
         <?php
         }
         ?>      
      </div>
   </section>
</header>
