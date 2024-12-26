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
      <a href="staff_dashboard.php" class="logo">
         <h2>STAFFPANEL</h2>
         <h2>STAFFPANEL</h2></a>

      <nav class="navbar">
         <a href="../staff/staff_dashboard.php">home</a>
         <a href="../staff/staff_products.php">products</a>
         <a href="../staff/orders.php">orders</a>
      </nav>

      <div class="icons">
         <div id="menu-btn" class="fas fa-bars"></div>
         <div id="user-btn" class="fas fa-user"></div>
      </div>

      <div class="profile">
         <?php
            $sql = "SELECT * FROM staff WHERE id = " . $staff_id;
            $result = mysqli_query($conn, $sql);
            $fetch_profile = mysqli_fetch_assoc($result); 
        ?>
        <img src="images/contact.png" alt="">
         <p>Hey! <?= $fetch_profile['name']; ?></p>
         <a href="../staff/update_staff.php" class="btn">update profile</a>
         <a href="../components/staff_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
      </div>

      <div class="profile">
         <?php
         $sql = "SELECT * FROM `staff` WHERE id = $staff_id";
         $result = mysqli_query($conn, $sql);

         if (mysqli_num_rows($result) > 0) {
            $fetch_profile = mysqli_fetch_assoc($result);
         ?>
         <p>Hey! <?= $fetch_profile['name']; ?></p>
         <a href="../staff/update_staff.php" class="btn">update profile</a>
         <a href="../components/staff_logout.php" class="delete-btn" onclick="return confirm('logout from the website?');">logout</a> 
      </div>
      <?php
      } else {
         echo "staff not found";
      }
      ?>

   </section>

</header>