-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th12 08, 2022 lúc 06:24 AM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `comga`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `password` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `name`, `password`) VALUES
(1, 'admin', '6216f8a75fd5bb3d5f22b6f9958cdede3fc086c2');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` int(10) NOT NULL,
  `fff` varchar(30) NOT NULL,
  `quantity` int(10) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `iddanhmuc` int(11) NOT NULL,
  `namedanhmuc` varchar(30) CHARACTER SET utf8mb4 NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`iddanhmuc`, `namedanhmuc`, `image`) VALUES
(1, 'Món Chính', 'cat-2.png'),
(2, 'Món Phụ', 'cat-1.png'),
(3, 'Món Tráng Miệng', 'cat-4.png'),
(4, 'Nước Uống', 'cat-3.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `loaisp`
--

CREATE TABLE `loaisp` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `loaisp`
--

INSERT INTO `loaisp` (`id`, `name`) VALUES
(1, 'Gà'),
(2, 'Rau'),
(3, 'Nước');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `messages`
--

CREATE TABLE `messages` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `number` varchar(12) NOT NULL,
  `message` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `name`, `email`, `number`, `message`) VALUES
(1, 1, 'Trân Khánh Dư', 'trandugold@gmail.com', '0836547247', 'Quá ngon');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(100) NOT NULL,
  `user_id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `number` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL,
  `total_products` varchar(1000) NOT NULL,
  `total_price` decimal(10,3) NOT NULL,
  `placed_on` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(20) NOT NULL DEFAULT 'Chưa xử lí'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `number`, `email`, `method`, `address`, `total_products`, `total_price`, `placed_on`, `payment_status`) VALUES
(1, 1, 'Trần Khánh Dư', '0836547247', 'trandugold@gmail.com', 'Thanh toán khi nhận hàng', '61, hẻm 15, Trần Việt Châu, Cái Khế, Ninh Kiều, Cần Thơ', 'Cánh Gà Chiên Xù (30.000đ x 1) - Salad Cầu Vòng (12.000đ x 1) - Trà Chanh (10.000đ x 3) - ', '72.000', '2022-12-07 20:50:51', 'Chưa xử lí'),
(2, 1, 'Trần Khánh Dư', '0836547247', 'trandugold@gmail.com', 'Thanh toán khi nhận hàng', '61, hẻm 15, Trần Việt Châu, Cái Khế, Ninh Kiều, Cần Thơ', 'Đùi Gà Chiên Xù (40.000đ x 1) - Cánh Gà Chiên Xù (30.000đ x 1) - ', '70.000', '2022-12-07 21:15:02', 'Chưa xử lí');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category` varchar(100) NOT NULL,
  `chitiet` text NOT NULL DEFAULT 'Chưa có thêm chi tiết.',
  `loaisanpham` varchar(50) NOT NULL,
  `fff` varchar(20) NOT NULL,
  `price` decimal(10,3) NOT NULL,
  `image` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `chitiet`, `loaisanpham`, `fff`, `price`, `image`) VALUES
(1, 'Cơm Gà Chiên Xù', '1', 'Katsudon là một trong những món cơm tô Nhật Bản nổi tiếng nhất trên thế giới, và có thể dễ dàng hiểu được tại sao món ăn này lại nổi tiếng đến vậy: món ăn có sự cân bằng hoàn hảo giữa vị ngọt và vị mặn, kết cấu làm mê mẩn lòng người với thịt gà chiên giòn và hạt cơm căng tròn ngập dưới lớp trứng béo ngậy. Để tận hưởng trọn vẹn món ăn này, hãy thưởng thức khi còn nóng!', 'Gà', 'Phần', '25.000', 'chien xu.jpg'),
(2, 'Cơm Gà Xá Xíu', '1', 'Nếu bạn là một tín đồ của những món ăn từ gà thì không nên bỏ qua món cơm gà xá xíu bằng nồi chiên không dầu cực kì thơm ngon, hấp dẫn đâu nhé! Hôm nay, hãy cùng vào bếp với ZU GOLD thực hiện ngay món ăn đậm đà hương vị này cho gia đình và bạn bè cùng thưởng thức thôi nào, đảm bảo mọi người sẽ đều thích mê đấy!', 'Gà', 'Phần', '25.000', 'com ga xa xiu.jpg'),
(3, 'Mì Gà Xá Xíu', '1', 'Nếu đã quá quen với những món gà luộc, gà nướng hay gà rang, hôm nay hãy cùng ZU GOLD “F5” nguyên liệu quốc dân này thành phiên bản đậm đà, lạ miệng mà chắc chắn cả nhà ai cũng thích. Vào bếp với ZU GOLD là chế biên ngay món gà xá xíu đẫm sốt bằng nồi chiên không dầu thôi nào!', 'Gà', 'Phần', '25.000', 'mi ga xa xiu.jpg'),
(4, 'Gà Nướng Tiêu Xanh', '1', 'Gà nướng tiêu xanh luôn là một món nướng rất hấp dẫn và có sức hút đối với nhiều người. Vị béo thơm của phần thịt gà mềm mịn cùng với phần gia vị được ướp đậm đà, cay nồng cực kỳ thơm ngon. Hôm nay, bạn hãy cùng vào bếp với ZU GOLD để thực hiện ngay món gà nướng tiêu xanh bằng nồi chiên không dầu siêu ngon nhé!', 'Gà', 'Phần', '25.000', 'nuong tieu xanh.jpg'),
(5, 'Cơm Gà Nướng Tỏi', '1', 'Từ khi ra mắt đên nay #cơm_gà_nướng_tỏi gần như trở thành một HIỆN TƯỢNG mới chiếm trọn bao tử mọi khách hàng. 😋 Nhờ vào bí quyết ướp nướng chuyên biệt và kì công do tự tay Lê Trang nghiên cứu. 😋 Nhờ vào những gia vị tự nhiên Trang cho ra lò những chiếc đùi gà nướng vàng ươm bắt mắt, vị ngọt thơm đậm đà từ thịt gà tươi hoà lẫn vị cay cay hấp dẫn từ tỏi ớt thiên nhiên lôi cuốn. 😋 Và khách yên tâm, cơm gà vẫn theo tiêu chí NÓI KHÔNG với bôt ngọt hay hạt nêm.', 'Gà', 'Phần', '25.000', 'nuong toi.jpg'),
(6, 'Cơm Gà Sốt Thái', '1', 'Nhắc đến món từ gà là phải nói đến gà sốt Thái, món ăn được mọi người đặc biệt yêu thích nhờ hương vị chua cay đậm đà, ngon cực đỉnh. Hãy cùng ZU GOLD vào bếp tìm hiểu cách làm gà sốt thái ngay để mời cả nhà bạn nhé!', 'Gà', 'Phần', '25.000', 'sot thai.jpg'),
(11, 'Soup Gà Bắp Non', '1', 'Súp gà là món ăn khai vị quen thuộc trong các bữa tiệc tại nhà hàng. Món súp gà rất bổ dưỡng và dễ tiêu hóa, cách nấu cũng không quá phức tạp. Hãy theo dõi bài viết dưới đây để cùng vào bếp thực hiện nấu món từ gà siêu hấp dẫn, thơm ngon như ngoài hàng nhé!', 'Gà', 'Phần', '7.000', 'soup ga bap non.jpg'),
(12, 'Soup Gà Cải Thìa', '2', 'Súp gà là món ăn khai vị quen thuộc trong các bữa tiệc tại nhà hàng. Món súp gà rất bổ dưỡng và dễ tiêu hóa, cách nấu cũng không quá phức tạp. Hãy theo dõi bài viết dưới đây để cùng vào bếp thực hiện nấu món từ gà siêu hấp dẫn, thơm ngon như ngoài hàng nhé!', 'Gà', 'Phần', '7.000', 'soup ga cai thia.jpg'),
(13, 'Soup Gà Rong Biển', '2', 'Súp gà là món ăn khai vị quen thuộc trong các bữa tiệc tại nhà hàng. Món súp gà rất bổ dưỡng và dễ tiêu hóa, cách nấu cũng không quá phức tạp. Hãy theo dõi bài viết dưới đây để cùng vào bếp thực hiện nấu món từ gà siêu hấp dẫn, thơm ngon như ngoài hàng nhé!', 'Gà', 'Phần', '7.000', 'soup ga rong bien.jpg'),
(14, 'Trà Chanh', '4', 'Hiện nay, nhu cầu ăn uống, khám phá thế giới ẩm thực của con người ngày càng phong phú, đa dạng. Không chỉ với các địa điểm kinh doanh nước uống, dân pha chế chuyên nghiệp mới quan tâm đến các xu hướng đồ uống đang hot mà đặc biệt, với giới trẻ, nhu cầu tìm hiểu về các món ăn, đồ uống hot trend, độc và lạ cũng rất lớn. Vậy đâu là xu hướng đồ uống 2020, cùng khám phá ngay nhé!', 'Nước', 'Kg', '10.000', 'tra chanh.jpg'),
(15, 'Nước Ép Chanh Dây', '4', 'Hiện nay, nhu cầu ăn uống, khám phá thế giới ẩm thực của con người ngày càng phong phú, đa dạng. Không chỉ với các địa điểm kinh doanh nước uống, dân pha chế chuyên nghiệp mới quan tâm đến các xu hướng đồ uống đang hot mà đặc biệt, với giới trẻ, nhu cầu tìm hiểu về các món ăn, đồ uống hot trend, độc và lạ cũng rất lớn. Vậy đâu là xu hướng đồ uống 2020, cùng khám phá ngay nhé!', 'Nước', 'Kg', '10.000', 'nuoc ep canh day.jpg'),
(16, 'Salad Cầu Vòng', '1', '“Salad Cầu Vồng Chay” với đầy đủ hương vị tươi ngon và cách làm siêu nhanh chóng và dễ dàng. Với lớp nước sốt trộn xoài mayonnaise chua cay được phủ lên, hẳn sẽ là một sự kết hợp hoàn hảo giữa các hương vị để tạo nên một món salad giàu dưỡng chất, thơm ngon và lành mạnh. Cùng Zu Gold vào bếp ngay với công thức làm salad ngay dưới đây bạn nhé!', 'Rau', 'Phần', '12.000', 'salad cau vong.jpg'),
(17, 'Gà Nướng Nguyên Con', '2', 'Gà nướng hay thịt gà nướng bao gồm các bộ phận của con gà hoặc toàn bộ nguyên con gà được nướng hoặc hun khói (BBQ). Có nhiều kỹ thuật chuẩn bị nấu nướng dành cho món gà nướng này trên khắp toàn cầu và khu vực và theo phong cách nấu ăn. Thịt gà nướng thường được tẩm gia vị hoặc phủ trong một lớp gia vị, hỗn hợp nước sốt thịt nướng, hoặc cả hai, cũng có thể một số nơi chỉ nướng không. Nước xốt cũng được sử dụng để làm mềm thịt và thêm đậm đà . Gà nướng là một trong những món nướng phổ biến.', 'Gà', 'Con', '150.000', 'dish-3.png'),
(18, 'Đùi Gà Chiên Xù', '2', 'Cánh gà là bộ phận mà rất được nhiều người yêu thích. Có vô vàn cách chế biến món ăn từ cánh gà, từ đơn giản đến phức tạp, mỗi món đều mang hương vị đặc biệt riêng. Cánh gà chiên xù là món ăn rất được yêu thích đặc biệt là trẻ nhỏ, với phần da giòn rụm, thơm ngon. Nấu cỗ 29 giới thiệu cho bạn đọc cách chế biến món ăn này.', 'Gà', 'Phần', '40.000', 'dish-6.png'),
(19, 'Cánh Gà Chiên Xù', '2', 'Cánh gà là bộ phận mà rất được nhiều người yêu thích. Có vô vàn cách chế biến món ăn từ cánh gà, từ đơn giản đến phức tạp, mỗi món đều mang hương vị đặc biệt riêng. Cánh gà chiên xù là món ăn rất được yêu thích đặc biệt là trẻ nhỏ, với phần da giòn rụm, thơm ngon. Nấu cỗ 29 giới thiệu cho bạn đọc cách chế biến món ăn này.', 'Gà', 'Phần', '30.000', 'dish-2.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `slider`
--

CREATE TABLE `slider` (
  `id` int(10) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8mb4 NOT NULL,
  `image` varchar(100) CHARACTER SET utf8mb4 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `slider`
--

INSERT INTO `slider` (`id`, `name`, `image`) VALUES
(2, 'Gà Nướng Nguyên Con', '3ga.png'),
(3, 'Cơm Gà Chiên Xù', '2ga.png'),
(4, 'Cánh Gà Chiên Xù', 'ga.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(100) NOT NULL,
  `name` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `number` varchar(10) NOT NULL,
  `password` varchar(50) NOT NULL,
  `address` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `number`, `password`, `address`) VALUES
(1, 'Trần Khánh Dư', 'trandugold@gmail.com', '0836547247', 'd159370e26e988e09c0a12ac2637a4aa39e66037', '61, hẻm 15, Trần Việt Châu, Cái Khế, Ninh Kiều, Cần Thơ'),
(11, 'Hàu Nướng Phô Mai', 'trandugold1@gmail.com', '0836547244', '601f1889667efaebb33b8c12572835da3f027f78', '');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`iddanhmuc`);

--
-- Chỉ mục cho bảng `loaisp`
--
ALTER TABLE `loaisp`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `slider`
--
ALTER TABLE `slider`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `iddanhmuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT cho bảng `loaisp`
--
ALTER TABLE `loaisp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `slider`
--
ALTER TABLE `slider`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
