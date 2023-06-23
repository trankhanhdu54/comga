<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
};

if(isset($_POST['add_category'])){

   $name = $_POST['name'];
   

   $select_category = $conn->prepare("SELECT * FROM `loaisp` WHERE name = ?");
   $select_category->execute([$name]);

   if($select_category->rowCount() > 0){
      $message[] = 'Tên danh mục đã tồn tại!';
   }else{
         $insert_category = $conn->prepare("INSERT INTO `loaisp`(name) VALUES(?)");
         $insert_category->execute([$name]);

         $message[] = 'Danh mục mới được thêm vào!';
      }

   }

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
  
   $delete_category = $conn->prepare("DELETE FROM `loaisp` WHERE id = ?");
   $delete_category->execute([$delete_id]);

   header('location:admin-loai.php');

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Loại</title>
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


<!-- add products section ends -->

<!-- show products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Thêm Loại Sản Phẩm</h3>
      <input type="text" required placeholder="Tên Loại" name="name" maxlength="100" class="box">
      <input type="submit" value="Thêm sản phẩm" name="add_category" class="btn">
   </form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

   <div class="box-container">

   <?php
      $show_category = $conn->prepare("SELECT * FROM `loaisp`");
      $show_category->execute();
      if($show_category->rowCount() > 0){
         while($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <div class="box">
      <div class="name">Thứ tự hiện thị :<h3><?= $fetch_category['id']; ?></h3></div>
      <div class="name">Tên Loại Sản Phẩm :<h3><?= $fetch_category['name']; ?></h3></div>
      <div class="flex-btn">
         <a href="admin-update-loai.php?update=<?= $fetch_category['id']; ?>" class="option-btn">Sửa</a>
         <a href="admin-loai.php?delete=<?= $fetch_category['id']; ?>" class="delete-btn" onclick="return confirm('Xóa danh mục?');">Xóa</a>
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