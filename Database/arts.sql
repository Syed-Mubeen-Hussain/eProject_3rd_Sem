-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2022 at 09:41 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `arts`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--

CREATE TABLE `admin_user` (
  `ad_id` int(50) NOT NULL,
  `ad_firstname` varchar(50) NOT NULL,
  `ad_lastname` varchar(50) NOT NULL,
  `ad_email` varchar(50) NOT NULL,
  `ad_username` varchar(50) NOT NULL,
  `ad_password` varchar(50) NOT NULL,
  `ad_role` tinyint(4) NOT NULL,
  `ad_mobile` varchar(11) NOT NULL,
  `ad_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`ad_id`, `ad_firstname`, `ad_lastname`, `ad_email`, `ad_username`, `ad_password`, `ad_role`, `ad_mobile`, `ad_status`) VALUES
(1, 'Ad', 'min', 'Mubeen@gmail.com', 'admin', 'admin', 0, '03171072776', 1),
(2, 'Syed', 'Mubeen', 'Mubeen@gmail.com', 'Mubeen', '123', 1, '02313213212', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `car_id` int(50) NOT NULL,
  `car_fk_product_id` int(50) NOT NULL,
  `car_product_qty` int(50) NOT NULL,
  `car_fk_cus_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`car_id`, `car_fk_product_id`, `car_product_qty`, `car_fk_cus_id`) VALUES
(9, 2533129, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(50) NOT NULL,
  `cat_name` varchar(50) NOT NULL,
  `cat_image` text NOT NULL,
  `cat_status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_image`, `cat_status`) VALUES
(1, 'Dollar', '812689493_dollar.png', 1),
(2, 'Dux', '666581522_dux_1200x1200.jpg', 1),
(3, 'Piano', '341045046_Piano (3).png', 1),
(4, 'Gifts', '316770081_gift.jpg', 1),
(5, 'Notebooks', '586528909_notebook.jpg', 1),
(6, 'Hand Bags', '911163409_hand_bag.png', 1),
(7, 'Wallets', '927905488_wallet.jpg', 1),
(8, 'Arts', '220696121_arts.jpg', 1),
(89, 'Beauty Products', '262527282_nail2.jpg', 1),
(90, 'Greeting Cards', '735877909_Birthday Card Template.jpg', 1),
(91, 'Files', '953957075_fills18.jpg', 1),
(92, 'Doll & Teddy', '223271030_Big-teddy-bear-real-doll-teddy-care-bears-baby-doll-toys-for-children-stuffed-toys-animal__98168.jpg', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `cont_id` int(50) NOT NULL,
  `cont_name` varchar(50) NOT NULL,
  `cont_email` varchar(50) NOT NULL,
  `cont_subject` text NOT NULL,
  `cont_message` text NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`cont_id`, `cont_name`, `cont_email`, `cont_subject`, `cont_message`, `added_on`) VALUES
(1, 'Mubeen', 'mubeen@gmail.com', 'Subject', 'Message', '2022-08-05 06:43:58');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `c_id` int(50) NOT NULL,
  `c_firstname` varchar(50) NOT NULL,
  `c_lastname` varchar(50) NOT NULL,
  `c_age` int(50) NOT NULL,
  `c_phone` varchar(11) NOT NULL,
  `c_gender` varchar(6) NOT NULL,
  `c_address` text NOT NULL,
  `c_image` text NOT NULL,
  `c_email` varchar(50) NOT NULL,
  `c_password` varchar(50) NOT NULL,
  `c_status` tinyint(4) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`c_id`, `c_firstname`, `c_lastname`, `c_age`, `c_phone`, `c_gender`, `c_address`, `c_image`, `c_email`, `c_password`, `c_status`, `added_on`) VALUES
(1, 'Syed', 'Mubeen Hussain', 18, '12345678910', 'Male', 'Korangi no 5 Karachi', '161315213_34a285cf-a21b-40e2-b1ae-29421f67583f.jpg', 'mubeen@gmail.com', '123', 1, '2022-08-05 05:04:56');

-- --------------------------------------------------------

--
-- Table structure for table `employee_orders`
--

CREATE TABLE `employee_orders` (
  `eo_id` int(50) NOT NULL,
  `eo_fk_cus_id` int(50) NOT NULL,
  `eo_fk_emp_id` int(50) NOT NULL,
  `eo_address` text NOT NULL,
  `eo_phone` varchar(11) NOT NULL,
  `eo_email` varchar(50) NOT NULL,
  `eo_zip` int(50) NOT NULL,
  `credit_card_number` int(16) NOT NULL,
  `credit_card_pin` int(4) NOT NULL,
  `cash_payment` tinyint(4) NOT NULL,
  `eo_status` varchar(50) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_orders`
--

INSERT INTO `employee_orders` (`eo_id`, `eo_fk_cus_id`, `eo_fk_emp_id`, `eo_address`, `eo_phone`, `eo_email`, `eo_zip`, `credit_card_number`, `credit_card_pin`, `cash_payment`, `eo_status`, `added_on`) VALUES
(31507254, 1, 1, 'Korangi no 5 Karachi', '12345678910', 'mubeen@gmail.com', 13256, 0, 0, 1, 'Pending', '2022-08-05 06:29:06'),
(40752432, 1, 1, 'Korangi no 5 Karachi', '12345678910', 'mubeen@gmail.com', 321, 0, 0, 1, 'Pending', '2022-08-05 06:43:22'),
(66945145, 1, 1, 'Korangi no 5 Karachi', '12345678910', 'mubeen@gmail.com', 13256, 0, 0, 1, 'Pending', '2022-08-05 06:29:06'),
(71045487, 1, 1, 'Korangi no 5 Karachi', '12345678910', 'mubeen@gmail.com', 12345, 0, 0, 1, 'Pending', '2022-08-05 06:54:05'),
(89179588, 1, 1, 'Korangi no 5 Karachi', '12345678910', 'mubeen@gmail.com', 2147483647, 2147483647, 3324, 0, 'Pending', '2022-08-05 06:33:40'),
(93392531, 1, 2, 'Korangi no 5 Karachi', '12345678910', 'mubeen@gmail.com', 12345, 0, 0, 1, 'Pending', '2022-08-05 06:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `employee_order_details`
--

CREATE TABLE `employee_order_details` (
  `eod_id` int(50) NOT NULL,
  `eod_fk_product_id` int(50) NOT NULL,
  `eod_product_qty` int(50) NOT NULL,
  `eod_fk_o` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employee_order_details`
--

INSERT INTO `employee_order_details` (`eod_id`, `eod_fk_product_id`, `eod_product_qty`, `eod_fk_o`) VALUES
(1, 2526416, 4, 31507254),
(2, 2570195, 1, 66945145),
(3, 2570195, 1, 89179588),
(4, 2536633, 1, 40752432),
(5, 2530345, 1, 71045487),
(6, 2533129, 2, 93392531);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `n_id` int(50) NOT NULL,
  `n_text` text NOT NULL,
  `n_fk_customer_id` int(50) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`n_id`, `n_text`, `n_fk_customer_id`, `added_on`) VALUES
(1, 'Your Order Has Been Placed Order Status Is Pending Order Id #1257019527152804 ', 1, '2022-08-05 06:29:06'),
(2, 'Your Order Has Been Placed Order Status Is Pending Order Id #2257019581262306 ', 1, '2022-08-05 06:33:40'),
(3, 'Your Order Has Been Cancel Order Id #2147483647 ', 1, '2022-08-05 06:38:01'),
(4, 'Your Return Product Is Pending Order Id #2257019581262306 Product Id #2570195', 1, '2022-08-05 06:38:16'),
(5, 'Your Order Has Been Cancel Order Id #2257019581262306 ', 1, '2022-08-05 06:41:05'),
(6, 'Your Return Product Is Approve Order Id #2257019581262306 Product Id #2570195', 1, '2022-08-05 06:41:39'),
(7, 'Your Return Product Is Approve Order Id #2257019581262306 Product Id #2570195', 1, '2022-08-05 06:42:25'),
(8, 'Your Return Product Is Pending Order Id #2257019581262306 Product Id #2570195', 1, '2022-08-05 06:42:33'),
(9, 'Your Return Product Is Approve Order Id #2257019581262306 Product Id #2570195', 1, '2022-08-05 06:42:40'),
(10, 'Your Order Has Been Placed Order Status Is Pending Order Id #1253663359689675 ', 1, '2022-08-05 06:43:22'),
(11, 'Your Order Is Processing Order Id #1253663359689675 ', 1, '2022-08-05 06:44:27'),
(12, 'Your Order Is Complete Order Id #1253663359689675 ', 1, '2022-08-05 06:44:41'),
(13, 'Your Order Is Cancel Order Id #1253663359689675 ', 1, '2022-08-05 06:44:50'),
(14, 'Your Order Is Pending Order Id #1253663359689675 ', 1, '2022-08-05 06:45:13'),
(15, 'Your Order Has Been Placed Order Status Is Pending Order Id #1253312923447993 ', 1, '2022-08-05 06:54:05');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `o_id` int(50) NOT NULL,
  `o_fk_cus_id` int(50) NOT NULL,
  `o_address` text NOT NULL,
  `o_phone` varchar(11) NOT NULL,
  `o_email` varchar(50) NOT NULL,
  `o_zip` int(50) NOT NULL,
  `o_total_amout` varchar(50) NOT NULL,
  `cash_payment` tinyint(4) NOT NULL,
  `credit_card_number` int(16) NOT NULL,
  `credit_card_pin` int(4) NOT NULL,
  `o_status` varchar(50) NOT NULL,
  `added_on` datetime NOT NULL,
  `o_end_date` datetime NOT NULL,
  `order_id_show` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`o_id`, `o_fk_cus_id`, `o_address`, `o_phone`, `o_email`, `o_zip`, `o_total_amout`, `cash_payment`, `credit_card_number`, `credit_card_pin`, `o_status`, `added_on`, `o_end_date`, `order_id_show`) VALUES
(23447993, 1, 'Korangi no 5 Karachi', '12345678910', 'mubeen@gmail.com', 12345, '390', 1, 0, 0, 'Pending', '2022-08-05 06:54:05', '2022-08-12 06:54:05', '1253312923447993'),
(27152804, 1, 'Korangi no 5 Karachi', '12345678910', 'mubeen@gmail.com', 13256, '2450', 1, 0, 0, 'Cancel', '2022-08-05 06:29:06', '2022-08-12 06:29:06', '2147483647'),
(59689675, 1, 'Korangi no 5 Karachi', '12345678910', 'mubeen@gmail.com', 321, '200', 1, 0, 0, 'Pending', '2022-08-05 06:43:22', '2022-08-12 06:43:22', '1253663359689675'),
(81262306, 1, 'Korangi no 5 Karachi', '12345678910', 'mubeen@gmail.com', 2147483647, '250', 0, 2147483647, 3324, 'Cancel', '2022-08-05 06:33:40', '2022-08-12 06:33:40', '2257019581262306');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `od_id` int(50) NOT NULL,
  `od_fk_product_id` int(50) NOT NULL,
  `od_product_qty` int(50) NOT NULL,
  `od_fk_o` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`od_id`, `od_fk_product_id`, `od_product_qty`, `od_fk_o`) VALUES
(1, 2526416, 4, 27152804),
(2, 2570195, 1, 27152804),
(3, 2570195, 1, 81262306),
(4, 2536633, 1, 59689675),
(5, 2530345, 1, 23447993),
(6, 2533129, 2, 23447993);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(50) NOT NULL,
  `p_price` varchar(50) NOT NULL,
  `p_image` text NOT NULL,
  `p_description` text NOT NULL,
  `p_qty` int(50) NOT NULL,
  `p_status` tinyint(4) NOT NULL,
  `p_fk_cat` int(50) NOT NULL,
  `p_added_by` int(50) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`p_id`, `p_name`, `p_price`, `p_image`, `p_description`, `p_qty`, `p_status`, `p_fk_cat`, `p_added_by`, `added_on`) VALUES
(2511343, 'Gift 4', '90', '715390252_Gift 4.jpg', 'Gift 4', 10, 1, 4, 1, '2022-08-04 10:48:23'),
(2512068, 'Dux Blue Black Foundation Pen', '80', '771329555_fountain-pen-717i.jpg', 'Dux Blue Black Foundation Pen', 10, 1, 2, 1, '2022-08-04 08:53:07'),
(2512356, 'Gift 3', '70', '788684556_gift 3.jpg', 'Gift 3', 10, 1, 4, 1, '2022-08-04 10:48:10'),
(2513215, 'Hand Bag 11', '1699', '882842007_hand bag 22.jpg', 'Hand Bag 11', 10, 1, 6, 1, '2022-08-04 11:07:43'),
(2515670, 'Color Pencil', '120', '442434336_color pencil.jpg', 'Dollar Color Pencil', 10, 1, 1, 1, '2022-08-04 08:28:07'),
(2517000, 'Piano Geomatry Box', '120', '917313188_geo.jpg', 'Piano Geomatry Box', 10, 1, 3, 1, '2022-08-04 10:40:22'),
(2517986, 'Dux Pencil Box', '180', '247767835_pencil2.jpg', 'Dux Pencil Box', 10, 1, 2, 1, '2022-08-04 08:54:32'),
(2518072, 'New Register', '85', '642602779_register-book-500x500.jpg', 'New Register', 10, 1, 5, 1, '2022-08-04 10:51:06'),
(2519530, 'Wallet 11', '150', '626168383_wallet 15.jpg', 'Wallet 11', 10, 1, 7, 1, '2022-08-04 11:10:56'),
(2520144, 'Wallet 4', '2000', '494216053_wallet 5.jpg', 'Wallet 4', 10, 1, 7, 1, '2022-08-04 11:08:53'),
(2520637, 'Teddy 4', '800', '229052425_teddybear8.jpg', 'Teddy 4', 4, 1, 92, 1, '2022-08-05 04:21:14'),
(2522067, 'FriendShip Greeting Cards', '90', '635421961_friendcard.jpg', 'FriendShip Greeting Cards', 10, 1, 90, 1, '2022-08-05 04:12:34'),
(2523770, 'Permanent Marker', '40', '491402175_permarker.jpg', 'Dollar Permanent Marker', 10, 1, 1, 1, '2022-08-04 08:37:53'),
(2524314, 'Correction Pen', '40', '557337755_correctionpenDUX_600x.png', 'Dux Correction Pen', 10, 1, 2, 1, '2022-08-04 08:52:09'),
(2525597, 'Piano Ball Point Pen', '50', '170862289_Piano-Ball-Point-Pen-_Pack-of-10-Ball-Point_-08_800x.png', 'Piano Ball Point Pen', 10, 1, 3, 2, '2022-08-05 06:51:05'),
(2525679, 'Hand Bag 2', '1600', '905300235_hand bag 2.jpg', 'Hand Bag 2', 10, 1, 6, 1, '2022-08-04 11:05:11'),
(2526416, 'Doll 1', '550', '521283482_dolls.png', 'Doll 1', 6, 1, 92, 1, '2022-08-05 04:19:13'),
(2526857, 'Multiples Files', '240', '816875176_fills.jpg', 'Multiples Files', 10, 1, 91, 1, '2022-08-05 04:16:18'),
(2527403, 'Green Pen Ink', '40', '842349187_green ink.png', 'Dollar Fountain Pen Ink 60ML Green\r\n\r\nQuantity : 60 ml.\r\nThe ink is washable.\r\nThe ink can be used to fill any fountain pen.\r\nThe ink is quite pigmented.\r\nThe colour of the ink does not fade.\r\nIt is advisable to always keep your pen capped when not in use.\r\nThe bottle is leak proof as it is made of plastic.\r\nThe plastic bottle is reusable.', 10, 1, 1, 1, '2022-08-04 08:15:10'),
(2527966, 'Teddy 1', '150', '939905497_teddybear2.jpg', 'Teddy 1', 10, 1, 92, 1, '2022-08-05 04:20:21'),
(2528360, 'Wallet 1', '50', '503725448_wallet 2.jpg', 'Wallet 1', 10, 1, 7, 1, '2022-08-04 11:08:13'),
(2528470, 'Painting Board', '300', '724441901_images (89).jpeg', 'Painting Board', 10, 1, 8, 1, '2022-08-04 11:53:52'),
(2529216, 'Gel Ball Pen', '220', '233876077_Dollar_Gel-1_Ball_Pen.jpg', 'Dollar Gel Ball Pen', 10, 1, 1, 1, '2022-08-04 08:31:41'),
(2529292, 'Compass', '60', '141687738_Dux-Student-Compass-D304.jpg', 'Dux Compass', 10, 1, 2, 1, '2022-08-04 08:53:55'),
(2529475, '500 Pages Register', '180', '700449405_register3.jpg', '500 Pages Register', 10, 1, 5, 1, '2022-08-04 10:55:00'),
(2529756, 'Brithday Greeting Card', '120', '390981104_Birthday Card Template.jpg', 'Brithday Greeting Card', 10, 1, 90, 1, '2022-08-05 04:11:52'),
(2529881, 'Piano Sharpener', '20', '983262894_staedtler-single-hole-metal-sharpener-500x500.jpg', 'Piano Sharpener', 10, 1, 3, 1, '2022-08-04 10:45:26'),
(2530345, 'Home Diary', '150', '622283156_large-my-homework-diary-4-schools.jpg', 'Home Diary', 9, 1, 5, 1, '2022-08-04 10:52:01'),
(2531905, 'Multi Colour Paintings', '250', '403307173_images (86).jpeg', 'Multi Colour Paintings', 10, 1, 8, 1, '2022-08-04 11:50:50'),
(2533129, 'Think Positive Notebook', '120', '354822613_Think-positive-notebook-600x600.jpg', 'Think Positive Notebook', 8, 1, 5, 2, '2022-08-05 06:53:35'),
(2533387, 'Piano Pencils', '95', '513460642_ppencil.jpg', 'Piano Pencils', 10, 1, 3, 1, '2022-08-04 10:46:44'),
(2533406, '14 August Greeting Card', '10', '634086248_Pakistan-day-greeting-card-0018.jpg', '14 August Greeting Card', 10, 1, 90, 1, '2022-08-05 04:14:08'),
(2534117, 'Gift 5', '100', '242231685_gift 5.jpg', 'Gift 5', 10, 1, 4, 1, '2022-08-04 10:48:36'),
(2535673, 'Stationary Boxs', '300', '689069822_box2.jpg', 'Dux Stationary Box', 10, 1, 2, 1, '2022-08-04 08:48:52'),
(2536221, 'Gift 7', '450', '658223219_Gift 7.jpg', 'Gift 7', 10, 1, 4, 1, '2022-08-04 10:49:07'),
(2536376, 'Color Pencils', '80', '358886662_pencil2.jpg', 'Dollar Color Pencils', 10, 1, 1, 1, '2022-08-05 03:18:28'),
(2536606, 'Stationary Box', '120', '294696636_box.jpg', 'Dux Stationary Box', 10, 1, 2, 1, '2022-08-04 08:48:18'),
(2536633, 'Teddy 2', '200', '358405780_tedybear4.jpg', 'Teddy 2', 9, 1, 92, 1, '2022-08-05 04:20:42'),
(2537489, 'Ring', '60', '787511827_rings4.jpg', 'Ring', 10, 1, 89, 1, '2022-08-05 03:41:38'),
(2537787, 'Eye Liner', '50', '374187084_eye liner 2.jpg', 'Eye Liner', 10, 1, 89, 1, '2022-08-05 03:40:33'),
(2538016, 'Painting Brush', '50', '520212139_images (79).jpeg', 'Painting Brush', 10, 1, 8, 1, '2022-08-04 11:52:44'),
(2538105, 'Dollar Pointer Plus Box', '390', '590271975_dollar_pointer_plus_10s_box_blue.jpg', 'Dollar Pointer Plus Box', 10, 1, 1, 1, '2022-08-05 03:29:19'),
(2538833, 'Hand Bag 9', '1950', '416798303_Hand bag 9.jpg', 'Hand Bag 9', 10, 1, 6, 1, '2022-08-04 11:06:54'),
(2539952, 'Hand Bag 5', '1950', '757545267_hand bag 5.jpg', 'Hand Bag 5', 10, 1, 6, 1, '2022-08-04 11:05:56'),
(2541449, 'Gift 2', '60', '952570193_gift 2.jpg', 'Gift 2', 10, 1, 4, 1, '2022-08-04 10:47:52'),
(2542860, 'Hand Bag 1', '1500', '272222531_ hand bag15.jpg', 'Hand Bag 1', 10, 1, 6, 1, '2022-08-04 11:04:57'),
(2543004, 'Wallet 9', '170', '546498483_wallet 13.jpg', 'Wallet 9', 10, 1, 7, 1, '2022-08-04 11:10:16'),
(2543232, 'Color Marker', '120', '201117147_colormarker.png', 'Dollar Color Marker', 10, 1, 1, 1, '2022-08-05 03:28:47'),
(2544291, 'Hand Bag 7', '850', '839529890_Hand bag 8.jpg', 'Hand Bag 7', 10, 1, 6, 1, '2022-08-04 11:06:41'),
(2545766, 'Doll 2', '150', '264377859_dolls2.png', 'Doll 2', 10, 1, 92, 1, '2022-08-05 04:19:27'),
(2546506, '6 Colors Highliter', '390', '487188460_0000155_dollar-highlighter.jpeg', 'Dollar 6 Colors Highliter', 10, 1, 1, 1, '2022-08-05 03:19:33'),
(2548158, 'Piano Black Ink', '30', '866344424_ink.jpeg', 'Piano Black Ink', 10, 1, 3, 1, '2022-08-04 10:41:11'),
(2548750, 'Black Pointer', '20', '897269769_Dollar-pointer-black-min.jpg', 'Dollar Black Pointer', 10, 1, 1, 1, '2022-08-04 08:39:05'),
(2548968, 'Piano Ball Pen', '55', '142976197_p pen.png', 'Piano Ball Pen', 10, 1, 3, 1, '2022-08-04 10:41:30'),
(2549655, 'Soft Eraser', '5', '640700172_erase.jpg', 'Dux Soft Eraser', 10, 1, 2, 1, '2022-08-04 08:52:36'),
(2550253, 'File', '50', '859528145_fills3.jpg', 'File', 10, 1, 91, 1, '2022-08-05 04:15:21'),
(2552264, 'Hand Bag 3', '1900', '632185938_hand bag 3.jpg', 'Hand Bag 3', 10, 1, 6, 1, '2022-08-04 11:05:25'),
(2552379, 'Diary', '80', '550077199_diary.jfif', 'Diary', 10, 1, 5, 1, '2022-08-04 10:50:21'),
(2553023, 'Foundation Pens', '350', '594040374_FountainPenSp10.png', 'Dollar Foundation Pens', 10, 1, 1, 1, '2022-08-05 03:18:56'),
(2553774, 'Wallet 8', '1450', '694642254_wallet 10.jpg', 'Wallet 8', 10, 1, 7, 1, '2022-08-04 11:10:02'),
(2554136, 'Attendence Register', '100', '803451565_attendenceregister.jpg', 'Attendence Register', 10, 1, 5, 1, '2022-08-04 10:50:07'),
(2554479, 'Foundation', '180', '860623829_foundation.jpg', 'Foundation', 10, 1, 89, 1, '2022-08-05 03:40:56'),
(2556812, 'Gift 8', '850', '288959924_Gift 11.jpg', 'Gift 8', 10, 1, 4, 1, '2022-08-04 10:49:21'),
(2557588, 'File2', '80', '408355876_fills7.jpg', 'File2', 10, 1, 91, 1, '2022-08-05 04:15:36'),
(2558421, 'Hand Bag 4', '1750', '837384894_hand bag 4.jpg', 'Hand Bag 4', 10, 1, 6, 1, '2022-08-04 11:05:41'),
(2558868, 'Hand Bag 6', '2100', '240010593_hand bag 7.jpg', 'Hand Bag 6', 10, 1, 6, 1, '2022-08-04 11:06:23'),
(2559171, 'Journel', '55', '722710495_journel.jpg', 'Journel', 10, 1, 5, 1, '2022-08-04 10:51:38'),
(2560651, 'Doll 5', '80', '750973953_dolls5.png', 'Doll 5', 10, 1, 92, 1, '2022-08-05 04:20:03'),
(2562173, 'Wallet 10', '40', '377707196_wallet 14.jpg', 'Wallet 10', 10, 1, 7, 1, '2022-08-04 11:10:40'),
(2562270, 'Glue Stick', '35', '699157327_Glue-Stick.png', 'Piano Glue Stick', 10, 1, 3, 1, '2022-08-04 10:40:48'),
(2562439, 'Register', '120', '241698135_register.jpg', 'Register', 10, 1, 5, 1, '2022-08-04 10:50:46'),
(2563562, 'Stapler Pin', '85', '151198499_pins.jpg', 'Dollar Stapler Pin', 10, 1, 1, 1, '2022-08-04 08:36:13'),
(2563807, 'Nail Polish', '150', '973153298_nail polish 3.jpg', 'Nail Polish', 10, 1, 89, 1, '2022-08-05 03:40:14'),
(2565209, 'Wallet 7', '150', '865159769_wallet 10.jpg', 'Wallet 7', 10, 1, 7, 1, '2022-08-04 11:09:44'),
(2566321, 'All Paintings Sets', '850', '472213212_images (97).jpeg', 'All Paintings Sets', 10, 1, 8, 1, '2022-08-04 11:53:18'),
(2566379, 'Piano Whito', '40', '982552376_piano-whito.png', 'Piano Whito', 10, 1, 3, 1, '2022-08-04 10:46:09'),
(2569291, 'New Year Greeting Cards', '80', '344012305_newyearcard.jpg', 'New Year Greeting Cards', 10, 1, 90, 1, '2022-08-05 04:12:52'),
(2569830, 'Lip Stick', '120', '304705512_lipstick.png', 'Lip Stick', 10, 1, 89, 1, '2022-08-05 03:41:22'),
(2569865, 'Piano Eraser', '5', '228870742_Piano-Factis-Erasers.png', 'Piano Eraser', 10, 1, 3, 1, '2022-08-04 10:42:32'),
(2570195, 'Teddy 3', '250', '713842708_teddybear6.jpg', 'Teddy 3', 8, 1, 92, 1, '2022-08-05 04:21:04'),
(2571952, 'Base', '80', '164575241_base.jpg', 'Base', 10, 1, 89, 1, '2022-08-05 03:39:17'),
(2572012, '7 Painting Brush', '270', '133333968_images (96).jpeg', '7 Painting Bushes', 10, 1, 8, 1, '2022-08-04 11:51:59'),
(2572859, 'Multiples Brush', '500', '916730631_paint brush 4.jpg', 'Multiples Brush', 10, 1, 8, 1, '2022-08-04 11:56:27'),
(2573568, 'Wallet 3', '1800', '267911093_wallet 4.jpg', 'Wallet 3', 10, 1, 7, 1, '2022-08-04 11:08:37'),
(2574399, 'Blue Pointer', '20', '194181334_Dollar.jpg', 'Dollar Blue Pointer', 10, 1, 1, 1, '2022-08-04 08:29:56'),
(2574803, 'Doll 3', '200', '522966407_dolls3.png', 'Doll 3', 10, 1, 92, 1, '2022-08-05 04:19:40'),
(2575383, 'Pointer Plus', '260', '593859783_dollar_pointer_plus_10s_box_blue.jpg', 'Dollar Blue Pointer Plus', 10, 1, 1, 1, '2022-08-04 08:32:30'),
(2575606, 'Hand Bag 10', '1500', '790933784_hand bag 10.jpg', 'Hand Bag 10', 10, 1, 6, 1, '2022-08-04 11:07:13'),
(2576796, 'Biro pen', '50', '653125515_bolpen.jpg', 'Dux Biro pen', 10, 1, 2, 1, '2022-08-04 08:47:27'),
(2578097, 'Piano Fiber Tip Colour Marker', '180', '720625246_PianoFiberTipColorMarker_940x.png', 'Piano Fiber Tip Colour Marker', 10, 1, 3, 1, '2022-08-04 10:42:55'),
(2578362, 'Gel Pen Plus', '50', '452071804_Dollar-Gel-1-Pen-Blue-505x555-1.jpg', 'Dollar Gel Pen Plus', 10, 1, 1, 1, '2022-08-04 08:33:06'),
(2579465, 'Copys', '180', '671257634_notebooks.jpg', 'Copys', 10, 1, 5, 1, '2022-08-04 10:52:28'),
(2580421, 'Blue Pen Ink', '40', '255299889_ink.jpg', 'Dollar Blue Pen Ink', 10, 1, 1, 1, '2022-08-04 08:20:06'),
(2580764, 'Piano Removers', '130', '539770726_remover2.jpg', 'Piano Removers', 10, 1, 3, 1, '2022-08-04 10:45:54'),
(2580803, 'Journel Pages', '50', '448497967_journalpages.jpg', 'Journel Pages', 10, 1, 5, 1, '2022-08-04 10:55:57'),
(2581010, '2 Blue Marker', '30', '730762896_marker.jpg', 'Dollar 2 Blue Marker', 10, 1, 1, 1, '2022-08-05 03:17:55'),
(2581057, 'Dux Color Pencil', '80', '336507135_colorbox.jpg', 'Dux Color Pencil', 10, 1, 2, 1, '2022-08-04 08:50:46'),
(2581266, 'Board Pen', '80', '740258463_board ink.jpg', 'Dollar Board Pen Ink 60ML Green', 10, 1, 1, 1, '2022-08-04 08:27:34'),
(2582185, 'Greeting Card 1', '50', '664669585_177-happy-birthday.jpg', 'Greeting Card 1', 10, 1, 90, 1, '2022-08-05 04:11:34'),
(2582597, 'Gift 6', '100', '416193121_gift 6.jpg', 'Gift 6', 10, 1, 4, 1, '2022-08-04 10:48:49'),
(2582647, 'Dux Lead Pencil', '45', '814514063_DuxLeadPencil_7000_600x.png', 'Dux Lead Pencil', 10, 1, 2, 1, '2022-08-04 08:53:33'),
(2582736, 'Physics Journel', '80', '218595793_journelphysics.jpg', 'Physics Journel', 10, 1, 5, 1, '2022-08-04 10:55:37'),
(2586022, '2 Files', '90', '275301882_fills11.jpg', '2 Files', 10, 1, 91, 1, '2022-08-05 04:15:58'),
(2586092, 'Markers', '240', '754215437_dollar-marker1.jpg', 'Dollar Marker', 10, 1, 1, 1, '2022-08-04 08:33:40'),
(2587597, 'Piano Black Marker', '80', '244116849_permarker.png', 'Piano Black Marker', 10, 1, 3, 1, '2022-08-04 10:42:08'),
(2587657, 'Wallet 6', '200', '695944310_wallet 6.jpg', 'Wallet 6', 10, 1, 7, 1, '2022-08-04 11:09:07'),
(2588376, 'Ear Rings', '90', '313464043_earrings.jpg', 'Ear Rings', 10, 1, 89, 1, '2022-08-05 03:39:38'),
(2588946, 'Wallet 2', '80', '966435107_wallet 3.jpg', 'Wallet 2', 10, 1, 7, 1, '2022-08-04 11:08:25'),
(2589199, 'Dux Stapler', '250', '408473593_dux-stapler-d-20-4688-414411-140520082229.jpg', 'Dux Stapler', 10, 1, 2, 2, '2022-08-05 06:50:16'),
(2590471, 'Office File', '80', '234367308_fills14.jpg', 'Office File', 10, 1, 91, 1, '2022-08-05 04:16:29'),
(2591112, 'Compass Box', '180', '688333394_compassbox.png', 'Dux Compass Box', 10, 1, 2, 1, '2022-08-04 08:55:11'),
(2594620, 'Gift 1', '50', '667379468_gift 1.jpg', 'Gift 1', 10, 1, 4, 1, '2022-08-04 10:47:39'),
(2596822, 'Eraser Pencil', '8', '703962232_pencil with eraser.jfif', 'Dollar Eraser Pencil', 10, 1, 1, 1, '2022-08-05 03:21:04'),
(2596901, 'Piano Color Pencil', '80', '215307288_Clour-Pencil.png', 'Piano Color Pencil', 10, 1, 3, 1, '2022-08-04 10:39:14'),
(2598796, 'Dollar Board Marker', '80', '256685763_download.jpg', 'Dollar Board Marker', 10, 1, 1, 2, '2022-08-05 06:50:37'),
(2599856, 'High Quality Painting', '950', '428979252_paint brush 15.jpg', 'High Quality Painting', 10, 1, 8, 1, '2022-08-04 11:54:23');

-- --------------------------------------------------------

--
-- Table structure for table `product_comment`
--

CREATE TABLE `product_comment` (
  `pc_id` int(50) NOT NULL,
  `pc_msg` text NOT NULL,
  `pc_fk_customer_id` int(50) NOT NULL,
  `pc_fk_product_id` int(50) NOT NULL,
  `pc_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_comment`
--

INSERT INTO `product_comment` (`pc_id`, `pc_msg`, `pc_fk_customer_id`, `pc_fk_product_id`, `pc_added_on`) VALUES
(1, 'Nice Teddy', 1, 2570195, '2022-08-05 06:28:38');

-- --------------------------------------------------------

--
-- Table structure for table `return_product`
--

CREATE TABLE `return_product` (
  `re_id` int(50) NOT NULL,
  `re_fk_product_id` int(50) NOT NULL,
  `re_fk_order_id` int(50) NOT NULL,
  `re_fk_customer_id` int(50) NOT NULL,
  `re_reason` text NOT NULL,
  `re_status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `return_product`
--

INSERT INTO `return_product` (`re_id`, `re_fk_product_id`, `re_fk_order_id`, `re_fk_customer_id`, `re_reason`, `re_status`) VALUES
(1, 2570195, 81262306, 1, 'no reason', 'Approve');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`ad_id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`car_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`cont_id`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`c_id`);

--
-- Indexes for table `employee_orders`
--
ALTER TABLE `employee_orders`
  ADD PRIMARY KEY (`eo_id`);

--
-- Indexes for table `employee_order_details`
--
ALTER TABLE `employee_order_details`
  ADD PRIMARY KEY (`eod_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`n_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`o_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`od_id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- Indexes for table `product_comment`
--
ALTER TABLE `product_comment`
  ADD PRIMARY KEY (`pc_id`);

--
-- Indexes for table `return_product`
--
ALTER TABLE `return_product`
  ADD PRIMARY KEY (`re_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `ad_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `car_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `cont_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `c_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `employee_order_details`
--
ALTER TABLE `employee_order_details`
  MODIFY `eod_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `n_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `od_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `product_comment`
--
ALTER TABLE `product_comment`
  MODIFY `pc_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `return_product`
--
ALTER TABLE `return_product`
  MODIFY `re_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
