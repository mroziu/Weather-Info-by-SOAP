-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 16 Lip 2015, 20:08
-- Wersja serwera: 5.5.43-0ubuntu0.14.04.1
-- Wersja PHP: 5.5.9-1ubuntu4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `weather`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=30 ;

--
-- Zrzut danych tabeli `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(15, 'Koszalin'),
(16, 'Katowice'),
(17, 'Poznan'),
(18, 'Rzeszow-Jasionka'),
(20, 'Warszawa-Okecie'),
(21, 'Szczecin'),
(24, 'Krakow');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `services`
--

CREATE TABLE IF NOT EXISTS `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) CHARACTER SET utf8 NOT NULL,
  `url` varchar(120) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=10 ;

--
-- Zrzut danych tabeli `services`
--

INSERT INTO `services` (`id`, `name`, `url`) VALUES
(8, 'www.webservicex.com', 'http://www.webservicex.com/globalweather.asmx?WSDL');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `timeout`
--

CREATE TABLE IF NOT EXISTS `timeout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `timeout`
--

INSERT INTO `timeout` (`id`, `value`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(4) NOT NULL AUTO_INCREMENT,
  `username` varchar(10) COLLATE utf8_polish_ci NOT NULL,
  `password` varchar(32) COLLATE utf8_polish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Admin', '098f6bcd4621d373cade4e832627b4f6');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `weather`
--

CREATE TABLE IF NOT EXISTS `weather` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` varchar(80) NOT NULL,
  `time` varchar(80) NOT NULL,
  `wind` varchar(120) NOT NULL,
  `visibility` varchar(40) NOT NULL,
  `skyconditions` varchar(80) NOT NULL,
  `temperature` varchar(20) NOT NULL,
  `dewpoint` varchar(20) NOT NULL,
  `relativehumidity` varchar(6) NOT NULL,
  `pressure` varchar(30) NOT NULL,
  `city_id` int(11) NOT NULL,
  `status` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city_id` (`city_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- Zrzut danych tabeli `weather`
--

INSERT INTO `weather` (`id`, `location`, `time`, `wind`, `visibility`, `skyconditions`, `temperature`, `dewpoint`, `relativehumidity`, `pressure`, `city_id`, `status`) VALUES
(37, 'Katowice, Poland (EPKT) 50-14N 019-02E 284M', 'Jul 16, 2015 - 01:30 PM EDT / 2015.07.16 1730 UTC', ' from the SSW (210 degrees) at 5 MPH (4 KT) (direction variable):0', ' greater than 7 mile(s):0', '', ' 78 F (26 C)', ' 57 F (14 C)', ' 47%', ' 30.03 in. Hg (1017 hPa)', 16, '<b style="color: red;">Server Offline. Data from database.</b>'),
(38, 'Poznan, Poland (EPPO) 52-25N 016-50E 92M', 'Jul 16, 2015 - 01:30 PM EDT / 2015.07.16 1730 UTC', ' from the WNW (290 degrees) at 3 MPH (3 KT):0', ' greater than 7 mile(s):0', ' mostly clear', ' 75 F (24 C)', ' 59 F (15 C)', ' 57%', ' 30.03 in. Hg (1017 hPa)', 17, '<b style="color: red;">Server Offline. Data from database.</b>'),
(39, 'Rzeszow-Jasionka, Poland (EPRZ) 50-06N 022-03E 202M', 'Jul 16, 2015 - 01:30 PM EDT / 2015.07.16 1730 UTC', ' from the WNW (290 degrees) at 3 MPH (3 KT):0', ' greater than 7 mile(s):0', '', ' 77 F (25 C)', ' 53 F (12 C)', ' 44%', ' 30.09 in. Hg (1019 hPa)', 18, '<b style="color: red;">Server Offline. Data from database.</b>'),
(40, 'Warszawa-Okecie, Poland (EPWA) 52-10N 020-58E 107M', 'Jul 16, 2015 - 01:30 PM EDT / 2015.07.16 1730 UTC', ' from the W (270 degrees) at 6 MPH (5 KT) (direction variable):0', ' greater than 7 mile(s):0', ' mostly clear', ' 73 F (23 C)', ' 53 F (12 C)', ' 49%', ' 30.03 in. Hg (1017 hPa)', 20, '<b style="color: red;">Server Offline. Data from database.</b>'),
(41, 'Szczecin, Poland (EPSC) 53-24N 014-37E 3M', 'Jul 16, 2015 - 01:30 PM EDT / 2015.07.16 1730 UTC', ' from the N (010 degrees) at 7 MPH (6 KT) (direction variable):0', ' greater than 7 mile(s):0', ' partly cloudy', ' 69 F (21 C)', ' 53 F (12 C)', ' 56%', ' 30.06 in. Hg (1018 hPa)', 21, '<b style="color: red;">Server Offline. Data from database.</b>'),
(42, 'Krakow, Poland (EPKK) 50-05N 019-48E 237M', 'Jul 16, 2015 - 01:30 PM EDT / 2015.07.16 1730 UTC', ' from the S (170 degrees) at 2 MPH (2 KT):0', ' greater than 7 mile(s):0', ' mostly clear', ' 78 F (26 C)', ' 59 F (15 C)', ' 50%', ' 30.06 in. Hg (1018 hPa)', 24, '<b style="color: red;">Server Offline. Data from database.</b>');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `weather`
--
ALTER TABLE `weather`
  ADD CONSTRAINT `city_id` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
