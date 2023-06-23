<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['update_payment'])){

   $order_id = $_POST['order_id'];
   $payment_status = $_POST['payment_status'];
   $update_status = $conn->prepare("UPDATE `orders` SET payment_status = ? WHERE id = ?");
   $update_status->execute([$payment_status, $order_id]);
   $message[] = 'Trạng thái thanh toán được cập nhật!';

}

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $delete_order = $conn->prepare("DELETE FROM `orders` WHERE id = ?");
   $delete_order->execute([$delete_id]);
   header('location:placed_orders.php');
}

?>


<!DOCTYPE html>
<html lang="vn">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn Hàng Đã Hoàn Thành</title>
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
            <section class="placed-orders">

<h1 class="heading">Đơn Đã Giao</h1>

<div class="box-container">

<?php
   $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = 'Đã hoàn thành' ORDER BY id DESC;");
   $select_orders->execute();
   if($select_orders->rowCount() > 0){
      while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
?>
<div class="box">
   <p> user id : <span><?= $fetch_orders['user_id']; ?></span> </p>
   <p> Thời gian đặt : <span><?= $fetch_orders['placed_on']; ?></span> </p>
   <p> Khách hàng : <span><?= $fetch_orders['name']; ?></span> </p>
   <p> email : <span><?= $fetch_orders['email']; ?></span> </p>
   <p> Điện thoại : <span><?= $fetch_orders['number']; ?></span> </p>
   <p> Địa chỉ giao : <span><?= $fetch_orders['address']; ?></span> </p>
   <p> Các món ăn : <span><?= $fetch_orders['total_products']; ?></span> </p>
   <p> Tổng giá : <span><?= $fetch_orders['total_price']; ?>/-VNĐ</span> </p>
   <p> Phương thức : <span><?= $fetch_orders['method']; ?></span> </p>
   <form action="" method="POST">
      <input type="hidden" name="order_id" value="<?= $fetch_orders['id']; ?>">
      <select name="payment_status" class="drop-down">
         <option value="" selected disabled><?= $fetch_orders['payment_status']; ?></option>
         <option value="Chưa xử lí">Chưa xử lí</option>
         <option value="Đang vận chuyển">Đang vận chuyển</option>
         <option value="Đã hoàn thành">Đã hoàn thành</option>
         <option value="Đã hủy đơn">Đã hủy đơn</option>
      </select>
      <div class="flex-btn">
         <input type="submit" value="Cập nhật" class="btn" name="update_payment">
         <a href="placed_orders.php?delete=<?= $fetch_orders['id']; ?>" class="delete-btn" onclick="return confirm('xóa đơn hàng này?');">Xóa</a>
      </div>
   </form>
</div>
<?php
   }
}else{
   echo '<p class="empty">chưa có đơn đặt hàng nào!</p>';
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