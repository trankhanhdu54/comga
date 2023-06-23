<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/add_cart.php';

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Menu</title>
   <link rel="icon" href="images/logo.png">
   <meta name="description" content="Cơm Gà Zu Gold chuyên cung cấp thức ăn nhanh ngon, sạch số một tại Cần Thơ">
    <meta property="og:type" content="profile">
    <meta property="og:title" content="Cơm Gà Zu Gold | Cần Thơ">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   
   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/stylenew.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Menu</h3>
   <p><a style="text-decoration: none"href="home">Home</a> <span> / Menu</span></p>
</div>

<!-- menu section starts  -->



<section class="dishes" id="dishes">
    <h1 class="title">MENU <nav class="navbar">
      
      <div class="dropdown">
      <button style="padding-top:10px" class="nut_dropdown">Loại Sản Phẩm<i class="fa fa-caret-down"></i></button>
      
            <div class="noidung_dropdown"> 
<?php
   $show_category = $conn->prepare("SELECT * FROM `loaisp`");
   $show_category->execute();
   if($show_category->rowCount() > 0){
      while($fetch_category = $show_category->fetch(PDO::FETCH_ASSOC)){  
?>
               <a style="text-decoration: none;" href="loaisanpham?loaisp=<?= $fetch_category['name']; ?>"><?= $fetch_category['name']; ?></a>
               <?php
      }
   }else{
      echo '<p class="empty">Chưa có danh mục được thêm vào!</p>';
   }
?>
            </div>
            
   </div> </h1>

    <div class="box-container">


    <?php  
        // PHẦN XỬ LÝ PHP
        // BƯỚC 1: KẾT NỐI CSDL
      //   require('db_connect.php');
        include 'components/connect.php';
 
        // BƯỚC 2: TÌM TỔNG SỐ RECORDS
        $result = $conn->prepare("select count(id) as total from products");
        $result->execute();
        $row = $result->fetch();
        $total_records = $row['total'];
 
        // BƯỚC 3: TÌM LIMIT VÀ CURRENT_PAGE
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 6;
        // BƯỚC 4: TÍNH TOÁN TOTAL_PAGE VÀ START
        // tổng số trang
        $total_page = ceil($total_records / $limit); 
 
        // Giới hạn current_page trong khoảng 1 đến total_page
        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }
 
        // Tìm Start
        $start = ($current_page - 1) * $limit;
        $count = 1;
 
        // BƯỚC 5: TRUY VẤN LẤY DANH SÁCH TIN 
        // Có limit và start rồi thì truy vấn CSDL lấy danh sách tin 
        $result =$conn->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $start, $limit ");
        $result->execute();
?>

<?php
                            if($result->rowCount() > 0){
                              while($fetch_products = $result->fetch(PDO::FETCH_ASSOC)){
                        ?> 

<form action="" method="post" class="box">
            <!-- <a style="text-decoration: none" href="#" class="fas fa-heart"></a>
            <a style="text-decoration: none" href="xemchitiet?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a> -->
            <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
            <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
            <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
            <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
            <input type="hidden" name="fff" value="<?= $fetch_products['fff']; ?>">
            
            <a href="xemchitiet?pid=<?= $fetch_products['id']; ?>"><img src="uploaded_img/<?= $fetch_products['image']; ?>" alt="<?= $fetch_products['name']; ?>"></a>
            <h3><a href="xemchitiet?pid=<?= $fetch_products['id']; ?>" style="text-decoration: none; color:black;"><?= $fetch_products['name']; ?></a></h3>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <span><?= $fetch_products['price']; ?></span><span style="font-weight: 400;position: relative;top: -9px;font-size: 13px;right: 0;">VNĐ/<?= $fetch_products['fff']; ?></span>
            <button class="btnbut" type="submit" name="add_to_cart"> Thêm giỏ hàng</button>
            <input type="hidden" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
            
            </form>
            <?php
            }
         }else{
            echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
         }
      ?>
      </div>
      <div class="pagination">
                            <p> Trang <?php echo $current_page; ?>/<?php echo $total_page; ?> </p>
                                <a href="?page=1" style="margin:5px" class="btn btn-info">Trang Đầu</a>
                                <a href="?page=<?php if($current_page == 1){echo 1;} else {echo $current_page-1;} ?>" style="margin:5px" class="btn btn-info">Trở Lại</a>
                                
                                <a href="?page=<?php if($current_page == $total_page){echo $total_page;} else {echo $current_page+1;} ?>" style="margin:5px" class="btn btn-info" >Xem Tiếp</a>
                                <a href="?page=<?php echo $total_page; ?>" style="margin:5px" class="btn btn-info" >Trang Cuối</a>
                            </div>

</section>



<!-- menu section ends -->
























<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>