-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 13 2019 г., 12:32
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `projectphp1`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `text` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL,
  `hide` int(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `text`, `date`, `user_id`, `hide`) VALUES
(11, 'wrthwrthwrth', '2019-11-25 17:42:21', 2, 0),
(12, 'sdfgst rtyhb thy', '2019-11-25 17:42:28', 3, 0),
(13, 'цукпинро нго л', '2019-11-26 11:30:00', 10, 0),
(28, 'sdfgfgthdyjtyj', '2019-11-26 11:45:05', 3, 0),
(30, '222222222222222', '2019-12-03 20:26:02', 10, 0),
(31, '333333333333333333333333333333333', '2019-12-03 20:26:07', 10, 0),
(32, 'Все работает, но жуткий говнокод!!!!!!!!!!!!!!!!!!!!!!!!!!!', '2019-12-08 17:40:08', 11, 0),
(33, 'Все глючит!!!!!!!!', '2019-12-12 10:18:25', 12, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(16) NOT NULL,
  `email` varchar(256) NOT NULL,
  `password` varchar(1024) NOT NULL,
  `image` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `image`) VALUES
(1, '123', '123@mn.ru', '1234', 'no-user.jpg'),
(2, 'aaaa', 'asd@ml.rt', '$2y$10$DzXayvCw4e75Rpy.xs1UHeP1oJdFiuRW8KwGUNLKVBvdHHUnDWEfy', 'no-user.jpg'),
(3, '123', '123@sd', '$2y$10$mK9Gl32OMx.6QjWDBOKtT.hV6BJkBx2cSHT2V1n.NyDdYHgl.nxEm', 'no-user.jpg'),
(10, 'hello', '1@nm.ru', '$2y$10$YjZaUD7AoJcEffVbznfnOetkV680/vavk01maBp9XCSzsmC5pZjs2', '5df2789080ba75df27803ebfe75df24b2e4d5834.jpg'),
(11, 'user', 'user@user.ru', '$2y$10$MMi.rFUMk3QPaFmLIq.6xuAy/ZZKRqim25jVOrRsphSYDn.jR/Eya', 'no-user.jpg'),
(12, 'unit', 'unit@nm.ru', '$2y$10$oVrbJngBQnlLTMm5DSsl5uvdx2DbD77VN.FttZBCE9eS7BlP1z9di', '5df2785a83a43favicon.jpg');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
