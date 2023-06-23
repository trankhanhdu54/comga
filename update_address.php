<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
   header('location:home');
};

if(isset($_POST['submit'])){

   $address = $_POST['flat'] .', '.$_POST['building'].', '.$_POST['area'].', '.$_POST['town'] .', '. $_POST['city'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);

   $update_address = $conn->prepare("UPDATE `users` set address = ? WHERE id = ?");
   $update_address->execute([$address, $user_id]);

   $message[] = 'Địa chỉ đã được lưu!';

}

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Cập Nhật Địa Chỉ</title>
   <link rel="icon" href="images/logo.png">
   <meta name="description" content="Cơm Gà Zu Gold chuyên cung cấp thức ăn nhanh ngon, sạch số một tại Cần Thơ">
    <meta property="og:type" content="profile">
    <meta property="og:title" content="Cơm Gà Zu Gold | Cần Thơ">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php' ?>

<section class="form-container">

   <form action="" method="post">
      <h3>Địa Chỉ Của Bạn</h3>
      <input type="text" class="box" placeholder="Nhập Số nhà" required maxlength="50" name="flat">
      <input type="text" class="box" placeholder="Nhập đường" required maxlength="50" name="building">
      <input type="text" class="box" placeholder="Nhập phường" required maxlength="50" name="area">
      <input type="text" class="box" placeholder="Nhập quận" required maxlength="50" name="town">
      <input type="text" class="box" placeholder="Nhập thành phố" required maxlength="50" name="city">
      <!-- <input type="text" class="box" placeholder="Ghi chú thêm" required maxlength="50" name="state"> -->
      <!-- <input type="text" class="box" placeholder="country name" required maxlength="50" name="country"> -->
      <!-- <input type="number" class="box" placeholder="pin code" required max="999999" min="0" maxlength="6" name="pin_code"> -->
      <input type="submit" value="Lưu Địa Chỉ" name="submit" class="btnz">
   </form>

</section>










<?php include 'components/footer.php' ?>







<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>