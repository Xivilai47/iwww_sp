-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Ned 28. led 2018, 17:07
-- Verze serveru: 10.1.30-MariaDB
-- Verze PHP: 7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `sp_test`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `cities`
--

CREATE TABLE `cities` (
  `ID` int(11) NOT NULL,
  `Nazev` text COLLATE utf8_unicode_ci NOT NULL,
  `country_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `cities`
--

INSERT INTO `cities` (`ID`, `Nazev`, `country_ID`) VALUES
(12, 'Kuta', 18),
(13, 'Port Douglas', 19),
(14, 'LondÃ½n', 20),
(15, 'Tampere', 21),
(16, 'Imatra', 21),
(17, 'Washington DC', 22),
(18, 'Barcelona', 23),
(19, 'Mykonos', 24),
(20, 'Jesolo', 25),
(21, 'PaÅ™Ã­Å¾', 26),
(22, 'KrÃ©ta', 24),
(23, 'Cairns', 19),
(24, 'Florencie', 25),
(25, 'New York', 22),
(26, 'Nusa Dua', 18),
(27, 'Edinburgh', 20);

-- --------------------------------------------------------

--
-- Struktura tabulky `comments`
--

CREATE TABLE `comments` (
  `id` int(6) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ID` int(6) NOT NULL,
  `hotel_ID` int(6) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `hodnoceni` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `comments`
--

INSERT INTO `comments` (`id`, `comment`, `user_ID`, `hotel_ID`, `created`, `hodnoceni`) VALUES
(1, 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur?', 6, 9, '2018-01-28 12:03:50', 8),
(15, '<p>FIRST!</p>', 6, 10, '2018-01-28 16:02:13', 10);

-- --------------------------------------------------------

--
-- Struktura tabulky `countries`
--

CREATE TABLE `countries` (
  `ID` int(11) NOT NULL,
  `NAZEV` tinytext CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `countries`
--

INSERT INTO `countries` (`ID`, `NAZEV`) VALUES
(18, 'Bali'),
(19, 'AustrÃ¡lie'),
(20, 'VelkÃ¡ BritÃ¡nie'),
(21, 'Finsko'),
(22, 'USA'),
(23, 'Å panÄ›lsko'),
(24, 'Å˜ecko'),
(25, 'ItÃ¡lie'),
(26, 'Francie');

-- --------------------------------------------------------

--
-- Struktura tabulky `hotels`
--

CREATE TABLE `hotels` (
  `ID` int(11) NOT NULL,
  `NAZEV` tinytext CHARACTER SET latin1 NOT NULL,
  `city_ID` int(11) DEFAULT NULL,
  `base_room_price` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `hotels`
--

INSERT INTO `hotels` (`ID`, `NAZEV`, `city_ID`, `base_room_price`, `description`) VALUES
(9, 'AlamKulKul Boutique Resort', 12, 1300, 'awdaweaeedwaqdre3awdawdawdawd'),
(10, 'By The Sea Port Douglas', 13, 2000, NULL),
(11, 'Central Park Hotel', 14, 2500, NULL),
(12, 'Cumulus Hotel Koskikatu', 15, 2500, 'awdawdawdawd'),
(13, 'Cumulus Resort', 16, 2500, NULL),
(14, 'Hyatt Place', 17, 2200, NULL),
(15, 'Eurostars Grand Marina', 18, 3300, NULL),
(16, 'Grand Hotel Central', 18, 5000, NULL),
(17, 'Harmony Boutique Hotel', 19, 2400, NULL),
(18, 'Hotel Adlon', 20, 1700, NULL),
(19, 'Hotel Les ThÃ©Ã¢tres', 21, 2400, NULL),
(20, 'HÃ´tel Westside Arc de Triomphe', 21, 2100, NULL),
(21, 'Marin Dream', 22, 1000, NULL),
(22, 'Novotel Cairns Oasis Resort', 23, 2400, NULL),
(23, 'Palazzo Alfieri Residenza D Epoca', 24, 4500, NULL),
(24, 'Room Mate Grace', 25, 2400, NULL),
(25, 'The Mulia', 26, 8000, NULL),
(26, 'Waldorf Astoria Edinburgh', 27, 4000, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `offers`
--

CREATE TABLE `offers` (
  `ID` int(11) NOT NULL,
  `ID_Room` int(11) NOT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `no_of_days` int(11) NOT NULL,
  `detail` text COLLATE utf8_unicode_ci,
  `img_path` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `offers`
--

INSERT INTO `offers` (`ID`, `ID_Room`, `user_ID`, `date_from`, `date_to`, `no_of_days`, `detail`, `img_path`) VALUES
(12, 10, 6, '2018-02-04', '2018-02-11', 7, 'awdawdwdawdadawdaadawdaedfawdawdwad5555', NULL),
(13, 12, NULL, '2018-02-04', '2018-02-18', 14, '', NULL),
(14, 14, NULL, '2018-02-05', '2018-02-12', 7, NULL, NULL),
(15, 16, NULL, '2018-03-05', '2018-03-19', 14, NULL, NULL),
(16, 18, NULL, '2018-05-14', '2018-05-21', 7, NULL, NULL),
(17, 20, NULL, '2018-01-10', '2018-01-17', 7, NULL, NULL),
(18, 24, NULL, '2018-06-04', '2018-06-11', 7, NULL, NULL),
(19, 26, NULL, '2018-04-02', '2018-04-09', 7, NULL, NULL),
(20, 28, NULL, '2018-07-02', '2018-07-09', 7, NULL, NULL),
(21, 32, NULL, '2018-07-08', '2018-07-29', 21, NULL, NULL),
(22, 34, NULL, '2018-05-07', '2018-05-21', 14, NULL, NULL),
(23, 36, NULL, '2018-07-02', '2018-07-09', 7, NULL, NULL),
(24, 30, NULL, '2018-06-04', '2018-06-08', 4, NULL, NULL),
(26, 38, NULL, '2018-02-01', '2018-02-04', 3, NULL, NULL),
(29, 40, NULL, '2018-05-09', '2018-05-16', 7, NULL, NULL),
(30, 22, NULL, '2018-05-04', '2018-05-24', 20, NULL, NULL),
(31, 42, NULL, '2018-02-13', '2018-02-28', 15, 'DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! DrahÃ½ jak pes! ', NULL),
(32, 44, NULL, '2018-03-12', '2018-03-19', 7, NULL, NULL);

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `pretty_offer`
-- (See below for the actual view)
--
CREATE TABLE `pretty_offer` (
`id` int(11)
,`country` tinytext
,`city` text
,`hotel` tinytext
,`no_of_beds` int(11)
,`od` varchar(12)
,`do` varchar(12)
,`price` bigint(32)
,`user_id` int(11)
,`detail` text
,`description` text
,`hotel_id` int(11)
);

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `pretty_offer2`
-- (See below for the actual view)
--
CREATE TABLE `pretty_offer2` (
`id` int(11)
,`pretty_room_id` mediumtext
,`Zarezervovano uzivatelem` int(11)
,`Od` date
,`Do` date
,`Dní` int(11)
,`Detail` text
);

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `pretty_rooms`
-- (See below for the actual view)
--
CREATE TABLE `pretty_rooms` (
`room_id` int(11)
,`pokoj` mediumtext
);

-- --------------------------------------------------------

--
-- Struktura tabulky `roles`
--

CREATE TABLE `roles` (
  `ID` int(11) NOT NULL,
  `Role` tinytext CHARACTER SET latin1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `roles`
--

INSERT INTO `roles` (`ID`, `Role`) VALUES
(1, 'Admin'),
(2, 'User');

-- --------------------------------------------------------

--
-- Struktura tabulky `rooms`
--

CREATE TABLE `rooms` (
  `ID` int(11) NOT NULL,
  `No_of_Beds` int(11) NOT NULL,
  `Price_Night` int(11) NOT NULL,
  `Taken` int(1) NOT NULL,
  `ID_Hotel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `rooms`
--

INSERT INTO `rooms` (`ID`, `No_of_Beds`, `Price_Night`, `Taken`, `ID_Hotel`) VALUES
(10, 2, 150, 0, 9),
(11, 4, 100, 0, 9),
(12, 3, 175, 0, 10),
(13, 2, 150, 0, 10),
(14, 2, 200, 0, 11),
(15, 4, 175, 0, 11),
(16, 4, 200, 0, 12),
(17, 5, 180, 0, 12),
(18, 2, 200, 0, 13),
(19, 3, 185, 0, 13),
(20, 1, 250, 0, 14),
(21, 2, 225, 0, 14),
(22, 2, 300, 0, 24),
(23, 4, 250, 0, 24),
(24, 4, 190, 0, 15),
(25, 2, 220, 0, 15),
(26, 1, 500, 0, 16),
(27, 2, 450, 0, 16),
(28, 2, 150, 0, 17),
(29, 4, 125, 0, 17),
(30, 6, 80, 0, 21),
(31, 4, 100, 0, 21),
(32, 1, 150, 0, 18),
(33, 3, 100, 0, 18),
(34, 2, 200, 0, 19),
(35, 4, 250, 0, 19),
(36, 2, 200, 0, 20),
(37, 3, 250, 0, 9),
(38, 4, 200, 0, 22),
(39, 5, 200, 0, 22),
(40, 1, 500, 0, 23),
(41, 2, 500, 0, 23),
(42, 3, 800, 0, 25),
(43, 1, 1000, 0, 25),
(44, 1, 400, 0, 26),
(45, 4, 300, 0, 26);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `First_name` text COLLATE utf8_unicode_ci NOT NULL,
  `Surname` text COLLATE utf8_unicode_ci NOT NULL,
  `email` text COLLATE utf8_unicode_ci NOT NULL,
  `login` text COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `Role_ID` int(11) NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'img/profile_pics/default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`ID`, `First_name`, `Surname`, `email`, `login`, `password`, `Role_ID`, `profile_picture`) VALUES
(6, 'JonÃ¡Å¡', 'Urban', 'admin@sunset.cz', 'admin', '$2y$10$guNHGfYIP7bpjiNkQt3SNOK3LlWKQEKKNQ6r.w5Uu23h2o1IFyzTK', 1, 'img/profile_pics/default.png'),
(7, 'Jan', 'Cestovatel', 'cestak@seznam.cz', 'cestak', '$2y$10$d0gzURZM8lOGWF8CS9WaL.HJGaC07NFW4B0zY2oaGQXNQfT3KnGAO', 2, 'img/profile_pics/default.png');

--
-- Spouště `users`
--
DELIMITER $$
CREATE TRIGGER `cancel_reservations_on_user_delete` BEFORE DELETE ON `users` FOR EACH ROW update offers set user_id=null where user_id=OLD.ID
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura pro pohled `pretty_offer`
--
DROP TABLE IF EXISTS `pretty_offer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pretty_offer`  AS  select `o`.`ID` AS `id`,`c`.`NAZEV` AS `country`,`cit`.`Nazev` AS `city`,`h`.`NAZEV` AS `hotel`,`r`.`No_of_Beds` AS `no_of_beds`,date_format(`o`.`date_from`,'%e. %c. %Y') AS `od`,date_format(`o`.`date_to`,'%e. %c. %Y') AS `do`,(`r`.`No_of_Beds` * (`h`.`base_room_price` + (`o`.`no_of_days` * `r`.`Price_Night`))) AS `price`,`o`.`user_ID` AS `user_id`,`o`.`detail` AS `detail`,`h`.`description` AS `description`,`h`.`ID` AS `hotel_id` from ((((`offers` `o` join `rooms` `r` on((`o`.`ID_Room` = `r`.`ID`))) join `hotels` `h` on((`r`.`ID_Hotel` = `h`.`ID`))) join `cities` `cit` on((`h`.`city_ID` = `cit`.`ID`))) join `countries` `c` on((`cit`.`country_ID` = `c`.`ID`))) ;

-- --------------------------------------------------------

--
-- Struktura pro pohled `pretty_offer2`
--
DROP TABLE IF EXISTS `pretty_offer2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pretty_offer2`  AS  select `o`.`ID` AS `id`,concat(`r`.`ID`,' (',`r`.`No_of_Beds`,'-lÅ¯Å¾kovÃ½ pokoj - ',`h`.`NAZEV`,' (',`cit`.`Nazev`,'))') AS `pretty_room_id`,`o`.`user_ID` AS `Zarezervovano uzivatelem`,`o`.`date_from` AS `Od`,`o`.`date_to` AS `Do`,`o`.`no_of_days` AS `Dní`,`o`.`detail` AS `Detail` from ((((`offers` `o` join `rooms` `r` on((`r`.`ID` = `o`.`ID_Room`))) join `hotels` `h` on((`h`.`ID` = `r`.`ID_Hotel`))) join `cities` `cit` on((`cit`.`ID` = `h`.`city_ID`))) join `countries` `c` on((`c`.`ID` = `cit`.`country_ID`))) ;

-- --------------------------------------------------------

--
-- Struktura pro pohled `pretty_rooms`
--
DROP TABLE IF EXISTS `pretty_rooms`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pretty_rooms`  AS  select `r`.`ID` AS `room_id`,concat(`r`.`No_of_Beds`,'-lÅ¯Å¾kovÃ½ pokoj - ',`h`.`NAZEV`,' (',`c`.`Nazev`,')') AS `pokoj` from ((`rooms` `r` join `hotels` `h` on((`h`.`ID` = `r`.`ID_Hotel`))) join `cities` `c` on((`c`.`ID` = `h`.`city_ID`))) ;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `fk_country_id` (`country_ID`);

--
-- Klíče pro tabulku `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`ID`);

--
-- Klíče pro tabulku `hotels`
--
ALTER TABLE `hotels`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Country` (`city_ID`);

--
-- Klíče pro tabulku `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Room` (`ID_Room`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Klíče pro tabulku `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`ID`);

--
-- Klíče pro tabulku `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ID_Hotel` (`ID_Hotel`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `Role` (`Role_ID`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `cities`
--
ALTER TABLE `cities`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT pro tabulku `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT pro tabulku `countries`
--
ALTER TABLE `countries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pro tabulku `hotels`
--
ALTER TABLE `hotels`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT pro tabulku `offers`
--
ALTER TABLE `offers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pro tabulku `rooms`
--
ALTER TABLE `rooms`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `fk_country_id` FOREIGN KEY (`country_ID`) REFERENCES `countries` (`ID`);

--
-- Omezení pro tabulku `hotels`
--
ALTER TABLE `hotels`
  ADD CONSTRAINT `fk_city_id` FOREIGN KEY (`city_ID`) REFERENCES `cities` (`ID`);

--
-- Omezení pro tabulku `offers`
--
ALTER TABLE `offers`
  ADD CONSTRAINT `offers_ibfk_1` FOREIGN KEY (`ID_Room`) REFERENCES `rooms` (`ID`),
  ADD CONSTRAINT `offers_ibfk_2` FOREIGN KEY (`user_ID`) REFERENCES `users` (`ID`);

--
-- Omezení pro tabulku `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_ibfk_1` FOREIGN KEY (`ID_Hotel`) REFERENCES `hotels` (`ID`);

--
-- Omezení pro tabulku `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `Role` FOREIGN KEY (`Role_ID`) REFERENCES `roles` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
