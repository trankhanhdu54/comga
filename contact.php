<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'Đã gửi tin nhắn!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'Gửi tin nhắn thành công!';

   }

}

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Liên Hệ</title>
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
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>Liên hệ chúng tôi</h3>
   <p><a style="text-decoration: none" href="home">Home</a> <span> / Liên Hệ</span></p>
</div>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact.png" alt="">
      </div>

      <form action="" method="post">
         <h3>Gửi cho chúng tôi thắc mắc của bạn!</h3>
         <input type="text" name="name" maxlength="50" class="box" placeholder="Tên của bạn" required>
         <input type="number" name="number" min="0" max="9999999999" class="box" placeholder="Số điện thoại" required maxlength="10">
         <input type="email" name="email" maxlength="50" class="box" placeholder="Email của bạn" required>
         <textarea name="msg" class="box" required placeholder="Lời thì thầm của bạn" maxlength="500" cols="30" rows="10"></textarea>
         <input type="submit" value="Gửi" name="send" class="btnz">
      </form>

   </div>

</section>

<!-- contact section ends -->










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>