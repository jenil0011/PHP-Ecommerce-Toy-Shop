<?php
error_reporting(0);
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>home</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
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

<section class="category">

   <h1 class="heading">shop by category</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="category.php?category=car" class="swiper-slide slide">
      <img src="images/icon-1.png" alt="">
      <h3>cars</h3>
   </a>

   <a href="category.php?category=doll" class="swiper-slide slide">
      <img src="images/icon3.png" alt="">
      <h3>dolls</h3>
   </a>

   <a href="category.php?category=buildongbricks" class="swiper-slide slide">
      <img src="images/icon4.png" alt="">
      <h3>building bricks</h3>
   </a>

   <a href="category.php?category=plane" class="swiper-slide slide">
      <img src="images/icon5.png" alt="">
      <h3>planes</h3>
   </a>

   <a href="category.php?category=guns" class="swiper-slide slide">
      <img src="images/icon6.png" alt="">
      <h3>guns</h3>
   </a>


   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>




<section class="category">

   <h1 class="heading">shop by brand</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="brand.php?brand=hotwheel" class="swiper-slide slide">
      <img src="images/b1.png" alt="">
   </a>

   <a href="brand.php?brand=barbie" class="swiper-slide slide">
       <img src="images/b2.png" alt="">
   </a>

   <a href="brand.php?brand=lego" class="swiper-slide slide">
      <img src="images/b3.png" alt="">
   </a>

   <a href="brand.php?brand=suicidesquad" class="swiper-slide slide">
      <img src="images/b4.png" alt="">
   </a>

   <a href="brand.php?brand=maxsteel" class="swiper-slide slide">
      <img src="images/b5.png" alt="">
   </a>

   <a href="brand.php?brand=playdoh" class="swiper-slide slide">
      <img src="images/b6.png" alt="">
   </a>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>
    


<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});


</script>

</body>
</html>