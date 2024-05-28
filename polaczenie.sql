-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 28, 2024 at 08:13 PM
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
-- Struktura tabeli dla tabeli `adresy`
--

CREATE TABLE `adresy` (
  `id_adresu` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `Miejscowosc` varchar(60) NOT NULL,
  `Ulica` varchar(30) NOT NULL,
  `Adres` varchar(20) NOT NULL,
  `Kod_pocztowy` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `adresy`
--

INSERT INTO `adresy` (`id_adresu`, `id_klienta`, `Miejscowosc`, `Ulica`, `Adres`, `Kod_pocztowy`) VALUES
(1, 13, 'Tuczna', 'Brak', '158A', '21-523'),
(2, 13, 'Biała Podlaska', 'Bolesława Chrobrego ', '3', '21-500'),
(3, 13, 'Warszawa', 'Polna', '3', '21-500');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `kategorie`
--

CREATE TABLE `kategorie` (
  `id_kategorii` int(11) NOT NULL,
  `nazwa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategorie`
--

INSERT INTO `kategorie` (`id_kategorii`, `nazwa`) VALUES
(2, 'Monitory'),
(3, 'Myszki'),
(4, 'Urzadzenia');

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
-- Struktura tabeli dla tabeli `koszyk10`
--

CREATE TABLE `koszyk10` (
  `id_przedmiotu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk11`
--

CREATE TABLE `koszyk11` (
  `id_przedmiotu` int(11) DEFAULT NULL,
  `ilosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk12`
--

CREATE TABLE `koszyk12` (
  `id_przedmiotu` int(11) DEFAULT NULL,
  `ilosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `koszyk13`
--

CREATE TABLE `koszyk13` (
  `id_przedmiotu` int(11) DEFAULT NULL,
  `ilosc` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `koszyk13`
--

INSERT INTO `koszyk13` (`id_przedmiotu`, `ilosc`) VALUES
(1, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opinie`
--

CREATE TABLE `opinie` (
  `id_opini` int(11) NOT NULL,
  `Imie` varchar(80) NOT NULL,
  `tekst` text NOT NULL,
  `gwiazdki` int(1) NOT NULL,
  `data_dodania` date NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opinie`
--

INSERT INTO `opinie` (`id_opini`, `Imie`, `tekst`, `gwiazdki`, `data_dodania`) VALUES
(4, 'Aleksander Lipka', 'Mega strona zamowiłem już z 15 rzeczy i wszystko było w porządku', 5, '2024-05-23'),
(5, 'Adam Nowak', 'Zamowienie nie przyszlo SCAM', 1, '2024-05-23'),
(6, 'Michał Kowalski', 'Test opini ', 5, '2024-05-27');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `opinieprzedmiotow`
--

CREATE TABLE `opinieprzedmiotow` (
  `id_opini` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `il_gwiazdek` int(11) NOT NULL,
  `tresc` text NOT NULL,
  `data` date NOT NULL DEFAULT current_timestamp(),
  `id_klienta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `opinieprzedmiotow`
--

INSERT INTO `opinieprzedmiotow` (`id_opini`, `id_przedmiotu`, `il_gwiazdek`, `tresc`, `data`, `id_klienta`) VALUES
(1, 3, 5, 'Bardzo dobry produkt', '2024-05-28', 11),
(2, 3, 1, 'Nie fajny produkt', '2024-05-28', 11),
(3, 3, 1, 'test', '2024-05-28', 11),
(4, 3, 1, 'test', '2024-05-28', 11),
(5, 3, 5, 'Faje', '2024-05-28', 11);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `przedmioty`
--

CREATE TABLE `przedmioty` (
  `id_przedmiotu` int(11) NOT NULL,
  `nazwa` varchar(40) NOT NULL,
  `cena` double NOT NULL,
  `krotki_opis` text NOT NULL,
  `opis` text NOT NULL,
  `ilosc` int(11) NOT NULL,
  `id_kategorii` int(11) NOT NULL,
  `sciezka` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `przedmioty`
--

INSERT INTO `przedmioty` (`id_przedmiotu`, `nazwa`, `cena`, `krotki_opis`, `opis`, `ilosc`, `id_kategorii`, `sciezka`) VALUES
(1, 'Kilof', 99.99, 'Kilof. Masa kilofa: 1500 g. Trzonek kilofa (tylec, stylisko): drewniany o długości 90 cm. Kilof do rozluźniania twardej, zbitej kamienistej ziemi (Pick, Spitzhacke). ', '✔ Kilof to narzędzie służące do rozbijania skał i wstępnego kruszenia twardego gruntu, który następnie można usunąć np. łopatą. Kilofy są używane w górnictwie i kamieniołomach ( kamieniarstwie)\r\n\r\n✔ Istnieją dwa rodzaje kilofów, a mianowicie kilof dwustronny i kilof jednostronny. W zależności od zastosowania można wybrać odpowiedni model.\r\n\r\n✔ Kilof BAUSTER doskonale sprawdza się w szerokim zakresie prac w budownictwie, ogrodnictwie i rolnictwie. Pomimo głównego obszaru zastosowania w górnictwie, może być również używany w wielu innych dziedzinach.\r\n\r\n✔ Przy rozbijaniu twardego gruntu kilof jest niezastąpiony, możemy go również wykorzystać do szybkiego i sprawnego wykonania pracy w wielu innych pracach związanych ze skałami, twardym podłożem czy węglem.\r\n\r\n✔ Odpowiednie narzędzie do wykonywanej pracy decyduje o czasie i jakości. Dlatego warto wyposażyć swoją skrzynkę narzędziową w nasz bardzo przydatny kilof BAUSTER', 11, 4, 'kilof.jpg'),
(2, 'Klawiatura', 199.99, 'Klawiatura to wysokiej jakości urządzenie zaprojektowane do zapewnienia wydajnego i wygodnego doświadczenia pisania oraz interakcji z komputerem. Ta klawiatura oferuje ergonomiczny układ klawiszy, który zapewnia komfort i efektywność podczas długotrwałego użytkowania. Zintegrowane funkcje multimedialne umożliwiają łatwy dostęp do sterowania odtwarzaniem multimediów, a jej solidna konstrukcja zapewnia trwałość i wytrzymałość. Klawiatura jest kompatybilna z różnymi systemami operacyjnymi i idealnie nadaje się do użytku domowego, biurowego lub gamingowego', 'Klawiatura gamingowa – czym różni się od innych i dlaczego warto ją wybrać? Co decyduje o tym, że pewne modele wprost stworzone są do profesjonalnego grania? Na jakie jeszcze parametry zwrócić uwagę przed zakupem i jaki rodzaj przełączników sprawdzi się najlepiej? Tego wszystkiego dowiesz się z poradnika.\r\n\r\nNa rynku akcesoriów komputerowych możemy spotkać wiele urządzeń opatrzonych dopiskiem: gamingowy. Częste użycie tego określenia sprawiło, że niekiedy brzmi już ono dość wyświechtanie, co w humorystyczny sposób wykorzystała marka Razer wypuszczając swój…gamingowy toster. Jeżeli interesuje Cię ta oraz inne ciekawostki ze świata technologii, to zapraszamy po więcej na nasz portal Geex.\r\n\r\nBądź co bądź, choć zdarza się, że niektóre produkty z tagiem: dla graczy kategoryzowane są trochę nad wyrost, to jednak większość takich urządzeń faktycznie się wyróżnia. A to, co dla gamerów, utożsamiane jest w uproszczeniu z tym, co profesjonalne, specjalistyczne. Wynika to ze szczególnych potrzeb graczy, a raczej specyfiki gier turniejowych, o czym w dalszej części tekstu.\r\n\r\nOstatecznie jednak klawiatura, jak i inne rzeczy stworzone z myślą o graczach, ma ułatwiać zdobywanie jak najlepszych wyników i być przy tym wygodna. Ale jaki typ sprawdzi się w tym najlepiej?', 0, 4, 'klawiatura.jpg'),
(3, 'Myszka', 149.99, 'Nasza oferta myszek obejmuje różnorodne modele, od tradycyjnych przewodowych po zaawansowane bezprzewodowe. Zapewniają one precyzyjną kontrolę i wygodę podczas użytkowania komputera. Dzięki ergonomicznemu designowi i dokładnym sensorom zapewniają płynne działanie, zarówno podczas pracy, jak i grania. Dodatkowe funkcje, takie jak regulowana czułość i programowalne przyciski, pozwalają dostosować mysz do indywidualnych potrzeb.', 'Klawiatura gamingowa – czym różni się od innych i dlaczego warto ją wybrać? Co decyduje o tym, że pewne modele wprost stworzone są do profesjonalnego grania? Na jakie jeszcze parametry zwrócić uwagę przed zakupem i jaki rodzaj przełączników sprawdzi się najlepiej? Tego wszystkiego dowiesz się z poradnika.\r\n\r\nNa rynku akcesoriów komputerowych możemy spotkać wiele urządzeń opatrzonych dopiskiem: gamingowy. Częste użycie tego określenia sprawiło, że niekiedy brzmi już ono dość wyświechtanie, co w humorystyczny sposób wykorzystała marka Razer wypuszczając swój…gamingowy toster. Jeżeli interesuje Cię ta oraz inne ciekawostki ze świata technologii, to zapraszamy po więcej na nasz portal Geex.\r\n\r\nBądź co bądź, choć zdarza się, że niektóre produkty z tagiem: dla graczy kategoryzowane są trochę nad wyrost, to jednak większość takich urządzeń faktycznie się wyróżnia. A to, co dla gamerów, utożsamiane jest w uproszczeniu z tym, co profesjonalne, specjalistyczne. Wynika to ze szczególnych potrzeb graczy, a raczej specyfiki gier turniejowych, o czym w dalszej części tekstu.\r\n\r\nOstatecznie jednak klawiatura, jak i inne rzeczy stworzone z myślą o graczach, ma ułatwiać zdobywanie jak najlepszych wyników i być przy tym wygodna. Ale jaki typ sprawdzi się w tym najlepiej?', 2, 3, 'myszka.jpg'),
(4, 'Monitor', 999.99, 'Nasz monitor to doskonałe rozwiązanie dla osób poszukujących wysokiej jakości wyświetlacza do pracy lub rozrywki. Zaoferuje Ci jasny obraz o żywych kolorach i ostrości. Dzięki ergonomicznemu designowi i funkcjom regulacji możesz dostosować ustawienia monitora do swoich preferencji, zapewniając wygodę podczas długotrwałego korzystania. Bez względu na to, czy pracujesz, oglądasz filmy czy grasz, nasz monitor z pewnością spełni Twoje oczekiwania.', 'Philips 273V7QDSB/00\r\nMonitor 27 \" Philips LED Full HD HDMI V Line czarny\r\n✔  przekątna: 27\"\r\n\r\n✔  technologia: TFT IPS\r\n\r\n✔  rozdzielczość: 1920 x 1080 px\r\n\r\n✔  czas reakcji: 5 ms\r\n\r\n✔  kontrast dynamiczny: 10000000:1\r\n\r\n✔  kontrast typowy: 1000:1\r\n\r\n✔  złącza: 1x D-Sub, 1x DVI-D, 1x HDMI\r\n\r\n✔  dodatkowe wyposażenie: dokumentacja użytkownika, przewód D-Sub, przewód zasilający\r\n\r\nMonitor 27 &quot; Philips 273V7QDSB/00 LED Full HD HDMI V Line czarny\r\nCechy:\r\n✅  Technologia IPS LED zapewnia szerszy kąt widzenia oraz lepszą dokładność obrazu i wierność kolorów\r\n\r\nMonitory IPS wykorzystują zaawansowaną technologię, która zapewnia wyjątkowo szeroki kąt widzenia wynoszący 178/178 stopni, umożliwiając oglądanie treści na monitorze pod niemal każdym kątem! W przeciwieństwie do standardowej technologii TN, technologia IPS zapewnia wyjątkowo ostre obrazy i żywe kolory. Dzięki temu technologia ta idealnie nadaje się do zdjęć, filmów i Internetu, ale także do zastosowań profesjonalnych, w których obowiązują wysokie wymagania dotyczące wierności i spójności kolorów.\r\n\r\n✅  Monitor Full HD 16:9 zapewnia szczegółowy obraz\r\n\r\nTen monitor ma ulepszoną rozdzielczość Full HD wynoszącą 1920 x 1080. Dzięki rozdzielczości Full HD zapewniającej wyraźne szczegóły, wysoką jasność, niesamowity kontrast i realistyczne kolory, możesz cieszyć się realistycznym obrazem.\r\n\r\n✅  SmartContrast zapewnia głęboką czerń i większe bogactwo szczegółów', 19, 2, 'monitor.jpg'),
(5, 'Obudowa', 14.99, 'Nasza obudowa komputerowa to nie tylko praktyczne rozwiązanie do przechowywania komponentów komputera, ale także estetyczny element Twojego stanowiska. Solidna konstrukcja zapewnia ochronę Twojego sprzętu, jednocześnie umożliwiając łatwy dostęp do wnętrza w razie potrzeby. Dostępne są różne rozmiary i style, aby dopasować się do Twoich preferencji i potrzeb. Wybierz obudowę, która pozwoli Ci stworzyć wyjątkowy i funkcjonalny zestaw komputerowy.', 'Specyfikacja\r\n\r\nPanel przedni: Szklany\r\nLewy panel boczny: okno akrylowe\r\nPrawy panel boczny: Prawa osłona boczna metalowa czerń SPCC 0,45 mm, czarne wewnątrz, 0,5 mm na zewnątrz\r\nZłącza: USB 3.0 x 2, USB 2.0 x 2 + HD Audio x 1 (w zestawie)\r\nMontaż zasilacza ATX: Dolny\r\nObsługiwane formaty płyt głównych: ATX / M ATX / ITX\r\nMontaż wentylatorów:  Przód: 3 x 120 mm (w zestawie) Tył: 1 x 120 mm (w zestawie) Góra: 2 x 120 mm (opcjonalnie)\r\n3,5-calowy dysk twardy: 2\r\n2,5-calowy dysk SSD: 2\r\nGniazda PCI: 7\r\nStruktura: 340 x 190 x 430 mm\r\nObudowa: 400 * 190 * 440 mm\r\nWaga netto: 4,4 kg\r\nMaksymalne wymiary Karty VGA: 310 mm\r\nMaksymalna wymiary chłodzenia procesora: 160 mm\r\nChłodzenie Wodne wymiary maksymalne: przód 240 mm', 87, 4, 'obudowa.jpg');

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
  `wiek` int(11) NOT NULL,
  `login` text NOT NULL,
  `haslo` varchar(255) NOT NULL,
  `Klasa` varchar(30) NOT NULL DEFAULT 'Uzytkownik'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `imie`, `nazwisko`, `email`, `telefon`, `wiek`, `login`, `haslo`, `Klasa`) VALUES
(11, 'Olek', 'ASASA', 'lukasiak@gmail.com', '2132343421', 12, 'Olipoli', '$2y$10$WzAIHZfVw648gggdfZ5i1O5yAlX6MRVXXKhKZErBVPHCBlFcvraHe', 'Uzytkownik'),
(12, 'Pawel', 'Lipka', 'XD@gmail.com', '2132343421', 37, 'Olipoli123', '$2y$10$WOmywK.O9LIKtpTtFQ9uNu657vuAobSK2RMXKSLsc7T1dDdShapI6', 'Uzytkownik'),
(13, 'Olek', 'Lipka', 'mikosialipka@gmail.com', '2132343421', 423, 'Olipoli1', '$2y$10$Xa4Q42Xwpb3g9/S3Aj777uqtv0FsG1cfuaaxRIBjjI74xlX5fqu3e', 'Uzytkownik');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zamowieniaklientow`
--

CREATE TABLE `zamowieniaklientow` (
  `Id_zamowienia` int(11) NOT NULL,
  `id_uzytkownika` int(11) NOT NULL,
  `id_adresu` int(11) NOT NULL,
  `Data` datetime NOT NULL DEFAULT current_timestamp(),
  `Laczna_Kwota` double NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zamowieniaklientow`
--

INSERT INTO `zamowieniaklientow` (`Id_zamowienia`, `id_uzytkownika`, `id_adresu`, `Data`, `Laczna_Kwota`, `Status`) VALUES
(18, 13, 1, '2024-05-28 14:13:00', 1114, 0),
(19, 13, 2, '2024-05-28 14:59:15', 99, 0);

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
(18, 1, 1),
(18, 4, 1),
(18, 5, 1),
(19, 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `zdjecia`
--

CREATE TABLE `zdjecia` (
  `id_zdjecia` int(11) NOT NULL,
  `id_przedmiotu` int(11) NOT NULL,
  `sciezka` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `zdjecia`
--

INSERT INTO `zdjecia` (`id_zdjecia`, `id_przedmiotu`, `sciezka`) VALUES
(1, 1, 'kilof1.jpg'),
(2, 1, 'kilof2.jpg'),
(3, 1, 'kilof3.jpg'),
(4, 1, 'kilof4.jpg'),
(5, 2, 'klawa1.jpg'),
(6, 2, 'klawa2.jpg'),
(7, 2, 'klawa3.jpg'),
(8, 2, 'klawa4.jpg'),
(9, 3, 'myszka1.jpg'),
(10, 3, 'myszka2.jpg'),
(11, 3, 'myszka3.jpg'),
(12, 3, 'myszka4.jpg'),
(13, 3, 'myszka5.jpg'),
(14, 3, 'myszka6.jpg'),
(15, 3, 'myszka7.jpg'),
(16, 4, 'm1.jpg'),
(17, 4, 'm2.jpg'),
(18, 4, 'm3.jpg'),
(19, 4, 'm4.jpg'),
(20, 5, 'o1.jpg'),
(21, 5, 'o2.jpg'),
(22, 5, 'o3.jpg'),
(23, 5, 'o4.jpg'),
(24, 5, 'o5.jpg'),
(25, 5, 'o6.jpg');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `adresy`
--
ALTER TABLE `adresy`
  ADD PRIMARY KEY (`id_adresu`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `kategorie`
--
ALTER TABLE `kategorie`
  ADD PRIMARY KEY (`id_kategorii`);

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
-- Indeksy dla tabeli `koszyk10`
--
ALTER TABLE `koszyk10`
  ADD KEY `id_przedmiotu` (`id_przedmiotu`);

--
-- Indeksy dla tabeli `koszyk11`
--
ALTER TABLE `koszyk11`
  ADD KEY `id_przedmiotu` (`id_przedmiotu`);

--
-- Indeksy dla tabeli `koszyk12`
--
ALTER TABLE `koszyk12`
  ADD KEY `id_przedmiotu` (`id_przedmiotu`);

--
-- Indeksy dla tabeli `koszyk13`
--
ALTER TABLE `koszyk13`
  ADD KEY `id_przedmiotu` (`id_przedmiotu`);

--
-- Indeksy dla tabeli `opinie`
--
ALTER TABLE `opinie`
  ADD PRIMARY KEY (`id_opini`);

--
-- Indeksy dla tabeli `opinieprzedmiotow`
--
ALTER TABLE `opinieprzedmiotow`
  ADD PRIMARY KEY (`id_opini`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `przedmioty`
--
ALTER TABLE `przedmioty`
  ADD PRIMARY KEY (`id_przedmiotu`),
  ADD KEY `id_kategorii` (`id_kategorii`);

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `zamowieniaklientow`
--
ALTER TABLE `zamowieniaklientow`
  ADD PRIMARY KEY (`Id_zamowienia`),
  ADD KEY `id_uzytkownika` (`id_uzytkownika`),
  ADD KEY `id_adresu` (`id_adresu`);

--
-- Indeksy dla tabeli `zamowioneprzedmioty`
--
ALTER TABLE `zamowioneprzedmioty`
  ADD KEY `Id_zamowienia` (`Id_zamowienia`);

--
-- Indeksy dla tabeli `zdjecia`
--
ALTER TABLE `zdjecia`
  ADD PRIMARY KEY (`id_zdjecia`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adresy`
--
ALTER TABLE `adresy`
  MODIFY `id_adresu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategorie`
--
ALTER TABLE `kategorie`
  MODIFY `id_kategorii` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `opinie`
--
ALTER TABLE `opinie`
  MODIFY `id_opini` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `opinieprzedmiotow`
--
ALTER TABLE `opinieprzedmiotow`
  MODIFY `id_opini` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `przedmioty`
--
ALTER TABLE `przedmioty`
  MODIFY `id_przedmiotu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `zamowieniaklientow`
--
ALTER TABLE `zamowieniaklientow`
  MODIFY `Id_zamowienia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `zdjecia`
--
ALTER TABLE `zdjecia`
  MODIFY `id_zdjecia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `adresy`
--
ALTER TABLE `adresy`
  ADD CONSTRAINT `adresy_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `uzytkownicy` (`id`);

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
-- Constraints for table `koszyk10`
--
ALTER TABLE `koszyk10`
  ADD CONSTRAINT `koszyk10_ibfk_1` FOREIGN KEY (`id_przedmiotu`) REFERENCES `przedmioty` (`id_przedmiotu`);

--
-- Constraints for table `koszyk11`
--
ALTER TABLE `koszyk11`
  ADD CONSTRAINT `koszyk11_ibfk_1` FOREIGN KEY (`id_przedmiotu`) REFERENCES `przedmioty` (`id_przedmiotu`);

--
-- Constraints for table `koszyk12`
--
ALTER TABLE `koszyk12`
  ADD CONSTRAINT `koszyk12_ibfk_1` FOREIGN KEY (`id_przedmiotu`) REFERENCES `przedmioty` (`id_przedmiotu`);

--
-- Constraints for table `koszyk13`
--
ALTER TABLE `koszyk13`
  ADD CONSTRAINT `koszyk13_ibfk_1` FOREIGN KEY (`id_przedmiotu`) REFERENCES `przedmioty` (`id_przedmiotu`);

--
-- Constraints for table `opinieprzedmiotow`
--
ALTER TABLE `opinieprzedmiotow`
  ADD CONSTRAINT `opinieprzedmiotow_ibfk_1` FOREIGN KEY (`id_klienta`) REFERENCES `uzytkownicy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `przedmioty`
--
ALTER TABLE `przedmioty`
  ADD CONSTRAINT `przedmioty_ibfk_1` FOREIGN KEY (`id_kategorii`) REFERENCES `kategorie` (`id_kategorii`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zamowieniaklientow`
--
ALTER TABLE `zamowieniaklientow`
  ADD CONSTRAINT `zamowieniaklientow_ibfk_2` FOREIGN KEY (`id_uzytkownika`) REFERENCES `uzytkownicy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `zamowieniaklientow_ibfk_3` FOREIGN KEY (`id_adresu`) REFERENCES `adresy` (`id_adresu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `zamowioneprzedmioty`
--
ALTER TABLE `zamowioneprzedmioty`
  ADD CONSTRAINT `zamowioneprzedmioty_ibfk_1` FOREIGN KEY (`Id_zamowienia`) REFERENCES `zamowieniaklientow` (`Id_zamowienia`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
