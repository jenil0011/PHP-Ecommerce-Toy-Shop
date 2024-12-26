<?php
error_reporting(0);
include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>

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

@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap");

*,
*::after,
*::before {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

#cards {
  place-items: center;
  margin-top: 150px;
  margin-bottom: 150px;
  width: 90%;
  padding-inline: 20px;
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
  align-items: center;
  justify-content: center;

}

.card {
  min-width: 200px;
  height: 350px;
  flex: 1 1 250px;
  background-color: rgba(255, 255, 255, 0.12);
  border-radius: 12px;
  position: relative;
}

#cards:hover > .card {
  background: radial-gradient(
    400px circle at var(--mouse-x) var(--mouse-y),
    hsl(var(--color) / 1),
    rgba(255, 255, 255, 0.12) 40%
  );
}

.card-content {
  position: absolute;
  inset: 1px;
  background-color: #435585;
  border-radius: inherit;
}

.card:nth-child(1) {
  --color: 348 80% 60%;
}
.card:nth-child(2) {
  --color: 0 0% 100%;
}
.card:nth-child(3) {
  --color: 220 100% 35%;
}

.card::before {
  content: "";
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  background: radial-gradient(
    500px circle at var(--mouse-x) var(--mouse-y),
    hsl(var(--color) / 0.35),
    transparent 40%
  );
  border-radius: inherit;
  opacity: 0;
  z-index: 2;
}

#cards:hover > .card::before {
  opacity: 1;
}

a {
  all: unset;
  cursor: pointer;
}

.card-content {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  gap: 18px;
  align-items: center;
}

.card-content > i {
  font-size: 10rem;
  color: rgba(255, 255, 255, 0.5);
}

.card-content > p {
  color: rgba(255, 255, 255, 0.5);
}

.card-content > a {
  width: 90%;
  padding-block: 0.8rem;
  background-color: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 6px;

  display: flex;
  justify-content: center;
  align-items: center;
  gap: 8px;
  z-index: 10;
}
.card-content > a:hover {
  background-color: rgba(255, 255, 255, 0.1);
  border: 1px solid rgba(255, 255, 255, 0.2);
}

</style>

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div id="cards">
      <div class="card">
        <div class="card-content">
          <i class="fa-brands fa-instagram"></i>
          <h2>Instagram</h2>

          <p>Followers: <span>33K</span></p>

          <a href="#">
            <i class="fa-solid fa-link"></i>
            <span>Follow us on Instagram</span>
          </a>
        </div>
      </div>
      <div class="card">
        <div class="card-content">
          <i class="fa-brands fa-github"></i>
          <h2>GitHub</h2>

          <p>Followers: <span>330</span></p>

          <a href="#">
            <i class="fa-solid fa-link"></i>
            <span>Follow us on GitHub</span>
          </a>
        </div>
      </div>
      <div class="card">
        <div class="card-content">
          <i class="fa-brands fa-linkedin"></i>
          <h2>Linkedin</h2>

          <p>Followers: <span>550</span></p>

          <a href="#">
            <i class="fa-solid fa-link"></i>
            <span>Follow us on Linkedlin</span>
          </a>
        </div>
      </div>
    </div>


<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>
const cards = Array.from(document.querySelectorAll(".card"));
const cardsContainer = document.querySelector("#cards");

cardsContainer.addEventListener("mousemove", (e) => {
  for (const card of cards) {
    const rect = card.getBoundingClientRect();
    x = e.clientX - rect.left;
    y = e.clientY - rect.top;

    card.style.setProperty("--mouse-x", `${x}px`);
    card.style.setProperty("--mouse-y", `${y}px`);
  }
});

</script>

</body>
</html>