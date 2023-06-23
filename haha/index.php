<?php

include '../components/connect.php';

session_start();

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE name = ? AND password = ?");
   $select_admin->execute([$name, $pass]);
   
   if($select_admin->rowCount() > 0){
      $fetch_admin_id = $select_admin->fetch(PDO::FETCH_ASSOC);
      $_SESSION['admin_id'] = $fetch_admin_id['id'];
      header('location:admin.php');
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
   <title>Đăng Nhập ADMIN</title>
   <link rel="icon" href="../images/logo.png">
   

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_login.css">

</head>
<body>

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

<!-- admin login form section starts  -->
<!-- <h2>test</h2> -->
<!-- <div class="container" id="container">
	<div class="form-container sign-up-container">
		<form action="" method="POST">
			<h1>Create Account</h1>
			<div class="social-container">
				<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
				<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
				<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
			</div>
			<span>or use your email for registration</span>
			<input type="text" name="name" placeholder="Nhập user admin" oninput="this.value = this.value.replace(/\s/g, '')" />
			<input type="password" name="pass" placeholder="Nhập mật khẩu"oninput="this.value = this.value.replace(/\s/g, '')" />
			<button>Sign Up</button>
		</form>
	</div>
	<div class="form-container sign-in-container">
		<form action="" method="POST">
			<h1>ADMIN</h1>
			
			<span></span>
			<input maxlength="20" type="text" name="name" placeholder="Nhập user admin" oninput="this.value = this.value.replace(/\s/g, '')" />
			<input maxlength="20" type="password" name="pass" placeholder="Nhập mật khẩu"oninput="this.value = this.value.replace(/\s/g, '')" />
			
			<button type="submit" name="submit" class="btn">Đăng Nhập</button>
		</form>
	</div>
	<div class="overlay-container">
		<div class="overlay">
			<div class="overlay-panel overlay-left">
				<h1>Welcome Back!</h1>
				<p>To keep connected with us please login with your personal info</p>
				<button class="ghost" id="signIn">Sign In</button>
			</div>
			<div class="overlay-panel overlay-right">
				<h1>Chào bạn!</h1>
				<p>Nhập thông tin cá nhân của bạn và bắt đầu truy cập vào trang quản lí!</p>
				
			</div>
		</div>
	</div>
</div> -->

<body class="align">

  <div class="login">

    <header class="login__header">
      <h2><svg class="icon">
          <use xlink:href="#icon-lock" />
        </svg>Đăng Nhập ADMIN</h2>
    </header>

    <form action="" class="login__form" method="POST">

      <div>
        <label for="text">Email</label>
        <input type="text" name="name" placeholder="Nhập user admin" oninput="this.value = this.value.replace(/\s/g, '')">
      </div>

      <div>
        <label for="password">Mật Khẩu</label>
        <input type="password" name="pass" placeholder="Nhập mật khẩu"oninput="this.value = this.value.replace(/\s/g, '')">
      </div>

	  <div>
        <input class="button" type="submit" name="submit" value="Đăng nhập ngay">
       
      </div>

    </form>

  </div>

  <svg xmlns="http://www.w3.org/2000/svg" class="icons">

    <symbol id="icon-lock" viewBox="0 0 448 512">
      <path d="M400 224h-24v-72C376 68.2 307.8 0 224 0S72 68.2 72 152v72H48c-26.5 0-48 21.5-48 48v192c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V272c0-26.5-21.5-48-48-48zm-104 0H152v-72c0-39.7 32.3-72 72-72s72 32.3 72 72v72z" />
    </symbol>

  </svg>

</body>









<!-- admin login form section ends -->









<script src="assets/js/admin_login.js"></script>

</body>
</html>