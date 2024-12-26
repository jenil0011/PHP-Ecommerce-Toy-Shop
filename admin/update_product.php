<?php
error_reporting(0);

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}


if(isset($_POST['update'])){

   $pid = mysqli_real_escape_string($conn, $_POST['pid']);
   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $brand = mysqli_real_escape_string($conn, $_POST['brand']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);

    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $price = filter_var($price, FILTER_SANITIZE_STRING);
    $brand = filter_var($brand, FILTER_SANITIZE_STRING);
    $details = filter_var($details, FILTER_SANITIZE_STRING);

    $update_product_query = "UPDATE `products` SET name = '$name', price = '$price', brand = '$brand',details = '$details' WHERE id = '$pid'";
    $update_product = mysqli_query($conn, $update_product_query);

    if ($update_product) {
      $message[] = 'Product updated successfully!';

      for ($i = 1; $i <= 3; $i++) {
          $image = 'image_0' . $i;
          $old_image = 'old_image_0' . $i;
          $image_name = $_FILES[$image]['name'];
          $image_size = $_FILES[$image]['size'];
          $image_tmp_name = $_FILES[$image]['tmp_name'];
          $image_folder = '../uploaded_img/' . $image_name;

          $image_name = mysqli_real_escape_string($conn, $image_name);

          if (!empty($image_name)) {
              if ($image_size > 2000000) {
                  $message[] = 'Image size is too large!';
              } else {
                  $update_image_query = "UPDATE `products` SET $image = '$image_name' WHERE id = '$pid'";
                  $update_image_result = mysqli_query($conn, $update_image_query);

                  if ($update_image_result) {
                      move_uploaded_file($image_tmp_name, $image_folder);
                      unlink('../uploaded_img/' . $_POST[$old_image]);
                      $message[] = 'Image ' . $i . ' updated successfully!';
                  }
              }
          }
      }
  } else {
      $message[] = 'Error updating product: ' . mysqli_error($conn);
  }

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>update product</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-product">

   <h1 class="heading">update product</h1>

   <?php
      $update_id = $_GET['update']; 
      $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE id = '$update_id'");
         
      if (mysqli_num_rows($select_products) > 0) {
         while ($fetch_products = mysqli_fetch_assoc($select_products)) {
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_products['image_01']; ?>">
      <input type="hidden" name="old_image_02" value="<?= $fetch_products['image_02']; ?>">
      <input type="hidden" name="old_image_03" value="<?= $fetch_products['image_03']; ?>">
      <div class="image-container">
         <div class="main-image">
            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
         </div>
         <div class="sub-image">
            <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
            <img src="../uploaded_img/<?= $fetch_products['image_02']; ?>" alt="">
            <img src="../uploaded_img/<?= $fetch_products['image_03']; ?>" alt="">
         </div>
      </div>
      <span>update name</span>
      <input type="text" name="name" required class="box" maxlength="100" placeholder="enter product name" value="<?= $fetch_products['name']; ?>">
      <span>update price</span>
      <input type="number" name="price" required class="box" min="0" max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" value="<?= $fetch_products['price']; ?>">
      <span>update details</span>
      <textarea name="details" class="box" required cols="30" rows="10"><?= $fetch_products['details']; ?></textarea>
      <span>update brand</span>
      <input type="text" name="brand" required class="box" maxlength="100" placeholder="enter product brand" value="<?= $fetch_products['brand']; ?>">
      <span>update image 01</span>
      <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <span>update image 02</span>
      <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <span>update image 03</span>
      <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <div class="flex-btn">
         <input type="submit" name="update" class="btn" value="update">
         <a href="products.php" class="option-btn">go back</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">no product found!</p>';
      }
   ?>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>