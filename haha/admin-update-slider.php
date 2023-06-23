<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $id = $_POST['id'];
   $id = filter_var($id, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `slider` SET name = ? WHERE id = ?");
   $update_product->execute([$name, $id]);

   $message[] = 'Slider được cập nhật!';
   header("location:admin-slider.php");

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../slider_img/'.$image;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'kích thước hình ảnh quá lớn!';
      }else{
         $update_image = $conn->prepare("UPDATE `slider` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $id]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../slider_img/'.$old_image);
         $message[] = 'hình ảnh được cập nhật!';
      }
   }

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Cập Nhật Slider</title>
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

            <section class="update-product">

   <h1 class="heading">Cập nhật Slider</h1>

   <?php
      $update_id = $_GET['update'];
      $show_products = $conn->prepare("SELECT * FROM `slider` WHERE id = ?");
      $show_products->execute([$update_id]);
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <img src="../slider_img/<?= $fetch_products['image']; ?>" alt="">
      <span>update name</span>
      <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
      <span>Cập nhật hình ảnh</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="admin-slider.php" class="option-btn">Trở lại</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">chưa có slider nào được thêm vào!</p>';
      }
   ?>

</section>
            
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>