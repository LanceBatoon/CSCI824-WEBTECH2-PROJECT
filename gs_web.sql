-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 23, 2025 at 07:22 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gs_web`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `product_type` varchar(50) DEFAULT NULL,
  `product_description` varchar(500) DEFAULT NULL,
  `product_price` double DEFAULT NULL,
  `product_img` varchar(100) DEFAULT NULL,
  `product_discount` double DEFAULT NULL,
  `member_discount` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`product_id`, `product_name`, `product_type`, `product_description`, `product_price`, `product_img`, `product_discount`, `member_discount`) VALUES
(1001, 'Cucumber 500 g', 'Produce', 'Forge ahead in your fitness journey by including delicious and healthy salads of LaLa Fresh Cucumbers. They have a high-water content to take care of your hydration needs. In addition, cucumbers contain a significant percentage of vitamins and minerals, making them one of the major food sources to support essential bodily functions.', 0.235, './Images/products/produce/cucumber.jpg', 0, 0),
(1002, 'Onion India 1 kg', 'Produce', 'Add a unique flavour to your everyday dishes with LaLa Fresh Onion. These onions provide a unique taste and texture. They are rich in fibre, antioxidants, vitamin C, potassium, and other nutrients that your body needs for maintaining proper overall health.', 0.205, './Images/products/produce/onionindia.jpg', 0, 0),
(1003, 'Banana Yellow India 1 kg', 'Produce', 'LaLa Fresh Bananas taste divine and can be added to any food to instantly make it taste better. They are loaded with vitamins, fibre, and antioxidants. They are grown using advanced agricultural knowledge and tested farming methods. To ensure exceptional quality and good texture, they are collected carefully.', 1.49, './Images/products/produce/bananaindia.jpg', 0, 1),
(1004, 'Okra 500 g', 'Produce', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 0.745, './Images/products/produce/okra.jpg', 0, 0),
(1005, 'Ginger China 250 g', 'Produce', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 0.265, './Images/products/produce/gingerchina.jpg', 0, 0),
(1006, 'Apple Royal Gala USA 1 kg', 'Produce', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 1.275, './Images/products/produce/appleroyalusa.jpg', 0.2, 0),
(1007, 'Potato Saudi 1 kg', 'Produce', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 0.3, './Images/products/produce/potatosaudi.jpg', 0, 0),
(1008, 'Tomato Syria 1 kg', 'Produce', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 0.34, './Images/products/produce/tomatosyria.jpg', 0, 0),
(1009, 'Sweet Potato 1 kg', 'Produce', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 0.77, './Images/products/produce/sweetpotato.jpg', 0, 0),
(1010, 'Carrots Australia 500 g', 'Produce', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 0.26, './Images/products/produce/carrotsaustralia.jpg', 0, 0),
(1011, 'Garlic India 200 g', 'Produce', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 0.36, './Images/products/produce/garlicindia.jpg', 0, 0),
(1012, 'Apple Fuji Jumbo 1kg', 'Produce', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 1.06, './Images/products/produce/applefuji.jpg', 0, 1),
(1013, 'Lemon Big South Africa 500 g', 'Produce', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 0.53, './Images/products/produce/lemon.jpg', 0, 0),
(1014, 'Indian Mutton Cuts Bone In 500 g', 'Meats', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 2.935, './Images/products/meats/indianmuttoncuts.jpg', 0.3, 0),
(1015, 'Tanmiah Fresh Chicken Thigh 450 g', 'Meats', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 0.86, './Images/products/meats/chickenthigh.jpg', 0, 1),
(1016, 'Australian Beef Mince 500 g', 'Meats', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 2.67, './Images/products/meats/australiabeefmince.jpg', 0.2, 0),
(1017, 'New Zealand Beef Striploin 500 g', 'Meats', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 4.42, './Images/products/meats/nzbeefstriploin.jpg', 0.4, 0),
(1018, 'Australian Lamb Rack 300 g', 'Meats', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 2.52, './Images/products/meats/australialambrack.jpg', 0, 1),
(1019, 'Pakistani Mutton Boneless 500 g', 'Meats', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 3.955, './Images/products/meats/pakistanimuttonboneless.jpg', 0, 0),
(1020, 'Fresh Chicken Legs Bone in Skinless 500 g', 'Meats', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 1.47, './Images/products/meats/chickenlegsbonein.jpg', 0, 1),
(1021, 'Chicken Hot Spicy BBQ Bone in 500 g', 'Meats', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 1.57, './Images/products/meats/chickenbbqbonein.jpg', 0.15, 0),
(1022, 'Tanmiah Fresh Whole Chicken 1 kg', 'Meats', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 1.825, './Images/products/meats/tanmiahwholechicken1kg.jpg', 0, 0),
(1023, 'Kenyan Lamb Cuts 500 g', 'Meats', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 1.94, './Images/products/meats/kenyanlambcuts.jpg', 0.1, 0),
(1024, 'Fresh Norwegian Salmon Fillet 350 g', 'Seafood', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 3.37, './Images/products/seafood/norwegiansalmonfillet.jpg', 0.25, 0),
(1025, 'Fresh Sea Bass Whole Cleaned 1 kg', 'Seafood', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 3.35, './Images/products/seafood/seabasswhole.jpg', 0, 1),
(1026, 'Fresh Tilapia Whole Cleaned 1 kg', 'Seafood', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 1.895, './Images/products/seafood/tilapia.jpg', 0, 0),
(1027, 'All Butter Mini Croissants 12 pcs', 'Bakery', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 1.8, './Images/products/bakery/minicroissants.jpg', 0, 0),
(1028, 'Almarai Full Fat Fresh Milk 2 Litres', 'Dairy', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 1.1, './Images/products/dairy/freshmilk.jpg', 0, 1),
(1029, 'Loacker Sandwich Assorted 25 x 25 g', 'Snacks', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 3.19, './Images/products/snacks/loackersandwich.jpg', 0, 1),
(1030, 'UFC Coconut Water 500 ml', 'Beverages', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 0.675, './Images/products/beverages/coconutwater.jpg', 0, 0),
(1031, 'Kleenex Ultrasoft Facial Tissue', 'Household', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Assumenda totam officia magni error quas inventore libero possimus nulla aliquam fugiat dicta cumque, reiciendis id ea quia qui amet deserunt numquam!', 2.95, './Images/products/household/kleenex.jpg', 0.4, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchase_cart`
--

CREATE TABLE `purchase_cart` (
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `purchase_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` varchar(20) NOT NULL,
  `password` varchar(20) DEFAULT NULL,
  `member` tinyint(1) DEFAULT NULL,
  `pfp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `password`, `member`, `pfp`) VALUES
('Alice', '123password', 1, './Images/pfps/pfp3.png'),
('Bob', 'password123', 0, './Images/pfps/pfp2.png'),
('Lance', 'password', 1, './Images/pfps/pfp1.png'),
('NewUser', 'newpassword', 0, './Images/pfps/default-pfp.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `purchase_cart`
--
ALTER TABLE `purchase_cart`
  ADD PRIMARY KEY (`purchase_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1032;

--
-- AUTO_INCREMENT for table `purchase_cart`
--
ALTER TABLE `purchase_cart`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `purchase_cart`
--
ALTER TABLE `purchase_cart`
  ADD CONSTRAINT `purchase_cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`),
  ADD CONSTRAINT `purchase_cart_ibfk_2` FOREIGN KEY (`username`) REFERENCES `users` (`username`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
