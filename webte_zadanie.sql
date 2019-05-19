-- phpMyAdmin SQL Dump
-- version 4.6.6deb5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: May 19, 2019 at 05:56 PM
-- Server version: 5.7.25-0ubuntu0.18.04.2
-- PHP Version: 7.2.15-0ubuntu0.18.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webte_zadanie`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `login` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `login`, `password`) VALUES
(1, 'admin', '$2y$10$iR1WFDzGHzjq8WQQqweFSuf9uU66/9tCaXJgsw3oZEtZnhTKrIv0S');

-- --------------------------------------------------------

--
-- Table structure for table `email`
--

CREATE TABLE `email` (
  `id` int(11) NOT NULL,
  `name` varchar(1000) NOT NULL,
  `subject` varchar(1000) NOT NULL,
  `date` varchar(1000) NOT NULL,
  `sablona` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `email`
--

INSERT INTO `email` (`id`, `name`, `subject`, `date`, `sablona`) VALUES
(55, 'Priezvisko1 Meno1', 'Prihalsovacie udaje na webte2', '12.05.2019', 31),
(56, 'Priezvisko2 Meno2', 'Prihalsovacie udaje na webte2', '12.05.2019', 31),
(57, 'Priezvisko3 Meno3', 'Prihalsovacie udaje na webte2', '12.05.2019', 31),
(58, 'Priezvisko4 Meno4', 'Prihalsovacie udaje na webte2', '12.05.2019', 31),
(59, 'Priezvisko1 Meno1', 'Prihalsovacie udaje na webte2', '12.05.2019', 31),
(60, 'Jozef Malcoh', 'Prihlasovacie udaje ', '12.05.2019', 31),
(61, 'Kalivoda Kristian', 'Prihlasovacie udaje ', '12.05.2019', 31),
(62, 'Jozef Malcoh', 'Dalsi mail', '12.05.2019', 32),
(63, 'Kalivoda Kristian', 'Dalsi mail', '12.05.2019', 32),
(64, 'Jozef Malcoh', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(65, 'Kalivoda Kristian', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(66, 'Jakub Matusov', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(67, 'Jozef Malcoh', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(68, 'Jozef Malcoh', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(69, 'Jozef Malcoh', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(70, 'Jozef Malcoh', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(71, 'Jozef Malcoh', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(72, 'Kalivoda Kristian', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(73, 'Kalivoda Kristian', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(74, 'Kalivoda Kristian', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(75, 'Kalivoda Kristian', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(76, 'Kalivoda Kristian', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(77, 'Jakub Matusov', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(78, 'Jakub Matusov', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(79, 'Jakub Matusov', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(80, 'Jakub Matusov', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(81, 'Jakub Matusov', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(82, 'Jozef Malcoh', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(83, 'Kalivoda Kristian', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(84, 'Jakub Matusov', 'Finalny mail na prihalsenie', '12.05.2019', 33),
(85, 'Jozef Malcoh', 'test', '19.05.2019', 32),
(86, 'Kalivoda Kristian', 'test', '19.05.2019', 32),
(87, 'Jozef Malcoh', 'testik finalny', '19.05.2019', 33),
(88, 'Kalivoda Kristian', 'testik finalny', '19.05.2019', 33);

-- --------------------------------------------------------

--
-- Table structure for table `sablona`
--

CREATE TABLE `sablona` (
  `id` int(11) NOT NULL,
  `text` varchar(10000) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci NOT NULL,
  `name` varchar(50) NOT NULL,
  `plain` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sablona`
--

INSERT INTO `sablona` (`id`, `text`, `name`, `plain`) VALUES
(31, '<p>Dobrý deň,</p><p>na predmete Webové technológie 2 budete mať k dispozícii vlastný virtuálny linux server, ktorý budete</p><p>používať počas semestra, a na ktorom budete vypracovávať zadania. Prihlasovacie údaje k Vašemu serveru</p><p>su uvedené nižšie.</p><p>ip adresa: {{verejnaIP}}</p><p>prihlasovacie meno: {{login}}</p><p>heslo: {{heslo}}</p><p>Vaše web stránky budú dostupné na: http:// {{verejnaIP}}:{{http}}</p><p>S pozdravom,</p><p>{{sender}}</p>', 'sablona', 'Dobrý deň,\nna predmete Webové technológie 2 budete mať k dispozícii vlastný virtuálny linux server, ktorý budete\npoužívať počas semestra, a na ktorom budete vypracovávať zadania. Prihlasovacie údaje k Vašemu serveru\nsu uvedené nižšie.\nip adresa: {{verejnaIP}}\nprihlasovacie meno: {{login}}\nheslo: {{heslo}}\nVaše web stránky budú dostupné na: http:// {{verejnaIP}}:{{http}}\nS pozdravom,\n{{sender}}\n'),
(32, '<p>Dobrý deň,</p><p>na predmete Webové technológie 2 budete mať k dispozícii vlastný virtuálny linux server, ktorý budete</p><p>používať počas semestra, a na ktorom budete vypracovávať zadania. Prihlasovacie údaje k Vašemu serveru</p><p>su uvedené nižšie.</p><p>id studenta: {{ID}}</p><p>meno studenta: {{meno}}</p><p>prihlasovacie meno: {{login}}</p><p>heslo: {{heslo}}</p><p>email: {{Email}}</p><p>Vaše web stránky budú dostupné na: http:// {{verejnaIP}}:{{http}}</p><p>S pozdravom,</p><p>{{sender}}</p>', 'nova sablona', 'Dobrý deň,\nna predmete Webové technológie 2 budete mať k dispozícii vlastný virtuálny linux server, ktorý budete\npoužívať počas semestra, a na ktorom budete vypracovávať zadania. Prihlasovacie údaje k Vašemu serveru\nsu uvedené nižšie.\nid studenta: {{ID}}\nmeno studenta: {{meno}}\nprihlasovacie meno: {{login}}\nheslo: {{heslo}}\nemail: {{Email}}\nVaše web stránky budú dostupné na: http:// {{verejnaIP}}:{{http}}\nS pozdravom,\n{{sender}}\n'),
(33, '<p>Dobrý deň,</p><p>na predmete Webové technológie 2 budete mať k dispozícii vlastný virtuálny linux server, ktorý budete</p><p>používať počas semestra, a na ktorom budete vypracovávať zadania. Prihlasovacie údaje k Vašemu serveru</p><p>su uvedené nižšie.</p><p>id studenta: {{ID}}</p><p>meno studenta: {{meno}}</p><p>prihlasovacie meno: {{login}}</p><p>heslo: {{password}}</p><p>email: {{Email}}</p><p>Vaše web stránky budú dostupné na: http:// {{verejnaIP}}:{{http}}</p><p>S pozdravom,</p><p>{{sender}}</p>', 'sablona 2', 'Dobrý deň,\nna predmete Webové technológie 2 budete mať k dispozícii vlastný virtuálny linux server, ktorý budete\npoužívať počas semestra, a na ktorom budete vypracovávať zadania. Prihlasovacie údaje k Vašemu serveru\nsu uvedené nižšie.\nid studenta: {{ID}}\nmeno studenta: {{meno}}\nprihlasovacie meno: {{login}}\nheslo: {{password}}\nemail: {{Email}}\nVaše web stránky budú dostupné na: http:// {{verejnaIP}}:{{http}}\nS pozdravom,\n{{sender}}\n'),
(34, '<p>Hello World!</p><p>Some initial <strong>bold</strong> text</p><p><br></p>', 'test', 'Hello World!\nSome initial bold text\n\n'),
(35, '<p>Hello World!</p><p>Some initial <strong>bold</strong> text</p><p><br></p>', '', 'Hello World!\nSome initial bold text\n\n');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `email`
--
ALTER TABLE `email`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sablona`
--
ALTER TABLE `sablona`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `email`
--
ALTER TABLE `email`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;
--
-- AUTO_INCREMENT for table `sablona`
--
ALTER TABLE `sablona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
