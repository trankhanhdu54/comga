<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_category'])){

   $namedanhmuc = $_POST['name'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../category_img/'.$image;

   $select_category = $conn->prepare("SELECT * FROM `category` WHERE namedanhmuc = ?");
   $select_category->execute([$namedanhmuc]);

   if($select_category->rowCount() > 0){
      $message[] = 'Tên danh mục đã tồn tại!';
   }else{
      if($image_size > 2000000){
         $message[] = 'Kích thước hình ảnh quá lớn';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_category = $conn->prepare("INSERT INTO `category`(namedanhmuc, image) VALUES(?,?)");
         $insert_category->execute([$namedanhmuc, $image]);

         $message[] = 'Danh mục mới được thêm vào!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_category_image = $conn->prepare("SELECT * FROM `category` WHERE iddanhmuc = ?");
   $delete_category_image->execute([$delete_id]);
   $fetch_delete_image = $delete_category_image->fetch(PDO::FETCH_ASSOC);
   unlink('../category_img/'.$fetch_delete_image['image']);
   $delete_category = $conn->prepare("DELETE FROM `category` WHERE iddanhmuc = ?");
   $delete_category->execute([$delete_id]);

   header('location:admin-danhmuc.php');

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

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Thêm Danh Mục</h3>
      <input type="text" required placeholder="Tên Danh Mục" name="name" maxlength="100" class="box">
      <h4>Lưu ý: Hình ảnh thêm vào phải là ảnh nền trắng dưới định dạng .png </h4>
      <input type="file" name="image" class="box" accept="image/png" required>
      <input type="submit" value="Thêm sản phẩm" name="add_category" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_category = $conn->prepare("SELECT * FROM `category`");
      $show_category->execute();
      if($show_category->rowCount() > 0){
         while($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <img src="../category_img/<?= $fetch_category['image']; ?>" alt="">
      <div class="name">Thứ tự hiện thị :<h3><?= $fetch_category['iddanhmuc']; ?></h3></div>
      <div class="name">Tên danh mục :<h3><?= $fetch_category['namedanhmuc']; ?></h3></div>
      <div class="flex-btn">
         <a href="admin-update-danhmuc.php?update=<?= $fetch_category['iddanhmuc']; ?>" class="option-btn">Sửa</a>
         <a href="admin-danhmuc.php?delete=<?= $fetch_category['iddanhmuc']; ?>" class="delete-btn" onclick="return confirm('Xóa danh mục?');">Xóa</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">Chưa có danh mục được thêm vào!</p>';
      }
   ?>

   </div>

</section>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>