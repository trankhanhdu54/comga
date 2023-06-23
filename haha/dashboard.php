<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Trang Quản Lí</title>
   <link rel="icon" href="../images/logo.png">
    
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- admin dashboard section starts  -->

<section class="dashboard">

   <h1 class="heading">Bảng Điều Khiển</h1>

   <div class="box-container">

   <div class="box">
      <h3>Xin chào!</h3>
      <p><?= $fetch_profile['name']; ?></p>
      <a href="update_profile.php" class="btn">Cập nhật Profile</a>
   </div>

   <div class="box">
      <?php
         $total_pendings = 0;
         $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
         $select_pendings->execute(['Đã hoàn thành']);
         while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
            $total_pendings += $fetch_pendings['total_price'];
         }
      ?>
      <h3><span></span><?= $total_pendings; ?>.000<span> VNĐ</span></h3>
      <p>Doanh thu</p>
      <a href="placed_orders-dht.php" class="btn">Xem đơn hàng</a>
   </div>

   <div class="box">
      <?php
         $total_completes = 0;
         $select_completes = $conn->prepare("SELECT COUNT(*) FROM `orders` WHERE payment_status = ?");
         $select_completes->execute(['Chưa xử lí']);
         while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
            $total_completes += $fetch_completes['COUNT(*)'];
         }
      ?>
      <h3><span></span><?= $total_completes; ?><span></span></h3>
      <p>Đang chờ xử lý</p>
      <a href="placed_orders-cxl.php" class="btn">Xem đơn hàng</a>
   </div>

   <div class="box">
      <?php
         $total_completes = 0;
         $select_completes = $conn->prepare("SELECT COUNT(*) FROM `orders` WHERE payment_status = ?");
         $select_completes->execute(['Đang vận chuyển']);
         while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
            $total_completes += $fetch_completes['COUNT(*)'];
         }
      ?>
      <h3><span></span><?= $total_completes; ?><span></span></h3>
      <p>Đang vận chuyển</p>
      <a href="placed_orders-dvc.php" class="btn">Xem đơn hàng</a>
   </div>

   <div class="box">
      <?php
         $total_completes = 0;
         $select_completes = $conn->prepare("SELECT COUNT(*) FROM `orders` WHERE payment_status = ?");
         $select_completes->execute(['Đã hủy đơn']);
         while($fetch_completes = $select_completes->fetch(PDO::FETCH_ASSOC)){
            $total_completes += $fetch_completes['COUNT(*)'];
         }
      ?>
      <h3><span></span><?= $total_completes; ?><span></span></h3>
      <p>Đơn đã hủy</p>
      <a href="placed_orders-dhd.php" class="btn">Xem đơn hàng</a>
   </div>

   <div class="box">
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         $numbers_of_orders = $select_orders->rowCount();
      ?>
      <h3><?= $numbers_of_orders; ?></h3>
      <p>Tổng đơn hàng</p>
      <a href="placed_orders.php" class="btn">Xem đơn hàng</a>
   </div>

   <div class="box">
      <?php
         $select_products = $conn->prepare("SELECT * FROM `products`");
         $select_products->execute();
         $numbers_of_products = $select_products->rowCount();
      ?>
      <h3><?= $numbers_of_products; ?></h3>
      <p>Món ăn</p>
      <a href="products.php" class="btn">Xem Món ăn</a>
   </div>

   <div class="box">
      <?php
         $select_users = $conn->prepare("SELECT * FROM `users`");
         $select_users->execute();
         $numbers_of_users = $select_users->rowCount();
      ?>
      <h3><?= $numbers_of_users; ?></h3>
      <p>Tổng người dùng</p>
      <a href="users_accounts.php" class="btn">Xem người dùng</a>
   </div>

   <div class="box">
      <?php
         $select_admins = $conn->prepare("SELECT * FROM `admin`");
         $select_admins->execute();
         $numbers_of_admins = $select_admins->rowCount();
      ?>
      <h3><?= $numbers_of_admins; ?></h3>
      <p>Admin</p>
      <a href="admin_accounts.php" class="btn">Xem admins</a>
   </div>

   <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `messages`");
         $select_messages->execute();
         $numbers_of_messages = $select_messages->rowCount();
      ?>
      <h3><?= $numbers_of_messages; ?></h3>
      <p>Tin nhắn mới</p>
      <a href="messages.php" class="btn">Xem tin nhắn</a>
   </div>

   <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `slider`");
         $select_messages->execute();
         $numbers_of_messages = $select_messages->rowCount();
      ?>
      <h3><?= $numbers_of_messages; ?></h3>
      <p>Slider Web</p>
      <a href="slider.php" class="btn">Xem Slider</a>
   </div>

   <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `category`");
         $select_messages->execute();
         $numbers_of_messages = $select_messages->rowCount();
      ?>
      <h3><?= $numbers_of_messages; ?></h3>
      <p>Danh mục món ăn</p>
      <a href="add-category.php" class="btn">Xem danh mục</a>
   </div>

   <div class="box">
      <?php
         $select_messages = $conn->prepare("SELECT * FROM `loaisp`");
         $select_messages->execute();
         $numbers_of_messages = $select_messages->rowCount();
      ?>
      <h3><?= $numbers_of_messages; ?></h3>
      <p>Loại Sản Phẩm</p>
      <a href="themloaisp.php" class="btn">Xem Loại Sản Phẩm</a>
   </div>

   </div>

</section>

<!-- admin dashboard section ends -->









<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>