<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
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

   header('location:themloaisp.php');

}

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thêm Loại Sản Phẩm</title>
   <link rel="icon" href="../images/logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- add products section starts  -->

<section class="add-products">

   <form action="" method="POST" enctype="multipart/form-data">
      <h3>Thêm Danh Mục</h3>
      <input type="text" required placeholder="Tên Danh Mục" name="name" maxlength="100" class="box">
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
         <a href="update-themloaisp.php?update=<?= $fetch_category['id']; ?>" class="option-btn">Sửa</a>
         <a href="themloaisp.php?delete=<?= $fetch_category['id']; ?>" class="delete-btn" onclick="return confirm('Xóa danh mục?');">Xóa</a>
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

<!-- show products section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>