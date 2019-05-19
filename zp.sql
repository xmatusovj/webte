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
-- Database: `zp`
--

-- --------------------------------------------------------

--
-- Table structure for table `bodytim`
--

CREATE TABLE `bodytim` (
  `tim` int(11) NOT NULL,
  `body` int(11) NOT NULL,
  `predmet` varchar(80) NOT NULL,
  `suhlasadmin` int(11) NOT NULL,
  `rok` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `bodytim`
--

INSERT INTO `bodytim` (`tim`, `body`, `predmet`, `suhlasadmin`, `rok`) VALUES
(1, 10, 'webte2', 0, '2018/2019'),
(5, 10, 'webte2', 0, '2018/2019'),
(1, 10, 'webte', 0, '2017/2018'),
(5, 5, 'webte', 0, '2017/2018'),
(1, 0, 'webte', 0, '2018/2019'),
(5, 0, 'webte', 0, '2018/2019'),
(1, 0, 'predmet', 0, '2018/2019'),
(1, 0, 'Test predmet', 0, '2016/2017'),
(2, 0, 'Test predmet', 0, '2016/2017');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `meno` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `heslo` varchar(80) NOT NULL,
  `tim` int(11) NOT NULL,
  `kapitan` int(11) NOT NULL,
  `body` int(11) NOT NULL,
  `suhlas` int(11) NOT NULL,
  `predmet` varchar(80) NOT NULL,
  `rok` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `meno`, `email`, `heslo`, `tim`, `kapitan`, `body`, `suhlas`, `predmet`, `rok`) VALUES
(12345, 'Piezvisko1 Meno1', 'xpriezvisko1@is.stuba.sk', 'bef57ec7f53a6d40beb640a780a639c83bc29ac8a9816f1fc6c5c6dcd93c4721', 1, 0, 0, 0, 'webte2', '2018/2019'),
(24589, 'Priezvisko2 Meno2', 'xpriezvisko2@is.stuba.sk', '43edef5220ae3ad71899cd358452c1f0a16ac40bbb60972fb3e2fde59f0677f0', 5, 0, 0, 0, 'webte2', '2018/2019'),
(54187, 'Priezvisko3 Meno3', 'xpriezvisko3@is.stuba.sk', '3c109ff8f33137d4a5d1ebdd47aa48d4790745fbde8a4d4d88636e8ee4d2c8fb', 5, 0, 0, 0, 'webte2', '2018/2019'),
(23581, 'Priezvisko4 Meno4', 'xpriezvisko4@is.stuba.sk', '989bd52bae8d535668094ba90f0abe1363282c3c6ed21955a1ed7723e95dcd9c', 5, 0, 0, 0, 'webte2', '2018/2019'),
(12345, 'Piezvisko1 Meno1', 'xpriezvisko1@is.stuba.sk', 'bef57ec7f53a6d40beb640a780a639c83bc29ac8a9816f1fc6c5c6dcd93c4721', 1, 0, 2, 0, 'webte', '2017/2018'),
(24589, 'Priezvisko2 Meno2', 'xpriezvisko2@is.stuba.sk', '43edef5220ae3ad71899cd358452c1f0a16ac40bbb60972fb3e2fde59f0677f0', 5, 0, 0, 0, 'webte', '2017/2018'),
(54187, 'Priezvisko3 Meno3', 'xpriezvisko3@is.stuba.sk', '3c109ff8f33137d4a5d1ebdd47aa48d4790745fbde8a4d4d88636e8ee4d2c8fb', 5, 0, 0, 0, 'webte', '2017/2018'),
(23581, 'Priezvisko4 Meno4', 'xpriezvisko4@is.stuba.sk', '989bd52bae8d535668094ba90f0abe1363282c3c6ed21955a1ed7723e95dcd9c', 5, 0, 0, 0, 'webte', '2017/2018'),
(12345, 'Piezvisko1 Meno1', 'xpriezvisko1@is.stuba.sk', 'bef57ec7f53a6d40beb640a780a639c83bc29ac8a9816f1fc6c5c6dcd93c4721', 1, 0, 0, 0, 'webte2', '2018/2019'),
(24589, 'Priezvisko2 Meno2', 'xpriezvisko2@is.stuba.sk', '43edef5220ae3ad71899cd358452c1f0a16ac40bbb60972fb3e2fde59f0677f0', 5, 0, 0, 0, 'webte2', '2018/2019'),
(54187, 'Priezvisko3 Meno3', 'xpriezvisko3@is.stuba.sk', '3c109ff8f33137d4a5d1ebdd47aa48d4790745fbde8a4d4d88636e8ee4d2c8fb', 5, 0, 0, 0, 'webte2', '2018/2019'),
(23581, 'Priezvisko4 Meno4', 'xpriezvisko4@is.stuba.sk', '989bd52bae8d535668094ba90f0abe1363282c3c6ed21955a1ed7723e95dcd9c', 5, 0, 0, 0, 'webte2', '2018/2019'),
(86283, 'Danis Tomas', 'td@is.stuba.sk', '56b1db8133d9eb398aabd376f07bf8ab5fc584ea0b8bd6a1770200cb613ca005', 1, 1, 8, 1, 'webte', '2018/2019'),
(86283, 'Danis Tomas', 'td@is.stuba.sk', '56b1db8133d9eb398aabd376f07bf8ab5fc584ea0b8bd6a1770200cb613ca005', 5, 1, 8, 1, 'webte', '2018/2019'),
(86283, 'Danis Tomas', 'td@is.stuba.sk', '56b1db8133d9eb398aabd376f07bf8ab5fc584ea0b8bd6a1770200cb613ca005', 1, 1, 0, 0, 'predmet', '2018/2019'),
(86283, 'Danis Tomas', 'td@is.stuba.sk', '56b1db8133d9eb398aabd376f07bf8ab5fc584ea0b8bd6a1770200cb613ca005', 1, 1, 0, 0, 'Test predmet', '2016/2017'),
(1, 'Test1 Meno', 'tetst1.meno@is.stuba.sk', '56b1db8133d9eb398aabd376f07bf8ab5fc584ea0b8bd6a1770200cb613ca005', 1, 0, 0, 0, 'Test predmet', '2016/2017'),
(2, 'Test2 Meno', 'tetst2.meno@is.stuba.sk', '56b1db8133d9eb398aabd376f07bf8ab5fc584ea0b8bd6a1770200cb613ca005', 1, 0, 0, 0, 'Test predmet', '2016/2017'),
(3, 'Test3 Meno', 'tetst3.meno@is.stuba.sk', '56b1db8133d9eb398aabd376f07bf8ab5fc584ea0b8bd6a1770200cb613ca005', 1, 0, 0, 0, 'Test predmet', '2016/2017'),
(4, 'Test4 Meno', 'tetst4.meno@is.stuba.sk', '56b1db8133d9eb398aabd376f07bf8ab5fc584ea0b8bd6a1770200cb613ca005', 2, 0, 0, 0, 'Test predmet', '2016/2017'),
(5, 'Test5 Meno', 'tetst5.meno@is.stuba.sk', '56b1db8133d9eb398aabd376f07bf8ab5fc584ea0b8bd6a1770200cb613ca005', 2, 0, 0, 0, 'Test predmet', '2016/2017'),
(6, 'Test6 Meno', 'tetst6.meno@is.stuba.sk', '56b1db8133d9eb398aabd376f07bf8ab5fc584ea0b8bd6a1770200cb613ca005', 2, 0, 0, 0, 'Test predmet', '2016/2017');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
