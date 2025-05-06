-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-5.7
-- Время создания: Май 06 2025 г., 21:00
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
-- База данных: `vvintage`
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
  `post_index` int(11) NOT NULL,
  `phone` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `surname`, `fathername`, `country`, `city`, `area`, `street`, `building`, `flat`, `post_index`, `phone`) VALUES
(1, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL),
(2, 2, 'Наталья3', 'Балашоваaaaaaaaaaaaaaaaaaaaaaaaa', 'Евгеньевна', 'Россия', 'Москва', 'Московская', 'Театральная', 220, 123, 142713, 79456574554);

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`id`, `title`) VALUES
(1, 'Chanel'),
(2, 'Cerruti'),
(3, 'Guy Laroche'),
(4, 'Ciner\r\n'),
(5, 'Dior'),
(6, 'Swarovski\r\n'),
(7, 'Manoush'),
(8, 'The Kooples\r\n'),
(9, 'Balmain'),
(10, 'Fuzeau\r\n'),
(11, 'Orena\r\n'),
(12, 'Givenchy');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `title`, `parent_id`, `image`) VALUES
(1, 'Для женщин', NULL, 'women'),
(2, 'Для мужчин', NULL, 'men'),
(3, 'Для детей', NULL, 'children'),
(4, 'Для дома', NULL, 'home'),
(5, 'Парфюмерия', NULL, 'parfume'),
(6, 'Косметика', NULL, 'cosmetic'),
(7, 'Сумки', 1, ''),
(8, 'Очки', 1, ''),
(9, 'Часы', 1, ''),
(10, 'Бижутерия', 1, ''),
(11, 'Косметика', 1, ''),
(12, 'Аксессуары', 1, ''),
(13, 'Очки', 2, ''),
(14, 'Часы', 2, ''),
(15, 'Ремни', 2, ''),
(16, 'Галстуки', 2, ''),
(17, 'Сумки', 2, ''),
(18, 'Все бренды', NULL, 'brands');

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
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `article` bigint(10) NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `stock` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category`, `title`, `desc`, `brand`, `price`, `article`, `url`, `stock`) VALUES
(1, 10, 'Цепочка и подвеска Chanel в форме креста из золотистого металла со стразами и жемчужно-белыми бусинами.', 'Цепочка и подвеска в форме креста из золотистого металла со стразами и жемчужно-белыми бусинами.\r\n\r\nЧрезвычайно тщательная отделка. \r\n\r\nОбщая длина: 45 см Вес 83 грамма.\r\n\r\nВеликолепное украшение, которое подходит к любому образу. Ни разу не использовалось. Для проверки подлинности можно обращаться в бутик Chanel.', 1, 9000, 1711817016, '-chaine-et-pendentif-metal-dore-chanel?referrer=catalog', 1),
(2, 10, 'Колье коллекционное Chanel Cruise 2005', 'Колье коллекционное Chanel Cruise 2005.\r\nИзготовлено во Франции.  \r\n\r\n\r\nПоказ мод Chanel Cruise 2005 года был организован Карлом Лагерфельдом.\r\nПо улицам центра Парижа модели прогуливались на фирменных автобусах Chanel (если не видели, то видео стоит найти на YouTube, потому что это действительно впечатляюще).\r\n\r\nОжерелье - одно из тех, которые были показаны, оно было самым важным в коллекции. Нося это действительно редкую и поразительную красоту.\r\n\r\n\r\n\r\nДлина ожерелья составляет около 60 см., плюс 28 см. кулон. Ожерелье редкой красоты', 1, 10000, 2317491898, '-collana-da-collezionisti-chanel-cruise-2005-made-in-france?referrer=catalog', 1),
(3, 10, 'Колье Chanel', 'Колье Chanel, белое золото и бриллианты. В колье более 100 крошечных бриллиантов и один крупный бриллиант из белого золота . Съемный.', 1, 14000, 5072819272, '-collar-chanel-oro-blanco-y-diamantes?referrer=catalog', 1),
(4, 10, 'Цельное кольцо Chanel Gold 750', 'Цельное кольцо chanel Gold 750 с драгоценными камнями.\r\n\r\nРазмер: 17 вес: 14,3 грамма\r\n\r\nБыло произведено не так много образцов, только для коллекционеров. Выполнена проверка подлинности, поэтому продажа без скидки. Для коллекционеров.', 1, 12000, 5689659597, '-anello-chanel-oro?referrer=catalog', 1),
(5, 10, 'Браслет Chanel Coco Crush золото и 9 бриллиантов', 'Браслет Chanel Coco Crush из бежевого золота и 9-ти бриллиантов.\r\n\r\nПодписанный и пронумерованный\r\n\r\nРазмер: 18\r\n\r\nВес брутто: 26,13 г', 1, 16000, 5824383511, '-chanel-bracelet-coco-crush-neuf-en-or-beige-et-diamants?referrer=catalog', 1),
(6, 10, 'Золотые серьги-клипсы с логотипом Givenchy', 'Винтажные серьги-клипсы в очень хорошем состоянии\r\nКоллекция подписанных ароматов Givenchy France', 12, 230, 5451505123, '-boucles-doreilles-clips-vintage-dorees-logo-givenchy-parfums-france?referrer=catalog', 1),
(7, 10, 'Серьги-клипсы Orecchini от Givenchy', 'Редкие винтажные клипсы из коллекции Givenchy 1980-х годов.\r\nЗолотого цвета в форме цветка с красным камнем. Идеально подходит для любого случая.', 12, 420, 5443577591, '-orecchini-a-clip-givenchy', 1),
(8, 10, 'Серьги Givenchy', 'Красивые серьги Givenchy c красным камнем. Ни разу не использовались.', 12, 320, 2702789727, '-boucles-doreilles-givenchy', 1),
(9, 10, 'Серьги-клипсы Givenchy', 'Винтаж 1980-х годов.\r\nВинтажные серьги-клипсы Givenchy в форме груши золотого цвета с черным камнем и стразами. В очень хорошем состоянии.', 12, 180, 4707509803, '-boucles-doreilles-clips-givenchy', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `filename` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_order` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `filename`, `image_order`) VALUES
(1, 1, 'chanel_gold_pendant_necklace_1.jpeg', 1),
(2, 1, 'chanel_gold_pendant_necklace_2.jpeg', 2),
(3, 1, 'chanel_gold_pendant_necklace_3.jpeg', 3),
(4, 1, 'chanel_gold_pendant_necklace_4.jpeg', 4),
(5, 1, 'chanel_gold_pendant_necklace_5.jpeg', 5),
(6, 1, 'chanel_gold_pendant_necklace_6.jpeg', 6),
(7, 1, 'chanel_gold_pendant_necklace_7.jpeg', 7),
(8, 1, 'chanel_gold_pendant_necklace_8.jpeg', 8),
(9, 1, 'chanel_gold_pendant_necklace_9.jpeg', 9),
(10, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_1.jpeg', 1),
(11, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_2.jpeg', 2),
(12, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_3.jpeg', 3),
(13, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_4.jpeg', 4),
(14, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_5.jpeg', 5),
(15, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_6.jpeg', 6),
(16, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_7.jpeg', 7),
(17, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_8jpeg', 8),
(18, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_9.jpeg', 9),
(19, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_10.jpeg', 10),
(20, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_11.jpeg', 11),
(21, 2, 'chanel_cruise_2005_collectible_jewelry_necklace_12.jpeg', 12),
(22, 2, 'chanel_cruis3e_2005_collectible_jewelry_necklace_13.jpeg', 13),
(23, 2, 'chanel_cruis3e_2005_collectible_jewelry_necklace_14.jpeg', 14),
(24, 2, 'chanel_cruis3e_2005_collectible_jewelry_necklace_15.jpeg', 15),
(25, 2, 'chanel_cruis3e_2005_collectible_jewelry_necklace_16.jpeg', 16),
(26, 2, 'chanel_cruis3e_2005_collectible_jewelry_necklace_17.jpeg', 17),
(27, 3, 'chanel_necklace_white_gold_diamond_1.jpeg', 1),
(28, 3, 'chanel_necklace_white_gold_diamond_2.jpeg', 2),
(29, 3, 'chanel_necklace_white_gold_diamond_3.jpeg', 3),
(30, 3, 'chanel_necklace_white_gold_diamond_4.jpeg', 4),
(31, 3, 'chanel_necklace_white_gold_diamond_5.jpeg', 5),
(32, 3, 'chanel_necklace_white_gold_diamond_6.jpeg', 6),
(33, 3, 'chanel_necklace_white_gold_diamond_7.jpeg', 7),
(34, 3, 'chanel_necklace_white_gold_diamond_8.jpeg', 8),
(35, 4, 'chanel_gold_ring_with_precious_stones_solitaire_1.jpeg', 1),
(36, 4, 'chanel_gold_ring_with_precious_stones_solitaire_2.jpeg', 2),
(37, 4, 'chanel_gold_ring_with_precious_stones_solitaire_3.jpeg', 3),
(38, 4, 'chanel_gold_ring_with_precious_stones_solitaire_4.jpeg', 4),
(39, 4, 'chanel_gold_ring_with_precious_stones_solitaire_5.jpeg', 5),
(40, 5, 'chanel_gold_bracelet_9_diamonds_1.jpeg', 1),
(41, 5, 'chanel_gold_bracelet_9_diamonds_2.jpeg', 2),
(42, 5, 'chanel_gold_bracelet_9_diamonds_3.jpeg', 3),
(43, 5, 'chanel_gold_bracelet_9_diamonds_4.jpeg', 4),
(44, 5, 'chanel_gold_bracelet_9_diamonds_5.jpeg', 5),
(45, 5, 'chanel_gold_bracelet_9_diamonds_6.jpeg', 6),
(46, 6, 'vintage_givenchy__signed_perfume_collection_earrings_clips_excellent_condition_1.jpeg', 1),
(47, 6, 'vintage_givenchy__signed_perfume_collection_earrings_clips_excellent_condition_2.jpeg', 2),
(48, 6, 'vintage_givenchy__signed_perfume_collection_earrings_clips_excellent_condition_3.jpeg', 3),
(49, 6, 'vintage_givenchy__signed_perfume_collection_earrings_clips_excellent_condition_4.jpeg', 4),
(50, 6, 'vintage_givenchy__signed_perfume_collection_earrings_clips_excellent_condition_5.jpeg', 5),
(51, 6, 'vintage_givenchy__signed_perfume_collection_earrings_clips_excellent_condition_6.jpeg', 6),
(52, 6, 'vintage_givenchy__signed_perfume_collection_earrings_clips_excellent_condition_7.jpeg', 7),
(53, 6, 'vintage_givenchy__signed_perfume_collection_earrings_clips_excellent_condition_8.jpeg', 8),
(54, 6, 'vintage_givenchy__signed_perfume_collection_earrings_clips_excellent_condition_9.jpeg', 9),
(55, 7, 'givenchy_1980s_flower_shape_gold_clip_earrings_red_stone_1.jpeg', 1),
(56, 7, 'givenchy_1980s_flower_shape_gold_clip_earrings_red_stone_2.jpeg', 2),
(57, 7, 'givenchy_1980s_flower_shape_gold_clip_earrings_red_stone_3.jpeg', 3),
(58, 7, 'givenchy_1980s_flower_shape_gold_clip_earrings_red_stone_4.jpeg', 4),
(59, 7, 'givenchy_1980s_flower_shape_gold_clip_earrings_red_stone_5.jpeg', 5),
(60, 8, 'givenchy_earrings_red_stone_unused_1.jpeg', 1),
(61, 8, 'givenchy_earrings_red_stone_unused_2.jpeg', 2),
(62, 8, 'givenchy_earrings_red_stone_unused_3.jpeg', 3),
(63, 8, 'givenchy_earrings_red_stone_unused_4.jpeg', 4),
(64, 8, 'givenchy_earrings_red_stone_unused_5.jpeg', 5),
(65, 8, 'givenchy_earrings_red_stone_unused_6.jpeg', 6),
(66, 9, 'givenchy_1980s_pear_shape_gold_clip_earrings_black_stone_rhinestones_excellent_1.jpeg', 1),
(67, 9, 'givenchy_1980s_pear_shape_gold_clip_earrings_black_stone_rhinestones_excellent_2.jpeg', 2),
(68, 9, 'givenchy_1980s_pear_shape_gold_clip_earrings_black_stone_rhinestones_excellent_3.jpeg', 3),
(69, 9, 'givenchy_1980s_pear_shape_gold_clip_earrings_black_stone_rhinestones_excellent_4.jpeg', 4),
(70, 9, 'givenchy_1980s_pear_shape_gold_clip_earrings_black_stone_rhinestones_excellent_5.jpeg', 5),
(71, 9, 'givenchy_1980s_pear_shape_gold_clip_earrings_black_stone_rhinestones_excellent_6.jpeg', 6),
(72, 9, 'givenchy_1980s_pear_shape_gold_clip_earrings_black_stone_rhinestones_excellent_7.jpeg', 7),
(73, 9, 'givenchy_1980s_pear_shape_gold_clip_earrings_black_stone_rhinestones_excellent_8.jpeg', 8),
(74, 9, 'givenchy_1980s_pear_shape_gold_clip_earrings_black_stone_rhinestones_excellent_9.jpeg', 9);

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
(1, 'info@mail.ru', 'user', '$2y$10$pNM47.qS/ehe9kuFpA.Lb.AvQ/tfOWbrYlYE33EqQ5r/Ev9o0fA0W', '[]', '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'info2@mail.ru', 'admin', '$2y$10$xvqZsEms93g0uQOFl/dF1OagOiFnRbMUzjeDJuq5fNJks8k1OIUzq', '[]', '[]', 'Наталья', 'Балашова', '', '', '', '', '379444427371.jpg', '48-379444427371.jpg'),
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
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `product_images`
--
ALTER TABLE `product_images`
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
-- AUTO_INCREMENT для таблицы `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
