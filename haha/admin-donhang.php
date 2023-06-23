<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin HoaiPhuong</title>
    <link rel="icon" href="../images/logo.png">
    <!-- ======= Styles ====== -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<body>
    <!-- =============== Navigation ================ -->
    <?php include 'lk/menu.php'; ?>

        <!-- ========================= Main ==================== -->
        <div class="main">
            <div class="topbar">
                <div class="toggle">
                    <ion-icon name="menu-outline"></ion-icon>
                </div>

                <!-- <div class="search">
                    <label>
                        <input type="text" placeholder="Search here">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </div> -->

                <div class="user">
                    <img src="assets/imgs/customer01.jpg" alt="">
                </div>
            </div>

            <!-- ======================= Cards ================== -->
            <section class="dashboard">

   <h1 class="heading">ĐƠN HÀNG</h1>

<div class="box-container">
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
      <a href="admin-donhangdht.php" class="btn">Xem đơn hàng</a>
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
      <a href="admin-donhangcxl.php" class="btn">Xem đơn hàng</a>
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
      <a href="admin-donhangdvc.php" class="btn">Xem đơn hàng</a>
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
      <a href="admin-donhangdhd.php" class="btn">Xem đơn hàng</a>
   </div>

   <div class="box">
      <?php
         $select_orders = $conn->prepare("SELECT * FROM `orders`");
         $select_orders->execute();
         $numbers_of_orders = $select_orders->rowCount();
      ?>
      <h3><?= $numbers_of_orders; ?></h3>
      <p>Tổng đơn hàng</p>
      <a href="admin-alldonhang.php" class="btn">Xem đơn hàng</a>
   </div>
</div>

</section>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>