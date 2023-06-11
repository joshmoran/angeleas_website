-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 10, 2023 at 08:57 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `angeladb`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
  `customer_id` int(255) NOT NULL,
  `username` varchar(50) NOT NULL,
  `pass` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`customer_id`, `username`, `pass`) VALUES
(616930811, 'jos', '$2y$10$8egjMQLlp.MPcD604EfBUO96QudtiHPk5wBwJunTly../9/jKSmhS'),
(1507781696, 'josh', '$2y$10$IFbXU2DZtviq0n3IKMbjoe2VFi/.nO1WDDx0qHzURFvUBGuZCRWkK'),
(2147483647, 'joshkelly', '$2y$10$dheX/RxjOzZVA0sCqdqA9eE64H2jQsbU5XpdR9Srfx7YCZOQlzooS');

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE `address` (
  `customer_id` varchar(255) NOT NULL,
  `1_line` varchar(255) NOT NULL,
  `2_line` varchar(255) NOT NULL,
  `3_line` varchar(255) DEFAULT NULL,
  `region` varchar(255) NOT NULL,
  `postcode` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `address`
--

INSERT INTO `address` (`customer_id`, `1_line`, `2_line`, `3_line`, `region`, `postcode`) VALUES
('2147483647', '10 Eastlands', 'Winlaton', '', 'Blaydon-on-Tyne', 'NE21 5DS');

-- --------------------------------------------------------

--
-- Table structure for table `alergies`
--

CREATE TABLE `alergies` (
  `product_id` int(255) NOT NULL,
  `type` tinytext NOT NULL,
  `description` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `basket_id` bigint(20) DEFAULT NULL,
  `product_id` int(255) NOT NULL,
  `quantity` int(100) NOT NULL,
  `total_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`basket_id`, `product_id`, `quantity`, `total_price`) VALUES
(428414, 20, 3, 2.97),
(428414, 2, 1, 0.99);

-- --------------------------------------------------------

--
-- Table structure for table `credit_cards`
--

CREATE TABLE `credit_cards` (
  `customer_id` int(255) NOT NULL,
  `cardnumber` bigint(255) NOT NULL,
  `expiry` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `credit_cards`
--

INSERT INTO `credit_cards` (`customer_id`, `cardnumber`, `expiry`) VALUES
(2147483647, 9877928563567338, '2025-10-04');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) DEFAULT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `addres` varchar(255) NOT NULL,
  `home` int(15) NOT NULL,
  `mobile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `first_name`, `last_name`, `email`, `addres`, `home`, `mobile`) VALUES
(2147483647, 'David', 'Jones', 'josh@lovingfamily.co.uk', '10 Eastlands, Winlaton, , Blaydon-on-Tyne,NE21 5DS', 0, 2147483647),
(1507781696, 'njo', 'hi', 'cuvbnjmpk', ', , , ,', 56789, 3456),
(1799545813, 'njo', 'hi', 'cuvbnjmpk', ', , , ,', 56789, 3456),
(616930811, 'jo', 'ni', 'josdghsjkd[s', ', , , ,', 567, 567);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` bigint(11) NOT NULL,
  `customer_id` bigint(11) NOT NULL,
  `time_ordered` date DEFAULT NULL,
  `complete` tinyint(1) NOT NULL,
  `status` varchar(50) DEFAULT NULL,
  `address` varchar(150) DEFAULT NULL,
  `card` int(4) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `time_ordered`, `complete`, `status`, `address`, `card`, `name`) VALUES
(428414, 2147483647, NULL, 0, NULL, NULL, NULL, NULL),
(451544, 2147483647, '2023-06-01', 1, 'order accepted, awaiting dispatch', '10 Eastlands, Winlaton, , Blaydon-on-Tyne, NE21 5DS', 7338, 'David Jones'),
(3313724462, 2147483647, '2023-05-25', 1, 'order dispatched', '10 Eastlands, Winlaton, , Blaydon-on-Tyne, NE21 5DS', 7338, 'Josh Kelly'),
(5412505154, 2147483647, '2023-05-25', 1, 'order dispatched', '10 Eastlands, Winlaton, , Blaydon-on-Tyne, NE21 5DS', 7338, 'Josh Kelly'),
(7029325006, 2147483647, '2023-06-01', 1, 'order dispatched', '10 Eastlands, Winlaton, , Blaydon-on-Tyne, NE21 5DS', 7338, 'David Jones');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(255) NOT NULL,
  `name` tinytext NOT NULL,
  `description` varchar(250) NOT NULL,
  `category` int(1) NOT NULL,
  `price` float(2,2) NOT NULL,
  `image_src` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category`, `price`, `image_src`) VALUES
(1, 'Item 1', 'Description for item 1', 1, 0.99, 'src/img/01.jpg'),
(2, 'Item 2', 'Description for item 2', 1, 0.99, 'src/img/02.jpg'),
(3, 'Item 3', 'Description for item 3', 1, 0.99, 'src/img/03.jpg'),
(4, 'Item 4', 'Description for item 4', 2, 0.99, 'src/img/04.jpg'),
(5, 'Item 5', 'Description for item 5', 2, 0.99, 'src/img/05.jpg'),
(6, 'Item 6', 'Description for item 6', 2, 0.99, 'src/img/06.jpg'),
(7, 'Item 7', 'Description for item 7', 3, 0.99, 'src/img/07.jpg'),
(8, 'Item 8', 'Description for item 8', 3, 0.99, 'src/img/08.jpg'),
(9, 'Item 9', 'Description for item 9', 3, 0.99, 'src/img/09.jpg'),
(10, 'Item 10', 'Description for item 10', 4, 0.99, 'src/img/10.jpg'),
(11, 'Item 11', 'Description for item 11', 4, 0.99, 'src/img/11.jpg'),
(12, 'Item 12', 'Description for item 12', 4, 0.99, 'src/img/12.jpg'),
(13, 'Item 13', 'Description for item 13', 5, 0.99, 'src/img/13.jpg'),
(14, 'Item 14', 'Description for item 14', 5, 0.99, 'src/img/14.jpg'),
(15, 'Item 15', 'Description for item 15', 5, 0.99, 'src/img/15.jpg'),
(16, 'Item 16', 'Description for item 16', 6, 0.99, 'src/img/16.jpg'),
(17, 'Item 17', 'Description for item 17', 6, 0.99, 'src/img/17.jpg'),
(18, 'Item 18', 'Description for item 18', 6, 0.99, 'src/img/18.jpg'),
(19, 'Item 19', 'Description for item 19', 7, 0.99, 'src/img/19.jpg'),
(20, 'Item 20', 'Description for item 20', 7, 0.99, 'src/img/20.jpg'),
(21, 'Item 21', 'Description for item 21', 7, 0.99, 'src/img/21.jpg'),
(22, 'Item 22', 'Description for item 22', 8, 0.99, 'src/img/22.jpg'),
(23, 'Item 23', 'Description for item 23', 8, 0.99, 'src/img/23.jpg'),
(24, 'Item 24', 'Description for item 24', 8, 0.99, 'src/img/24.jpg'),
(25, 'Item 25', 'Description for item 25', 9, 0.99, 'src/img/25.jpg'),
(26, 'Item 26', 'Description for item 26', 9, 0.99, 'src/img/26.jpg'),
(27, 'Item 27', 'Description for item 27', 9, 0.99, 'src/img/27.jpg'),
(28, 'Item 28', 'Description for item 28', 10, 0.99, 'src/img/28.jpg'),
(29, 'Item 29', 'Description for item 29', 10, 0.99, 'src/img/29.jpg'),
(30, 'Item 30', 'Description for item 30', 10, 0.99, 'src/img/30.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `basket_id` bigint(20) NOT NULL,
  `customer_id` varchar(255) NOT NULL,
  `product_id` int(255) NOT NULL,
  `quantity` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`basket_id`, `customer_id`, `product_id`, `quantity`) VALUES
(5412505154, '2147483647', 2, 2),
(3313724462, '2147483647', 1, 5),
(451544, '2147483647', 4, 4),
(7029325006, '2147483647', 4, 3);

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `id` int(2) NOT NULL,
  `name` varchar(30) NOT NULL,
  `description` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`id`, `name`, `description`) VALUES
(1, 'Cakes', 'A combination of flour, eggs, sugar, fats (oil or butter), leavening agents (yeast or baking powder) and sometimes milk and water.'),
(2, 'Cookies', 'Made with flour and sugar and shaped usually into a round and flat shape.'),
(3, 'Biscuits', ''),
(4, 'Pastries', ''),
(5, 'Sweets', ''),
(6, 'Custards and Puddings', ''),
(7, 'Deep-fried', ''),
(8, 'Frozen', ''),
(9, 'Gelatin', ''),
(10, 'Fruit', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
  ADD UNIQUE KEY `customer_id` (`customer_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD UNIQUE KEY `customer_id` (`customer_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD UNIQUE KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
