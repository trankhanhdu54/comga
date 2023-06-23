<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
};

if(isset($_POST['add_product'])){

   $name = $_POST['name'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../slider_img/'.$image;

   $select_slider = $conn->prepare("SELECT * FROM `slider` WHERE name = ?");
   $select_slider->execute([$name]);

   if($select_slider->rowCount() > 0){
      $message[] = 'Tên Slider đã tồn tại!';
   }else{
      if($image_size > 2000000){
         $message[] = 'Kích thước hình ảnh quá lớn';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `slider`(name, image) VALUES(?,?)");
         $insert_product->execute([$name, $image]);

         $message[] = 'Slider mới được thêm vào!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `slider` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../slider_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `slider` WHERE id = ?");
   $delete_product->execute([$delete_id]);

   header('location:admin-slider.php');

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
            <section class="add-products">

<form action="" method="POST" enctype="multipart/form-data">
   <h3>Thêm Slider</h3>
   <input type="text" required placeholder="Tên Slider" name="name" maxlength="100" class="box">
   <h4>Lưu ý: Hình ảnh thêm vào phải là ảnh nền trắng dưới định dạng .png </h4>
   <input type="file" name="image" class="box" accept="image/png" required>
   <input type="submit" value="Thêm sản phẩm" name="add_product" class="btn">
</form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

<div class="box-container">

<?php
   $show_slider = $conn->prepare("SELECT * FROM `slider` ORDER BY id DESC");
   $show_slider->execute();
   if($show_slider->rowCount() > 0){
      while($fetch_slider = $show_slider->fetch(PDO::FETCH_ASSOC)){  
?>
<div class="box">
   <img src="../slider_img/<?= $fetch_slider['image']; ?>" alt="">
   <div class="name">Tên Slider :<h3><?= $fetch_slider['name']; ?></h3></div>
   <div class="flex-btn">
      <a href="admin-update-slider.php?update=<?= $fetch_slider['id']; ?>" class="option-btn">Sửa</a>
      <a href="admin-slider.php?delete=<?= $fetch_slider['id']; ?>" class="delete-btn" onclick="return confirm('Xóa Slider?');">Xóa</a>
   </div>
</div>
<?php
      }
   }else{
      echo '<p class="empty">Chưa có Slider được thêm vào!</p>';
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