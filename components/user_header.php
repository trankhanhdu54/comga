<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>
<header class="header">

   <section class="flex">

      <a style="text-decoration: none;" href="home" class="logo"><img style="width:220px; height:40px;" src="images/logo-web.png" alt=""></a>

      <nav class="navbar">
         <a style="text-decoration: none" href="home">Home</a>
         <a style="text-decoration: none" href="menu">Menu</a>
         <a style="text-decoration: none" href="about">Chúng tôi</a>
         <a style="text-decoration: none" href="orders">Đơn hàng</a>
         <a style="text-decoration: none" href="lienhe">Liên hệ</a>
      </nav>

      <div class="icons">
         <?php
            $count_cart_items = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $count_cart_items->execute([$user_id]);
            $total_cart_items = $count_cart_items->rowCount();
         ?>
         <a href="timkiem"><i class="fas fa-search"></i></a>
         <a style="text-decoration: none" href="giohang"><i class="fas fa-shopping-cart"></i><span>(<?= $total_cart_items; ?>)</span></a>
         <div id="user-btn" class="fas fa-user"></div>
         <div id="menu-btn" class="fas fa-bars"></div>
      </div>

      <div class="profile">
         <?php
            $select_profile = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
            $select_profile->execute([$user_id]);
            if($select_profile->rowCount() > 0){
               $fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);
         ?>
         <p class="name">Hi! <?= $fetch_profile['name']; ?></p>
         <div class="flexz">
            <a style="text-decoration: none" href="trangcanhan" class="btnz">Profile</a>
            <a style="text-decoration: none" href="thoat"  class="delete-btnz">Thoát</a>
            <!-- onclick="return confirm('Bạn sẽ đăng xuất khỏi website?');" -->
         </div>
         
         <?php
            }else{
         ?>
            <p class="name">xin vui lòng đăng nhập!</p>
            <a style="text-decoration: none" href="dangnhap" class="btnz">Đăng nhập</a>
         <?php
          }
         ?>
      </div>

   </section>

</header>

