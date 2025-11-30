-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th10 30, 2025 lúc 02:12 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shop_dienthoai`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cauhinh_footer`
--

CREATE TABLE `cauhinh_footer` (
  `id` int(11) NOT NULL,
  `ten_cua_hang` varchar(100) DEFAULT 'Tech Shop',
  `mo_ta` text DEFAULT 'Cửa hàng điện thoại và phụ kiện chất lượng',
  `diachi` text DEFAULT '18 Ung Văn Khiêm, phường Đông Xuyên, TP Long Xuyên, An Giang',
  `dienthoai` varchar(20) DEFAULT '076 3841190',
  `email` varchar(100) DEFAULT 'abc@abc.com'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cauhinh_footer`
--

INSERT INTO `cauhinh_footer` (`id`, `ten_cua_hang`, `mo_ta`, `diachi`, `dienthoai`, `email`) VALUES
(1, 'Tech Shop', 'Cửa hàng điện thoại và phụ kiện chất lượng, chính hãng', '18 Ung Văn Khiêm, phường Đông Xuyên, TP Long Xuyên, Kiên Giang', '076 3841199', 'techshop@19.com');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `danhmuc`
--

CREATE TABLE `danhmuc` (
  `id` int(11) NOT NULL,
  `tendanhmuc` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `danhmuc`
--

INSERT INTO `danhmuc` (`id`, `tendanhmuc`) VALUES
(1, 'Điện thoại Apple'),
(2, 'Điện thoại Samsung'),
(3, 'Điện thoại Google'),
(4, 'Phụ kiện điện thoại');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diachi`
--

CREATE TABLE `diachi` (
  `id` int(11) NOT NULL,
  `nguoidung_id` int(11) NOT NULL,
  `diachi` varchar(255) NOT NULL,
  `macdinh` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `diachi`
--

INSERT INTO `diachi` (`id`, `nguoidung_id`, `diachi`, `macdinh`) VALUES
(1, 6, 'sdfs', 1),
(2, 4, 'Kiên Giang', 1),
(3, 5, 'An Giang', 1),
(4, 9, 'Long Xuyên', 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhang`
--

CREATE TABLE `donhang` (
  `id` int(11) NOT NULL,
  `nguoidung_id` int(11) NOT NULL,
  `diachi_id` int(11) DEFAULT NULL,
  `ngay` datetime NOT NULL DEFAULT current_timestamp(),
  `tongtien` float NOT NULL DEFAULT 0,
  `ghichu` varchar(255) DEFAULT NULL,
  `trangthai` tinyint(4) DEFAULT 1
) ;

--
-- Đang đổ dữ liệu cho bảng `donhang`
--

INSERT INTO `donhang` (`id`, `nguoidung_id`, `diachi_id`, `ngay`, `tongtien`, `ghichu`, `trangthai`) VALUES
(4, 4, 2, '2025-11-19 10:56:47', 11990000, NULL, 3),
(5, 4, 2, '2025-11-19 11:19:44', 29990000, NULL, 3),
(6, 4, 2, '2025-11-19 11:21:08', 990000, NULL, 2),
(7, 4, 2, '2025-11-19 11:28:23', 39990000, NULL, 2),
(8, 4, 2, '2025-11-19 11:36:28', 390000, NULL, 2),
(9, 4, 2, '2025-11-19 12:15:34', 40980000, NULL, 3),
(11, 4, 2, '2025-11-19 12:20:29', 12490000, NULL, 3),
(13, 5, 3, '2025-11-20 17:00:56', 16990000, NULL, 3),
(14, 5, 3, '2025-11-20 23:20:57', 190000, NULL, 2),
(15, 5, 3, '2025-11-20 23:26:21', 39990000, NULL, 3),
(16, 5, 3, '2025-11-21 00:12:26', 690000, NULL, 3),
(17, 4, 2, '2025-11-25 21:01:24', 10990000, NULL, 1),
(18, 4, 2, '2025-11-25 21:01:53', 24980000, NULL, 2),
(19, 5, 3, '2025-11-25 21:03:52', 40170000, NULL, 1),
(20, 9, 4, '2025-11-26 00:40:10', 29990000, NULL, 3),
(21, 9, 4, '2025-11-26 00:41:16', 24990000, NULL, 1),
(22, 9, 4, '2025-11-26 00:58:32', 390000, NULL, 1),
(23, 4, 2, '2025-11-26 11:52:35', 37980000, NULL, 2),
(24, 4, 2, '2025-11-26 13:37:21', 89970000, NULL, 1),
(25, 4, 2, '2025-11-26 13:40:09', 48980000, NULL, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `donhangct`
--

CREATE TABLE `donhangct` (
  `id` int(11) NOT NULL,
  `donhang_id` int(11) NOT NULL,
  `mathang_id` int(11) NOT NULL,
  `dongia` float NOT NULL DEFAULT 0,
  `soluong` int(11) NOT NULL DEFAULT 1,
  `thanhtien` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `donhangct`
--

INSERT INTO `donhangct` (`id`, `donhang_id`, `mathang_id`, `dongia`, `soluong`, `thanhtien`) VALUES
(4, 4, 8, 11990000, 1, 11990000),
(5, 5, 13, 29990000, 1, 29990000),
(6, 6, 23, 990000, 1, 990000),
(7, 7, 9, 39990000, 1, 39990000),
(8, 8, 21, 390000, 1, 390000),
(9, 9, 13, 29990000, 1, 29990000),
(10, 9, 15, 10990000, 1, 10990000),
(11, 11, 20, 12490000, 1, 12490000),
(13, 13, 3, 16990000, 1, 16990000),
(14, 14, 24, 190000, 1, 190000),
(15, 15, 9, 39990000, 1, 39990000),
(16, 16, 22, 690000, 1, 690000),
(17, 17, 15, 10990000, 1, 10990000),
(18, 18, 20, 12490000, 2, 24980000),
(19, 19, 19, 19990000, 2, 39980000),
(20, 19, 24, 190000, 1, 190000),
(21, 20, 13, 29990000, 1, 29990000),
(22, 21, 18, 24990000, 1, 24990000),
(23, 22, 21, 390000, 1, 390000),
(24, 23, 17, 7990000, 1, 7990000),
(25, 23, 13, 29990000, 1, 29990000),
(26, 24, 13, 29990000, 3, 89970000),
(27, 25, 3, 16990000, 1, 16990000),
(28, 25, 1, 31990000, 1, 31990000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mathang`
--

CREATE TABLE `mathang` (
  `id` int(11) NOT NULL,
  `tenmathang` varchar(255) NOT NULL,
  `mota` text DEFAULT NULL,
  `thongso` text DEFAULT NULL,
  `giagoc` float NOT NULL DEFAULT 0,
  `giaban` float NOT NULL DEFAULT 0,
  `soluongton` int(11) NOT NULL DEFAULT 0,
  `hinhanh` varchar(255) DEFAULT NULL,
  `hinhphu` text DEFAULT NULL,
  `danhmuc_id` int(11) NOT NULL,
  `luotxem` int(11) NOT NULL DEFAULT 0,
  `luotmua` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `mathang`
--

INSERT INTO `mathang` (`id`, `tenmathang`, `mota`, `thongso`, `giagoc`, `giaban`, `soluongton`, `hinhanh`, `hinhphu`, `danhmuc_id`, `luotxem`, `luotmua`) VALUES
(1, 'iPhone 15 Pro Max 256GB', 'iPhone 15 Pro Max đại diện cho sự đột phá với thiết kế khung Titanium siêu nhẹ và bền bỉ, mang lại cảm giác cầm nắm cao cấp. Sức mạnh tuyệt đối được cung cấp bởi chip A17 Pro mới, tối ưu hóa cho hiệu năng chơi game và xử lý AI. Điểm nhấn là hệ thống camera chuyên nghiệp với ống kính Telephoto 5x quang học độc quyền. Cùng với cổng USB-C tốc độ cao và Dynamic Island cải tiến, 15 Pro Max 256GB là lựa chọn hàng đầu cho những người dùng đòi hỏi khắt khe nhất.', '[\"6.7\" Super Retina XDR\",\"Chip A17 Pro\",\"48MP + 12MP\",\"4422mAh\",\"iOS 17\",\"Titan nhẹ\"]', 34990000, 31990000, 9, 'images/products/iphone15promax.jpg', '[\"images/products/iphone15promax1.jpg\",\"images/products/iphone15promax2.jpg\",\"images/products/iphone15promax3.jpg\"]\n', 1, 5, 20),
(2, 'iPhone 14 Plus 128GB', 'iPhone 14 Plus 128GB sở hữu màn hình Super Retina XDR 6,7 inch sắc nét, mang đến không gian hiển thị rộng rãi cho xem phim và giải trí. Máy dùng chip A15 Bionic mạnh mẽ, xử lý trơn tru mọi tác vụ từ lướt web đến chơi game. Hệ thống camera kép 12MP hỗ trợ chụp đêm, chống rung và quay video 4K chất lượng cao. Thiết kế kính + khung nhôm sang trọng kèm chuẩn IP68 cho khả năng chống nước, chống bụi. Viên pin lớn giúp thời lượng sử dụng kéo dài cả ngày, rất phù hợp cho người dùng thích màn hình lớn nhưng vẫn muốn sự gọn nhẹ và hiệu năng ổn định.', '[\"6.7\" Super Retina\",\"Chip A16 Bionic\",\"12MP Dual\",\"4323mAh\",\"iOS 17\",\"Pin trâu\"]', 24990000, 22990000, 15, 'images/products/iphone14plus.png', '[\"images/products/iphone14plus1.jpg\",\"images/products/iphone14plus2.jpg\",\"images/products/iphone14plus3.jpg\"]\n', 1, 0, 10),
(3, 'iPhone 13 128GB', 'iPhone 13 128GB là sự lựa chọn hoàn hảo giữa hiệu năng và giá trị. Được trang bị chip A15 Bionic mạnh mẽ, máy mang lại tốc độ xử lý nhanh chóng cho mọi tác vụ từ làm việc đến giải trí. Hệ thống camera kép 12MP cùng tính năng Chế độ Điện ảnh (Cinematic Mode) giúp bạn dễ dàng quay video chuẩn điện ảnh. Thiết kế viền phẳng hiện đại, màn hình Super Retina XDR siêu sáng và dung lượng 128GB tiêu chuẩn đáp ứng thoải mái nhu cầu lưu trữ hàng ngày.', '[\"6.1\" Super Retina\",\"Chip A15 Bionic\",\"12MP Dual\",\"3240mAh\",\"iOS 16\",\"Giá tốt\"]', 18990000, 16990000, 18, 'images/products/iphone13.png', '[\"images/products/iphone131.jpg\",\"images/products/iphone132.jpg\",\"images/products/iphone133.jpg\"]\n', 1, 4, 15),
(4, 'Samsung Galaxy S24 Ultra 512GB', 'S24 Ultra là siêu phẩm tiên phong mở ra Kỷ nguyên Galaxy AI, mang đến các tính năng đột phá như Khoanh tròn để tìm kiếm, Dịch trực tiếp cuộc gọi và Trợ lý Chỉnh ảnh chuyên nghiệp. Máy được trang bị chip Snapdragon 8 Gen 3 for Galaxy mạnh mẽ nhất, RAM 12GB và bộ nhớ 512GB cho hiệu năng không giới hạn. Nổi bật với Camera 200MP cùng khả năng Zoom quang học 5x sắc nét và khung Titanium bền bỉ, S24 Ultra là sự kết hợp hoàn hảo giữa thiết kế đẳng cấp và công nghệ tương lai, đi kèm bút S Pen tích hợp', '[\"6.8\" Dynamic AMOLED 2X\",\"Snapdragon 8 Gen 3\",\"200MP + AI\",\"5000mAh\",\"S Pen\",\"Chống nước IP68\"]', 36990000, 33990000, 12, 'images/products/galaxys24ultra.jpg', '[\"images/products/galaxys24ultra1.jpg\",\"images/products/galaxys24ultra2.jpg\",\"images/products/galaxys24ultra3.jpg\"]\n', 2, 0, 25),
(5, 'Samsung Galaxy A55 256GB', 'Galaxy A55 là sự kết hợp hoàn hảo giữa thẩm mỹ và sức mạnh trong phân khúc tầm trung. Máy sở hữu thiết kế khung kim loại cao cấp lần đầu tiên xuất hiện trên dòng A, cùng chuẩn kháng nước IP67 bền bỉ. Hiệu năng được tối ưu bởi chip Exynos mới nhất và bộ nhớ trong 256GB lớn. Nổi bật với hệ thống Camera 50MP chống rung quang học (OIS), A55 mang lại chất lượng ảnh và video sắc nét, cùng màn hình Super AMOLED 120Hz rực rỡ cho trải nghiệm giải trí mượt mà.', '[\"6.6\" Super AMOLED\",\"Exynos 1480\",\"50MP OIS\",\"5000mAh\",\"IP67\",\"Giá rẻ\"]', 10990000, 9990000, 25, 'images/products/galaxya55.jpg', '[\"images/products/galaxya551.jpg\",\"images/products/galaxya552.jpg\",\"images/products/galaxya553.jpg\"]\n', 2, 0, 12),
(6, 'Samsung Galaxy Z Fold5 512GB', 'Galaxy Z Fold5 là chiếc điện thoại gập mỏng nhẹ nhất từ Samsung, mở ra không gian làm việc và giải trí tối thượng. Màn hình chính Dynamic AMOLED 2X 7.6 inch cho trải nghiệm đa nhiệm liền mạch với Thanh tác vụ (Taskbar) nâng cấp và Bút S Pen chuyên nghiệp. Hiệu năng vượt trội nhờ chip Snapdragon 8 Gen 2 for Galaxy, kết hợp bộ nhớ 512GB tiêu chuẩn. Thiết kế bản lề Flex Hinge mới bền bỉ hơn, giúp máy gập sát tuyệt đối, khẳng định vị thế của một siêu phẩm công nghệ linh hoạt và đẳng cấp.', '[\"7.6\" Foldable AMOLED\",\"Snapdragon 8 Gen 2\",\"50MP\",\"4400mAh\",\"Đa nhiệm\",\"Thiết kế gập\"]', 40990000, 37990000, 8, 'images/products/galaxyzfold5.jpg', '[\"images/products/galaxyzfold51.jpg\",\"images/products/galaxyzfold52.jpg\",\"images/products/galaxyzfold53.jpg\"]\n', 2, 1, 18),
(7, 'Google Pixel 8 Pro 128GB', 'Pixel 8 Pro là flagship đỉnh cao của Google, tích hợp chip Tensor G3 mới nhất, mở khóa các tính năng AI tạo sinh đột phá như Video Boost và Audio Magic Eraser. Máy nổi bật với hệ thống Camera Pro tiên tiến cùng cảm biến nhiệt độ tích hợp độc quyền. Màn hình Super Actua siêu sáng và hệ điều hành Android thuần túy được hỗ trợ cập nhật trong 7 năm. Với bộ nhớ 128GB, đây là lựa chọn hoàn hảo cho những người dùng yêu thích khả năng chỉnh sửa ảnh/video thông minh và hiệu năng mạnh mẽ.', '[\"6.7\" OLED 120Hz\",\"Tensor G3\",\"50MP + 48MP\",\"5050mAh\",\"AI Magic Editor\",\"7 năm update\"]', 24990000, 22990000, 15, 'images/products/pixel8pro.png', '[\"images/products/pixel8pro1.jpg\",\"images/products/pixel8pro2.jpg\",\"images/products/pixel8pro3.jpg\"]\n', 3, 2, 14),
(8, 'Google Pixel 7a 128GB', 'Google Pixel 7a mang đến khả năng chụp ảnh trứ danh của Pixel trong một mức giá tầm trung hấp dẫn. Được trang bị chip Tensor G2 mạnh mẽ, máy vẫn hỗ trợ các tính năng AI cốt lõi như Magic Eraser, cho phép chỉnh sửa ảnh dễ dàng. Máy sở hữu thiết kế quen thuộc, bền bỉ cùng màn hình 90Hz mượt mà. Với camera chất lượng cao và giao diện Android thuần túy được Google cam kết cập nhật lâu dài, Pixel 7a 128GB là lựa chọn thông minh cho những ai ưu tiên hiệu năng và nhiếp ảnh.', '[\"6.1\" OLED 90Hz\",\"Tensor G2\",\"64MP\",\"4385mAh\",\"AI chụp đêm\",\"Giá hợp lý\"]', 12990000, 11990000, 18, 'images/products/pixel7a.png', '[\"images/products/pixel7a1.jpg\",\"images/products/pixel7a2.jpg\",\"images/products/pixel7a3.jpg\"]\n', 3, 5, 8),
(9, 'Google Pixel Fold 256GB', 'Google Pixel Fold là chiếc điện thoại gập đầu tiên của Google, mang đến trải nghiệm di động hoàn toàn mới với màn hình lớn và tỷ lệ khung hình độc đáo. Máy nổi bật với khả năng xử lý chụp ảnh đẳng cấp Pixel được hỗ trợ bởi chip Tensor G2, tích hợp các tính năng AI thông minh độc quyền của Google. Thiết kế bền bỉ với bản lề linh hoạt, cùng bộ nhớ 256GB, Pixel Fold không chỉ là thiết bị giải trí mà còn là công cụ đa nhiệm mạnh mẽ, hoàn hảo cho những người yêu thích sự đổi mới và nhiếp ảnh.', '[\"7.6\" Foldable OLED\",\"Tensor G2\",\"48MP\",\"4821mAh\",\"Gập ngang\",\"Google AI\"]', 42990000, 39990000, 8, 'images/products/pixelfold.jpg', '[\"images/products/pixelfold1.jpg\",\"images/products/pixelfold2.jpg\",\"images/products/pixelfold3.jpg\"]\n', 3, 10, 10),
(10, 'Tai nghe không dây Apple AirPods Pro 2', 'AirPods Pro 2 mang đến trải nghiệm nghe nhạc đỉnh cao với chip Apple H2 mạnh mẽ, cho khả năng Khử tiếng ồn Chủ động (ANC) gấp đôi thế hệ trước. Chất lượng âm thanh được nâng cấp với Âm thanh Không gian Cá nhân hóa giúp bạn đắm chìm hoàn toàn. Chế độ Transparency thông minh tự điều chỉnh âm thanh xung quanh. Đi kèm là hộp sạc MagSafe cung cấp tổng thời lượng pin lên đến 30 giờ và có hỗ trợ tìm kiếm chính xác (Precision Finding), là lựa chọn hoàn hảo cho mọi nhu cầu di chuyển.', '[\"Âm thanh Spatial\",\"Chống ồn x2\",\"Pin 6h + case 30h\",\"Sạc không dây\",\"MagSafe\"]', 6490000, 5990000, 30, 'images/products/airpodspro2.jpg', '[\"images/products/airpodspro21.jpg\",\"images/products/airpodspro22.jpg\",\"images/products/airpodspro23.jpg\"]\n', 4, 3, 50),
(11, 'Sạc nhanh Samsung 45W', 'Bộ sạc Samsung 45W là giải pháp cấp nguồn mạnh mẽ, được thiết kế để nạp đầy pin cho thiết bị của bạn trong thời gian ngắn kỷ lục. Sử dụng công nghệ Super Fast Charging 2.0 (Sạc siêu nhanh 2.0), bộ sạc này đảm bảo tối ưu hóa tốc độ sạc an toàn cho các dòng Samsung Galaxy cao cấp. Thiết kế nhỏ gọn dễ dàng mang theo, cùng khả năng tương thích ngược với các chuẩn sạc thấp hơn, là phụ kiện không thể thiếu để duy trì năng lượng cho ngày dài bận rộn.', '[\"45W PD\",\"Sạc nhanh Super Fast\",\"Cổng USB-C\",\"An toàn nhiệt\",\"Tương thích Galaxy\",\"Nhỏ gọn\"]', 990000, 890000, 50, 'images/products/samsungcharger.jpeg', '[\"images/products/samsungcharger1.jpg\",\"images/products/samsungcharger2.jpg\",\"images/products/samsungcharger3.jpg\"]\n', 4, 1, 20),
(12, 'Ốp lưng Google Pixel 8', 'Ốp lưng được thiết kế riêng cho Google Pixel 8, mang lại sự bảo vệ chắc chắn mà vẫn giữ được đường nét thiết kế độc đáo của máy. Chất liệu nhựa dẻo (TPU) hoặc polycarbonate cao cấp giúp chống sốc hiệu quả và chống trầy xước. Ốp có các đường cắt chính xác, đảm bảo bạn dễ dàng truy cập vào các nút bấm và cổng sạc. Thiết kế mỏng nhẹ, chống bám vân tay giúp máy luôn sạch sẽ và nằm gọn trong tay, bảo vệ điện thoại mà không làm tăng thêm trọng lượng cồng kềnh.', '[\"Chống sốc quân đội\",\"Vật liệu TPU\",\"Bảo vệ camera\",\"Google Pixel 8\",\"Mỏng nhẹ\",\"Dễ cầm\"]', 790000, 690000, 40, 'images/products/pixelcase.jpg', '[\"images/products/pixelcase1.jpg\",\"images/products/pixelcase2.jpg\",\"images/products/pixelcase3.jpg\"]\n', 4, 2, 15),
(13, 'iPhone 16 Pro 128GB', 'iPhone 16 Pro nâng tầm trải nghiệm nhiếp ảnh di động với hệ thống camera tiên tiến nhất, nổi bật là ống kính Telephoto 5x/12MP và cảm biến chính được cải tiến lớn hơn. Thiết kế khung Titanium siêu nhẹ và nút Capture Button vật lý mới giúp việc chụp ảnh trở nên tức thì và chuyên nghiệp hơn. Sức mạnh được đảm bảo bởi chip A18 Pro mạnh mẽ, tối ưu cho AI và hiệu năng game, cùng dung lượng 128GB tiêu chuẩn, biến chiếc điện thoại này thành công cụ sáng tạo không giới hạn.', '[\"6.1\" Ceramic Shield\",\"Chip A18 Pro\",\"48MP Fusion\",\"iOS 18\",\"Apple Intelligence\",\"USB-C\"]', 32990000, 29990000, 6, 'images/products/iphone16pro.png', '[\"images/products/iphone16pro1.jpg\",\"images/products/iphone16pro2.jpg\",\"images/products/iphone16pro3.jpg\"]\n', 1, 29, 18),
(14, 'iPhone 15 128GB', 'iPhone 15 mang đến những nâng cấp cốt lõi, lần đầu tiên tích hợp Dynamic Island thông minh và Camera Chính 48MP độ phân giải cao, cho phép chụp ảnh zoom quang học 2x ấn tượng. Máy duy trì sức mạnh ổn định với chip A16 Bionic và sở hữu thiết kế viền bo cong cùng mặt lưng nhám màu sắc mới. Việc chuyển sang cổng USB-C phổ biến hoàn thiện trải nghiệm sử dụng hiện đại, làm cho iPhone 15 trở thành lựa chọn lý tưởng với mức giá dễ tiếp cận hơn.', '[\"6.1\" Super Retina\",\"Chip A16\",\"48MP Main\",\"iOS 17\",\"Dynamic Island\",\"Pin tốt\"]', 21990000, 19990000, 25, 'images/products/iphone15.jpg', '[\"images/products/iphone151.jpg\",\"images/products/iphone152.jpg\",\"images/products/iphone153.jpg\"]\n', 1, 22, 30),
(15, 'iPhone SE 2024 64GB', 'iPhone SE 2024 là sự kết hợp hoàn hảo giữa thiết kế cổ điển, quen thuộc và sức mạnh hàng đầu. Được trang bị chip mới nhất (giả định là A16 hoặc A17) từ Apple, máy mang lại tốc độ xử lý nhanh chóng cho mọi ứng dụng và game. Camera đơn được tối ưu hóa bằng thuật toán xử lý ảnh tiên tiến của Apple. Đây là lựa chọn lý tưởng cho người dùng yêu thích kích thước nhỏ gọn và cần một chiếc iPhone hiệu năng cao, bền bỉ với chi phí hợp lý nhất.', '[\"4.7\" Retina HD\",\"Chip A15\",\"12MP\",\"iOS 17\",\"Thiết kế nhỏ gọn\",\"Giá rẻ nhất\"]', 12990000, 10990000, 28, 'images/products/iphonese.jpg', '[\"images/products/iphonese1.jpg\",\"images/products/iphonese2.jpg\",\"images/products/iphonese3.jpg\"]\n', 1, 14, 22),
(16, 'Samsung Galaxy S24 256GB', 'Galaxy S24 256GB là thiết bị flagship nhỏ gọn mang đến kỷ nguyên Galaxy AI đột phá, với các tính năng thông minh như Dịch trực tiếp cuộc gọi (Live Translate) và Khoanh tròn để tìm kiếm (Circle to Search). Máy sở hữu thiết kế viền phẳng hiện đại và khung Armor Aluminum bền bỉ, cùng màn hình Dynamic AMOLED 2X siêu sáng. Được trang bị chip Exynos 2400 mạnh mẽ và camera chất lượng cao, S24 là sự lựa chọn hoàn hảo cho người dùng muốn trải nghiệm công nghệ AI mới nhất trong một thiết kế tinh tế.\n\n', '[\"6.2\" Dynamic AMOLED\",\"Snapdragon 8 Gen 3\",\"50MP\",\"4000mAh\",\"AI Galaxy\",\"Nhẹ 167g\"]', 22990000, 20990000, 20, 'images/products/galaxys24.jpg', '[\"images/products/galaxys241.jpg\",\"images/products/galaxys242.jpg\",\"images/products/galaxys243.jpg\"]\n', 2, 3, 25),
(17, 'Samsung Galaxy A35 128GB', 'Galaxy A35 tiếp tục mang phong cách thiết kế cao cấp với khung viền hiện đại và mặt lưng kính sang trọng. Máy sở hữu hệ thống Camera chính 50MP chống rung quang học (OIS), đảm bảo ảnh chụp đêm và video luôn sắc nét, ổn định. Hiệu năng được cung cấp bởi chip Exynos mạnh mẽ, đi kèm bộ nhớ 128GB tiêu chuẩn. Với màn hình Super AMOLED 120Hz rực rỡ và chuẩn kháng nước/bụi IP67, Galaxy A35 mang lại trải nghiệm giải trí mượt mà và an tâm trong mọi điều kiện sử dụng.\n\n', '[\"6.6\" AMOLED 120Hz\",\"Exynos 1380\",\"50MP\",\"5000mAh\",\"IP67\",\"Màn hình lớn\"]', 8990000, 7990000, 34, 'images/products/galaxya35.png', '[\"images/products/galaxya351.jpg\",\"images/products/galaxya352.jpg\",\"images/products/galaxya353.jpg\"]\n', 2, 4, 15),
(18, 'Samsung Galaxy Z Flip6 256GB', 'Galaxy Z Flip6 là biểu tượng của phong cách sống năng động, với thiết kế vỏ sò gấp gọn bỏ túi độc đáo. Máy nổi bật với Màn hình ngoài lớn hơn, cho phép xem thông báo, trả lời tin nhắn và chụp ảnh selfie tức thì mà không cần mở máy. Camera kép được nâng cấp mạnh mẽ giúp bạn tạo ra những bức ảnh chất lượng cao. Hiệu năng ổn định cùng bộ nhớ 256GB tiêu chuẩn, Z Flip6 không chỉ là điện thoại mà còn là một phụ kiện thời trang cá tính, bền bỉ và tiện lợi.', '[\"6.7\" Foldable AMOLED\",\"Snapdragon 8 Gen 3\",\"50MP\",\"3700mAh\",\"Gập dọc\",\"Thiết kế nhỏ\"]', 26990000, 24990000, 11, 'images/products/galaxyzflip6.jpg', '[\"images/products/galaxyzflip61.jpg\",\"images/products/galaxyzflip62.jpg\",\"images/products/galaxyzflip63.jpg\"]\n', 2, 17, 20),
(19, 'Google Pixel 9 128GB', 'Google Pixel 9 tiếp tục khẳng định vị thế dẫn đầu về AI và nhiếp ảnh di động. Được trang bị chip Tensor G4 mới nhất, máy mang lại hiệu năng xử lý tác vụ thông minh vượt trội và khả năng xử lý ảnh AI tức thì tinh vi hơn. Thiết kế tinh tế, nhỏ gọn cùng màn hình rực rỡ, đảm bảo trải nghiệm hiển thị tuyệt vời. Với hệ điều hành Android thuần túy và các tính năng bảo mật hàng đầu, Pixel 9 128GB là thiết bị hoàn hảo cho những người dùng coi trọng phần mềm thông minh và camera chất lượng cao.', '[\"6.3\" Actua Display\",\"Tensor G4\",\"50MP\",\"4700mAh\",\"AI Gemini\",\"7 năm update\"]', 21990000, 19990000, 15, 'images/products/pixel9.jpg', '[\"images/products/pixel91.jpg\",\"images/products/pixel92.jpg\",\"images/products/pixel93.jpg\"]\n', 3, 10, 16),
(20, 'Google Pixel 8a 128GB', 'Pixel 8a mang lại trải nghiệm phần mềm và AI đặc trưng của Google với mức giá dễ tiếp cận. Được trang bị chip Tensor G3, máy cung cấp các tính năng AI mạnh mẽ như Magic Editor và Best Take, giúp bạn chỉnh sửa ảnh chuyên nghiệp một cách dễ dàng. Camera kép được đánh giá cao, chụp ảnh sắc nét ngay cả trong điều kiện thiếu sáng. Với thiết kế trẻ trung, bền bỉ và cam kết cập nhật phần mềm lâu dài, Pixel 8a là lựa chọn hàng đầu cho những ai muốn trải nghiệm Android thuần túy và nhiếp ảnh thông minh.', '[\"6.1\" OLED 120Hz\",\"Tensor G3\",\"64MP\",\"4492mAh\",\"AI Photo\",\"Giá tầm trung\"]', 13990000, 12490000, 25, 'images/products/pixel8a.jpg', '[\"images/products/pixel8a1.jpg\",\"images/products/pixel8a2.jpg\",\"images/products/pixel8a3.jpg\"]\n', 3, 2, 12),
(21, 'Cáp USB-C to Lightning Anker PowerLine+ 1.8m', 'Cáp USB-C to Lightning Anker PowerLine+ 1.8m là sự lựa chọn hoàn hảo cho độ bền vượt trội. Được chế tạo với lõi sợi Aramid chịu lực và bọc ngoài bằng lớp vải nylon bện kép, cáp có khả năng chịu đựng hơn 30.000 lần uốn cong. Chiều dài 1.8 mét cung cấp sự linh hoạt tối đa khi sạc. Sản phẩm được chứng nhận MFi (Made for iPhone/iPad) của Apple và hỗ trợ sạc nhanh (Power Delivery), đảm bảo tốc độ nạp pin an toàn và hiệu quả nhất cho các thiết bị Apple của bạn.', '[\"1.8m dài\",\"MFi Certified\",\"Sạc nhanh 20W\",\"Dây dù chống đứt\",\"Anker PowerLine+\",\"USB-C to Lightning\"]', 490000, 390000, 48, 'images/products/anker-cable.png', '[\"images/products/anker-cable1.jpg\",\"images/products/anker-cable2.jpg\",\"images/products/anker-cable3.jpg\"]\n', 4, 9, 40),
(22, 'Ốp lưng Spigen iPhone 16 Pro Max', 'Ốp lưng Spigen dành cho iPhone 16 Pro Max là lựa chọn hàng đầu cho khả năng bảo vệ tối đa mà không làm mất đi vẻ ngoài của máy. Sản phẩm tích hợp công nghệ Air Cushion độc quyền, giúp hấp thụ lực sốc hoàn hảo trong các cú rơi. Thiết kế vừa vặn hoàn hảo, ôm sát thân máy và có viền nâng cao quanh camera và màn hình để chống trầy xước. Với vật liệu cao cấp chống ố vàng và bền bỉ, ốp lưng Spigen giữ cho thiết bị của bạn luôn như mới.', '[\"Chống va đập\",\"Viền cao bảo vệ\",\"Spigen Rugged\",\"iPhone 16 Pro Max\",\"Hỗ trợ MagSafe\",\"Đen bóng\"]', 790000, 690000, 39, 'images/products/spigen-case.jpg', '[\"images/products/spigen-case1.jpg\",\"images/products/spigen-case2.jpg\",\"images/products/spigen-case3.jpg\"]\n', 4, 7, 35),
(23, 'Sạc không dây Samsung 15W', 'Bộ sạc không dây Samsung 15W mang đến sự tiện lợi tối đa, loại bỏ sự rắc rối của dây cáp. Với tốc độ sạc nhanh 15W, nó cung cấp năng lượng ổn định cho các thiết bị Samsung Galaxy và các thiết bị hỗ trợ chuẩn Qi khác. Thiết kế mỏng, gọn nhẹ dễ dàng đặt trên bàn làm việc hoặc đầu giường. Tích hợp quạt làm mát thông minh giúp kiểm soát nhiệt độ, đảm bảo thiết bị của bạn được sạc một cách an toàn và hiệu quả qua đêm.', '[\"15W Qi\",\"Sạc không dây\",\"Tương thích Galaxy\",\"Đế tản nhiệt\",\"Nhẹ 68g\",\"Cáp kèm\"]', 1190000, 990000, 29, 'images/products/samsung-wireless.jpg', '[\"images/products/samsung-wireless1.jpg\",\"images/products/samsung-wireless2.jpg\",\"images/products/samsung-wireless3.jpg\"]\n', 4, 8, 28),
(24, 'Kính cường lực Google Pixel 9 Pro', 'Kính cường lực dành riêng cho Google Pixel 9 Pro được chế tạo từ vật liệu cao cấp, cung cấp độ cứng 9H chống trầy xước và va đập hiệu quả cho màn hình. Thiết kế vừa vặn, phủ kín màn hình cong mà không cản trở camera trước hay cảm biến. Đặc biệt, kính giữ được độ nhạy cảm ứng 100% và độ trong suốt cao, đảm bảo hiển thị sắc nét như màn hình gốc. Lớp phủ chống bám vân tay giúp màn hình luôn sạch sẽ và dễ dàng vệ sinh.', '[\"9H cứng\",\"Chống vân tay\",\"Dán full màn\",\"Google Pixel 9 Pro\",\"Cạnh cong 2.5D\",\"Dễ lau\"]', 290000, 190000, 58, 'images/products/pixel-glass.jpg', '[\"images/products/pixel-glass1.jpg\",\"images/products/pixel-glass2.jpg\",\"images/products/pixel-glass3.jpg\"]\n', 4, 2, 20);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nguoidung`
--

CREATE TABLE `nguoidung` (
  `id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `sodienthoai` varchar(10) NOT NULL,
  `matkhau` varchar(255) NOT NULL,
  `hoten` varchar(255) NOT NULL,
  `loai` tinyint(4) NOT NULL DEFAULT 3,
  `trangthai` tinyint(4) NOT NULL DEFAULT 1,
  `hinhanh` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `nguoidung`
--

INSERT INTO `nguoidung` (`id`, `email`, `sodienthoai`, `matkhau`, `hoten`, `loai`, `trangthai`, `hinhanh`) VALUES
(1, 'admin@shop.com', '0988994683', '900150983cd24fb0d6963f7d28e17f72', 'Quản Trị Viên', 1, 1, 'hinh2.jpg'),
(2, 'staff@shop.com', '11111111', '900150983cd24fb0d6963f7d28e17f72', 'Nhân Viên Bán Hàng', 2, 1, 'hinh3.jpg'),
(3, 'support@shop.com', '0988994685', '900150983cd24fb0d6963f7d28e17f72', 'Hỗ Trợ Khách Hàng', 2, 1, 'hinh1.png'),
(4, 'customer1@gmail.com', '0988994686', '900150983cd24fb0d6963f7d28e17f72', 'Nguyễn Văn Anh', 3, 1, NULL),
(5, 'customer2@gmail.com', '0332484921', '900150983cd24fb0d6963f7d28e17f72', 'Trần Thị B', 3, 1, NULL),
(6, 'abc@abc.com', '222222222', 'e11170b8cbd2d74102651cb967fa28e5', 'á', 3, 1, NULL),
(7, 'admin@dienthoai12.com', '000000999', '900150983cd24fb0d6963f7d28e17f72', 'Ngô Kim Ngân', 3, 1, NULL),
(9, 'khvy19@gmail.com', '9999999990', '96e79218965eb72c92a549dd5a330112', 'a', 3, 1, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cauhinh_footer`
--
ALTER TABLE `cauhinh_footer`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoidung_id` (`nguoidung_id`);

--
-- Chỉ mục cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nguoidung_id` (`nguoidung_id`),
  ADD KEY `diachi_id` (`diachi_id`);

--
-- Chỉ mục cho bảng `donhangct`
--
ALTER TABLE `donhangct`
  ADD PRIMARY KEY (`id`),
  ADD KEY `donhang_id` (`donhang_id`),
  ADD KEY `mathang_id` (`mathang_id`);

--
-- Chỉ mục cho bảng `mathang`
--
ALTER TABLE `mathang`
  ADD PRIMARY KEY (`id`),
  ADD KEY `danhmuc_id` (`danhmuc_id`);

--
-- Chỉ mục cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `danhmuc`
--
ALTER TABLE `danhmuc`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `diachi`
--
ALTER TABLE `diachi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `donhang`
--
ALTER TABLE `donhang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `donhangct`
--
ALTER TABLE `donhangct`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `mathang`
--
ALTER TABLE `mathang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT cho bảng `nguoidung`
--
ALTER TABLE `nguoidung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `diachi`
--
ALTER TABLE `diachi`
  ADD CONSTRAINT `diachi_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhang`
--
ALTER TABLE `donhang`
  ADD CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`nguoidung_id`) REFERENCES `nguoidung` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `donhangct`
--
ALTER TABLE `donhangct`
  ADD CONSTRAINT `donhangct_ibfk_1` FOREIGN KEY (`donhang_id`) REFERENCES `donhang` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `donhangct_ibfk_2` FOREIGN KEY (`mathang_id`) REFERENCES `mathang` (`id`) ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `mathang`
--
ALTER TABLE `mathang`
  ADD CONSTRAINT `mathang_ibfk_1` FOREIGN KEY (`danhmuc_id`) REFERENCES `danhmuc` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
