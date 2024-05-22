-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 22, 2024 at 09:54 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `polaczenie`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `dostawy`
--

CREATE TABLE `dostawy` (
  `id_dostawy` int(11) NOT NULL,
  `id_zamowienia` int(11) NOT NULL,
  `Miejscowosc` varchar(40) NOT NULL,
  `Ulica` varchar(30) NOT NULL,
  `Adres` varchar(20) NOT NULL,
  `Kod_pocztowy` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dostawy`
--

INSERT INTO `dostawy` (`id_dostawy`, `id_zamowienia`, `Miejscowosc`, `Ulica`, `Adres`, `Kod_pocztowy`) VALUES
(1, 14, 'Tuczna', 'Brak', '158A', '21-523'),
(2, 15, '', '', '', '');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk`
--

CREATE TABLE `koszyk` (
  `id_przedmiotu` int(11) DEFAULT NULL,
  `ilosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk2`
--

CREATE TABLE `koszyk2` (
  `id_przedmiotu` int(11) DEFAULT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `koszyk2`
--

INSERT INTO `koszyk2` (`id_przedmiotu`, `ilosc`) VALUES
(1, 1),
(3, 1),
(4, 1),
(5, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk3`
--

CREATE TABLE `koszyk3` (
  `id_przedmiotu` int(11) DEFAULT NULL,
  `ilosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk5`
--

CREATE TABLE `koszyk5` (
  `id_przedmiotu` int(11) DEFAULT NULL,
  `ilosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk6`
--

CREATE TABLE `koszyk6` (
  `id_przedmiotu` int(11) DEFAULT NULL,
  `ilosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk7`
--

CREATE TABLE `koszyk7` (
  `id_przedmiotu` int(11) DEFAULT NULL,
  `ilosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedmioty`
--

CREATE TABLE `przedmioty` (
  `id_przedmiotu` int(11) NOT NULL,
  `nazwa` varchar(40) NOT NULL,
  `cena` double NOT NULL,
  `ilosc` int(11) NOT NULL,
  `sciezka` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `przedmioty`
--

INSERT INTO `przedmioty` (`id_przedmiotu`, `nazwa`, `cena`, `ilosc`, `sciezka`) VALUES
(1, 'Kilof', 99.99, 14, 'kilof.jpg'),
(2, 'Klawiatura', 199.99, 0, 'klawiatura.jpg'),
(3, 'Myszka', 149.99, 6, 'myszka.jpg'),
(4, 'Monitor', 999.99, 22, 'monitor.jpg'),
(5, 'Obudowa', 14.99, 90, 'obudowa.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `imie` text NOT NULL,
  `nazwisko` text NOT NULL,
  `email` text NOT NULL,
  `telefon` text NOT NULL,
  `wiek` text NOT NULL,
  `login` text NOT NULL,
  `haslo` text NOT NULL,
  `Klasa` varchar(30) NOT NULL DEFAULT 'Uzytkownik'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `imie`, `nazwisko`, `email`, `telefon`, `wiek`, `login`, `haslo`, `Klasa`) VALUES
(1, 'Pawel', 'Lukasiak', 'lukasiak@gmail.com', '2132343421', '37', 'Pawel', '1234', 'Uzytkownik'),
(2, 'Olek', 'Lipka', 'mikosialipka@gmail.com', '515937170', '17', 'Olipoli', 'Aleksander1', 'Uzytkownik'),
(3, 'Aleksander', 'Kowalski', 'XD@gmail.com', '21212121', '32', 'LmaoEssa', 'Olipoli420', 'Uzytkownik'),
(6, 'Olipoli420', 'admin123', 'admin@gmail.com', '12121212121', '49', 'Olipoli420', 'admin123', 'Admin'),
(7, 'SDSD', 'ASASA', 'asASas', '12121', '12', 'Twoja mama', 'ALeksander1', 'Uzytkownik');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowieniaklientow`
--

CREATE TABLE `zamowieniaklientow` (
  `Id_zamowienia` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `Data` datetime NOT NULL DEFAULT current_timestamp(),
  `Laczna_Kwota` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowieniaklientow`
--

INSERT INTO `zamowieniaklientow` (`Id_zamowienia`, `id_uzytkownika`, `Data`, `Laczna_Kwota`) VALUES
(14, 2, '2024-05-22 11:31:02', 1329.95),
(15, 2, '2024-05-22 21:36:07', 2414.94);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowioneprzedmioty`
--

CREATE TABLE `zamowioneprzedmioty` (
  `Id_zamowienia` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowioneprzedmioty`
--

INSERT INTO `zamowioneprzedmioty` (`Id_zamowienia`, `id_przedmiotu`, `ilosc`) VALUES
(14, 3, 2),
(14, 4, 1),
(14, 5, 2),
(15, 3, 2),
(15, 4, 2),
(15, 5, 1),
(15, 1, 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `dostawy`
--
ALTER TABLE `dostawy`
  ADD PRIMARY KEY (`id_dostawy`);

--
-- Indeksy dla tabeli `koszyk`
--
ALTER TABLE `koszyk`
  ADD KEY `id_przedmiotu` (`id_przedmiotu`);

--
-- Indeksy dla tabeli `koszyk2`
--
ALTER TABLE `koszyk2`
  ADD KEY `id_przedmiotu` (`id_przedmiotu`);

--
-- Indeksy dla tabeli `koszyk3`
--
ALTER TABLE `koszyk3`
  ADD KEY `id_przedmiotu` (`id_przedmiotu`);

--
-- Indeksy dla tabeli `koszyk5`
--
ALTER TABLE `koszyk5`
  ADD KEY `id_przedmiotu` (`id_przedmiotu`);

--
-- Indeksy dla tabeli `koszyk6`
--
ALTER TABLE `koszyk6`
  ADD KEY `id_przedmiotu` (`id_przedmiotu`);

--
-- Indeksy dla tabeli `koszyk7`
--
ALTER TABLE `koszyk7`
  ADD KEY `id_przedmiotu` (`id_przedmiotu`);

--
-- Indeksy dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  ADD PRIMARY KEY (`id_przedmiotu`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zamowieniaklientow`
--
ALTER TABLE `zamowieniaklientow`
  ADD PRIMARY KEY (`Id_zamowienia`);

--
-- Indeksy dla tabeli `zamowioneprzedmioty`
--
ALTER TABLE `zamowioneprzedmioty`
  ADD KEY `Id_zamowienia` (`Id_zamowienia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dostawy`
--
ALTER TABLE `dostawy`
  MODIFY `id_dostawy` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `przedmioty`
--
ALTER TABLE `przedmioty`
  MODIFY `id_przedmiotu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `zamowieniaklientow`
--
ALTER TABLE `zamowieniaklientow`
  MODIFY `Id_zamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `koszyk`
--
ALTER TABLE `koszyk`
  ADD CONSTRAINT `koszyk_ibfk_1` FOREIGN KEY (`id_przedmiotu`) REFERENCES `przedmioty` (`id_przedmiotu`);

--
-- Constraints for table `koszyk2`
--
ALTER TABLE `koszyk2`
  ADD CONSTRAINT `koszyk2_ibfk_1` FOREIGN KEY (`id_przedmiotu`) REFERENCES `przedmioty` (`id_przedmiotu`);

--
-- Constraints for table `koszyk3`
--
ALTER TABLE `koszyk3`
  ADD CONSTRAINT `koszyk3_ibfk_1` FOREIGN KEY (`id_przedmiotu`) REFERENCES `przedmioty` (`id_przedmiotu`);

--
-- Constraints for table `koszyk5`
--
ALTER TABLE `koszyk5`
  ADD CONSTRAINT `koszyk5_ibfk_1` FOREIGN KEY (`id_przedmiotu`) REFERENCES `przedmioty` (`id_przedmiotu`);

--
-- Constraints for table `koszyk6`
--
ALTER TABLE `koszyk6`
  ADD CONSTRAINT `koszyk6_ibfk_1` FOREIGN KEY (`id_przedmiotu`) REFERENCES `przedmioty` (`id_przedmiotu`);

--
-- Constraints for table `koszyk7`
--
ALTER TABLE `koszyk7`
  ADD CONSTRAINT `koszyk7_ibfk_1` FOREIGN KEY (`id_przedmiotu`) REFERENCES `przedmioty` (`id_przedmiotu`);

--
-- Constraints for table `zamowioneprzedmioty`
--
ALTER TABLE `zamowioneprzedmioty`
  ADD CONSTRAINT `zamowioneprzedmioty_ibfk_1` FOREIGN KEY (`Id_zamowienia`) REFERENCES `zamowieniaklientow` (`Id_zamowienia`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
