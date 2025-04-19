-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Апр 19 2025 г., 08:20
-- Версия сервера: 10.4.32-MariaDB
-- Версия PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `my_database`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cargoes`
--

CREATE TABLE `cargoes` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `weight` decimal(10,2) NOT NULL,
  `volume` decimal(10,2) DEFAULT NULL,
  `type` enum('fragile','standard','hazardous') DEFAULT 'standard',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `clients`
--

CREATE TABLE `clients` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `city` varchar(100) DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `house` varchar(10) DEFAULT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `clients`
--

INSERT INTO `clients` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `first_name`, `last_name`, `password`, `city`, `street`, `house`, `role`) VALUES
(1, 'ers', 'Kaliev@gmail.com', '', 'Казакстан', '2025-03-15 06:48:39', 'Ersultan', 'Kaliev', '$2y$10$UWBJF0Ps39vvJfbiBIsE5uZs7pv/wo2JlbnIh4FmCqS2zL8TH3Du6', 'Алматы', 'Абая', '24', 'user'),
(2, 'Ринат Каракулов', 'Abdy@gmail.com', '87715162164', 'Казакстан', '2025-03-15 07:56:42', 'Абду', 'Нуриддин', '$2y$10$DPunkG4k4AZYNqd7.pTUu.OMtILirbyW0z0KUEdwOgStwoo/QC17C', 'Алматы', 'Шашкина', '14а', 'user'),
(3, 'Berik', 'Saduakas@gmail.com', '', 'Казакстан', '2025-04-12 04:32:14', 'Berik', 'Saduakas', '$2y$10$vjDoOFHgFKnMssmKJAt1SeOdg/JLOqmvpcc.juurtIvqyC.sTG1MS', 'Almaty', 'Abai', '12', 'user'),
(4, 'Arnat', 'Arnat@gmail.com', '', 'Almaty', '2025-04-12 05:38:30', 'Арнат', 'Лескалиев', '$2y$10$KVoPcSRIAt7oDR6EmEBlgetr7piJsrbyLztb04/ApxefFeFL1xOga', 'Алматы', 'Сатпаева', '43', 'user'),
(5, 'rinat', 'rinatkarakulov840@gmail.com', '87051849265', 'Казакстан', '2025-04-18 18:37:58', 'Ринат', 'Каракулов', '$2y$10$1tenCqxx71N688zQonCfFe4jRmRBRepZsdSqyPff4cGaMzxUXX0yy', 'Орал', 'Жамбыл', '123', 'user'),
(6, '', 'Rinat@gmail.com', '', 'Казакстан', '2025-04-19 06:18:02', 'Ринат', 'Каракулов', '$2y$10$E2jgMN1gMCEP.490SZMf5uYti2sRLq2yYmUKO.Z2V5CwWlcIlF3di', '', '', '', 'user');

-- --------------------------------------------------------

--
-- Структура таблицы `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` enum('manager','driver','loader') DEFAULT 'manager',
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `name`, `message`, `created_at`, `user_id`) VALUES
(1, '', 'rinat', '2025-03-01 06:30:59', 1),
(2, '', '12432rf2fqwawfr', '2025-03-01 06:35:04', 5),
(3, '', 'Rinat krasavhik\r\n', '2025-03-01 08:30:13', 5),
(4, '', 'maga hert\r\n', '2025-03-01 08:30:36', 5),
(5, '', 'thedtyjty', '2025-04-12 05:42:03', 6),
(6, '', 'rergtyrhtyh', '2025-04-12 05:43:47', 1),
(7, '', 'wsvgxtcercgertbn', '2025-04-12 05:44:14', 4),
(8, '', 'rgdstyhjw56hegdt', '2025-04-12 07:37:16', 3),
(9, '', 'gtsrhjayswtrhqw', '2025-04-12 07:37:35', 4);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `route_id` int(11) NOT NULL,
  `status` enum('new','in_progress','delivered','canceled') DEFAULT 'new',
  `total_cost` decimal(10,2) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `collection_zip` varchar(20) NOT NULL,
  `collection_city` varchar(100) NOT NULL,
  `collection_country` varchar(100) NOT NULL,
  `delivery_zip` varchar(20) NOT NULL,
  `delivery_city` varchar(100) NOT NULL,
  `delivery_country` varchar(100) NOT NULL,
  `transport_details` text DEFAULT NULL,
  `delivery_method` enum('car','railway','air','sea') NOT NULL DEFAULT 'car',
  `status` enum('pending','processed','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `user_id`, `name`, `email`, `phone`, `company`, `collection_zip`, `collection_city`, `collection_country`, `delivery_zip`, `delivery_city`, `delivery_country`, `transport_details`, `delivery_method`, `status`, `created_at`) VALUES
(4, NULL, 'Ринат Каракулов', 'rinatkarakulov840@gmail.com', '87051849265', '', '596580', '4', 'Казахстан', '596580', '4', 'Казахстан', 'trwhthwrertshthawh', 'car', '', '2025-04-01 06:29:00'),
(11, 2, 'Ринат Каракулов', 'test@example.com', '87051849265', '', '596580', '4', 'Казахстан', '596580', '4', 'Казахстан', 'апкф', 'air', '', '2024-01-23 14:08:00'),
(12, 2, 'Ринат Каракулов', 'newadmin@example.com', '87051849265', '', '596580', '4', 'Казахстан', '596580', '4', 'Казахстан', 'кпырер', 'sea', '', '2025-04-12 07:12:00'),
(13, 2, 'Ринат Каракулов', 'Arnat@gmail.com', '87715162164', '', '596580', '4', 'Казахстан', '596580', '4', 'Казахстан', 'пыуепывпы', 'sea', '', '2025-04-12 07:13:00'),
(14, 4, 'Ринат Каракулов', 'rinatkarakulov840@gmail.com', '87051849265', '', '596580', '4', 'Казахстан', '596580', '4', 'Казахстан', '', 'railway', '', '2025-04-12 07:51:44'),
(15, 4, 'Ринат Каракулов', 'rinatksenia@gmail.com', '87051849265', '', '596580', '4', 'Казахстан', '596580', '4', 'Казахстан', 'yers mal', 'air', '', '2025-04-12 07:57:41'),
(16, 5, 'Ринат Каракулов', 'rinatkarakulov840@gmail.com', '87051849265', 'hbyfn', '596580', '4', 'Казахстан', '596580', '4', 'Казахстан', 'q23as5u7iy8;hp/ibuvyltckrxexyz44e5urcfikt', 'sea', '', '2025-04-18 18:38:23'),
(17, 5, 'Магжан', 'Kaliev@gmail.com', '87770282005', '', '596580', 'Актау', 'Казахстан', '548553', 'Орал', 'Казахстан', 'он кг алма берп жбериншы', 'railway', 'pending', '2025-04-19 06:13:30');

-- --------------------------------------------------------

--
-- Структура таблицы `routes`
--

CREATE TABLE `routes` (
  `id` int(11) NOT NULL,
  `start_point` varchar(255) NOT NULL,
  `end_point` varchar(255) NOT NULL,
  `departure_date` date DEFAULT NULL,
  `arrival_date` date DEFAULT NULL,
  `transport_type` enum('truck','air','sea','rail') DEFAULT 'truck',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `routes`
--

INSERT INTO `routes` (`id`, `start_point`, `end_point`, `departure_date`, `arrival_date`, `transport_type`, `created_at`) VALUES
(1, 'Москва', 'Санкт-Петербург', '2025-04-15', '2025-04-17', '', '2025-04-12 05:15:30'),
(2, 'Санкт-Петербург', 'Казань', '2025-04-18', '2025-04-21', '', '2025-04-12 05:15:30');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager') DEFAULT 'manager',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `created_at`) VALUES
(6, 'newadmin@example.com', '$2y$10$K2ghG6MzeohwOGQVB/26OumEZtAW72cZIS5iMY6RIABz3yIqLeRpe', 'admin', '2025-03-15 06:35:26'),
(7, 'secondadmin@example.com', '$2y$10$oJNNQRIZr8U..GhaF5ZGg.tPUzxcWloKu6JD5CQbaSBMRLXMMuzRK', 'admin', '2025-04-12 05:26:34');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cargoes`
--
ALTER TABLE `cargoes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_cargoes_order_id` (`order_id`);

--
-- Индексы таблицы `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_orders_client_id` (`client_id`),
  ADD KEY `idx_orders_route_id` (`route_id`);

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requests_ibfk_1` (`user_id`);

--
-- Индексы таблицы `routes`
--
ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cargoes`
--
ALTER TABLE `cargoes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT для таблицы `routes`
--
ALTER TABLE `routes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `cargoes`
--
ALTER TABLE `cargoes`
  ADD CONSTRAINT `cargoes_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`client_id`) REFERENCES `clients` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`route_id`) REFERENCES `routes` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `clients` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
