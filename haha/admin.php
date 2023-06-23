<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:index.php');
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin HoaiPhuong</title>
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
            <div class="cardBox">
                <div class="card">
                    <div> 
                    <?php
                        $select_orders = $conn->prepare("SELECT * FROM `orders`");
                        $select_orders->execute();
                        $numbers_of_orders = $select_orders->rowCount();
                    ?>
                        <div class="numbers"><?= $numbers_of_orders; ?></div>
                        <div class="cardName">Đơn hàng</div>
                    </div>
                
                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                    <?php
                        $select_products = $conn->prepare("SELECT * FROM `products`");
                        $select_products->execute();
                        $numbers_of_products = $select_products->rowCount();
                    ?>
                        <div class="numbers"><?= $numbers_of_products; ?></div>
                        <div class="cardName">Món ăn</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cart-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                    <?php
                        $select_messages = $conn->prepare("SELECT * FROM `messages`");
                        $select_messages->execute();
                        $numbers_of_messages = $select_messages->rowCount();
                    ?>
                        <div class="numbers"><?= $numbers_of_messages; ?></div>
                        <div class="cardName">Tin nhắn</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="chatbubbles-outline"></ion-icon>
                    </div>
                </div>

                <div class="card">
                    <div>
                    <?php
                        $total_pendings = 0;
                        $select_pendings = $conn->prepare("SELECT * FROM `orders` WHERE payment_status = ?");
                        $select_pendings->execute(['Đã hoàn thành']);
                        while($fetch_pendings = $select_pendings->fetch(PDO::FETCH_ASSOC)){
                            $total_pendings += $fetch_pendings['total_price'];
                        }
                    ?>
                        <div class="numbers"><?= $total_pendings; ?>.<span>000</span></div>
                        <div class="cardName">Doanh thu</div>
                    </div>

                    <div class="iconBx">
                        <ion-icon name="cash-outline"></ion-icon>
                    </div>
                </div>
            </div>

            <!-- ================ Order Details List ================= -->
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Đơn hàng mới</h2>
                        <a href="admin-alldonhang.php" class="btn">View All</a>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Khách hàng</td>
                                <td>Tổng Giá</td>
                                <td>Thời gian</td>
                                <td>Trạng thái</td>
                            </tr>
                        </thead>

                        <tbody>
                        <?php
                            $select_orders = $conn->prepare("SELECT * FROM `orders` ORDER BY id DESC LIMIT 6;");
                            $select_orders->execute();
                            if($select_orders->rowCount() > 0){
                                while($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)){
                        ?>
                            <tr>
                                <td><?= $fetch_orders['name']; ?></td>
                                <td><?= $fetch_orders['total_price']; ?></td>
                                <td><?= $fetch_orders['placed_on']; ?></td>
                            <td><span class="<?php if(
                                    $fetch_orders['payment_status'] == 'Chưa xử lí'){ echo 'status inProgress';
                                }else if ($fetch_orders['payment_status'] == 'Đang vận chuyển'){ echo 'status pending'; 
                                }else if ($fetch_orders['payment_status'] == 'Đã hủy đơn'){ echo 'status return'; }
                                else { echo 'status delivered'; }; ?>">
                                <?= $fetch_orders['payment_status']; ?>
                            </span></td>
                            </tr>
                            <?php
                                }
                            }else{
                                echo '<p class="empty">chưa có đơn đặt hàng nào!</p>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- ================= New Customers ================ -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Khách hàng vừa tham gia</h2>
                    </div>

                    <table>
                    <?php
                            $select_account = $conn->prepare("SELECT * FROM `users` ORDER BY id DESC");
                            $select_account->execute();
                            if($select_account->rowCount() > 0){
                                while($fetch_accounts = $select_account->fetch(PDO::FETCH_ASSOC)){  
                        ?>
                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="assets/imgs/customer02.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4><?= $fetch_accounts['name']; ?> </h4>
                                </br>
                                <h4> <span> Điện thoại: <?= $fetch_accounts['number']; ?></span></h4>
                            </td>
                        </tr>
                        <?php
                                }
                            }else{
                                echo '<p class="empty">Chưa có ai đăng ký!</p>';
                            }
                            ?>

                        
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- =========== Scripts =========  -->
    <script src="assets/js/main.js"></script>

    <!-- ====== ionicons ======= -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>