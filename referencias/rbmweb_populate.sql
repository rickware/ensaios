-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Dec 01, 2021 at 03:54 PM
-- Server version: 8.0.25
-- PHP Version: 7.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rbmweb`
--

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `nome`, `email`, `celular`) VALUES
(1, 'Anna', 'abdeliriberri@cweb.com', '12345'),
(2, 'Antonio', 'tonio@mail.com', '12345'),
(3, 'Thomas', 'thom@mail.com', '12345'),
(4, 'Christina', 'chris@mail.com', '12345'),
(8, 'Elizabeth', 'beth@mail.com', '12345'),
(9, 'Sven', 'sven@mail.com', '12345'),
(10, 'Roland', 'roland@mail.com', '12345'),
(11, 'Peter', 'pete@mail.com', '12345'),
(12, 'John', 'john@mail.com', '12345'),
(13, 'Andre', 'andre@mail.com', '12345'),
(14, 'Carlos', 'carlos@mail.com', '12345'),
(15, 'Helena', 'helena@mail.com', '12345'),
(16, 'Daniel', 'daniel@mail.com', '12345'),
(17, 'Catherine', 'cathe@mail.com', '12345'),
(18, 'Alexander', 'alex@mail.com', '12345'),
(19, 'George', 'jorje@mail.com', '12345'),
(20, 'Bernard', 'bern@mail.com', '12345'),
(21, 'Luciana', 'luciana@mail.com', '12345'),
(22, 'Michael', 'chael@mail.com', '12345'),
(23, 'Jonas', 'jonas@mail.com', '12345'),
(24, 'John', 'joohn@mail.com', '12345'),
(25, 'Run', 'runn@mail.com', '12345'),
(26, 'Karen', 'karem@mail.com', '12345'),
(27, 'Amritansh', 'amrit@mail.com', '12345'),
(28, 'Soo Jung', 'sjung@mail.com', '12345');

--
-- Dumping data for table `pedidos`
--

INSERT INTO `pedidos` (`id`, `cliente_id`, `data_do_pedido`) VALUES
(1, 27, '2021-11-28 08:28:51'),
(2, 4, '2021-11-28 08:28:51'),
(3, 12, '2021-11-28 08:28:51'),
(4, 8, '2021-11-28 08:28:51'),
(5, 4, '2021-11-28 08:28:51'),
(6, 24, '2021-11-28 08:28:51'),
(7, 3, '2021-11-28 08:28:51'),
(8, 2, '2021-11-28 08:28:51'),
(9, 28, '2021-11-28 08:28:51'),
(10, 8, '2021-11-28 08:28:51'),
(11, 10, '2021-11-28 08:28:51'),
(12, 7, '2021-11-28 08:28:51'),
(13, 10, '2021-11-28 08:28:51'),
(14, 11, '2021-11-28 08:28:51'),
(15, 1, '2021-11-28 08:28:51'),
(16, 28, '2021-11-28 08:28:51'),
(17, 9, '2021-11-28 08:28:51'),
(18, 2, '2021-11-28 08:28:51'),
(19, 8, '2021-11-28 08:28:51'),
(20, 25, '2021-11-28 08:28:51'),
(82, 3, '2021-12-01 10:16:12'),
(83, 1, '2021-12-01 10:27:24'),
(84, 1, '2021-12-01 10:31:18'),
(85, 11, '2021-12-01 10:36:33'),
(86, 3, '2021-12-01 10:59:34');

--
-- Dumping data for table `pedido_detalhes`
--

INSERT INTO `pedido_detalhes` (`id`, `pedido_id`, `produto_id`, `quantidade`) VALUES
(1, 1, 34, '100.0000'),
(2, 1, 43, '30.0000'),
(3, 2, 7, '10.0000'),
(4, 2, 42, '10.0000'),
(5, 2, 43, '10.0000'),
(6, 3, 1, '15.0000'),
(7, 3, 40, '20.0000'),
(8, 4, 19, '30.0000'),
(9, 5, 19, '20.0000'),
(10, 6, 41, '10.0000'),
(11, 7, 38, '200.0000'),
(12, 8, 8, '17.0000'),
(13, 9, 40, '300.0000'),
(14, 10, 41, '100.0000'),
(15, 11, 45, '200.0000'),
(16, 11, 39, '300.0000'),
(17, 12, 6, '10.0000'),
(18, 12, 4, '10.0000'),
(19, 12, 19, '10.0000'),
(20, 13, 43, '20.0000'),
(21, 13, 44, '50.0000'),
(22, 14, 1, '25.0000'),
(49, 14, 43, '25.0000'),
(50, 14, 37, '25.0000'),
(51, 15, 41, '50.0000'),
(52, 15, 40, '50.0000'),
(53, 16, 33, '100.0000'),
(54, 16, 33, '50.0000'),
(55, 17, 34, '300.0000'),
(56, 18, 8, '25.0000'),
(57, 18, 19, '25.0000'),
(59, 19, 21, '20.0000'),
(60, 20, 5, '25.0000'),
(61, 20, 41, '30.0000'),
(62, 20, 40, '30.0000'),
(66, 20, 36, '10.0000'),
(67, 20, 34, '87.0000'),
(92, 85, 1, '22.0000'),
(93, 85, 2, '12.0000'),
(94, 86, 6, '11.0000'),
(95, 86, 4, '10.0000'),
(96, 7, 3, '3.0000'),
(97, 17, 4, '1.0000');

--
-- Dumping data for table `produtos`
--

INSERT INTO `produtos` (`id`, `codigo`, `nome`, `preco`, `unidade`, `categoria`, `estoque`) VALUES
(1, 'NWTB-1', 'Chai', '18.0000', '10 boxes x 20 bags', 'Bebidas', 3),
(2, 'NWTCO-3', 'Syrup', '10.0000', '12 - 550 ml bottles', 'Condimentos', 6),
(3, 'NWTCO-4', 'Cajun Seasoning', '22.0000', '48 - 6 oz jars', 'Condimentos', 9),
(4, 'NWTO-5', 'Olive Oil', '21.3500', '36 boxes', 'Oleos', 12),
(5, 'NWTJP-6', 'Boysenberry Spread', '25.0000', '12 - 8 oz jars', 'Conservas', 15),
(6, 'NWTDFN-7', 'Dried Pears', '30.0000', '12 - 1 lb pkgs.', 'Variados', 18),
(7, 'NWTS-8', 'Curry Sauce', '40.0000', '12 - 12 oz jars', 'Molhos', 21),
(8, 'NWTDFN-14', 'Walnuts', '23.2500', '40 - 100 g pkgs.', 'Variados', 24),
(9, 'NWTCFV-17', 'Fruit Cocktail', '39.0000', '15.25 OZ', 'Enlatados Frutas', 27),
(10, 'NWTBGM-19', 'Chocolate Biscuits Mix', '9.2000', '10 boxes x 12 pieces', 'Padaria', 30),
(11, 'NWTJP-6', 'Marmalade', '81.0000', '30 gift boxes', 'Conservas', 33),
(12, 'NWTBGM-21', 'Scones', '10.0000', '24 pkgs. x 4 pieces', 'Padaria', 36),
(13, 'NWTB-34', 'Beer', '14.0000', '24 - 12 oz bottles', 'Bebidas', 39),
(14, 'NWTCM-40', 'Crab Meat', '18.4000', '24 - 4 oz tins', 'Enlatados Carne', 42),
(15, 'NWTSO-41', 'Clam Chowder', '9.6500', '12 - 12 oz cans', 'Sopas', 45),
(16, 'NWTB-43', 'Coffee', '46.0000', '16 - 500 g tins', 'Bebidas', 48),
(17, 'NWTCA-48', 'Chocolate', '12.7500', '10 pkgs', 'Doces', 51),
(18, 'NWTDFN-51', 'Dried Apples', '53.0000', '50 - 300 g pkgs.', 'Variados', 54),
(19, 'NWTG-52', 'Long Grain Rice', '7.0000', '16 - 2 kg boxes', 'Grao', 57),
(20, 'NWTP-56', 'Gnocchi', '38.0000', '24 - 250 g pkgs.', 'Massas', 60),
(21, 'NWTP-57', 'Ravioli', '19.5000', '24 - 250 g pkgs.', 'Massas', 63),
(22, 'NWTS-65', 'Hot Pepper Sauce', '21.0500', '32 - 8 oz bottles', 'Molhos', 66),
(23, 'NWTS-66', 'Tomato Sauce', '17.0000', '24 - 8 oz jars', 'Molhos', 69),
(24, 'NWTD-72', 'Mozzarella', '34.8000', '24 - 200 g pkgs.', 'Laticínios', 72),
(25, 'NWTDFN-74', 'Almonds', '10.0000', '5 kg pkg.', 'Variados', 75),
(26, 'NWTCO-77', 'Mustard', '13.0000', '12 boxes', 'Condimentos', 78),
(27, 'NWTDFN-80', 'Dried Plums', '3.5000', '1 lb bag', 'Variados', 81),
(29, 'NWTC-82', 'Granola', '4.0000', 'Da Boa', 'Cereais', 87),
(30, 'NWTCS-83', 'Potato Chips', '1.8000', 'Chips', 'Lanches', 90),
(31, 'NWTBGM-85', 'Brownie Mix', '12.4900', '3 boxes', 'Padaria', 93),
(32, 'NWTBGM-86', 'Cake Mix', '15.9900', '4 boxes', 'Padaria', 96),
(33, 'NWTB-87', 'Tea', '4.0000', '100 count per box', 'Bebidas', 99),
(34, 'NWTCFV-88', 'Pears', '1.3000', '15.25 OZ', 'Enlatados Frutas', 102),
(35, 'NWTCFV-89', 'Peaches', '1.5000', '15.25 OZ', 'Enlatados Frutas', 105),
(36, 'NWTCFV-90', 'Pineapple', '1.8000', '15.25 OZ', 'Enlatados Frutas', 108),
(37, 'NWTCFV-91', 'Cherry Pie Filling', '2.0000', '15.25 OZ', 'Enlatados Frutas', 111),
(38, 'NWTCFV-92', 'Green Beans', '1.2000', '14.5 OZ', 'Enlatados Frutas', 114),
(39, 'NWTCFV-93', 'Corn', '1.2000', '14.5 OZ', 'Enlatados Frutas', 117),
(40, 'NWTCFV-94', 'Peas', '1.5000', '14.5 OZ', 'Enlatados Frutas', 120),
(41, 'NWTCM-95', 'Tuna Fish', '2.0000', '5 oz', 'Enlatados Carne', 123),
(42, 'NWTCM-96', 'Smoked Salmon', '4.0000', '5 oz', 'Enlatados Carne', 126),
(43, 'NWTC-82', 'Hot Cereais', '5.0000', 'hothot', 'Cereais', 129),
(44, 'NWTSO-98', 'Vegetable Soup', '1.8900', 'sopa', 'Sopas', 132),
(45, 'NWTSO-99', 'Chicken Soup', '1.9500', 'sopao', 'Sopas', 135),
(190, 'MAMAMAMA', 'Agua', '10.0000', 'LITRO', 'Bebidas', 33);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
