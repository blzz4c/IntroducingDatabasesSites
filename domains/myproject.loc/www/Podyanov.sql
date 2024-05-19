-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 18 2023 г., 19:21
-- Версия сервера: 8.0.30
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `Podyanov`
--
CREATE DATABASE IF NOT EXISTS `Podyanov` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `Podyanov`;

-- --------------------------------------------------------

--
-- Структура таблицы `Table_Podyanov`
--

CREATE TABLE `Table_Podyanov` (
  `ID` int NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `MidName` varchar(30) NOT NULL,
  `Phone` varchar(11) NOT NULL,
  `Salary` int NOT NULL,
  `Experience` date DEFAULT NULL,
  `Adress` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `Table_Podyanov`
--

INSERT INTO `Table_Podyanov` (`ID`, `Name`, `Surname`, `MidName`, `Phone`, `Salary`, `Experience`, `Adress`) VALUES
(1, 'Roman', 'Podyanov', 'Pavlovich', '79082485055', 100000, '2016-09-01', 'Perm, Proffessora Dedyukina st, 20'),
(2, 'Pavel', 'Frolov', 'Maksimovich', '78261694972', 103100, '2019-05-18', 'Perm, Dorozhnaya st, 29'),
(3, 'Vasily', 'Maksimov', 'Romanovich', '71836562188', 20000, '2018-03-25', 'Perm, Lesnaya Ulitsa, 34'),
(4, 'Ekaterina', 'Lomaeva', 'Nadezdovna', '71449098764', 1000000, '2022-07-09', 'Perm, Dachnaya st, 4'),
(5, 'Maksim', 'Korepanov', 'Aleksandovich', '76963365634', 35000, '2017-11-12', 'Perm, Lenina st, 10'),
(6, 'Fedor', 'Petrov', 'Valerevich', '79093746361', 70000, '2011-08-07', 'Perm, Parkovaya st, 11'),
(7, 'Anton', 'Vikentev', 'Emelyanovich', '70054982637', 30000, '2021-12-28', 'Perm, Parkovaya st, 11'),
(8, 'Evgenyi', 'Sevhanov', 'Miroslavovich', '72242601208', 200003, '2015-04-11', 'Perm, Sadovaya st, 22'),
(9, 'Miroslav', 'Ageev', 'Mikhailovich', '75549311036', 160320, '2020-10-05', 'Perm, Voronezhskaya st, 20'),
(10, 'Kirill', 'Maltsev', 'Glebovich', '78788438123', 300000, '2014-02-19', 'Perm, Zelenaya st, 20'),
(11, 'Semyon', 'Belov', 'Artemovich', '76727385625', 65000, '2012-12-03', 'Perm, Ozernaya st, 30'),
(12, 'Anton', 'Kuznetsov', 'Vladimirovich', '72835524713', 45000, '2013-06-15', 'Perm, Sneznaya st, 20'),
(13, 'Makar', 'Ivanov', 'Robertovich', '73631080641', 31000, '2010-01-24', 'Perm, Kudymkarskaya st, 24'),
(14, 'Elisei', 'Sitnikov', 'Mikhailovich', '70289144439', 5000, '2017-10-30', 'Berezniki, Permskaya st, 100'),
(15, 'Bogdan', 'Larin', 'Maksimovich', '78966749010', 56000, '2023-08-21', 'Kudymkar, Bereznikova st, 39'),
(16, 'Artem', 'Smirnov', 'Grigorevich', '75006317695', 15305400, '2016-07-14', 'Perm, Vladimirskaya st, 67'),
(17, 'Maksim', 'Platonov', 'Sergeevich', '79630939064', 580390, '2018-04-26', 'Perm, Krymskaya st, 2'),
(18, 'Bogdan', 'Mikheev', 'Yurevich', '71242854170', 400000, '2018-04-26', 'Ekaterinburg, Eltsina st, 54'),
(19, 'Ivan', 'Fedorov', 'Maratovich', '72404562149', 424222, '2019-03-07', 'Perm, Koroleva st, 18'),
(20, 'Kirill', 'Sofronov', 'Olegovich', '75116997980', 390539, '2011-10-09', 'Ekaterinburg, Pesochnaya st, 5'),
(21, 'Oleg', 'Plutonov', 'Geraklovich', '74104681246', 21313, '2015-02-23', 'Perm, Zheleznodorozhnaya st, 26');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Table_Podyanov`
--
ALTER TABLE `Table_Podyanov`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Table_Podyanov`
--
ALTER TABLE `Table_Podyanov`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
