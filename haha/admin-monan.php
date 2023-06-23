<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

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

   $image = $_FILES['image']['name'];
   $image = filter_var($image, FILTER_SANITIZE_STRING);
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = '../uploaded_img/'.$image;

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE name = ?");
   $select_products->execute([$name]);

   if($select_products->rowCount() > 0){
      $message[] = 'Tên sản phẩm đã tồn tại!';
   }else{
      if($image_size > 2000000){
         $message[] = 'Kích thước hình ảnh quá lớn';
      }else{
         move_uploaded_file($image_tmp_name, $image_folder);

         $insert_product = $conn->prepare("INSERT INTO `products`(name, category, fff, price, chitiet, loaisanpham, image) VALUES(?,?,?,?,?,?,?)");
         $insert_product->execute([$name, $category, $fff, $price, $chitiet, $loaisanpham, $image]);

         $message[] = 'Sản phẩm mới được thêm vào!';
      }

   }

}

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE id = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE id = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE pid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:admin-monan.php');

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Món Ăn</title>
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
   <h3>Thêm Sản Phẩm</h3>
   <input type="text" required placeholder="Tên sản phẩm" name="name" maxlength="100" class="box">
   <input type="number" min="0" max="9999999999" required placeholder="Nếu 100k thì chỉ cần ghi 100" name="price" onkeypress="if(this.value.length == 10) return false;" class="box">
   <textarea name="chitiet" class="box" required placeholder="Nhập giới thiệu sản phẩm" maxlength="500" cols="30" rows="5" maxlength="266"></textarea>
   <span>Thêm loại sản phẩm</span>
   <select name="category" class="box" required>
      <option value="" disabled selected>-- Loại sản phẩm --</option>
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
      echo '<p class="empty">Chưa có danh mục được thêm vào!</p>';
   }
?>
   </select>
   <span>Thêm loại mặt hàng</span>
   <select name="fff" class="box" required>
      <option value="" disabled selected>-- Loại mặt hàng --</option>
      <option value="Phần">Phần</option>
      <option value="Kg">Ly</option>
      <option value="Con">Con</option>
      <option value="Chai">Chai</option>
   </select>
   <span>Thêm loại sản phẩm</span>
   <select name="loaisanpham" class="box" required>
      <option value="" disabled selected>-- Loại sản phẩm --</option>
      <?php
   $show_category = $conn->prepare("SELECT * FROM `loaisp`");
   $show_category->execute();
   if($show_category->rowCount() > 0){
      while($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)){  
?>
      <option value="<?= $fetch_category['name']; ?>"><?= $fetch_category['name']; ?></option>
      <?php
      }
   }else{
      echo '<p class="empty">Chưa có danh mục được thêm vào!</p>';
   }
?>
   </select>
   <input type="file" name="image" class="box" accept="image/jpg, image/jpeg, image/png, image/webp" required>
   <input type="submit" value="Thêm sản phẩm" name="add_product" class="btn">
</form>

</section>

<!-- add products section ends -->

<!-- show products section starts  -->

<section class="show-products" style="padding-top: 0;">

<div class="box-container">

<?php
   $show_products = $conn->prepare("SELECT * FROM `products` ORDER BY id DESC");
   $show_products->execute();
   if($show_products->rowCount() > 0){
      while($fetch_products = $show_products->fetch(PDO::FETCH_ASSOC)){  
?>
<div class="box">
   <img src="../uploaded_img/<?= $fetch_products['image']; ?>" alt="">
   <div class="flex">
      <div class="price"><span></span><?= $fetch_products['price']; ?><span>đ/-<?= $fetch_products['fff']; ?></span></div>
      
      <div class="category"><?= $fetch_products['category']; ?></div>
   </div>
   <div class="name">Thứ tự hiện thị :<h3><?=$fetch_products['id']; ?></h3></div>
   <div class="name"><?= $fetch_products['name']; ?></div>
   <div class="flex-btn">
      <a href="admin-update-monan.php?update=<?= $fetch_products['id']; ?>" class="option-btn">Sửa</a>
      <a href="admin-monan.php?delete=<?= $fetch_products['id']; ?>" class="delete-btn" onclick="return confirm('Xóa sản phẩm?');">Xóa</a>
   </div>
</div>
<?php
      }
   }else{
      echo '<p class="empty">Chưa có sản phẩm được thêm vào!</p>';
   }
?>

</div>

</section>

            <!-- ================ Order Details List ================= -->
            
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>