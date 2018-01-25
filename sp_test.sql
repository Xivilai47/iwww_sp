-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 25. led 2018, 21:44
-- Verze serveru: 10.1.28-MariaDB
-- Verze PHP: 7.1.10

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
(1, 'Liberec', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `comments`
--

CREATE TABLE `comments` (
  `id` int(6) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8_unicode_ci NOT NULL,
  `user_ID` int(6) NOT NULL,
  `hotel_ID` int(6) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, '?eská republika');

-- --------------------------------------------------------

--
-- Struktura tabulky `hotels`
--

CREATE TABLE `hotels` (
  `ID` int(11) NOT NULL,
  `NAZEV` tinytext CHARACTER SET latin1 NOT NULL,
  `city_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `hotels`
--

INSERT INTO `hotels` (`ID`, `NAZEV`, `city_ID`) VALUES
(1, 'Hotel Ješt?d', 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `offers`
--

CREATE TABLE `offers` (
  `ID` int(11) NOT NULL,
  `ID_Room` int(11) NOT NULL,
  `reserved` tinyint(1) DEFAULT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `no_of_days` int(11) NOT NULL,
  `detail` text COLLATE utf8_unicode_ci,
  `picture` text COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Vypisuji data pro tabulku `offers`
--

INSERT INTO `offers` (`ID`, `ID_Room`, `reserved`, `user_ID`, `date_from`, `date_to`, `no_of_days`, `detail`, `picture`) VALUES
(1, 1, 1, 6, '2018-06-03', '2018-06-09', 6, NULL, NULL),
(3, 1, 1, NULL, '2018-06-10', '2018-06-23', 12, NULL, NULL);

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `pretty_offer`
-- (See below for the actual view)
--
CREATE TABLE `pretty_offer` (
`Offer_ID` int(11)
,`Country` tinytext
,`City` text
,`Hotel` tinytext
,`No_of_Beds` int(11)
,`From` varchar(12)
,`To` varchar(12)
,`Price` bigint(21)
,`Reserved_by` int(11)
);

-- --------------------------------------------------------

--
-- Zástupná struktura pro pohled `pretty_offer2`
-- (See below for the actual view)
--
CREATE TABLE `pretty_offer2` (
`id` int(11)
,`Země > Město > Hotel > ID místnosti` mediumtext
,`Zarezervovano` tinyint(1)
,`Zarezervovano uzivatelem` int(11)
,`Od` date
,`Do` date
,`Dní` int(11)
,`Detail` text
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
(1, 2, 500, 1, 1);

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
(5, 'blabla', 'blabla', 'blabla@bla.bla', 'bla', '$2y$10$B1Nnl/L3k2UeBwy/7SCJ2Obb629Q2dPoVbRpDRQOZNauctLqiEgJu', 2, 'img/profile_pics/default.png'),
(6, 'JonÃ¡Å¡', 'Urban', 'admin@sunset.cz', 'admin', '$2y$10$guNHGfYIP7bpjiNkQt3SNOK3LlWKQEKKNQ6r.w5Uu23h2o1IFyzTK', 1, 'img/profile_pics/default.png'),
(7, 'Jan', 'Cestovatel', 'cestak@seznam.cz', 'cestak', '$2y$10$d0gzURZM8lOGWF8CS9WaL.HJGaC07NFW4B0zY2oaGQXNQfT3KnGAO', 2, 'img/profile_pics/default.png');

-- --------------------------------------------------------

--
-- Struktura pro pohled `pretty_offer`
--
DROP TABLE IF EXISTS `pretty_offer`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pretty_offer`  AS  select `o`.`ID` AS `Offer_ID`,`c`.`NAZEV` AS `Country`,`cit`.`Nazev` AS `City`,`h`.`NAZEV` AS `Hotel`,`r`.`No_of_Beds` AS `No_of_Beds`,date_format(`o`.`date_from`,'%e. %c. %Y') AS `From`,date_format(`o`.`date_to`,'%e. %c. %Y') AS `To`,(`r`.`Price_Night` * `o`.`no_of_days`) AS `Price`,`o`.`user_ID` AS `Reserved_by` from ((((`offers` `o` join `rooms` `r` on((`o`.`ID_Room` = `r`.`ID`))) join `hotels` `h` on((`r`.`ID_Hotel` = `h`.`ID`))) join `cities` `cit` on((`cit`.`ID` = `h`.`city_ID`))) join `countries` `c` on((`c`.`ID` = `cit`.`country_ID`))) ;

-- --------------------------------------------------------

--
-- Struktura pro pohled `pretty_offer2`
--
DROP TABLE IF EXISTS `pretty_offer2`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `pretty_offer2`  AS  select `o`.`ID` AS `id`,concat(convert(`c`.`NAZEV` using utf8),' > ',`cit`.`Nazev`,' > ',convert(`h`.`NAZEV` using utf8),' > ',`o`.`ID_Room`) AS `Země > Město > Hotel > ID místnosti`,`o`.`reserved` AS `Zarezervovano`,`o`.`user_ID` AS `Zarezervovano uzivatelem`,`o`.`date_from` AS `Od`,`o`.`date_to` AS `Do`,`o`.`no_of_days` AS `Dní`,`o`.`detail` AS `Detail` from ((((`offers` `o` join `rooms` `r` on((`r`.`ID` = `o`.`ID_Room`))) join `hotels` `h` on((`h`.`ID` = `r`.`ID_Hotel`))) join `cities` `cit` on((`cit`.`ID` = `h`.`city_ID`))) join `countries` `c` on((`c`.`ID` = `cit`.`country_ID`))) ;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `countries`
--
ALTER TABLE `countries`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `hotels`
--
ALTER TABLE `hotels`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pro tabulku `offers`
--
ALTER TABLE `offers`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `rooms`
--
ALTER TABLE `rooms`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
