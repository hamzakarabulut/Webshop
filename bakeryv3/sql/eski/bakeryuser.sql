-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 02. Jan 2021 um 14:56
-- Server-Version: 10.4.14-MariaDB
-- PHP-Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bakerydb`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `bakeryuser`
--

CREATE TABLE `bakeryuser` (
  `userId` int(200) NOT NULL,
  `userName` varchar(200) NOT NULL,
  `firstName` varchar(200) NOT NULL,
  `surname` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `lastLogin` date NOT NULL DEFAULT current_timestamp(),
  `lastActivity` datetime NOT NULL DEFAULT current_timestamp(),
  `onlineStatus` enum('OFFLINE','ONLINE') NOT NULL DEFAULT 'OFFLINE'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Daten für Tabelle `bakeryuser`
--

INSERT INTO `bakeryuser` (`userId`, `userName`, `firstName`, `surname`, `email`, `password`, `lastLogin`, `lastActivity`, `onlineStatus`) VALUES
(119, 'yas', 'yas', 'yas', 'yas@yas', '5cc50107ac375e075cca5f7977b4cccd42b4232e54d878ac1f5e557c942ccb17d76c757fe8625d748330df822df4d50aaa473ca9126110c5bf82e8510e227f88', '2020-12-31', '2020-12-31 15:11:21', 'OFFLINE'),
(120, 'yase', 'yase', 'yase', 'yase@yase', 'b5b598cb2beb99ae85358bd52f62573ecd0bf15466561896ab40069787e0e519fed7d788fec0634fbdba43bbdcbf0f6756bd694274bca382d0b9f91af2291895', '2020-12-31', '2020-12-31 16:18:43', 'ONLINE'),
(121, 'ku', 'ku', 'ku', 'ku@ku', '9faf38826a07153476cbb63301976f18586428d195dd513f6268434e4d6d9950aaf7bc7711185c6982815639f3005f5c65722acdb211be1d7f08b36b87817481', '2020-12-30', '2020-12-30 20:58:22', 'OFFLINE'),
(122, 'du', 'du', 'du', 'du@du', 'cdec6e821965f441eb8b206c00d0dfd92051d048ca6ebe03f5dea2a744e6646b786e9836879f7c44cb5ff22789fdb6f53f8966b5b0c8a3b6ef10e64d18a7d937', '2020-12-31', '2020-12-31 15:12:17', 'OFFLINE'),
(123, 'cansu', 'cansu', 'cansu', 'ca@ca', '8fb9d6efc486cbbbd6f7aff25d33dac4e0c7cf4a1e87163eed5388f402d5b7f2db1cf36ccdc8811a45919f17e6b8047a53dca1beb658830231045b0b82eac3f4', '2020-12-30', '2020-12-30 20:58:22', 'OFFLINE'),
(124, 'yasemin', 'yasemin', 'yasemin', 'yasemin@yasemin', '8f69653de6321a8c93ae6cf8364f8ae0e4f1362683e6ca9b91bdf3b21db980726da2f238e8262b2ce116d61d968d68c0f76474438a672fe9cf1ae0b2bdecc380', '2020-12-31', '2020-12-31 15:11:51', 'OFFLINE'),
(125, 'gu', 'gu', 'gu', 'gu@gu', '4607d683da2d51c9276e1b2a72ac1ab64ac7748e7ff72de6a56933da7557c7bc7c9f7a1d43eaaf6c29595edf0e049796c7f3fbacca4e1f898075096f4ecfb254', '2020-12-31', '2020-12-31 16:26:21', 'ONLINE'),
(126, 'mel', 'mel', 'mel', 'mel@mel', '131eb8aa642a3df1134e0e985ca0e31a876d9b4ea87b5c63a51da47f2f122f0eddca2fcb868a61a571f1238c5c6cc32c0507d5fcd4d711ebd5476bd66abd7a29', '2020-12-31', '2020-12-31 15:14:00', 'ONLINE');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `bakeryuser`
--
ALTER TABLE `bakeryuser`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `bakeryuser`
--
ALTER TABLE `bakeryuser`
  MODIFY `userId` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
