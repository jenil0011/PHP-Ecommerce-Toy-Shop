<?php
error_reporting(0);
   if(isset($message)){
      foreach($message as $message){
         echo '
         <div class="message">
            <span>'.$message.'</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
         </div>
         ';
      }
   }
?>

<header class="header">

<style>
   /* for navbar logo  */
    @import url("https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900");

* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
	font-family: "Poppins", sans-serif;
}


.logo {
	position: relative;
}

.logo h2 {
	color: burlywood;
	font-size: 1.5em;
	position: absolute;
	transform: translate(-50%, -50%);
}

.logo h2:nth-child(1) {
	color: yellow;
	-webkit-text-stroke: 2px #8338ec;
}

.logo h2:nth-child(2) {
	color: lightcoral;
	animation: animate 2s ease-in-out infinite;
}

@keyframes animate {
	0%,
	100% {
		clip-path: polygon(
			0% 45%,
			16% 44%,
			33% 50%,
			54% 60%,
			70% 61%,
			84% 59%,
			100% 52%,
			100% 100%,
			0% 100%
		);
	}

	50% {
		clip-path: polygon(
			0% 60%,
			15% 65%,
			34% 66%,
			51% 62%,
			67% 50%,
			84% 45%,
			100% 46%,
			100% 100%,
			0% 100%
		);
	}
}

</style>

   <section class="flex">

      <!-- <a href="../admin/dashboard.php" class="logo">Admin<span>Panel</span></a> -->
      <a href="dashboard.php" class="logo">
         <h2>ADMINPANEL</h2>
         <h2>ADMINPANEL</h2></a>

      <nav class="navbar">
         <a href="../admin/dashboard.php">home</a>
         <a href="../admin/products.php">products</a>
         <a href="../admin/placed_orders.php">orders</a>
         <a href="../admin/admin_accounts.php">admins</a>
         <a href="../admin/users_accounts.php">users</a>
         <a href="../admin/messages.php">messages</a>
         <a href="../admin/feedback.php">feedbacks</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $sql = "SELECT * FROM admins WHERE id = " . $admin_id;
            $result = mysqli_query($conn, $sql);
            $fetch_profile = mysqli_fetch_assoc($result); 
        ?>
        <img src="images/man.png" alt="">
         <p>Hey! <?= $fetch_profile['name']; ?></p>
         
         <a href="../admin/update_profile.php" class="btn">update profile</a>
         <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
      </div>

      <div class="profile">
         <?php
         $sql = "SELECT * FROM `admins` WHERE id = $admin_id";
         $result = mysqli_query($conn, $sql);

         if (mysqli_num_rows($result) > 0) {
            $fetch_profile = mysqli_fetch_assoc($result);
         ?>
         <img src="images/man.png" alt="">
         <p>Hey! <?= $fetch_profile['name']; ?></p>
         <a href="../admin/update_profile.php" class="btn">update profile</a>
         <a href="../components/admin_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
      </div>
      <?php
      } else {
         echo "Admin not found";
      }

      ?>
      
<?php

if(isset($_POST['search_box']) || isset($_POST['search_btn'])){
    $search_box = $_POST['search_box'];
    $query = "SELECT * FROM `products` WHERE name LIKE '%$search_box%'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){
        while($fetch_product = mysqli_fetch_assoc($result)){
?>
<form action="handle_product.php" method="post" class="box">
   <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
   <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
   <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
   <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">
   <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
   <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
   <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">
   <div class="name"><?= $fetch_product['name']; ?></div>
   <div class="flex">
      <div class="price"><span>Rs. </span><?= $fetch_product['price']; ?><span>/-</span></div>
      <input type="number" name="qty" class="qty" min="1" max="99" onkeypress="if(this.value.length == 2) return false;" value="1">
   </div>
   <input type="submit" value="add to cart" class="btn" name="add_to_cart">
</form>
<?php
        }
    } else {
        echo '<p class="empty">no products found!</p>';
    }
}

?>

</div>

</section>

      <?php
error_reporting(0);
include 'components/connect.php';
