<?php
error_reporting(0);


if(isset($_POST['add_to_wishlist'])){
   if($user_id == ''){
       header('location:user_login.php');
   } else {
       $pid = mysqli_real_escape_string($conn, $_POST['pid']);
       $name = mysqli_real_escape_string($conn, $_POST['name']);
       $price = mysqli_real_escape_string($conn, $_POST['price']);
       $image = mysqli_real_escape_string($conn, $_POST['image']);

       $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$name' AND user_id = '$user_id'");
       $check_wishlist_count = mysqli_num_rows($check_wishlist_numbers);

       $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$name' AND user_id = '$user_id'");
       $check_cart_count = mysqli_num_rows($check_cart_numbers);

       if($check_wishlist_count > 0){
           $message[] = 'already added to wishlist!';
       } elseif($check_cart_count > 0){
           $message[] = 'already added to cart!';
       } else {
           $insert_wishlist = mysqli_query($conn, "INSERT INTO `wishlist`(user_id, pid, name, price, image) VALUES('$user_id', '$pid', '$name', '$price', '$image')");
           if($insert_wishlist){
               $message[] = 'added to wishlist!';
           } else {
               $message[] = 'Error adding to wishlist.';
           }
       }
   }
}


if (isset($_POST['add_to_cart'])) {
   if ($user_id == '') {
       header('Location: user_login.php');
   } else {

       $pid = mysqli_real_escape_string($conn, $_POST['pid']);
       $name = mysqli_real_escape_string($conn, $_POST['name']);
       $price = mysqli_real_escape_string($conn, $_POST['price']);
       $image = mysqli_real_escape_string($conn, $_POST['image']);
       $qty = mysqli_real_escape_string($conn, $_POST['qty']);

       $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$name' AND user_id = '$user_id'");
       if (mysqli_num_rows($check_cart_numbers) > 0) {
           $message[] = 'already added to cart!';
       } else {
           $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE name = '$name' AND user_id = '$user_id'");
           if (mysqli_num_rows($check_wishlist_numbers) > 0) {
               mysqli_query($conn, "DELETE FROM `wishlist` WHERE name = '$name' AND user_id = '$user_id'");
           }

           $insert_cart = mysqli_query($conn, "INSERT INTO `cart`(user_id, pid, name, price, quantity, image) VALUES('$user_id', '$pid', '$name', '$price', '$qty', '$image')");
           if ($insert_cart) {
               $message[] = 'added to cart!';
           }
       }
   }
}

?>