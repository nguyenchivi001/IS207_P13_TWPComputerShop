SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


-- --------------------------------------------------------

--
-- Table structure for table `admin_info`
--

CREATE TABLE `admin_info` (
  `admin_id` int(10) NOT NULL,
  `admin_name` varchar(100) NOT NULL,
  `admin_email` varchar(300) NOT NULL,
  `admin_password` varchar(300) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin_info`
--

INSERT INTO `admin_info` (`admin_id`, `admin_name`, `admin_email`, `admin_password`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', '25f9e794323b453885f5181f1b624d0b','Manager');

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `brand_id` int(100) NOT NULL,
  `brand_title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`brand_id`, `brand_title`) VALUES
(1, 'Apple'),
(2, 'Samsung'),
(3, 'Hp'),
(4, 'Acer'),
(5, 'Dell'),
(6, 'Msi'),
(7, 'Lenovo'),
(8, 'Lg'),
(9, 'Asus'),
(10, 'Alienware'),
(11, 'Gigabyte');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(10) NOT NULL,
  `p_id` int(10) NOT NULL,
  `ip_add` varchar(250) NOT NULL,
  `user_id` int(10) DEFAULT NULL,
  `qty` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(100) NOT NULL,
  `cat_title` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_title`) VALUES
(1, 'Laptop Gaming'),
(2, 'Laptop Học tập, Văn phòng'),
(3, 'Laptop Đồ họa'),
(4, 'Laptop Mỏng nhẹ');

-- --------------------------------------------------------

--
-- Table structure for table `email_info`
--

CREATE TABLE `email_info` (
  `email_id` int(100) NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `email_info`
--

INSERT INTO `email_info` (`email_id`, `email`) VALUES
(3, 'admin@gmail.com'),
(4, 'puneethreddy951@gmail.com'),
(5, 'supportreddy@gmail.com'),
(6, 'vantuan100301@gmail.com'),
(7, 'ntson230801@gmail.com');


-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `trx_id` varchar(255) NOT NULL,
  `p_status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


-- --------------------------------------------------------

--
-- Table structure for table `orders_info`
--

CREATE TABLE `orders_info` (
  `order_id` int(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zip` int(10) NOT NULL,
  `cardname` varchar(255) NOT NULL,
  `cardnumber` varchar(20) NOT NULL,
  `expdate` varchar(255) NOT NULL,
  `prod_count` int(15) DEFAULT NULL,
  `total_amt` int(15) DEFAULT NULL,
  `cvv` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--------------------------------------------------------

--
-- Table structure for table `order_products`
--

CREATE TABLE `order_products` (
  `order_pro_id` int(10) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `qty` int(15) DEFAULT NULL,
  `amt` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(100) NOT NULL,
  `product_cat` int(100) NOT NULL,
  `product_brand` int(100) NOT NULL,
  `product_title` varchar(255) NOT NULL,
  `product_price` int(100) NOT NULL,
  `product_desc` text NOT NULL,
  `product_image` text NOT NULL,
  `product_keywords` text NOT NULL,
  `quantity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_cat`, `product_brand`, `product_title`, `product_price`, `product_desc`, `product_image`, `product_keywords`,`quantity`) VALUES
(1, 2, 4, 'Laptop Acer Aspire 5', 62849000, '(i5 1235U/8GB RAM/512GB SSD/14.0 inch FHD/Win11)', 'acer1.png', 'Acer-5954',10),
(2, 2, 4, 'Laptop Acer Aspire 3', 14899000, ' (i5 1135G7/8GB RAM/512GB SSD/15.6 inch FHD/ Win 11)', 'acer2.png', 'Acer-54M5',10),
(4, 1, 4, 'Laptop Acer Gaming Nitro 5', 37799000, '(i9 12900H/16GB Ram/512GB SSD/RTX3060 6G/15.6 inch FHD 165Hz/Win 11)', 'acer4.png', ' Acer-957R',10),
(5, 1, 9, 'Laptop Asus Gaming ROG Strix ', 19799000, '(R7 4800H/8GB RAM/512GB SSD/15.6 FHD 144hz/GTX1650 4GB/Win11)', 'asus1.png', 'Asus-HN015W',10),
(6, 1, 9, 'Laptop Asus Gaming TUF', 19049000, '(R5 4600H/8GB RAM/512GB SSD/15.6 FHD 144hz/RTX 3050 4GB/Win11)', 'asus3.png', 'asus',10),
(7, 2, 5, 'Laptop Dell Inspiron 3520', 13599000, '(i3 1215U 8GB RAM/256GB SSD/15.6 inch FHD/Win11/OfficeHS21/?en)', 'dell1.png', 'Dell-N3520',10),
(8, 2, 5, 'Laptop Dell Inspiron 5420', 13599000, '(i7 1255U/8GB/512GB SSD/14.0FHD+/Win11/Office HS21)', 'dell4.png', 'Dell-G2',10),
(9, 2, 5, 'Laptop Dell Inspiron 3520', 17399000, ' (i5 1235U 8GB RAM/512GB SSD/15.6 inch FHD/Win11/OfficeHS21)', 'dell1.png', 'Dell-085W11BLU',10),
(10, 4, 3, 'Laptop HP ProBook 440 G8', 196678000, '(i5 1145G7/16GB RAM/512GB SSD /14\" HD/FP/Win10 Pro)', 'hp1.png', 'HP-095',10),
(11, 4, 3, 'Laptop HP Pavilion 14-dv2069TU', 13199000, '(i3 1215U/8GB RAM/256GB SSD/14 FHD/Win11)', 'hp2.png', ' HP-145',10),
(12, 4, 3, 'Laptop HP Pavilion 15-eg2035TX', 18799000, '(i5-1235U/8GB RAM/512GB SSD/15.6 FHD/MX550 2Gb/Win11)', 'hp3.png', 'HP-142',10),
(13, 4, 7, 'Laptop Lenovo IdeaPad Slim 5 Pro 14IAP7', 19299000, '(i5 1240P/16GB RAM/512GB SSD/14 2.8K/Win11)', 'lenovo1.png', 'Lenovo-558',10),
(14, 2, 7, 'Laptop Lenovo V14 ', 12899000, '(i5 1235U/8GB RAM/256GB SSD/14 FHD/Dos)', 'lenovo2.png', 'Lenovo-62VN',10),
(15, 2, 7, 'Laptop Lenovo Thinkpad E14', 19899000, '(i5 1235U/16GB RAM/512GB SSD/14.0 FHD/Dos)', 'lenovo3.png', 'Lenovo-E14',10),
(16, 4, 6, 'Laptop MSI Modern 14 ', 19899000, '(i5-1155G7/8GB RAM/512GBSSD/MX450 2GB/14 inch FHD/Win 10) ', 'msi1.png', 'MSI-425',10),
(17, 1, 6, 'Laptop MSI Gaming GF63 Thin ', 18799000, '(i5 11400H/8GB RAM/512GBSSD/RTX3050Ti 4G/15.6 inch FHD/Win11)', 'msi2.png', 'MSI-473VN',10),
(19, 1, 6, 'Laptop MSI Gaming Cyborg 15', 27839000, '(i7 12650H/8GB/512GB SSD/RTX4050 6GB/15.6FHD 144Hz/Win11)', 'msi3.png', 'MSI-240VN',10),
(20, 4, 8, 'Laptop LG Gram 14ZD90Q-G. AH75A5', 32849000, '(i7-1260P/16GB RAM/512GB SSD/14.0 inch WUXGA/Win11/)', 'lg1.png', 'LG-G030',10),
(21, 4, 8, 'Laptop LG Gram 16ZD90Q-G.AX55A5', 29899000, ' (i5-1240P/16GB RAM/512GB SSD/16.0 inch WQXGA/Dos)', 'lg2.png', 'LG-032',10),
(22, 4, 8, 'Laptop LG Gram 16ZD90Q-G.AX72A5', 33349000, ' (i7-1260P/16GB RAM/256GB SSD/16.0 inch WQXGA/Dos)', 'lg3.png', 'LG-033',10),
(23, 2, 11, 'Laptop Gigabyte U4 (UD-50S1823SO)', 15199000, '(i5 1155G7/16GB RAM/512GB SSD/14.0inch FHD/Win11/2021)', 'giga1.png', 'Gigabyte-025',10),
(24, 1, 11, 'Laptop Gigabyte Gaming G5 ', 23199000, '(i5 12500H /16GB Ram/512GB SSD/RTX3050 4G/15.6 inch FHD 144Hz/Win 11)', 'giga2.png', 'Gigabyte-029',10),
(25, 1, 11, 'Laptop Gigabyte Gaming AORUS 17', 54449000, '(i7 12700H /16GB Ram/1TB SSD/RTX3070Ti 8G/17.3 inch FHD 360Hz/Win 11)', 'giga3.png', 'Gigabyte-032',10),
(27, 4, 1, 'Apple MacBook Air M1 2020', 18790000, 'Apple MacBook Air M1 2020 8GB/256GB/7-core GPU', 'apple1.png', 'Apple-3SA',10),
(32, 1, 10, 'Laptop Gaming Dell Alienware M15 R6', 42999000, '(i7 11800H/32GB RAM/1TB SSD/RTX3060 6G/15.6 inch QHD 240Hz/Win11/OfficeHS21)', 'alienware1.png', 'alienware',10),
(33, 1, 10, 'Laptop Gaming Dell Alienware M18', 87000000, '(I9 13900HX / 32GB / 1TB SSD / RTX 4080 12GB / QHD+ 165Hz)', 'alienware2.png', 'alienware',10),
(34, 1, 10, 'Laptop Gaming Dell Alienware X17', 54500000, '(I7 12700H / 16GB / 1TB SSD / RTX 3060 6GB / FHD 165HZ)', 'alienware3.png', 'alienware2',10),
(35, 3, 9, 'Laptop Asus Pro Art', 82499000, '(i9 12900H/32GB RAM/1TB SSD/16 Oled WQUXGA/RTX A3000 12GB/Win11)', 'asus4.png', 'Asus-L2048W',10),
(36, 3, 1, 'Apple Macbook Pro 13', 40199000, 'Apple M2 /8C CPU/10C GPU/16GB RAM/512GB SSD/13.3 inch/Mac OS)', 'apple2.png', 'Apple-034',10),
(37, 3, 1, 'Apple Macbook Air', 34499000, 'Apple M2/8C CPU/10C GPU/8GB RAM/512GB SSD/13.6 inch/Mac OS)', 'apple3.png', 'Apple-3SA',10),
(38, 3, 1, 'Apple Macbook Pro 14', 59999000, 'Apple M2 Pro 12C CPU/19C GPU/16GB RAM/1TB SSD/14.2 inch/Mac OS/Xám', 'apple1.png', 'Apple',10),
(39, 2, 1, 'Apple Macbook Air', 38899000, 'Apple M2/8C CPU/8C GPU/16GB RAM/512GB SSD/13.6/Mac OS/B?c', 'apple4.png', 'Apple',10),
(40, 2, 1, 'Apple Macbook Pro 16', 60499000, 'Apple M1 Pro/16GB RAM/512GB SSD/16.2 inch/Mac OS/B?c', 'apple5.png', 'Apple',10),
(45, 2, 3, 'Laptop HP Envy X360', 26999000, 'i7 1250U/16GB RAM/512GB SSD/13.3 QHD C?m ?ng/Bút/Win11/Xanh', 'hp4.png', 'HP',10),
(46, 2, 3, 'Laptop HP 15s-fq2712T', 10599000, 'i3 1115G4/8GB RAM/256GB SSD/15.6 HD/Win11/B?c', 'hp5.JPG', 'HP',10),
(47, 4, 3, 'Laptop HP 15s-fq2663TU', 9999000, 'i3 1115G4/4GB RAM/256GB SSD/15.6 HD/Win11/B?c', 'hp6.jpg', 'HP',10),
(48, 2, 4, 'Laptop Acer Swift 3 SF314-511-55QE', 17999000, 'i5-1135G7/16GBRAM/512GB SSD/14.0 inch FHD IPS/Win11/B?c', 'acer5.jpg', 'Acer',10),
(49, 2, 4, 'Laptop Acer Swift 3 SF314-512-56QN', 20299000, 'i5-1240P/16GB RAM/512GB SSD/14.0 inch QHD IPS/Win11/B?c/v? nhôm', 'acer6.jpg', 'Acer',10),
(50, 1, 4, 'Laptop Acer Gaming Nitro 5 Tiger', 28499000, 'i7 12700H/8GB Ram/512GB SSD/RTX3050Ti 4G/15.6 inch FHD 144Hz/Win 11/?en', 'acer7.JPG', 'Acer',10),
(51, 4, 2, 'Laptop Samsung Galaxy Book Pro', 16990000, ' Intel Core i5-1135G7 | 15.6 inch', 'samsung4.JPG', 'Samsung',10),
(52, 4, 2, 'Laptop Samsung Galaxy Book Flex 2', 17999000, 'Alpha NP730QDA KB3US - Intel Core i5', 'samsung5.JPG', 'Samsung',10),
(53, 4, 2, 'Laptop Samsung Galaxy Book2 360', 87000000, 'Intel Core i7-1255U | 13 inch Full HD', 'samsung6.JPG', 'Samsung',10),
(54, 1, 6, 'Laptop MSI Gaming Katana 15', 34339000, 'shirts', 'msi4.png', 'msi',10),
(55, 2, 6, 'Laptop MSI Modern 15', 14199000, 'shirts', 'msi5.png', 'msi',10),
(56, 1, 6, 'Laptop MSI Gaming GF63 Thin ', 16799000, 'shirts', 'msi6.png', 'msi',10),
(57, 2, 7, 'Laptop Lenovo Thinkpad E15 G4 ', 18599000, 'shirts', 'lenovo4.png', 'lenovo',10),
(58, 2, 7, 'Laptop Lenovo Thinkpad E14', 19899000, 'shirts', 'lenovo5.png', 'lenovo',10),
(59, 2, 7, 'Laptop Lenovo IdeaPad Slim 5 Pro 14AR7H', 21349000, 'shirts', 'lenovo6.png', 'lenovo',10),
(60, 4, 8, 'Laptop LG Gram 16ZD90Q-G.AH78A5 ', 43349000, 'shirts', 'lg4.png', 'lg',10),
(61, 4, 8, 'Laptop LG Gram 16ZD90Q-G.AX51A5', 28299000, 'lg', 'lg5.png', 'lg',10),
(62, 4, 8, 'Laptop LG Gram 17Z90P-G.AH78A5', 29990000, 'lg', 'lg6.png', 'lg',10),
(63, 2, 9, 'Laptop Asus ZenBook UX3402VA-KM085W', 26299000, 'i5 1340P/16GB RAM/512GB SSD/14 Oled/Win11', 'asus4.png', 'Asus',10),
(64, 2, 9, 'Laptop Asus VivoBook A1503ZA-L1421W', 17799000, 'i5 12500H/8GB RAM/512GB SSD/15.6 Oled/Win11', 'asus5.png', 'Asus',10),
(65, 3, 9, 'Laptop Asus Pro Art W7600Z3A-L2048W', 82499000, 'i9 12900H/32GB RAM/1TB SSD/16 Oled WQUXGA/RTX A3000 12GB/Win11', 'asus6.png', 'Asus',10),
(66, 1, 11, 'Laptop Gigabyte Gaming AERO 16 (XE5-73VN938AH)', 46349000, 'i7 12700H /16GBRam/2TB SSD/RTX3070Ti 8G/16.0 inch UHD+ AMOLED/Win 11', 'giga4.png', 'Gigabyte',10),
(67, 1, 11, 'Laptop Gigabyte Gaming AORUS 15 (XE4-73VNB14GH)', 47849000, 'i7 12700H /16GBRam/1TB SSD/RTX3070Ti 8G/15.6 inch QHD 165Hz/Win 11', 'giga5.png', 'Gigabyte',10),
(68, 1, 11, 'Laptop Gigabyte Gaming G5 (GE- 51VN213SH)', 21099000, 'i5 12500H /16GB Ram/512GB SSD/RTX3050 4G/15.6 inch FHD 144Hz/Win 11', 'giga6.png', 'Gigabyte',10),
(69, 1, 10, 'Laptop Gaming Dell Alienware M15 R7', 61990000, 'AMD Ryzen 9 6900HX/16GB/512GB/GeForce RTX 3080Ti/15.6\" QHD/Win 11', 'alienware4.png', 'Alienware',10),
(70, 1, 10, 'Laptop Gaming Dell Alienware M15 R7', 39000000, 'i7 12700H /16GBRam/1TB SSD/RTX3070Ti 8G/15.6 inch QHD 165Hz/Win 11', 'alienware5.png', 'Alienware',10),
(71, 1, 10, 'Laptop Gaming Dell Alienware M15 R6 P109F001CBL', 44990000, 'i7 12700H /16GBRam/2TB SSD/RTX3070Ti 8G/16.0 inch UHD+ AMOLED/Win 11', 'alienware6.png', 'Alienware',10),
(72, 2, 5, 'Laptop Dell Inspiron 5620 ', 22649000, 'shirts', 'dell4.png', 'dell',10),
(73, 2, 5, 'Laptop Dell Inspiron 3520', 13499000, 'shirts', 'dell5.png', 'dell',10),
(74, 2, 5, 'Laptop Dell Inspiron 3520', 13799000, 'shirts', 'dell6.png', 'dell',10),
(75, 4, 2, 'Samsung Galaxy Book Flex', 19983738, 'Samsung Galaxy Book Flex Alpha 13 3 34 Touch 8Gb 256Gb Intel Core I5 10210U X41 6Ghz Royal Silver', 'samsung1.png', '	LPDDR4X',10),
(76, 2, 2, 'Samsung Chromebook 4 ', 13196121, 'Samsung Chromebook 4 Chrome 11 6 34Intel Celeron Processor N4000 4Gb Ram 32Gb  Gigabit Wi Fi Xe310Xb', 'samsung2.png', 'HHNFGASJ',10),
(77, 2, 2, 'Samsung Galaxy Book Go', 11600400, 'Samsung Galaxy Book Go 14 34  Laptop Qualcomm Snapdragon 7C Gen 2 4Gb Ram 64GB Silver Windows 10', 'samsung3.png', 'HTGDJDS',10),
(79, 2, 3, 'Abcac', 73770000, 'abcc', '1688090100_alienware3.png', 'Gaming',10),
(80, 1, 4, 'Acerrrrr', 19000000, '?ây là s?n ph?m c?a hãng Acer', '1688109717_alienware1.png', 'Acer',10);

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE `user_info` (
  `user_id` int(10) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `address1` varchar(300) NOT NULL,
  `address2` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`user_id`, `first_name`, `last_name`, `email`, `password`, `mobile`, `address1`, `address2`) VALUES
(25, 'otheruser', 'user', 'otheruser@gmail.com', 'support', '1234446576', 'New York', 'Kumbalagodu'),
(26, 'Hieu', 'Trinh', 'byn1612@gmail.com', 'BGBFS8SXzUhzgxi', '0339369512', 'VietNam', 'Hue'),
(27, 'Ricardo', 'Milo', 'venkey@gmail.com', 'H8agvdVHpu6i4Ys', '0339369321', 'VietNam', 'Ha Noi'),
(30, 'Dong Van', 'Tuan', 'vantuan100301@gmail.com', 'Tuan100301', '0369280523', 'Vu Thuong', 'Ho Chi Minh'),
(31, 'Dong Van', 'Nam', 'tuan1553164@gmail.com', 'Tuan100301', '0369280523', 'Vu Thuong', 'Ha Noi'),
(32, 'Nguyen Van', 'Quy', 'user@gmail.com', 'user12345', '0369280523', 'Vu Thuong', 'Binh Duong');

--
-- Triggers `user_info`
--
DELIMITER $$
CREATE TRIGGER `after_user_info_insert` AFTER INSERT ON `user_info` FOR EACH ROW BEGIN 
INSERT INTO user_info_backup VALUES(new.user_id,new.first_name,new.last_name,new.email,new.password,new.mobile,new.address1,new.address2);
END
$$
DELIMITER ;


-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(10) NOT NULL,
  `p_id` int(10) NOT NULL,
  `ip_add` varchar(250) NOT NULL,
  `user_id` int(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;


--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_info`
--
ALTER TABLE `admin_info`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`brand_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `email_info`
--
ALTER TABLE `email_info`
  ADD PRIMARY KEY (`email_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `orders_info`
--
ALTER TABLE `orders_info`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`order_pro_id`),
  ADD KEY `order_products` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `user_info`
--
ALTER TABLE `user_info`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_info`
--
ALTER TABLE `admin_info`
  MODIFY `admin_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `brand_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `email_info`
--
ALTER TABLE `email_info`
  MODIFY `email_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `orders_info`
--
ALTER TABLE `orders_info`
  MODIFY `order_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `order_products`
--
ALTER TABLE `order_products`
  MODIFY `order_pro_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `user_info`
--
ALTER TABLE `user_info`
  MODIFY `user_id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;
COMMIT;
