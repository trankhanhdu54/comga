<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home');
};

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đơn Hàng</title>
   <link rel="icon" href="images/logo.png">
   <meta name="description" content="Cơm Gà Zu Gold chuyên cung cấp thức ăn nhanh ngon, sạch số một tại Cần Thơ">
    <meta property="og:type" content="profile">
    <meta property="og:title" content="Cơm Gà Zu Gold | Cần Thơ">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Đơn hàng</h3>
   <p><a style="text-decoration: none" href="html.php">Home</a> <span> / Đơn hàng</span></p>
</div>

<section class="orders">

   <h1 class="title">Đơn hàng của bạn</h1>

   <div class="box-container">

   <?php
      if($user_id == ''){
         echo '<p class="empty">Vui lòng đăng nhập để xem đơn đặt hàng của bạn</p>';
      }else{
         $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? ORDER BY id DESC");
         $select_orders->execute([$user_id]);
         if($select_orders->rowCount() > 0){
            while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
   ?>
   <div class="box">
      <p>Thời gian đặt hàng : <span><?= $fetch_orders['placed_on']; ?></span></p>
      <p>Tên khách hàng : <span><?= $fetch_orders['name']; ?></span></p>
      <p>Email : <span><?= $fetch_orders['email']; ?></span></p>
      <p>Số điện thoại : <span><?= $fetch_orders['number']; ?></span></p>
      <p>Địa chỉ nhận hàng : <span><?= $fetch_orders['address']; ?></span></p>
      <p>Thanh toán : <span><?= $fetch_orders['method']; ?></span></p>
      <p>Bạn đã đặt : <span><?= $fetch_orders['total_products']; ?></span></p>
      <p>Tổng giá tiền : <span><?= $fetch_orders['total_price']; ?>/-VNĐ</span></p>
      <p>Trạng thái : <span style="color:<?php if(
         $fetch_orders['payment_status'] == 'Chưa xử lí'){ echo '#774EF2';
       }else if ($fetch_orders['payment_status'] == 'Đang vận chuyển'){ echo '#F2934E'; 
      }else if ($fetch_orders['payment_status'] == 'Đã hủy đơn'){ echo 'red'; }
       else { echo 'green'; }; ?>">
       <?= $fetch_orders['payment_status']; ?></span> </p>
   </div>
   <?php
      }
      }else{
         echo '<p class="empty">Bạn chưa có đơn đặt hàng nào!</p>';
      }
      }
   ?>

   </div>

</section>










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>