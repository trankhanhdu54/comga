<?php

   include 'components/connect.php';

   session_start();

   if(isset($_SESSION['user_id'])){
      $user_id = $_SESSION['user_id'];
   }else{
      $user_id = '';
   };

   include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cơm Gà Zu Gold</title>
   <link rel="icon" href="images/logo.png">
    <meta name="description" content="Cơm Gà Zu Gold chuyên cung cấp thức ăn nhanh ngon, sạch số một tại Cần Thơ">
    <meta property="og:type" content="profile">
    <meta property="og:title" content="Cơm Gà Zu Gold | Cần Thơ">

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />
   <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous"> -->

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/stylenew.css">
   


</head>
<body>

<?php include 'components/user_header.php'; ?>


<section class="hero">

   <div class="swiper hero-slider">
      <div class="swiper-wrapper">
      <?php
      $show_slider = $conn->prepare("SELECT * FROM `slider` ORDER BY id DESC");
      $show_slider->execute();
      if($show_slider->rowCount() > 0){
         while($fetch_slider = $show_slider->fetch(PDO::FETCH_ASSOC)){  
   ?>
         <div class="swiper-slide slide">
            <div class="content">
               <span>Our special best seller</span>
               <h3><?= $fetch_slider['name']; ?></h3>
               <a style="text-decoration: none" href="menu" class="btnz">Xem Menu</a>
            </div>
            <div class="image">
               <img src="slider_img/<?= $fetch_slider['image']; ?>" alt="">
            </div>
         </div>
         <?php
         }
      }else{
         echo '<p class="empty">Chưa có Slider được thêm vào!</p>';
      }
   ?>
      </div>
      

      <div class="swiper-pagination"></div>

   </div>

</section>


<section class="category">

   <h1 class="title">DANH MỤC MÓN ĂN</h1>

   <div class="box-container">
   <?php
      $show_category = $conn->prepare("SELECT * FROM `category`");
      $show_category->execute();
      if($show_category->rowCount() > 0){
         while($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)){  
   ?>
      <a style="text-decoration: none" href="danhmuc?category=<?= $fetch_category['iddanhmuc']; ?>" class="box">
         <img src="category_img/<?= $fetch_category['image']; ?>" alt="<?= $fetch_category['namedanhmuc']; ?>">
         <h3><?= $fetch_category['namedanhmuc']; ?></h3>
      </a>
      <?php
         }
      }else{
         echo '<p class="empty">Chưa có danh mục được thêm vào!</p>';
      }
   ?>
   </div>
   <nav class="navbar">
      
         <div class="dropdown">
         <button style="padding-top:10px" class="nut_dropdown">Loại Món Ăn<i class="fa fa-caret-down"></i></button>
         
               <div class="noidung_dropdown"> 
   <?php
      $show_category = $conn->prepare("SELECT * FROM `loaisp`");
      $show_category->execute();
      if($show_category->rowCount() > 0){
         while($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)){  
   ?>
                  <a style="text-decoration: none;" href="loaisanpham?loaisp=<?= $fetch_category['name']; ?>"><?= $fetch_category['name']; ?></a>
                  <?php
         }
      }else{
         echo '<p class="empty">Chưa có danh mục được thêm vào!</p>';
      }
   ?>
               </div>
               
      </div>
      

</section>
      

<section class="dishes" id="dishes">
    <h1 class="title">Món ăn mới</h1>

    <div class="box-container">
    <?php
         $select_products = $conn->prepare("SELECT * FROM `products` ORDER BY id DESC LIMIT 6");
         $select_products->execute();
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
      ?>

        <form action="" method="post" class="box">
            <!-- <a style="text-decoration: none" href="#" class="fas fa-heart"></a>
            <a style="text-decoration: none" href="xemchitiet?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a> -->
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
            <input type="hidden" name="fff" value="<?= $fetch_products['fff']; ?>">
            <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
            
            
            <a href="xemchitiet?pid=<?= $fetch_products['id']; ?>"><img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="<?= $fetch_products['name']; ?>"></a>
            <h3><a href="xemchitiet?pid=<?= $fetch_products['id']; ?>" style="text-decoration: none; color:black;"><?= $fetch_products['name']; ?></a></h3>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <span><?= $fetch_products['price']; ?></span><span style="font-weight: 400;position: relative;top: -9px;font-size: 13px;right: 0;">VNĐ/<?= $fetch_products['fff']; ?></span>
            <button class="btnbut" type="submit" name="add_to_cart"> Thêm giỏ hàng</button>
            <input type="hidden" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
            
            </form>
            <?php
            }
         }else{
            echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
         }
      ?>

    </div>
    <div class="more-btnz">
    <a style="text-decoration: none; background-color:#192a56;" href="menu" class="btnz">Xem tất cả</a>
   </div>

</section>



<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>


<script>

var swiper = new Swiper(".hero-slider", {
   loop:true,
   grabCursor: true,
   effect: "flip",
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
});

</script>

</body>
</html>
