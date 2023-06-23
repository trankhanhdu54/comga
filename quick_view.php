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
   <title>Chi Tiết Sản Phẩm</title>
   <link rel="icon" href="images/logo.png">
   <meta name="description" content="Cơm Gà Zu Gold chuyên cung cấp thức ăn nhanh ngon, sạch số một tại Cần Thơ">
    <meta property="og:type" content="profile">
    <meta property="og:title" content="Cơm Gà Zu Gold | Cần Thơ">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/view.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v15.0&appId=2416650061976445&autoLogAppEvents=1" nonce="AQGFGKY7"></script>

<section class="quick-view">
<h1 class="title"> Xem Chi Tiết</h1>
<bodyz>
<?php
      $pid = $_GET['pid'];
      $select_products = $conn->prepare("SELECT category.iddanhmuc,category.namedanhmuc, products.id,products.name,products.price,products.image,products.fff,products.chitiet
      FROM products,category WHERE category.iddanhmuc=products.id LIKE ? LIMIT 1;");
      $select_products->execute([$pid]);
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
   ?>
<form action="" method="post">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
      <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
      <input type="hidden" name="fff" value="<?= $fetch_products['fff']; ?>">
  <div class="wrapper">
    <div class="zproduct-img">
      <img src="uploaded_img/<?= $fetch_products['image']; ?>" height="420" width="327">
    </div>
    <div class="product-info">
      <div class="product-text">
        <h1><?= $fetch_products['name']; ?></h1>
        <h2>Danh mục: <?= $fetch_products['namedanhmuc']; ?></h2>
        <p><?= $fetch_products['chitiet']; ?></p>
      </div>
      <div class="product-price-btn">
        <p style="color: var(--green);"><span><?= $fetch_products['price']; ?></span>đ/<?= $fetch_products['fff']; ?> <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2"></p>
        
        <button type="submit" name="add_to_cart">Thêm giỏ hàng</button>
      </div>
    </div>
  </div>
  </form>
  <div style="text-align: center;" class="fb-comments" data-href="https://haisanhoaiphuong.com/xemchitiet?pid=<?= $fetch_products['id']; ?>" data-width="450" data-numposts="5"></div>

  <?php
         }
      }else{
         echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
      }
   ?>
</bodyz>


</section>
















<?php include 'components/footer.php'; ?>


<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="js/script.js"></script>


</body>
</html>