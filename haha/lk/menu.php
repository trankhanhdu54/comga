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
<div class="container">
        <div class="navigation">
            <ul>
                <li>
                <a style="text-decoration: none;" href="home" class="logo"><img style="width:220px; height:40px;" src="../images/logo-web.png" alt=""></a>
                </li>

                <li>
                    <a href="admin.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="admin-khachhang.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Khách Hàng</span>
                    </a>
                </li>

                <li>
                    <a href="admin-tinnhan.php">
                        <span class="icon">
                            <ion-icon name="chatbubble-outline"></ion-icon>
                        </span>
                        <span class="title">Tin Nhắn</span>
                    </a>
                </li>

                <li>
                    <a href="admin-khac.php">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Khác</span>
                    </a>
                </li>

                <li>
                    <a href="admin-monan.php">
                        <span class="icon">
                            <ion-icon name="help-outline"></ion-icon>
                        </span>
                        <span class="title">Món ăn</span>
                    </a>
                </li>

                <li>
                    <a href="admin-donhang.php">
                        <span class="icon">
                            <ion-icon name="settings-outline"></ion-icon>
                        </span>
                        <span class="title">Đơn hàng</span>
                    </a>
                </li>

                <li>
                    <a href="admin-profile.php">
                        <span class="icon">
                            <ion-icon name="lock-closed-outline"></ion-icon>
                        </span>
                        <span class="title">Profile</span>
                    </a>
                </li>

                <li>
                    <a href="../components/admin_logout.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </div>