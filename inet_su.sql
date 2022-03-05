-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Мар 05 2022 г., 22:38
-- Версия сервера: 10.3.13-MariaDB-log
-- Версия PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `inet.su`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `user_id` varchar(255) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`user_id`, `product_id`, `quantity`) VALUES
('5', '1', '1'),
('5', '3', '2'),
('5', '5', '1'),
('5', '4', '1');

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Детские товары'),
(2, 'Автотовары'),
(3, 'Продукты питаний');

-- --------------------------------------------------------

--
-- Структура таблицы `order_user`
--

CREATE TABLE `order_user` (
  `order_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `filling` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `adress` varchar(255) NOT NULL,
  `total_price` varchar(255) NOT NULL,
  `date_time` datetime NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `order_user`
--

INSERT INTO `order_user` (`order_id`, `user_id`, `filling`, `adress`, `total_price`, `date_time`, `status`) VALUES
(1, '5', '[{\"user_id\":\"5\",\"product_id\":\"2\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"3\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"1\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"5\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"4\",\"quantity\":\"1\"}]', 'Город: Новосибирск Адрес: НОВОСИБИРСКАЯ ОБЛАСТЬ НОВОСИБИРСК КУБОВАЯ Адрес 2: 12313 Почтовый индекс: 630040', '2509.6', '2022-03-05 19:26:00', 'Упакован'),
(2, '5', '[{\"user_id\":\"5\",\"product_id\":\"2\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"3\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"1\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"5\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"4\",\"quantity\":\"1\"}]', 'Город: Новосибирск Адрес: НОВОСИБИРСКАЯ ОБЛАСТЬ НОВОСИБИРСК КУБОВАЯ Адрес 2: 12313 Почтовый индекс: 630040', '555', '2022-03-05 19:32:00', 'Упакован'),
(3, '5', '[{\"user_id\":\"5\",\"product_id\":\"2\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"3\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"1\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"5\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"4\",\"quantity\":\"1\"}]', 'Город: Новосибирск Адрес: НОВОСИБИРСКАЯ ОБЛАСТЬ НОВОСИБИРСК КУБОВАЯ Адрес 2: 12313 Почтовый индекс: 630040', '55515', '2022-03-05 19:34:00', 'Упакован'),
(4, '5', '[{\"user_id\":\"5\",\"product_id\":\"1\",\"quantity\":\"7\"}]', 'Город: Новосибирск Адрес: НОВОСИБИРСКАЯ ОБЛАСТЬ НОВОСИБИРСК КУБОВАЯ Адрес 2: 31231 Почтовый индекс: 630040', '500', '2022-03-05 20:08:00', 'Заказ получен'),
(5, '5', '[{\"user_id\":\"5\",\"product_id\":\"1\",\"quantity\":\"4\"},{\"user_id\":\"5\",\"product_id\":\"2\",\"quantity\":\"1\"},{\"user_id\":\"5\",\"product_id\":\"3\",\"quantity\":\"1\"}]', 'Город: Новосибирск Адрес: НОВОСИБИРСКАЯ ОБЛАСТЬ НОВОСИБИРСК КУБОВАЯ Адрес 2: 12313 Почтовый индекс: 630040', '3610', '2022-03-05 20:16:00', 'Получен');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(2000) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `price` int(255) NOT NULL,
  `sale` varchar(3) DEFAULT NULL,
  `sale_date` date DEFAULT NULL,
  `img` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `forAdults` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `category_id`, `price`, `sale`, `sale_date`, `img`, `forAdults`) VALUES
(1, 'Тестовый товар 1 Категория 1', 'Тестовый товар 1 Категория 1 Описание', '1', 500, NULL, NULL, '[\"/img/products/20220305191153232844312.jpg\",\"/img/products/202203051911531111442818.jpg\",\"/img/products/202203051911531133051301.jpg\"]', 0),
(2, 'Тестовый товар 2 Категория 1', 'Тестовый товар 2 Категория 1 Описание', '1', 600, '50', '2022-03-06', '[\"/img/products/20220305191242660336225.jpg\",\"/img/products/202203051912421787632462.jpg\",\"/img/products/202203051912422100061091.jpg\"]', 0),
(3, 'Тестовый товар 3 Категория 1', 'Тестовый товар 3 Категория 1 Описание', '1', 900, '10', '2022-03-06', '[\"/img/products/20220305191449983596405.jpg\",\"/img/products/2022030519144988095511.jpg\",\"/img/products/20220305191449883983332.jpg\"]', 1),
(4, 'Тестовый товар 1 Категория 2', 'Тестовый товар 1 Категория 2 описание', '2', 500, NULL, NULL, '[\"/img/products/202203051915361223882668.jpg\",\"/img/products/202203051915361466441210.jpg\",\"/img/products/202203051915361921734601.jpg\"]', 0),
(5, 'Тестовый товар 2 Категория 2', 'Тестовый товар 2 Категория 2 ', '2', 999, '60', '2022-03-23', '[\"/img/products/202203051915572063142248.jpg\",\"/img/products/20220305191557623196606.jpg\",\"/img/products/202203051915571209152213.jpg\"]', 0),
(6, 'Тестовый товар 1 Категория 3', 'Тестовый товар 1 Категория 3 Описание', '3', 9999, NULL, NULL, '[\"/img/products/202203051916281424570055.jpg\",\"/img/products/20220305191628420373708.jpg\",\"/img/products/202203051916281682838393.jpg\"]', 0);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `age` date NOT NULL,
  `admin_lvl` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `surname`, `city`, `age`, `admin_lvl`) VALUES
(5, 'semtrip1@gmail.com', '123323qwe', 'СЕМЁН', 'Г.', 'Новосибирск', '2010-06-25', '2');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `order_user`
--
ALTER TABLE `order_user`
  ADD PRIMARY KEY (`order_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
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
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `order_user`
--
ALTER TABLE `order_user`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
