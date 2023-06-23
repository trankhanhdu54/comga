<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ?");
   $select_admin->execute([$name]);
   
   if($select_admin->rowCount() > 0){
      $message[] = 'tên đăng kí đã được sử dụng!';
   }else{
      if($pass != $cpass){
         $message[] = 'xác nhận mật khẩu không khớp!';
      }else{
         $insert_admin = $conn->prepare("INSERT INTO `admin`(name, password) VALUES(?,?)");
         $insert_admin->execute([$name, $cpass]);
         $message[] = 'Admin mới đã đăng ký thành công!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Thêm admin</title>
   <link rel="icon" href="../images/logo.png">

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php' ?>

<!-- register admin section starts  -->

<section class="form-container">

   <form action="" method="POST">
      <h3>Thêm ADMIN mới</h3>
      <input type="text" name="name" maxlength="20" required placeholder="nhập tên tài khoản" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="pass" maxlength="20" required placeholder="nhập mật khẩu" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="password" name="cpass" maxlength="20" required placeholder="nhập lại mật khẩu" class="box" oninput="this.value = this.value.replace(/\s/g, '')">
      <input type="submit" value="Thêm mới" name="submit" class="btn">
   </form>

</section>

<!-- register admin section ends -->
















<!-- custom js file link  -->
<script src="../js/admin_script.js"></script>

</body>
</html>