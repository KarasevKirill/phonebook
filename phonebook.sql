-- phpMyAdmin SQL Dump
-- version 4.4.15.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Апр 16 2017 г., 13:53
-- Версия сервера: 5.7.13
-- Версия PHP: 7.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `phonebook`
--

-- --------------------------------------------------------

--
-- Структура таблицы `city`
--

CREATE TABLE IF NOT EXISTS `city` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `city`
--

INSERT INTO `city` (`id`, `name`) VALUES
(1, 'Москва'),
(2, 'Владивосток'),
(3, 'Хабаровск'),
(4, 'Новосибирск');

-- --------------------------------------------------------

--
-- Структура таблицы `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) unsigned NOT NULL,
  `surname` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `patronymic` varchar(255) DEFAULT NULL,
  `city_id` int(11) unsigned DEFAULT NULL,
  `street_id` int(11) unsigned DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `phone` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `contact`
--

INSERT INTO `contact` (`id`, `surname`, `name`, `patronymic`, `city_id`, `street_id`, `birthday`, `phone`) VALUES
(1, 'Иванов', 'Иван', 'Иванович', 1, 4, '1990-02-01', '890030001'),
(2, 'Петров', 'Петр', 'Петрович', 3, 13, '1980-02-13', '255-55-66');

-- --------------------------------------------------------

--
-- Структура таблицы `street`
--

CREATE TABLE IF NOT EXISTS `street` (
  `id` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `city_id` int(11) unsigned NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `street`
--

INSERT INTO `street` (`id`, `name`, `city_id`) VALUES
(1, 'Московская улица №1', 1),
(2, 'Московская улица №2', 1),
(3, 'Московская улица №3', 1),
(4, 'Московская улица №4', 1),
(5, 'Московская улица №5', 1),
(6, 'Владивостокская улица №1', 2),
(7, 'Владивостокская улица №2', 2),
(8, 'Владивостокская улица №3', 2),
(9, 'Владивостокская улица №4', 2),
(10, 'Владивостокская улица №5', 2),
(11, 'Хабаровская улица №1', 3),
(12, 'Хабаровская улица №2', 3),
(13, 'Хабаровская улица №3', 3),
(14, 'Хабаровская улица №4', 3),
(15, 'Хабаровская улица №5', 3),
(16, 'Новосибирская улица №1', 4),
(17, 'Новосибирская улица №2', 4),
(18, 'Новосибирская улица №3', 4),
(19, 'Новосибирская улица №4', 4),
(20, 'Новосибирская улица №5', 4);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `city`
--
ALTER TABLE `city`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `street_id` (`street_id`);

--
-- Индексы таблицы `street`
--
ALTER TABLE `street`
  ADD PRIMARY KEY (`id`),
  ADD KEY `city_id` (`city_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `city`
--
ALTER TABLE `city`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT для таблицы `street`
--
ALTER TABLE `street`
  MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `contact`
--
ALTER TABLE `contact`
  ADD CONSTRAINT `contact_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`),
  ADD CONSTRAINT `contact_ibfk_2` FOREIGN KEY (`street_id`) REFERENCES `street` (`id`);

--
-- Ограничения внешнего ключа таблицы `street`
--
ALTER TABLE `street`
  ADD CONSTRAINT `street_ibfk_1` FOREIGN KEY (`city_id`) REFERENCES `city` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
