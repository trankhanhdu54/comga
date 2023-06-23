<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['id'];
    //   echo '<script>window.alert("Đăng nhập thành công!");</script>';
    $message[] = 'Đăng nhập thành công!';
      header('location:home');
      
   }else{
      $message[] = 'Tên đăng nhập hoặc mật khẩu không chính xác!';
   }

}

?>


<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Đăng nhập</title>
   <link rel="icon" href="images/logo.png">
   <meta name="description" content="Cơm Gà Zu Gold chuyên cung cấp thức ăn nhanh ngon, sạch số một tại Cần Thơ">
    <meta property="og:type" content="profile">
    <meta property="og:title" content="Cơm Gà Zu Gold | Cần Thơ">
   

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   
   <link rel="stylesheet" href="css/login.css">
   

</head>
<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>

<body class="align">

  <div class="login">

    <header class="login__header">
      <h2><svg class="icon">
          <use xlink:href="#icon-lock" />
        </svg>Đăng Nhập</h2>
    </header>

    <form action="" class="login__form" method="POST">

      <div>
        <label for="email">Email</label>
        <input type="email" name="email" required placeholder="Nhập Email">
      </div>

      <div>
        <label for="password">Mật Khẩu</label>
        <input type="password" name="pass" required placeholder="Nhập mật khẩu">
      </div>

      <div>
        <input class="button" type="submit" name="submit" value="Đăng nhập ngay">
        <p class="lienket">Bạn chưa có tài khoản? <a style="text-decoration: none" href="dangky.php">Đăng ký ngay</a></p>
      </div>

    </form>

  </div>

  <svg xmlns="http://www.w3.org/2000/svg" class="icons">

    <symbol id="icon-lock" viewBox="0 0 448 512">
      <path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z" />
    </symbol>

  </svg>

</body>

<script src="js/script.js"></script>

<!-- <script src="js/sweetalert.min.js"></script> -->
</body>
</html>

