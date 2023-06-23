<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update'])){

   $pid = $_POST['pid'];
   $pid = filter_var($pid, FILTER_SANITIZE_STRING);
   $xid = $_POST['xid'];
   $xid = filter_var($xid, FILTER_SANITIZE_STRING);
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $price = $_POST['price'];
   $price = filter_var($price, FILTER_SANITIZE_STRING);
   $chitiet = $_POST['chitiet'];
   $chitiet = filter_var($chitiet, FILTER_SANITIZE_STRING);
   $loaisanpham = $_POST['loaisanpham'];
   $loaisanpham = filter_var($loaisanpham, FILTER_SANITIZE_STRING);
   $category = $_POST['category'];
   $category = filter_var($category, FILTER_SANITIZE_STRING);
   $fff = $_POST['fff'];
   $fff = filter_var($fff, FILTER_SANITIZE_STRING);

   $update_product = $conn->prepare("UPDATE `products` SET id = ?, name = ?, category = ?, fff = ?, price = ?, chitiet = ?, loaisanpham = ? WHERE id = ?");
   $update_product->execute([$xid, $name, $category, $fff, $price, $chitiet, $loaisanpham, $pid]);

   $message[] = 'sản phẩm được cập nhật!';
   header("location:admin-monan.php");

   $old_image = $_POST['old_image'];
   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   if(!empty($image)){
      if($image_size > 2000000){
         $message[] = 'kích thước hình ảnh quá lớn!';
      }else{
         $update_image = $conn->prepare("UPDATE `products` SET image = ? WHERE id = ?");
         $update_image->execute([$image, $pid]);
         move_uploaded_file($image_tmp_name, $image_folder);
         unlink('../uploaded_img/'.$old_image);
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
    <title>Admin Chỉnh Sửa Sản Phẩm</title>
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

   <h1 class="heading">Cập nhật sản phẩm</h1>

   <?php
      $update_id = $_GET['update'];
      $show_products = $conn->prepare("SELECT category.iddanhmuc,category.namedanhmuc,products.id,products.name,products.price,products.image,products.fff,products.loaisanpham,products.chitiet,products.category 
      FROM products,category WHERE category.iddanhmuc=products.id LIKE ?");
      $show_products->execute([$update_id]);
      if($show_products->rowCount() > 0){
         while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
   ?>
   <form action="" method="POST" enctype="multipart/form-data">
   <div style="margin-bottom:10px;" class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="admin-monan.php" class="option-btn">Trở lại</a>
      </div>
      <span>Thứ tự hiển thị</span>
      <input type="number" required placeholder="ví dụ 1-2-3-4" name="xid" maxlength="100" class="box" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
      <input type="hidden" name="old_image" value="<?= $fetch_products['image']; ?>">
      <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
      <span>update name</span>
      <input type="text" required placeholder="enter product name" name="name" maxlength="100" class="box" value="<?= $fetch_products['name']; ?>">
      <span>update price</span>
      <input type="number" min="0" max="9999999999" required placeholder="Nếu giá 100k thì chỉ cần ghi 100" name="price" onkeypress="if(this.value.length == 10) return false;" class="box" value="<?= $fetch_products['price']; ?>">
      <input type="text" required placeholder="<?= $fetch_products['chitiet']; ?>" name="chitiet" maxlength="2000" class="box" value="<?= $fetch_products['chitiet']; ?>">
      <span>Cập nhật danh mục</span>
         <select name="category" class="box" required>
            <option selected value="<?= $fetch_products['category']; ?>">--- Chọn danh mục ---</option>
            <?php
         $show_category = $conn->prepare("SELECT * FROM `category`");
         $show_category->execute();
         if($show_category->rowCount() > 0){
            while($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)){  
      ?>
            <option value="<?= $fetch_category['iddanhmuc']; ?>"><?= $fetch_category['namedanhmuc']; ?></option>
            <?php
            }
         }else{
            echo '<p class="empty">Chưa được thêm vào!</p>';
         }
      ?>
         
         </select>
      <span>Cập nhật mặt hàng</span>
         <select name="fff" class="box" required>
            <option selected value="<?= $fetch_products['fff']; ?>"><?= $fetch_products['fff']; ?></option>
            <option value="Phần">Phần</option>
            <option value="Ly">Ly</option>
            <option value="Con">Con</option>
            <option value="Chai">Chai</option>
         </select>
      <span>Cập nhật loại sản phẩm</span>
         <select name="loaisanpham" class="box" required>
            <option selected value="<?= $fetch_products['loaisanpham']; ?>"><?= $fetch_products['loaisanpham']; ?></option>
            <?php
         $show_category = $conn->prepare("SELECT * FROM `loaisp`");
         $show_category->execute();
         if($show_category->rowCount() > 0){
            while($fetch_loaisp = $show_category->fetch(PDO::FETCH_ASSOC)){  
      ?>
            <option value="<?= $fetch_loaisp['name']; ?>"><?= $fetch_loaisp['name']; ?></option>
            <?php
            }
         }else{
            echo '<p class="empty">Chưa có loại được thêm vào!</p>';
         }
      ?>
         
         </select>
      <span>Cập nhật hình ảnh</span>
      <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp">
      <div class="flex-btn">
         <input type="submit" value="update" class="btn" name="update">
         <a href="admin-monan.php" class="option-btn">Trở lại</a>
      </div>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">chưa có sản phẩm nào được thêm vào!</p>';
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