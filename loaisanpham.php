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
   <title>Menu</title>
   <link rel="icon" href="images/logo.png">
   <meta name="description" content="Cơm Gà Zu Gold chuyên cung cấp thức ăn nhanh ngon, sạch số một tại Cần Thơ">
    <meta property="og:type" content="profile">
    <meta property="og:title" content="Cơm Gà Zu Gold | Cần Thơ">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/stylenew.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Menu</h3>
   <p><a style="text-decoration: none"href="home">Home</a> <span> / Menu</span></p>
</div>

<!-- menu section starts  -->



<section class="dishes" id="dishes">
    <h1 class="title">MENU <nav class="navbar">
      
      <div class="dropdown">
      <button style="padding-top:10px" class="nut_dropdown">Loại Sản Phẩm<i class="fa fa-caret-down"></i></button>
      
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
            
   </div></h1>

    <div class="box-container">
    <?php
        $loaisp = $_GET['loaisp'];
        $select_products = $conn->prepare("SELECT * FROM `products` WHERE loaisanpham LIKE ?");
        $select_products->execute([$loaisp]);
         if($select_products->rowCount() > 0){
            while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
    ?>
<form action="" method="post" class="box">
            
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
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

</section>

<!-- menu section ends -->
























<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>