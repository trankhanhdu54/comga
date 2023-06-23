<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home');
};

if(isset($_POST['delete'])){
   $cart_id = $_POST['cart_id'];
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE id = ?");
   $delete_cart_item->execute([$cart_id]);
   $message[] = 'Mặt hàng hàng đã bị xóa!';
}

if(isset($_POST['delete_all'])){
   $delete_cart_item = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
   $delete_cart_item->execute([$user_id]);
   // header('location:giohang');
   $message[] = 'Đã xóa tất cả khỏi giỏ hàng!';
}

if(isset($_POST['update_qty'])){
   $cart_id = $_POST['cart_id'];
   $qty = $_POST['qty'];
   $qty = filter_var($qty, FILTER_SANITIZE_STRING);
   $update_qty = $conn->prepare("UPDATE `cart` SET quantity = ? WHERE id = ?");
   $update_qty->execute([$qty, $cart_id]);
   $message[] = 'Đã cập nhật số lượng giỏ hàng';
}

$grand_total = 0;

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Giỏ Hàng</title>
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
   <h3>Giỏ hàng của bạn</h3>
   <p><a style="text-decoration: none" href="home">Home</a> <span> / Giỏ hàng</span></p>
</div>

<!-- shopping cart section starts  -->

<section class="products">

   <div class="box-container">

      <?php
         $grand_total = 0;
         $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
         $select_cart->execute([$user_id]);
         if($select_cart->rowCount() > 0){
            while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)){
      ?>
      <form action="" method="post" class="box">
         <input type="hidden" name="cart_id" value="<?= $fetch_cart['id']; ?>">
         <button type="submit" class="fas fa-times" name="delete" onclick="return confirm('Xóa sản phẩm này?');"></button>
         <img src="uploaded_img/<?= $fetch_cart['image']; ?>" alt="">
         <div class="name"><?= $fetch_cart['name']; ?></div>
         <div class="flex">
            <div class="price"><?= $fetch_cart['price']; ?>.000<span style="font-weight: 400;position: relative;top: -9px;font-size: 13px;right: 0;">/<?= $fetch_cart['fff']; ?></span></div>
            <input type="number" name="qty" class="qty" min="1" max="99" value="<?= $fetch_cart['quantity']; ?>" maxlength="2">
            <button type="submit" class="fas fa-edit" name="update_qty"></button>
         </div>
         <div style="color:var(--red);" class="sub-total"> Tổng : <?= $sub_total = ($fetch_cart['price'] * $fetch_cart['quantity']); ?>.000<span style="font-weight: 400;position: relative;top: -9px;font-size: 13px;right: 0;">đ</span> </div>
      </form>
      <?php
               $grand_total += $sub_total;
            }
         }else{
            echo '<p class="empty">Giỏ của bạn trống!</p>';
         }
      ?>

   </div>

   <div class="cart-total">
      <p>Tổng số tiền : <?= $grand_total; ?>.000<span style="font-weight: 400;position: relative;top: -9px;font-size: 13px;right: 0;"> VNĐ</span></span></p>
      <a style="text-decoration: none;" href="thanhtoan" class="btnz <?= ($grand_total > 1)?'':'disabled'; ?>">Thanh Toán</a>
   </div>

   <div class="more-btn">
      <form action="" method="post">
         <button type="submit" class="delete-btnz <?= ($grand_total > 1)?'':'disabled'; ?>" name="delete_all" onclick="return confirm('Bạn chắc chắn muốn xóa hết?');">Xóa tất cả</button>
         <a style="text-decoration: none" href="menu" class="btnz">Tiếp tục mua hàng</a>
      </form>
      
   </div>

</section>

<!-- shopping cart section ends -->










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>