<?php
error_reporting(0);

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};


if(isset($_POST['add_product'])){

   $name = mysqli_real_escape_string($conn, $_POST['name']);
   $price = mysqli_real_escape_string($conn, $_POST['price']);
   $brand = mysqli_real_escape_string($conn, $_POST['brand']);
   $details = mysqli_real_escape_string($conn, $_POST['details']);

   $image_01 = mysqli_real_escape_string($conn, $_FILES['image_01']['name']);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   $image_02 = mysqli_real_escape_string($conn, $_FILES['image_02']['name']);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   $image_03 = mysqli_real_escape_string($conn, $_FILES['image_03']['name']);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE name = '$name'");

   if(mysqli_num_rows($select_products) > 0){
       $message[] = 'Product name already exists!';
   } else {
       $insert_products = mysqli_query($conn, "INSERT INTO `products` (name, details, price, brand, image_01, image_02, image_03) VALUES ('$name', '$details', '$price', '$brand' , '$image_01', '$image_02', '$image_03')");

       if($insert_products){
           if($image_size_01 > 9000000 || $image_size_02 > 9000000 || $image_size_03 > 9000000){
               $message[] = 'Image size is too large!';
           } else {
               move_uploaded_file($image_tmp_name_01, $image_folder_01);
               move_uploaded_file($image_tmp_name_02, $image_folder_02);
               move_uploaded_file($image_tmp_name_03, $image_folder_03);
               $message[] = 'New product added!';
           }
       }
   }

};


if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];

   // Check if the product exists
   $select_product = mysqli_query($conn, "SELECT * FROM `products` WHERE id = $delete_id");
   if(mysqli_num_rows($select_product) > 0) {
       // Fetch product details before deletion
       $fetch_delete_image = mysqli_fetch_assoc($select_product);

       // Delete associated images
       unlink('../uploaded_img/' . $fetch_delete_image['image_01']);
       unlink('../uploaded_img/' . $fetch_delete_image['image_02']);
       unlink('../uploaded_img/' . $fetch_delete_image['image_03']);

       // Delete the product from the products table
       mysqli_query($conn, "DELETE FROM `products` WHERE id = $delete_id");

       // Delete related entries from cart and wishlist tables
       mysqli_query($conn, "DELETE FROM `cart` WHERE pid = $delete_id");
       mysqli_query($conn, "DELETE FROM `wishlist` WHERE pid = $delete_id");
   }

   header('Location: products.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">add product</h1>

   <form action="" name="productform" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
      <div class="flex">
         <div class="inputBox">
            <span>product name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="name">
         </div>
         <div class="inputBox">
            <span>product price (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price"  name="price">
         </div>
         <div class="inputBox">
            <span>product brand (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product brand" name="brand">
         </div>
        <div class="inputBox">
            <span>image 01 (required)</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>image 02 (required)</span>
            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>image 03 (required)</span>
            <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
         <div class="inputBox">
            <span>product details (required)</span>
            <textarea name="details" placeholder="enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
      </div>
      
      <input type="submit" value="add product" class="btn" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="heading">products added</h1>

   <div class="box-container">

   <?php
      $query = "SELECT * FROM products";
      $select_products = mysqli_query($conn, $query);
            
      if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_products = mysqli_fetch_assoc($select_products)) { 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_products['name']; ?></div>
      <div class="price">Rs. <span><?= $fetch_products['price']; ?></span>/-</div>
      <div class="price"><span><?= $fetch_products['brand']; ?></span></div>
      <div class="details"><span><?= $fetch_products['details']; ?></span></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['id']; ?>" class="option-btn">update</a>
         <a href="products.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>
   
   </div>

</section>


<script src="../js/admin_script.js"></script>

<script>
        function validateForm() {

            // Name validation
            var brand = document.forms["productform"]["brand"].value;
            if (!/^[a-zA-Z\s]*$/.test(brand)) {
                alert("Brand should contain only alphabets.");
                return false;
            }

            // Price validation
            var price = document.forms["productform"]["price"].value;
            if (!/^[0-9]+$/.test(price)) {
                alert("Price should contain only numeric values.");
                return false;
            }

            // If all validations pass, the form will be submitted
            return true;
        }
    </script>
   
</body>
</html>