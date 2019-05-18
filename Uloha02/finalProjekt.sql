-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost:3306
-- Vytvořeno: Sob 18. kvě 2019, 10:36
-- Verze serveru: 5.7.25-0ubuntu0.18.04.2
-- Verze PHP: 7.2.15-0ubuntu0.18.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `finalProjekt`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `clenovaTimov`
--

CREATE TABLE `clenovaTimov` (
  `ID` int(11) NOT NULL,
  `IDziaka` int(5) NOT NULL,
  `IDtimu` int(11) NOT NULL,
  `jeKapitan` tinyint(1) NOT NULL,
  `body` float DEFAULT NULL,
  `suhlas` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Vypisuji data pro tabulku `clenovaTimov`
--

INSERT INTO `clenovaTimov` (`ID`, `IDziaka`, `IDtimu`, `jeKapitan`, `body`, `suhlas`) VALUES
(3, 86223, 2, 1, 42, 1),
(4, 86247, 2, 0, 0, 1),
(5, 86247, 3, 1, 25, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `predmety`
--

CREATE TABLE `predmety` (
  `ID` int(11) NOT NULL,
  `nazov` varchar(255) COLLATE utf8mb4_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Vypisuji data pro tabulku `predmety`
--

INSERT INTO `predmety` (`ID`, `nazov`) VALUES
(1, 'Webtech2'),
(2, 'VSA');

-- --------------------------------------------------------

--
-- Struktura tabulky `studenti`
--

CREATE TABLE `studenti` (
  `ID` int(5) NOT NULL,
  `meno` varchar(255) COLLATE utf8mb4_slovak_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_slovak_ci NOT NULL,
  `heslo` varchar(255) COLLATE utf8mb4_slovak_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Vypisuji data pro tabulku `studenti`
--

INSERT INTO `studenti` (`ID`, `meno`, `email`, `heslo`) VALUES
(86223, 'Nicolas Macák', 'macak.nicolas@gmail.com', NULL),
(86247, 'Samuel Palaj', 'dsada', 'dasda');

-- --------------------------------------------------------

--
-- Struktura tabulky `timy`
--

CREATE TABLE `timy` (
  `ID` int(11) NOT NULL,
  `cisloTimu` int(3) NOT NULL,
  `IDpredmetu` int(11) NOT NULL,
  `rok` int(4) NOT NULL,
  `body` float DEFAULT NULL,
  `schvaleneKapitanom` tinyint(1) DEFAULT NULL,
  `schvaleneAdminom` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovak_ci;

--
-- Vypisuji data pro tabulku `timy`
--

INSERT INTO `timy` (`ID`, `cisloTimu`, `IDpredmetu`, `rok`, `body`, `schvaleneKapitanom`, `schvaleneAdminom`) VALUES
(2, 1, 1, 2019, 55, 1, NULL),
(3, 7, 2, 2019, 56, 1, NULL);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `clenovaTimov`
--
ALTER TABLE `clenovaTimov`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDziaka` (`IDziaka`),
  ADD KEY `IDtimu` (`IDtimu`);

--
-- Klíče pro tabulku `predmety`
--
ALTER TABLE `predmety`
  ADD PRIMARY KEY (`ID`);

--
-- Klíče pro tabulku `studenti`
--
ALTER TABLE `studenti`
  ADD PRIMARY KEY (`ID`);

--
-- Klíče pro tabulku `timy`
--
ALTER TABLE `timy`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `IDpredmetu` (`IDpredmetu`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `clenovaTimov`
--
ALTER TABLE `clenovaTimov`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pro tabulku `predmety`
--
ALTER TABLE `predmety`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `timy`
--
ALTER TABLE `timy`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `clenovaTimov`
--
ALTER TABLE `clenovaTimov`
  ADD CONSTRAINT `clenovaTimov_ibfk_1` FOREIGN KEY (`IDtimu`) REFERENCES `timy` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `clenovaTimov_ibfk_2` FOREIGN KEY (`IDziaka`) REFERENCES `studenti` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `timy`
--
ALTER TABLE `timy`
  ADD CONSTRAINT `timy_ibfk_1` FOREIGN KEY (`IDpredmetu`) REFERENCES `predmety` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
