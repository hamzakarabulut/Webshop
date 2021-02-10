-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 02 Oca 2021, 16:43:52
-- Sunucu sürümü: 5.7.11
-- PHP Sürümü: 7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `bakery`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `bakeryuser`
--

CREATE TABLE `bakeryuser` (
  `userId` int(200) NOT NULL,
  `userName` varchar(200) NOT NULL,
  `firstName` varchar(200) NOT NULL,
  `surname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `lastLogin` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastActivity` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `onlineStatus` enum('OFFLINE','ONLINE') NOT NULL DEFAULT 'OFFLINE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `bakeryuser`
--

INSERT INTO `bakeryuser` (`userId`, `userName`, `firstName`, `surname`, `email`, `password`, `lastLogin`, `lastActivity`, `onlineStatus`) VALUES
(119, 'yas', 'yas', 'yas', 'yas@yas', '5cc50107ac375e075cca5f7977b4cccd42b4232e54d878ac1f5e557c942ccb17d76c757fe8625d748330df822df4d50aaa473ca9126110c5bf82e8510e227f88', '2020-12-31 00:00:00', '2020-12-31 15:11:21', 'OFFLINE'),
(120, 'yase', 'yase', 'yase', 'yase@yase', 'b5b598cb2beb99ae85358bd52f62573ecd0bf15466561896ab40069787e0e519fed7d788fec0634fbdba43bbdcbf0f6756bd694274bca382d0b9f91af2291895', '2020-12-31 00:00:00', '2020-12-31 16:18:43', 'ONLINE'),
(121, 'ku', 'ku', 'ku', 'ku@ku', '9faf38826a07153476cbb63301976f18586428d195dd513f6268434e4d6d9950aaf7bc7711185c6982815639f3005f5c65722acdb211be1d7f08b36b87817481', '2020-12-30 00:00:00', '2020-12-30 20:58:22', 'OFFLINE'),
(122, 'du', 'du', 'du', 'du@du', 'cdec6e821965f441eb8b206c00d0dfd92051d048ca6ebe03f5dea2a744e6646b786e9836879f7c44cb5ff22789fdb6f53f8966b5b0c8a3b6ef10e64d18a7d937', '2020-12-31 00:00:00', '2020-12-31 15:12:17', 'OFFLINE'),
(123, 'cansu', 'cansu', 'cansu', 'ca@ca', '8fb9d6efc486cbbbd6f7aff25d33dac4e0c7cf4a1e87163eed5388f402d5b7f2db1cf36ccdc8811a45919f17e6b8047a53dca1beb658830231045b0b82eac3f4', '2020-12-30 00:00:00', '2020-12-30 20:58:22', 'OFFLINE'),
(124, 'yasemin', 'yasemin', 'yasemin', 'yasemin@yasemin', '8f69653de6321a8c93ae6cf8364f8ae0e4f1362683e6ca9b91bdf3b21db980726da2f238e8262b2ce116d61d968d68c0f76474438a672fe9cf1ae0b2bdecc380', '2020-12-31 00:00:00', '2020-12-31 15:11:51', 'OFFLINE'),
(125, 'gu', 'gu', 'gu', 'gu@gu', '4607d683da2d51c9276e1b2a72ac1ab64ac7748e7ff72de6a56933da7557c7bc7c9f7a1d43eaaf6c29595edf0e049796c7f3fbacca4e1f898075096f4ecfb254', '2020-12-31 00:00:00', '2020-12-31 16:26:21', 'ONLINE'),
(126, 'mel', 'mel', 'mel', 'mel@mel', '131eb8aa642a3df1134e0e985ca0e31a876d9b4ea87b5c63a51da47f2f122f0eddca2fcb868a61a571f1238c5c6cc32c0507d5fcd4d711ebd5476bd66abd7a29', '2020-12-31 00:00:00', '2020-12-31 15:14:00', 'ONLINE'),
(127, 'deneme', 'İsim', 'Soyisim', 'deneme@deneme.com', '511149afa5f8e00452ce18721dde6ffe0725d7b4c1ed73e083b15058c96ba38f771a1323bfa0b92fe9d6ef2c6aded1951079d86cf4fcc9d167e37566576ab04e', '2021-01-02 00:00:00', '2021-01-02 14:46:19', 'ONLINE');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `artikel_id`, `quantity`) VALUES
(1, 1, 15, 1),
(9, 127, 15, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `shipment_type` varchar(50) NOT NULL,
  `total` double(10,2) NOT NULL,
  `shipment` double(10,2) NOT NULL,
  `adress` text,
  `tel` int(11) DEFAULT NULL,
  `order_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `shipment_type`, `total`, `shipment`, `adress`, `tel`, `order_date`) VALUES
(1, 127, 'Express', 123.00, 5.00, 'Adres Adres Adres Adres Adres Adres ', 123456623, '2021-01-01 00:00:00'),
(2, 127, 'Express', 123.00, 5.00, 'Adres Adres Adres Adres Adres Adres ', 123456623, '2021-01-02 15:37:44'),
(3, 127, 'Express', 123.00, 5.00, 'Adres Adres Adres Adres Adres Adres ', 123456623, '2021-01-02 15:38:06'),
(6, 127, 'Express', 123.00, 5.00, 'Adres Adres Adres Adres Adres Adres ', 123456623, '2021-01-02 15:42:07'),
(7, 127, 'Express', 123.00, 5.00, 'Adres Adres Adres Adres Adres Adres ', 123456623, '2021-01-02 15:42:30'),
(9, 127, 'Normal', 2240.00, 0.00, 'son adres', 888888888, '2021-01-02 16:25:41'),
(10, 127, 'Express', 3750.00, 5.00, 'adres 5', 55555555, '2021-01-02 16:29:01');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `artikel_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `artikel_id`, `quantity`) VALUES
(1, 1, 1, 1),
(3, 2, 1, 1),
(4, 2, 15, 2),
(5, 3, 1, 1),
(6, 3, 15, 2),
(7, 6, 1, 1),
(12, 9, 1, 1),
(13, 9, 15, 3),
(14, 10, 1, 2),
(15, 10, 15, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(25) NOT NULL,
  `product_desc` text,
  `product_price` float DEFAULT NULL,
  `product_image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Tablo döküm verisi `products`
--

INSERT INTO `products` (`id`, `product_name`, `product_desc`, `product_price`, `product_image`) VALUES
(1, 'Kuchen 1', 'deneme', 1799, 'img/kasekuchen.jpg'),
(15, 'Kuchen 2', 'test', 147, 'img/kasekuchen.jpg');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `bakeryuser`
--
ALTER TABLE `bakeryuser`
  ADD PRIMARY KEY (`userId`);

--
-- Tablo için indeksler `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `bakeryuser`
--
ALTER TABLE `bakeryuser`
  MODIFY `userId` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;
--
-- Tablo için AUTO_INCREMENT değeri `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- Tablo için AUTO_INCREMENT değeri `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- Tablo için AUTO_INCREMENT değeri `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- Tablo için AUTO_INCREMENT değeri `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
