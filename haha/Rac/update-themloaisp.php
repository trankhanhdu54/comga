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
   $xid = $_POST['xid'];
   $xid = filter_var($xid, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);

   $update_category = $conn->prepare("UPDATE `loaisp` SET id = ?, name = ? WHERE id = ?");
   $update_category->execute([$xid, $name, $id]);

   $message[] = 'Loại sản phẩm được cập nhật!';
   header('location:themloaisp.php');

   }



?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cập nhật Sản Phẩm</title>
   <link rel="icon" href="../images/logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- update product section starts  -->

<section class="update-product">

   <h1 class="heading">Cập nhật sản phẩm</h1>

   <?php
      $update_id = $_GET['update'];
      $show_category = $conn->prepare("SELECT * FROM `loaisp` WHERE id = ?");
      $show_category->execute([$update_id]);
      if($show_category->rowCount() > 0){
         while($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $fetch_category['id']; ?>">
      <span>Thứ tự hiển thị</span>
      <input type="number" required placeholder="ví dụ 1-2-3-4" name="xid" maxlength="100" class="box" value="<?= $fetch_category['id']; ?>">
      <span>update name</span>
      <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_category['name']; ?>">
      <div class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="themloaisp.php" class="option-btn">Trở lại</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">chưa có sản phẩm nào được thêm vào!</p>';
      }
   ?>

</section>

<!-- update product section ends -->










<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>