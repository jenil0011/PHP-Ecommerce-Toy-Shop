<?php
session_start();
error_reporting(0);
//ini_set('display_errors', 1);

// Include the database connection
include 'components/connect.php';

// Check database connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get user ID
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

// Include wishlist and cart logic if needed
include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Toy Mania</title>

    <!-- Stylesheets -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;800&display=swap");

        /* CSS variables and styles */
        :root {
            --clr-1: #00c2ff;
            --clr-2: #33ff8c;
            --clr-3: #ffc640;
            --clr-4: #e54cff;
            --blur: 1rem;
            --fs: clamp(3rem, 8vw, 7rem);
            --ls: clamp(-1.75px, -0.25vw, -3.5px);
        }

        /* Additional styles here... */

    </style>
</head>
<body>

<?php include 'components/user_header.php'; ?>

<div class="name-plate">
    <h1 class="title">Welcome To Toy Mania
        <div class="aurora">
            <div class="aurora__item"></div>
            <div class="aurora__item"></div>
            <div class="aurora__item"></div>
            <div class="aurora__item"></div>
        </div>
    </h1>
</div>

<div class="home-bg">
    <section class="home">
        <div class="swiper home-slider">
            <div class="swiper-wrapper">
                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="images/homeimg1.png" alt="">
                    </div>
                    <div class="content">
                        <span>upto 40% off</span>
                        <h3>on latest toy cars</h3>
                        <a href="shop.php" class="btn">shop now</a>
                    </div>
                </div>
                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="images/homeimg2.png" alt="">
                    </div>
                    <div class="content">
                        <span>upto 50% off</span>
                        <h3>on brand new lego toys, unlock new adventures</h3>
                        <a href="shop.php" class="btn">shop now</a>
                    </div>
                </div>
                <div class="swiper-slide slide">
                    <div class="image">
                        <img src="images/homeimg3.png" alt="">
                    </div>
                    <div class="content">
                        <span>upto 50% off</span>
                        <h3>on newly launched toy planes</h3>
                        <a href="shop.php" class="btn">shop now</a>
                    </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </section>
</div>

<section class="home-products">
    <h1 class="heading">Latest Products</h1>
    <div class="swiper products-slider">
        <div class="swiper-wrapper">

        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products` LIMIT 6");

        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                ?>
                <form action="#" method="post" class="swiper-slide slide">
                    <input type="hidden" name="pid" value="<?= $fetch_product['id']; ?>">
                    <input type="hidden" name="name" value="<?= $fetch_product['name']; ?>">
                    <input type="hidden" name="price" value="<?= $fetch_product['price']; ?>">
                    <input type="hidden" name="image" value="<?= $fetch_product['image_01']; ?>">

                    <button class="fas fa-heart" type="submit" name="add_to_wishlist"></button>
                    <a href="quick_view.php?pid=<?= $fetch_product['id']; ?>" class="fas fa-eye"></a>
                    <img src="uploaded_img/<?= $fetch_product['image_01']; ?>" alt="">

                    <div class="name"><?= $fetch_product['name']; ?></div>
                    <div class="brand"><?= $fetch_product['brand']; ?></div>
                    <div class="flex">
                        <div class="price"><span>Rs. </span><?= $fetch_product['price']; ?><span>/-</span></div>
                        <input type="number" name="qty" class="qty" min="1" max="99" value="1" onkeypress="if(this.value.length == 2) return false;">
                    </div>
                    <input type="submit" value="Add to Cart" class="btn" name="add_to_cart">
                </form>
                <?php
            }
        } else {
            echo '<p class="empty">No products added yet!</p>';
        }
        ?>

        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
<script src="js/script.js"></script>

<script>
var swiper = new Swiper(".home-slider", {
    loop: true,
    spaceBetween: 20,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
});

var swiper = new Swiper(".products-slider", {
    loop: true,
    spaceBetween: 20,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },
    breakpoints: {
        550: {
            slidesPerView: 2,
        },
        768: {
            slidesPerView: 2,
        },
        1024: {
            slidesPerView: 3,
        },
    },
});
</script>

</body>
</html>
