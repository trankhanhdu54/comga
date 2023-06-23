<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = $_POST['address'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if($check_cart->rowCount() > 0){

      if($address == ''){
         $message[] = 'Vui lòng thêm địa chỉ của bạn!';
      }else{
         
         $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
         $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

         $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
         $delete_cart->execute([$user_id]);

         $message[] = 'Đặt hàng thành công!
         đi đến <a style="text-decoration: none" href="orders">Đơn hàng</a>';
      }
      
   }else{
      $message[] = 'Giỏ của bạn trống';
   }

}

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thanh Toán</title>
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
   <h3>Thanh toán</h3>
   <p><a style="text-decoration: none" href="home">Home</a> <span> / Thanh toán</span></p>
</div>

<section class="checkout">

   <h1 class="title">Tóm tắt đơn hàng</h1>

<form action="" method="post">

   <div class="cart-items">
      <h3>Sản phẩm đã chọn</h3>
      <?php
         $grand_total = 0;
         $cart_items[] = '';
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
               $cart_items[] = $fetch_cart['name'] .' ('.$fetch_cart['price'].'.000đ x '. $fetch_cart['quantity'].') - ';
               $total_products = implode($cart_items);
               $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
      ?>
      <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price"><?= $fetch_cart['price']; ?>.000 x <?= $fetch_cart['quantity']; ?></span></p>
      <?php
            }
         }else{
            echo '<p class="empty">Giỏ của bạn trống!</p>';
         }
      ?>
      <p class="grand-total"><span class="name">Tổng giá tiền :</span><span class="price"><?= $grand_total; ?>.000 VNĐ</span></p>
      <a style="text-decoration: none"  href="giohang" class="btnz">Xem giỏ hàng</a>
   </div>

   <input type="hidden" name="total_products" value="<?= $total_products; ?>">
   <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
   <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
   <input type="hidden" name="number" value="<?= $fetch_profile['number'] ?>">
   <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
   <input type="hidden" name="address" value="<?= $fetch_profile['address'] ?>">

   <div class="user-info">
      <h3>Thông tin của bạn</h3>
      <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
      <p><i class="fas fa-phone"></i><span><?= $fetch_profile['number'] ?></span></p>
      <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
      <a style="text-decoration: none"  href="capnhatprofile" class="btnz">Cập nhật thông tin</a>
      <h3>Địa chỉ giao hàng</h3>
      <p><i class="fas fa-map-marker-alt"></i><span><?php if($fetch_profile['address'] == ''){echo 'vui lòng nhập địa chỉ của bạn';}else{echo $fetch_profile['address'];} ?></span></p>
      <a style="text-decoration: none"  href="capnhatdiachi" class="btnz">Cập nhật địa chỉ nhận hàng</a>
      <select name="method" class="box" required>
         <option value="" disabled selected>Chọn phương thức thanh toán --</option>
         <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
      </select>
      <input type="submit" value="Đặt hàng" class="btnz <?php if($fetch_profile['address'] == ''){echo 'disabled';} ?>" style="width:100%; background:var(--red); color:var(--white);" name="submit">
   </div>

</form>
   
</section>









<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->






<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>