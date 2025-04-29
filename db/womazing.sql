-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-5.7
-- Время создания: Окт 15 2024 г., 13:25
-- Версия сервера: 5.7.44
-- Версия PHP: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `womazing`
--

-- --------------------------------------------------------

--
-- Структура таблицы `address`
--

CREATE TABLE `address` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fathername` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `street` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `building` int(11) UNSIGNED DEFAULT NULL,
  `flat` int(11) UNSIGNED DEFAULT NULL,
  `phone` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `surname`, `fathername`, `country`, `city`, `area`, `street`, `building`, `flat`, `phone`) VALUES
(1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 2, 'Наталья', 'Балашова', 'Евгеньевна', 'Россия', 'Москва', 'Московская', 'Театральная', 22, 123, 79456574554);

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`id`, `title`) VALUES
(2, 'Dior');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`) VALUES
(2, 'Обувь');

-- --------------------------------------------------------

--
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `message` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `phone` double DEFAULT NULL,
  `timestamp` int(11) UNSIGNED DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `email`, `name`, `message`, `phone`, `timestamp`, `status`, `user_id`) VALUES
(1, 'info@yandex.ru', 'Elena Truman', 'Тестовое сообщение №1', 792577760741, 1728899250, NULL, NULL),
(2, 'info@yandex.ru', 'Elena Truman', 'Тестовое сообщение №1', 792577760741, 1728899493, 'new', NULL),
(3, 'ifrance@yandex.ru', 'Наталья Евгеньевна Балашова', 'Сообщение №2', 79258260741, 1728899526, 'new', NULL),
(4, 'info@yandex.ru', 'RESIDENCE BONOMELLI', 'Сообщение №3', 792577760741, 1728899620, 'new', NULL),
(5, 'info@yandex.ru', 'RESIDENCE BONOMELLI', 'Новое', 792577760741, 1728900239, 'new', 2),
(6, 'info@yandex.ru', 'Admin Truman', 'Сообщение 3', 79256666666, 1728908421, 'new', 2),
(7, 'info@yandex.ru', 'Admin Truman', 'Сообщение 3', 79256666666, 1728908484, NULL, 2),
(8, 'info@yandex.ru', 'Elena Truman', 'Сообщение', 792577760741, 1728908497, 'new', 2),
(10, 'info@yandex.ru', 'Admin Truman', 'Сообщение', 79256666666, 1728908663, 'new', 2),
(11, 'info@yandex.ru', 'Admin Truman', 'Сообщение', 79256666666, 1728908710, 'new', 2),
(12, 'info@yandex.ru', 'Admin Truman', 'Сообщение', 79256666666, 1728908727, 'new', 2),
(13, 'info@yandex.ru', 'Admin Truman', 'Сообщение', 79256666666, 1728908734, 'new', 2),
(14, 'info@yandex.ru', 'Admin Truman', 'Сообщение', 79256666666, 1728908756, 'new', 2),
(15, 'info@yandex.ru', 'Admin Truman', 'Сообщение', 79256666666, 1728908798, NULL, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `role` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `cart` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fav_list` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `avatar_small` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `role`, `password`, `cart`, `fav_list`, `name`, `surname`, `country`, `city`, `phone`, `address`, `avatar`, `avatar_small`) VALUES
(1, 'info@mail.ru', 'user', '$2y$10$pNM47.qS/ehe9kuFpA.Lb.AvQ/tfOWbrYlYE33EqQ5r/Ev9o0fA0W', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'info2@mail.ru', 'admin', '$2y$10$xvqZsEms93g0uQOFl/dF1OagOiFnRbMUzjeDJuq5fNJks8k1OIUzq', '[]', '[]', 'Наталья', 'Балашова', '', '', '', '', '383477628290.jpg', '48-383477628290.jpg'),
(3, 'text@mail.ru', 'user', '$2y$10$IZ2LlttwKkC0gNXyfvheD.mlf3pQb1gNxR5GSgzeUP1MfL/rx1gDC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'test2@mail.ru', 'user', '$2y$10$Ra3.yzKgi0/SGWfgcTRN5OevGK8g71JqcoxEFGwJVWAevEkQhI7Au', '[]', '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_address_user` (`user_id`);

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_messages_user` (`user_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
