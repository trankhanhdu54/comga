<?php

include '../components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="vn">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Về Chúng Tôi</title>
   <link rel="icon" href="images/logo.png">
    <meta name="description" content="Hải Sản Hoài Phương chuyên cung cấp hải sản tươi sống, các món ngon hải sản tại Cần Thơ">
    <meta property="og:type" content="profile">
    <meta property="og:title" content="Hải Sản Hoài Phương | Cần Thơ">

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->

   

   <!-- custom css file link  -->
   <!-- <link rel="stylesheet" href="css/app.css"> -->
   
   <link rel="stylesheet" href="../css/404.css">
   <link rel="stylesheet" href="../css/style.css">



</head>
<body>
   
<!-- header section starts  -->

<!-- header section ends -->

<section class="page_404">
	<div class="container">
		<div class="row">	
		<div class="col-sm-12 ">
		<div class="col-sm-10 col-sm-offset-1  text-center">
		<div class="four_zero_four_bg">
			<h1 class="text-center ">404</h1>
		
		
		</div>
		
		<div class="contant_box_404">
		<h3 class="h2">
		Có vẻ như bạn đã bị lạc lối ~~
		</h3>
		
		<p>Địa chị bạn truy cập không tồn tại!</p>
		
		<a style="text-decoration: none" href="../home" class="link_404">Về Trang Chủ</a>
	</div>
		</div>
		</div>
		</div>
	</div>
</section>


</body>
</html>