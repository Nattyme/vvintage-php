-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-5.7
-- Время создания: Окт 31 2025 г., 15:20
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
  `user_id` int(11) NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fathername` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `country` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `city` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `area` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `street` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `building` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `flat` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `post_index` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `address`
--

INSERT INTO `address` (`id`, `user_id`, `name`, `surname`, `fathername`, `country`, `city`, `area`, `street`, `building`, `flat`, `post_index`, `phone`) VALUES
(1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `blogcategories`
--

CREATE TABLE `blogcategories` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `blogcategories`
--

INSERT INTO `blogcategories` (`id`, `title`) VALUES
(1, 'История бренда');

-- --------------------------------------------------------

--
-- Структура таблицы `brands`
--

CREATE TABLE `brands` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `brands`
--

INSERT INTO `brands` (`id`, `title`, `description`, `image`) VALUES
(1, 'Chanel', NULL, NULL),
(2, 'Cerruti 1881', NULL, NULL),
(3, 'Guy Laroche', NULL, NULL),
(4, 'Ciner\r\n', NULL, NULL),
(5, 'Dior', NULL, NULL),
(6, 'Swarovski\r\n', NULL, NULL),
(7, 'Manoush', NULL, NULL),
(8, 'The Kooples\r\n', NULL, NULL),
(9, 'Balmain', NULL, NULL),
(10, 'Fuzeau\r\n', NULL, NULL),
(11, 'Orena\r\n', NULL, NULL),
(12, 'Givenchy', NULL, NULL),
(13, 'Yves Saint Laurent', NULL, NULL),
(14, 'Hermès', NULL, NULL),
(15, 'Valentino Garavani', NULL, NULL),
(16, 'Tabbah', NULL, NULL),
(17, 'Chopard', NULL, NULL),
(18, 'Guy Laroche Paris', NULL, NULL),
(19, 'Cartier', NULL, NULL),
(20, 'Patek Philippe', NULL, NULL),
(21, 'Longines', NULL, NULL),
(22, 'Christopher Ross', NULL, NULL),
(23, 'E. Marinella', NULL, NULL),
(24, 'Louis Vuitton', NULL, NULL),
(25, 'Fuzeau', NULL, NULL),
(26, 'Guerlain', NULL, NULL),
(27, 'Baccarat', 'Baccarat — французская компания, основанная в 1764 году, известная своими хрустальными изделиями и эксклюзивными парфюмами, такими как Les Larmes Sacrées de Thèbes. Ароматы Baccarat сочетают роскошь, искусство и уникальный дизайн.', '');

-- --------------------------------------------------------

--
-- Структура таблицы `brandstranslation`
--

CREATE TABLE `brandstranslation` (
  `id` int(10) UNSIGNED NOT NULL,
  `brand_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `brandstranslation`
--

INSERT INTO `brandstranslation` (`id`, `brand_id`, `locale`, `title`, `description`, `meta_title`, `meta_description`) VALUES
(1, 1, 'ru', 'Chanel', 'Винтажные оригинальные украшения, одежда и ароматы бренда Chanel', 'Chanel - винтажные оригинальные вещи и ароматы', 'Продажа винтажных оригинальных украшений, одежды и ароматов бренда Chanel. Уникальные коллекции для ценителей.'),
(2, 1, 'en', 'Chanel', 'Vintage original jewelry, clothing, and fragrances by Chanel', 'Chanel - Vintage Original Items and Fragrances', 'Selling vintage original jewelry, clothing, and fragrances by Chanel. Unique collections for connoisseurs.'),
(3, 1, 'es', 'Chanel', 'Joyería, ropa y fragancias originales vintage de Chanel', 'Chanel - Artículos y Fragancias Originales Vintage', 'Venta de joyería, ropa y fragancias originales vintage de Chanel. Colecciones únicas para conocedores.'),
(4, 1, 'fr', 'Chanel', 'Bijoux, vêtements et parfums originaux vintage de Chanel', 'Chanel - Articles et Parfums Originaux Vintage', 'Vente de bijoux, vêtements et parfums originaux vintage de Chanel. Collections uniques pour les connaisseurs.'),
(5, 1, 'ja', 'シャネル', 'シャネルのヴィンテージのオリジナルジュエリー、衣類、香水', 'シャネル - ヴィンテージのオリジナルアイテムと香水', 'シャネルのヴィンテージのオリジナルジュエリー、衣類、香水を販売。コレクター向けのユニークなコレクション。'),
(6, 1, 'zh', '香奈儿', '香奈儿的复古原装珠宝、服装和香水', '香奈儿 - 复古原装商品和香水', '销售香奈儿的复古原装珠宝、服装和香水。为鉴赏家提供独特的收藏品。'),
(7, 1, 'de', 'Chanel', 'Vintage originale Schmuckstücke, Kleidung und Düfte von Chanel', 'Chanel - Vintage Originalartikel und Düfte', 'Verkauf von vintage original Schmuckstücken, Kleidung und Düften von Chanel. Einzigartige Kollektionen für Kenner.'),
(8, 2, 'ru', 'Cerruti 1881', 'Nino Cerruti — знаменитый итальянский модельер и основатель бренда Cerruti 1881, оказавший значительное влияние на мировую моду. Родился в 1930 году в Бьелле, Италия, и в 1967 году открыл свой дом моды в Париже, представив мужскую коллекцию prêt-à-porter под маркой Cerruti 1881. В 1972 году была запущена женская линия одежды. Cerruti известен элегантными костюмами, инновационным дизайном и тесной связью с киноиндустрией, создавая костюмы для фильмов, таких как Basic Instinct и Pretty Woman.', 'Cerruti 1881 — ароматы от Nino Cerruti', 'Cerruti 1881 предлагает широкий ассортимент парфюмерии от Nino Cerruti, включая мужские и женские ароматы, сочетающие элегантность и современность.'),
(9, 2, 'en', 'Cerruti 1881', 'Nino Cerruti is a renowned Italian fashion designer and the founder of Cerruti 1881, a brand that has had a significant influence on global fashion. Born in 1930 in Biella, Italy, he opened his own fashion house in Paris in 1967, presenting a men’s prêt-à-porter collection under the Cerruti 1881 label. In 1972, he launched a women’s clothing line. Cerruti is known for elegant suits, innovative design approaches, and close ties to the film industry, creating costumes for movies such as Basic Instinct and Pretty Woman.', 'Cerruti 1881 — fragrances by Nino Cerruti', 'Cerruti 1881 offers a wide range of perfumes by Nino Cerruti, including men\'s and women\'s scents that combine elegance and modernity.'),
(10, 2, 'es', 'Cerruti 1881', 'Nino Cerruti es un famoso diseñador de moda italiano y fundador de la marca Cerruti 1881, que ha tenido una influencia significativa en la moda mundial. Nacido en 1930 en Biella, Italia, abrió su propia casa de moda en París en 1967, presentando una colección prêt-à-porter masculina bajo la marca Cerruti 1881. En 1972 lanzó una línea de ropa femenina. Cerruti es conocido por sus elegantes trajes, enfoques innovadores de diseño y estrecha relación con la industria cinematográfica, creando vestuarios para películas como Basic Instinct y Pretty Woman.', 'Cerruti 1881 — perfumes de Nino Cerruti', 'Cerruti 1881 ofrece una amplia gama de perfumes de Nino Cerruti, incluyendo fragancias para hombres y mujeres que combinan elegancia y modernidad.'),
(11, 2, 'fr', 'Cerruti 1881', 'Nino Cerruti est un célèbre créateur de mode italien et fondateur de la marque Cerruti 1881, qui a eu une influence significative sur la mode mondiale. Né en 1930 à Biella, en Italie, il ouvre sa maison de couture à Paris en 1967, présentant une collection de prêt-à-porter pour hommes sous la marque Cerruti 1881. En 1972, il lance une ligne de vêtements pour femmes. Cerruti est connu pour ses costumes élégants, ses approches de design innovantes et ses liens étroits avec le cinéma, créant des costumes pour des films tels que Basic Instinct et Pretty Woman.', 'Cerruti 1881 — parfums de Nino Cerruti', 'Cerruti 1881 propose une large gamme de parfums de Nino Cerruti, y compris des senteurs pour hommes et femmes alliant élégance et modernité.'),
(12, 2, 'ja', 'Cerruti 1881', 'ニーノ・チェルッティは著名なイタリアのファッションデザイナーで、Cerruti 1881の創設者です。世界のファッションに大きな影響を与えました。1930年にイタリアのビエッラで生まれ、1967年にパリで自身のファッションハウスを開設し、Cerruti 1881のブランドで男性向けプレタポルテコレクションを発表しました。1972年には女性向け衣料ラインも開始しました。チェルッティはエレガントなスーツ、革新的なデザイン、映画産業との密接な関係で知られ、『氷の微笑』や『プリティ・ウーマン』などの衣装も手掛けています。', 'Cerruti 1881 — ニーノ・チェルッティの香水', 'Cerruti 1881は、ニーノ・チェルッティによる香水の広範なラインを提供しており、男性と女性の香りがエレガンスと現代性を融合しています。'),
(13, 2, 'zh', 'Cerruti 1881', 'Nino Cerruti 是著名的意大利时装设计师，也是 Cerruti 1881 品牌的创始人，对全球时尚产生了重要影响。他于1930年出生在意大利比耶拉，并于1967年在巴黎开设自己的时装屋，推出 Cerruti 1881 男士成衣系列。1972年，他还推出了女装系列。Cerruti 以优雅的西装、创新的设计理念以及与电影界的紧密联系而闻名，为《致命诱惑》和《漂亮女人》等电影设计服装。', 'Cerruti 1881 — Nino Cerruti 的香水', 'Cerruti 1881 提供 Nino Cerruti 的广泛香水系列，包括男士和女士香氛，融合优雅与现代感。'),
(14, 2, 'de', 'Cerruti 1881', 'Nino Cerruti ist ein renommierter italienischer Modedesigner und Gründer der Marke Cerruti 1881, die einen bedeutenden Einfluss auf die weltweite Mode ausübte. Er wurde 1930 in Biella, Italien, geboren und eröffnete 1967 sein eigenes Modehaus in Paris, in dem er eine Herren-Prêt-à-porter-Kollektion unter dem Label Cerruti 1881 präsentierte. 1972 lancierte er eine Damenbekleidungslinie. Cerruti ist bekannt für elegante Anzüge, innovative Designansätze und enge Verbindungen zur Filmindustrie und kreierte Kostüme für Filme wie Basic Instinct und Pretty Woman.', 'Cerruti 1881 — Düfte von Nino Cerruti', 'Cerruti 1881 bietet eine breite Palette an Parfums von Nino Cerruti, darunter Herren- und Damendüfte, die Eleganz und Modernität vereinen.'),
(15, 3, 'ru', 'Guy Laroche', 'Винтажные оригинальные украшения, одежда и ароматы бренда Guy Laroche', 'Guy Laroche - винтажные оригинальные вещи и ароматы', 'Продажа винтажных оригинальных украшений, одежды и ароматов бренда Guy Laroche. Уникальные коллекции для ценителей.'),
(16, 3, 'en', 'Guy Laroche', 'Vintage original jewelry, clothing, and fragrances by Guy Laroche', 'Guy Laroche - Vintage Original Items and Fragrances', 'Selling vintage original jewelry, clothing, and fragrances by Guy Laroche. Unique collections for connoisseurs.'),
(17, 3, 'es', 'Guy Laroche', 'Joyería, ropa y fragancias originales vintage de Guy Laroche', 'Guy Laroche - Artículos y Fragancias Originales Vintage', 'Venta de joyería, ropa y fragancias originales vintage de Guy Laroche. Colecciones únicas para conocedores.'),
(18, 3, 'fr', 'Guy Laroche', 'Bijoux, vêtements et parfums originaux vintage de Guy Laroche', 'Guy Laroche - Articles et Parfums Originaux Vintage', 'Vente de bijoux, vêtements et parfums originaux vintage de Guy Laroche. Collections uniques pour les connaisseurs.'),
(19, 3, 'ja', 'ギィ・ラロッシュ', 'ギィ・ラロッシュのヴィンテージのオリジナルジュエリー、衣類、香水', 'ギィ・ラロッシュ - ヴィンテージのオリジナルアイテムと香水', 'ギィ・ラロッシュのヴィンテージのオリジナルジュエリー、衣類、香水を販売。コレクター向けのユニークなコレクション。'),
(20, 3, 'zh', '吉·拉罗什', '吉·拉罗什的复古原装珠宝、服装和香水', '吉·拉罗什 - 复古原装商品和香水', '销售吉·拉罗什的复古原装珠宝、服装和香水。为鉴赏家提供独特的收藏品。'),
(21, 3, 'de', 'Guy Laroche', 'Vintage originale Schmuckstücke, Kleidung und Düfte von Guy Laroche', 'Guy Laroche - Vintage Originalartikel und Düfte', 'Verkauf von vintage original Schmuckstücken, Kleidung und Düften von Guy Laroche. Einzigartige Kollektionen für Kenner.'),
(22, 4, 'ru', 'Ciner', 'Винтажные оригинальные украшения бренда Ciner', 'Ciner - винтажные оригинальные украшения', 'Продажа винтажных оригинальных украшений бренда Ciner. Уникальные коллекции для ценителей.'),
(23, 4, 'en', 'Ciner', 'Vintage original jewelry by Ciner', 'Ciner - Vintage Original Jewelry', 'Selling vintage original jewelry by Ciner. Unique collections for connoisseurs.'),
(24, 4, 'es', 'Ciner', 'Joyería original vintage de Ciner', 'Ciner - Joyería Original Vintage', 'Venta de joyería original vintage de Ciner. Colecciones únicas para conocedores.'),
(25, 4, 'fr', 'Ciner', 'Bijoux originaux vintage de Ciner', 'Ciner - Bijoux Originaux Vintage', 'Vente de bijoux originaux vintage de Ciner. Collections uniques pour les connaisseurs.'),
(26, 4, 'ja', 'シナー', 'シナーのヴィンテージのオリジナルジュエリー', 'シナー - ヴィンテージのオリジナルジュエリー', 'シナーのヴィンテージのオリジナルジュエリーを販売。コレクター向けのユニークなコレクション。'),
(27, 4, 'zh', '西纳', '西纳的复古原装珠宝', '西纳 - 复古原装珠宝', '销售西纳的复古原装珠宝。为鉴赏家提供独特的收藏品。'),
(28, 4, 'de', 'Ciner', 'Vintage originale Schmuckstücke von Ciner', 'Ciner - Vintage Original Schmuckstücke', 'Verkauf von vintage original Schmuckstücken von Ciner. Einzigartige Kollektionen für Kenner.'),
(29, 5, 'ru', 'Dior', 'Винтажные оригинальные украшения, одежда и ароматы бренда Dior', 'Dior - винтажные оригинальные вещи и ароматы', 'Продажа винтажных оригинальных украшений, одежды и ароматов бренда Dior. Уникальные коллекции для ценителей.'),
(30, 5, 'en', 'Dior', 'Vintage original jewelry, clothing, and fragrances by Dior', 'Dior - Vintage Original Items and Fragrances', 'Selling vintage original jewelry, clothing, and fragrances by Dior. Unique collections for connoisseurs.'),
(31, 5, 'es', 'Dior', 'Joyería, ropa y fragancias originales vintage de Dior', 'Dior - Artículos y Fragancias Originales Vintage', 'Venta de joyería, ropa y fragancias originales vintage de Dior. Colecciones únicas para conocedores.'),
(32, 5, 'fr', 'Dior', 'Bijoux, vêtements et parfums originaux vintage de Dior', 'Dior - Articles et Parfums Originaux Vintage', 'Vente de bijoux, vêtements et parfums originaux vintage de Dior. Collections uniques pour les connaisseurs.'),
(33, 5, 'ja', 'ディオール', 'ディオールのヴィンテージのオリジナルジュエリー、衣類、香水', 'ディオール - ヴィンテージのオリジナルアイテムと香水', 'ディオールのヴィンテージのオリジナルジュエリー、衣類、香水を販売。コレクター向けのユニークなコレクション。'),
(34, 5, 'zh', '迪奥', '迪奥的复古原装珠宝、服装和香水', '迪奥 - 复古原装商品和香水', '销售迪奥的复古原装珠宝、服装和香水。为鉴赏家提供独特的收藏品。'),
(35, 5, 'de', 'Dior', 'Vintage originale Schmuckstücke, Kleidung und Düfte von Dior', 'Dior - Vintage Originalartikel und Düfte', 'Verkauf von vintage original Schmuckstücken, Kleidung und Düften von Dior. Einzigartige Kollektionen für Kenner.'),
(36, 6, 'ru', 'Swarovski', 'Винтажные оригинальные украшения бренда Swarovski', 'Swarovski - винтажные оригинальные украшения', 'Продажа винтажных оригинальных украшений бренда Swarovski. Уникальные коллекции для ценителей.'),
(37, 6, 'en', 'Swarovski', 'Vintage original jewelry by Swarovski', 'Swarovski - Vintage Original Jewelry', 'Selling vintage original jewelry by Swarovski. Unique collections for connoisseurs.'),
(38, 6, 'es', 'Swarovski', 'Joyería original vintage de Swarovski', 'Swarovski - Joyería Original Vintage', 'Venta de joyería original vintage de Swarovski. Colecciones únicas para conocedores.'),
(39, 6, 'fr', 'Swarovski', 'Bijoux originaux vintage de Swarovski', 'Swarovski - Bijoux Originaux Vintage', 'Vente de bijoux originaux vintage de Swarovski. Collections uniques pour les connaisseurs.'),
(40, 6, 'ja', 'スワロフスキー', 'スワロフスキーのヴィンテージのオリジナルジュエリー', 'スワロフスキー - ヴィンテージのオリジナルジュエリー', 'スワロフスキーのヴィンテージのオリジナルジュエリーを販売。コレクター向けのユニークなコレクション。'),
(41, 6, 'zh', '施华洛世奇', '施华洛世奇的复古原装珠宝', '施华洛世奇 - 复古原装珠宝', '销售施华洛世奇的复古原装珠宝。为鉴赏家提供独特的收藏品。'),
(42, 6, 'de', 'Swarovski', 'Vintage originale Schmuckstücke von Swarovski', 'Swarovski - Vintage Original Schmuckstücke', 'Verkauf von vintage original Schmuckstücken von Swarovski. Einzigartige Kollektionen für Kenner.'),
(43, 7, 'ru', 'Manoush', 'Винтажные оригинальные украшения, одежда и ароматы бренда Manoush', 'Manoush - винтажные оригинальные вещи и ароматы', 'Продажа винтажных оригинальных украшений, одежды и ароматов бренда Manoush. Уникальные коллекции для ценителей.'),
(44, 7, 'en', 'Manoush', 'Vintage original jewelry, clothing, and fragrances by Manoush', 'Manoush - Vintage Original Items and Fragrances', 'Selling vintage original jewelry, clothing, and fragrances by Manoush. Unique collections for connoisseurs.'),
(45, 7, 'es', 'Manoush', 'Joyería, ropa y fragancias originales vintage de Manoush', 'Manoush - Artículos y Fragancias Originales Vintage', 'Venta de joyería, ropa y fragancias originales vintage de Manoush. Colecciones únicas para conocedores.'),
(46, 7, 'fr', 'Manoush', 'Bijoux, vêtements et parfums originaux vintage de Manoush', 'Manoush - Articles et Parfums Originaux Vintage', 'Vente de bijoux, vêtements et parfums originaux vintage de Manoush. Collections uniques pour les connaisseurs.'),
(47, 7, 'ja', 'マヌーシュ', 'マヌーシュのヴィンテージのオリジナルジュエリー、衣類、香水', 'マヌーシュ - ヴィンテージのオリジナルアイテムと香水', 'マヌーシュのヴィンテージのオリジナルジュエリー、衣類、香水を販売。コレクター向けのユニークなコレクション。'),
(48, 7, 'zh', '马努什', '马努什的复古原装珠宝、服装和香水', '马努什 - 复古原装商品和香水', '销售马努什的复古原装珠宝、服装和香水。为鉴赏家提供独特的收藏品。'),
(49, 7, 'de', 'Manoush', 'Vintage originale Schmuckstücke, Kleidung und Düfte von Manoush', 'Manoush - Vintage Originalartikel und Düfte', 'Verkauf von vintage original Schmuckstücken, Kleidung und Düften von Manoush. Einzigartige Kollektionen für Kenner.'),
(50, 8, 'ru', 'The Kooples', 'Винтажные оригинальные украшения, одежда и аксессуары бренда The Kooples', 'The Kooples - винтажные оригинальные вещи и аксессуары', 'Продажа винтажных оригинальных украшений, одежды и аксессуаров бренда The Kooples. Уникальные коллекции для ценителей.'),
(51, 8, 'en', 'The Kooples', 'Vintage original jewelry, clothing, and accessories by The Kooples', 'The Kooples - Vintage Original Items and Accessories', 'Selling vintage original jewelry, clothing, and accessories by The Kooples. Unique collections for connoisseurs.'),
(52, 8, 'es', 'The Kooples', 'Joyería, ropa y accesorios originales vintage de The Kooples', 'The Kooples - Artículos y Accesorios Originales Vintage', 'Venta de joyería, ropa y accesorios originales vintage de The Kooples. Colecciones únicas para conocedores.'),
(53, 8, 'fr', 'The Kooples', 'Bijoux, vêtements et accessoires originaux vintage de The Kooples', 'The Kooples - Articles et Accessoires Originaux Vintage', 'Vente de bijoux, vêtements et accessoires originaux vintage de The Kooples. Collections uniques pour les connaisseurs.'),
(54, 8, 'ja', 'ザ・クープルズ', 'ザ・クープルズのヴィンテージのオリジナルジュエリー、衣類、アクセサリー', 'ザ・クープルズ - ヴィンテージのオリジナルアイテムとアクセサリー', 'ザ・クープルズのヴィンテージのオリジナルジュエリー、衣類、アクセサリーを販売。コレクター向けのユニークなコレクション。'),
(55, 8, 'zh', 'The Kooples', 'The Kooples 的复古原装珠宝、服装和配饰', 'The Kooples - 复古原装商品和配饰', '销售 The Kooples 的复古原装珠宝、服装和配饰。为鉴赏家提供独特的收藏品。'),
(56, 8, 'de', 'The Kooples', 'Vintage originale Schmuckstücke, Kleidung und Accessoires von The Kooples', 'The Kooples - Vintage Originalartikel und Accessoires', 'Verkauf von vintage original Schmuckstücken, Kleidung und Accessoires von The Kooples. Einzigartige Kollektionen für Kenner.'),
(57, 9, 'ru', 'Balmain', 'Винтажные оригинальные украшения, одежда и аксессуары бренда Balmain', 'Balmain - винтажные оригинальные вещи и аксессуары', 'Продажа винтажных оригинальных украшений, одежды и аксессуаров бренда Balmain. Уникальные коллекции для ценителей.'),
(58, 9, 'en', 'Balmain', 'Vintage original jewelry, clothing, and accessories by Balmain', 'Balmain - Vintage Original Items and Accessories', 'Selling vintage original jewelry, clothing, and accessories by Balmain. Unique collections for connoisseurs.'),
(59, 9, 'es', 'Balmain', 'Joyería, ropa y accesorios originales vintage de Balmain', 'Balmain - Artículos y Accesorios Originales Vintage', 'Venta de joyería, ropa y accesorios originales vintage de Balmain. Colecciones únicas para conocedores.'),
(60, 9, 'fr', 'Balmain', 'Bijoux, vêtements et accessoires originaux vintage de Balmain', 'Balmain - Articles et Accessoires Originaux Vintage', 'Vente de bijoux, vêtements et accessoires originaux vintage de Balmain. Collections uniques pour les connaisseurs.'),
(61, 9, 'ja', 'バルマン', 'バルマンのヴィンテージのオリジナルジュエリー、衣類、アクセサリー', 'バルマン - ヴィンテージのオリジナルアイテムとアクセサリー', 'バルマンのヴィンテージのオリジナルジュエリー、衣類、アクセサリーを販売。コレクター向けのユニークなコレクション。'),
(62, 9, 'zh', '巴尔曼', '巴尔曼的复古原装珠宝、服装和配饰', '巴尔曼 - 复古原装商品和配饰', '销售巴尔曼的复古原装珠宝、服装和配饰。为鉴赏家提供独特的收藏品。'),
(63, 9, 'de', 'Balmain', 'Vintage originale Schmuckstücke, Kleidung und Accessoires von Balmain', 'Balmain - Vintage Originalartikel und Accessoires', 'Verkauf von vintage original Schmuckstücken, Kleidung und Accessoires von Balmain. Einzigartige Kollektionen für Kenner.'),
(64, 10, 'ru', 'Fuzeau', 'Винтажные оригинальные украшения и аксессуары бренда Fuzeau', 'Fuzeau - винтажные оригинальные украшения и аксессуары', 'Продажа винтажных оригинальных украшений и аксессуаров бренда Fuzeau. Уникальные коллекции для ценителей.'),
(65, 10, 'en', 'Fuzeau', 'Vintage original jewelry and accessories by Fuzeau', 'Fuzeau - Vintage Original Jewelry and Accessories', 'Selling vintage original jewelry and accessories by Fuzeau. Unique collections for connoisseurs.'),
(66, 10, 'es', 'Fuzeau', 'Joyería y accesorios originales vintage de Fuzeau', 'Fuzeau - Joyería y Accesorios Originales Vintage', 'Venta de joyería y accesorios originales vintage de Fuzeau. Colecciones únicas para conocedores.'),
(67, 10, 'fr', 'Fuzeau', 'Bijoux et accessoires originaux vintage de Fuzeau', 'Fuzeau - Bijoux et Accessoires Originaux Vintage', 'Vente de bijoux et accessoires originaux vintage de Fuzeau. Collections uniques pour les connaisseurs.'),
(68, 10, 'ja', 'フゾー', 'フゾーのヴィンテージのオリジナルジュエリーとアクセサリー', 'フゾー - ヴィンテージのオリジナルジュエリーとアクセサリー', 'フゾーのヴィンテージのオリジナルジュエリーとアクセサリーを販売。コレクター向けのユニークなコレクション。'),
(69, 10, 'zh', '富佐欧', '富佐欧的复古原装珠宝和配饰', '富佐欧 - 复古原装珠宝和配饰', '销售富佐欧的复古原装珠宝和配饰。为鉴赏家提供独特的收藏品。'),
(70, 10, 'de', 'Fuzeau', 'Vintage originale Schmuckstücke und Accessoires von Fuzeau', 'Fuzeau - Vintage Originalschmuck und Accessoires', 'Verkauf von vintage original Schmuckstücken und Accessoires von Fuzeau. Einzigartige Kollektionen für Kenner.'),
(71, 11, 'ru', 'Orena', 'Винтажные оригинальные украшения бренда Orena', 'Orena - винтажные оригинальные украшения', 'Продажа винтажных оригинальных украшений бренда Orena. Уникальные коллекции для ценителей.'),
(72, 11, 'en', 'Orena', 'Vintage original jewelry by Orena', 'Orena - Vintage Original Jewelry', 'Selling vintage original jewelry by Orena. Unique collections for connoisseurs.'),
(73, 11, 'es', 'Orena', 'Joyería original vintage de Orena', 'Orena - Joyería Original Vintage', 'Venta de joyería original vintage de Orena. Colecciones únicas para conocedores.'),
(74, 11, 'fr', 'Orena', 'Bijoux originaux vintage de Orena', 'Orena - Bijoux Originaux Vintage', 'Vente de bijoux originaux vintage de Orena. Collections uniques pour les connaisseurs.'),
(75, 11, 'ja', 'オレナ', 'オレナのヴィンテージのオリジナルジュエリー', 'オレナ - ヴィンテージのオリジナルジュエリー', 'オレナのヴィンテージのオリジナルジュエリーを販売。コレクター向けのユニークなコレクション。'),
(76, 11, 'zh', '奥雷纳', '奥雷纳的复古原装珠宝', '奥雷纳 - 复古原装珠宝', '销售奥雷纳的复古原装珠宝。为鉴赏家提供独特的收藏品。'),
(77, 11, 'de', 'Orena', 'Vintage originale Schmuckstücke von Orena', 'Orena - Vintage Originalschmuck', 'Verkauf von vintage original Schmuckstücken von Orena. Einzigartige Kollektionen für Kenner.'),
(78, 12, 'ru', 'Givenchy', 'Винтажные оригинальные украшения, одежда и ароматы бренда Givenchy', 'Givenchy - винтажные оригинальные вещи и ароматы', 'Продажа винтажных оригинальных украшений, одежды и ароматов бренда Givenchy. Уникальные коллекции для ценителей.'),
(79, 12, 'en', 'Givenchy', 'Vintage original jewelry, clothing, and fragrances by Givenchy', 'Givenchy - Vintage Original Items and Fragrances', 'Selling vintage original jewelry, clothing, and fragrances by Givenchy. Unique collections for connoisseurs.'),
(80, 12, 'es', 'Givenchy', 'Joyería, ropa y fragancias originales vintage de Givenchy', 'Givenchy - Artículos y Fragancias Originales Vintage', 'Venta de joyería, ropa y fragancias originales vintage de Givenchy. Colecciones únicas para conocedores.'),
(81, 12, 'fr', 'Givenchy', 'Bijoux, vêtements et parfums originaux vintage de Givenchy', 'Givenchy - Articles et Parfums Originaux Vintage', 'Vente de bijoux, vêtements et parfums originaux vintage de Givenchy. Collections uniques pour les connaisseurs.'),
(82, 12, 'ja', 'ジバンシィ', 'ジバンシィのヴィンテージのオリジナルジュエリー、衣類、香水', 'ジバンシィ - ヴィンテージのオリジナルアイテムと香水', 'ジバンシィのヴィンテージのオリジナルジュエリー、衣類、香水を販売。コレクター向けのユニークなコレクション。'),
(83, 12, 'zh', '纪梵希', '纪梵希的复古原装珠宝、服装和香水', '纪梵希 - 复古原装商品和香水', '销售纪梵希的复古原装珠宝、服装和香水。为鉴赏家提供独特的收藏品。'),
(84, 12, 'de', 'Givenchy', 'Vintage originale Schmuckstücke, Kleidung und Düfte von Givenchy', 'Givenchy - Vintage Originalartikel und Düfte', 'Verkauf von vintage original Schmuckstücken, Kleidung und Düften von Givenchy. Einzigartige Kollektionen für Kenner.'),
(85, 13, 'ru', 'Yves Saint Laurent', 'Винтажные ароматы, аксессуары и редкие коллекционные вещи Yves Saint Laurent.', 'Винтаж Yves Saint Laurent — ароматы и аксессуары', 'Откройте редкие винтажные ароматы, аксессуары и уникальные коллекционные вещи Yves Saint Laurent в нашем интернет-магазине.'),
(86, 13, 'en', 'Yves Saint Laurent', 'Vintage fragrances, accessories and rare collectible items from Yves Saint Laurent.', 'Vintage Yves Saint Laurent — Fragrances & Accessories', 'Discover rare vintage fragrances, accessories and unique collectible pieces from Yves Saint Laurent in our online store.'),
(87, 13, 'de', 'Yves Saint Laurent', 'Vintage-Düfte, Accessoires und seltene Sammlerstücke von Yves Saint Laurent.', 'Vintage Yves Saint Laurent — Düfte & Accessoires', 'Entdecken Sie seltene Vintage-Düfte, Accessoires und einzigartige Sammlerstücke von Yves Saint Laurent in unserem Online-Shop.'),
(88, 13, 'es', 'Yves Saint Laurent', 'Perfumes vintage, accesorios y piezas de colección raras de Yves Saint Laurent.', 'Yves Saint Laurent vintage — Perfumes y accesorios', 'Descubre perfumes vintage raros, accesorios y artículos únicos de colección Yves Saint Laurent en nuestra tienda online.'),
(89, 13, 'fr', ' Yves Saint Laurent', 'Parfums vintage, accessoires et pièces de collection rares Yves Saint Laurent.', 'Yves Saint Laurent vintage — Parfums & Accessoires', 'Découvrez des parfums vintage rares, des accessoires et des pièces uniques de collection Yves Saint Laurent dans notre boutique en ligne.'),
(90, 13, 'ja', 'イヴ・サンローラン (Yves Saint Laurent)', 'ヴィンテージ香水、アクセサリー、希少なコレクションアイテム', 'ヴィンテージ イヴ・サンローラン — 香水とアクセサリー', '当店では、希少なヴィンテージ香水、アクセサリー、イヴ・サンローランのユニークなコレクションをお楽しみいただけます。'),
(91, 13, 'zh', '圣罗兰 (Yves Saint Laurent)', '复古香水、配饰和稀有收藏品', '复古圣罗兰 — 香水与配饰', '在我们的网上商店探索稀有的复古圣罗兰香水、配饰和独特的收藏级单品。'),
(92, 14, 'ru', 'Hermès', 'Винтажные ароматы, аксессуары и редкие коллекционные вещи Hermès.', 'Hermès — ароматы и аксессуары', 'Откройте для себя винтажные ароматы, эксклюзивные аксессуары и редкие коллекционные вещи Hermès в нашем интернет-магазине.'),
(93, 14, 'en', 'Hermès', 'Vintage fragrances, accessories and rare collectible items from Hermès.', 'Vintage Hermès — Fragrances & Accessories', 'Explore vintage fragrances, exclusive accessories and rare collectible pieces from Hermès in our online store.'),
(94, 14, 'de', 'Hermès', 'Vintage-Düfte, Accessoires und seltene Sammlerstücke von Hermès.', 'Vintage Hermès — Düfte & Accessoires', 'Entdecken Sie exklusive Vintage-Düfte, Accessoires und einzigartige Sammlerstücke von Hermès in unserem Online-Shop.'),
(95, 14, 'es', 'Hermès', 'Perfumes vintage, accesorios y piezas de colección raras de Hermès.', 'Hermès vintage — Perfumes y accesorios', 'Descubre perfumes vintage, accesorios exclusivos y artículos de colección únicos de Hermès en nuestra tienda online.'),
(96, 14, 'fr', 'Hermès', 'Parfums vintage, accessoires et pièces de collection rares Hermès.', 'Hermès vintage — Parfums & Accessoires', 'Découvrez des parfums vintage, des accessoires exclusifs et des pièces de collection rares Hermès dans notre boutique en ligne.'),
(97, 14, 'ja', 'エルメス (Hermès)', 'ヴィンテージ香水、アクセサリー、希少なコレクションアイテム。', 'ヴィンテージ エルメス — 香水とアクセサリー', '当店では、エルメスのヴィンテージ香水、アクセサリー、希少なコレクションアイテムを取り揃えています。'),
(98, 14, 'zh', '爱马仕 (Hermès)', '复古香水、配饰和稀有收藏品。', '复古爱马仕 — 香水与配饰', '在我们的网上商店探索稀有的复古爱马仕香水、配饰和独特的收藏级单品。'),
(99, 15, 'ru', 'Valentino Garavani', 'Винтажные аксессуары и редкие коллекционные вещи Valentino Garavani.', 'Valentino Garavani — аксессуары и ароматы', 'Откройте редкие винтажные аксессуары, ароматы и коллекционные вещи Valentino Garavani в нашем интернет-магазине.'),
(100, 15, 'en', ' Valentino Garavani', 'Vintage accessories and rare collectible items from Valentino Garavani.', 'Vintage Valentino Garavani — Accessories & Fragrances', 'Discover rare vintage accessories, fragrances and unique collectible pieces from Valentino Garavani in our online store.'),
(101, 15, 'de', 'Valentino Garavani', 'Vintage-Accessoires und seltene Sammlerstücke von Valentino Garavani.', 'Vintage Valentino Garavani — Accessoires & Düfte', 'Entdecken Sie seltene Vintage-Accessoires, Düfte und exklusive Sammlerstücke von Valentino Garavani in unserem Online-Shop.'),
(102, 15, 'es', 'Valentino Garavani', 'Accesorios vintage y piezas de colección raras de Valentino Garavani.', 'Valentino Garavani vintage — Accesorios y perfumes', 'Descubre accesorios vintage raros, perfumes y artículos únicos de colección Valentino Garavani en nuestra tienda online.'),
(103, 15, 'fr', 'Valentino Garavani', 'Accessoires vintage et pièces de collection rares Valentino Garavani.', 'Valentino Garavani vintage — Accessoires & Parfums', 'Découvrez des accessoires vintage rares, des parfums et des pièces uniques de collection Valentino Garavani dans notre boutique en ligne.'),
(104, 15, 'ja', 'ヴァレンティノ・ガラヴァーニ (Valentino Garavani)', 'ヴィンテージアクセサリーや希少なコレクションアイテム。', 'ヴィンテージ ヴァレンティノ・ガラヴァーニ — アクセサリーと香水', '当店では、ヴァレンティノ・ガラヴァーニの希少なヴィンテージアクセサリー、香水、コレクションアイテムをご紹介しています。'),
(105, 15, 'zh', '华伦天奴·加拉瓦尼 (Valentino Garavani)', '复古配饰和稀有收藏品。', '复古Valentino Garavani — 配饰与香水', '在我们的网上商店探索华伦天奴·加拉瓦尼的稀有复古配饰、香水和独特收藏级单品。'),
(106, 16, 'ru', 'Tabbah', 'Винтажные ювелирные украшения и редкие коллекционные аксессуары Tabbah.', 'Винтаж Tabbah — ювелирные украшения и аксессуары', 'Откройте редкие винтажные украшения, аксессуары и коллекционные изделия ювелирного дома Tabbah в нашем интернет-магазине.'),
(107, 16, 'en', 'Tabbah', 'Vintage jewelry and rare collectible accessories from Tabbah.', 'Vintage Tabbah — Jewelry & Accessories', 'Discover rare vintage jewelry, accessories and unique collectible pieces from Tabbah in our online store.'),
(108, 16, 'de', 'Tabbah', 'Vintage-Schmuck und seltene Sammlerstücke von Tabbah.', 'Vintage Tabbah — Schmuck & Accessoires', ' Entdecken Sie seltene Vintage-Schmuckstücke, Accessoires und exklusive Sammlerstücke von Tabbah in unserem Online-Shop.'),
(109, 16, 'es', 'Tabbah', '\r\ndescription:', 'Tabbah vintage — Joyería y accesorios', 'Descubre joyería vintage rara, accesorios y piezas únicas de colección de Tabbah en nuestra tienda online.'),
(110, 16, 'fr', 'Tabbah', 'Bijoux vintage et accessoires de collection rares Tabbah.', 'Tabbah vintage — Bijoux & Accessoires', 'Découvrez des bijoux vintage rares, des accessoires et des pièces uniques de collection de la maison Tabbah dans notre boutique en ligne.'),
(111, 16, 'ja', 'タバー (Tabbah)', 'ヴィンテージジュエリーや希少なアクセサリー。', 'ヴィンテージ Tabbah — ジュエリーとアクセサリー', '当店では、Tabbahの希少なヴィンテージジュエリー、アクセサリー、ユニークなコレクションアイテムをご紹介しています。'),
(112, 16, 'zh', '塔巴 (Tabbah)', '复古珠宝与稀有收藏级配饰。', '复古Tabbah — 珠宝与配饰', ' 在我们的网上商店探索Tabbah的稀有复古珠宝、配饰和独特收藏单品。'),
(113, 17, 'ru', 'Chopard', 'Chopard — это легендарный швейцарский бренд, известный своими ювелирными изделиями, аксессуарами и ароматами. Винтажные вещи Chopard (часы, ароматы, украшения) очень ценятся коллекционерами.', 'Chopard — винтажные украшения, аксессуары и ароматы', 'Винтажные украшения, ароматы и аксессуары Chopard. Коллекционные швейцарские шедевры, редкие находки для ценителей.'),
(114, 17, 'en', 'Chopard', 'Chopard is a legendary Swiss brand known for its fine jewelry, accessories, and fragrances. Vintage Chopard pieces (watches, perfumes, jewelry) are highly prized by collectors.', 'Chopard — vintage jewelry, accessories & fragrances', 'Vintage Chopard jewelry, perfumes, and accessories. Swiss collectible masterpieces for true connoisseurs.'),
(115, 17, 'de', 'Chopard', 'Chopard ist eine legendäre Schweizer Marke, bekannt für ihre edlen Schmuckstücke, Accessoires und Düfte. Vintage-Stücke von Chopard (Uhren, Parfums, Schmuck) sind bei Sammlern sehr begehrt.', 'Chopard — Vintage-Schmuck, Accessoires und Düfte', 'Vintage-Schmuck, Parfums und Accessoires von Chopard. Schweizer Sammlerstücke für Liebhaber.'),
(116, 17, 'es', 'Chopard', 'Chopard es una marca suiza legendaria, conocida por sus joyas, accesorios y perfumes. Las piezas vintage de Chopard (relojes, perfumes, joyas) son muy valoradas por los coleccionistas.', 'Chopard — joyas, accesorios y perfumes vintage', 'Joyas, perfumes y accesorios vintage de Chopard. Piezas de colección suizas únicas para amantes del lujo.'),
(117, 17, 'fr', 'Chopard', 'Chopard est une marque suisse légendaire, célèbre pour ses bijoux, accessoires et parfums. Les pièces vintage Chopard (montres, parfums, bijoux) sont très recherchées par les collectionneurs.', 'Chopard — bijoux, accessoires et parfums vintage', 'Bijoux, parfums et accessoires Chopard vintage. Pièces de collection suisses rares pour les passionnés.'),
(118, 17, 'ja', 'ショパール (Chopard)', 'ショパールは、ジュエリー、アクセサリー、香水で知られる伝説的なスイスブランドです。ヴィンテージのショパール作品（時計、香水、ジュエリー）はコレクターに高く評価されています。', 'ショパール — ヴィンテージジュエリーと香水', 'ショパールのヴィンテージ香水、ジュエリー、アクセサリー。コレクション価値のあるスイスの名品。'),
(119, 17, 'zh', '萧邦 (Chopard)', '萧邦是传奇性的瑞士品牌，以珠宝、配饰和香氛闻名。萧邦的复古作品（腕表、香水、珠宝）深受收藏家珍视。', '萧邦 — 复古珠宝、配饰与香氛', '萧邦复古香水、珠宝和配饰。瑞士收藏级精品，稀有之选。'),
(120, 18, 'ru', 'Guy Laroche Paris', 'Это французский дом моды, основанный в 1957 году дизайнером Ги Ларошем. Он известен своей элегантной и современной одеждой, а также парфюмерией и аксессуарами. Guy Laroche сочетает в своих коллекциях французскую утонченность с современными тенденциями, предлагая как женскую, так и мужскую одежду, а также парфюмерию и аксессуары.', 'Guy Laroche Paris — элегантная мода и парфюмерия', 'Guy Laroche — французский дом моды, предлагающий элегантную одежду, парфюмерию и аксессуары для женщин и мужчин.'),
(121, 18, 'en', 'Guy Laroche Paris', 'Guy Laroche Paris is a French fashion house founded in 1957 by designer Guy Laroche. It is known for its elegant and modern clothing, as well as fragrances and accessories. Guy Laroche combines French sophistication with modern trends, offering both women\'s and men\'s fashion along with perfumes and accessories.', 'Guy Laroche Paris — elegant fashion & fragrances', 'Guy Laroche — French fashion house offering elegant clothing, fragrances, and accessories for women and men.'),
(122, 18, 'de', 'Guy Laroche Paris', 'Guy Laroche Paris ist ein französisches Modehaus, das 1957 von Designer Guy Laroche gegründet wurde. Es ist bekannt für seine elegante und moderne Kleidung sowie Parfüms und Accessoires. Guy Laroche verbindet französische Raffinesse mit modernen Trends und bietet sowohl Damen- als auch Herrenmode sowie Parfüms und Accessoires an.', 'Guy Laroche Paris — elegante Mode & Parfüms', 'Guy Laroche — französisches Modehaus, das elegante Kleidung, Parfüms und Accessoires für Damen und Herren anbietet.'),
(123, 18, 'es', 'Guy Laroche Paris', 'Guy Laroche Paris est une maison de mode française fondée en 1957 par le créateur Guy Laroche. Elle est connue pour ses vêtements élégants et modernes ainsi que pour ses parfums et accessoires. Guy Laroche allie sophistication française et tendances contemporaines, proposant des vêtements pour femmes et hommes ainsi que des parfums et accessoires.', 'Guy Laroche Paris — mode élégante & parfums', 'Guy Laroche — maison de mode française offrant des vêtements élégants, des parfums et des accessoires pour femmes et hommes.'),
(124, 18, 'fr', 'Guy Laroche Paris', 'Guy Laroche Paris es una casa de moda francesa fundada en 1957 por el diseñador Guy Laroche. Es conocida por su ropa elegante y moderna, así como por sus perfumes y accesorios. Guy Laroche combina la sofisticación francesa con tendencias modernas, ofreciendo ropa para mujer y hombre, así como perfumes y accesorios.', 'Guy Laroche Paris — moda elegante y perfumes', 'Guy Laroche — casa de moda francesa que ofrece ropa elegante, perfumes y accesorios para mujeres y hombres.'),
(125, 18, 'ja', 'Guy Laroche Paris', 'Guy Laroche Parisは、1957年にデザイナーのギー・ラロッシュによって設立されたフランスのファッションハウスです。エレガントでモダンな衣服、香水、アクセサリーで知られています。Guy Larocheはフランスの洗練さと現代のトレンドを組み合わせ、女性・男性向けの服や香水、アクセサリーを提供しています。', 'Guy Laroche Paris — エレガントな服と香水', 'Guy Laroche — 女性・男性向けのエレガントな衣服、香水、アクセサリーを提供するフランスのファッションハウス。'),
(126, 18, 'zh', 'Guy Laroche Paris', 'Guy Laroche Paris是由设计师吉·拉罗什于1957年创立的法国时尚品牌。它以优雅且现代的服装、香水和配饰而闻名。Guy Laroche将法国的精致优雅与现代潮流相结合，提供男女服装以及香水和配饰。', 'Guy Laroche Paris — 优雅时尚与香水', 'Guy Laroche — 法国时尚品牌，提供优雅的男女服装、香水和配饰'),
(127, 19, 'ru', 'Cartier', 'Cartier — французский дом ювелирных изделий и часов, основанный в 1847 году. Он известен своими роскошными украшениями, часами и аксессуарами. Cartier сочетает французскую элегантность с современным стилем, предлагая изделия для женщин и мужчин.', 'Cartier — роскошные ювелирные изделия и часы', ' Cartier — французский бренд, предлагающий роскошные украшения, часы и аксессуары для женщин и мужчин.'),
(128, 19, 'en', 'Cartier', 'Cartier is a French jewelry and watch house founded in 1847. It is known for its luxurious jewelry, watches, and accessories. Cartier combines French elegance with modern style, offering pieces for women and men.', 'Cartier — luxury jewelry & watches', 'Cartier — French brand offering luxurious jewelry, watches, and accessories for women and men.'),
(129, 19, 'de', 'Cartier ', 'Cartier ist ein französisches Schmuck- und Uhrenhaus, das 1847 gegründet wurde. Es ist bekannt für seinen luxuriösen Schmuck, Uhren und Accessoires. Cartier verbindet französische Eleganz mit modernem Stil und bietet Schmuckstücke für Damen und Herren an.', 'Cartier — luxuriöser Schmuck & Uhren', 'Cartier — französische Marke, die luxuriösen Schmuck, Uhren und Accessoires für Damen und Herren anbietet.'),
(130, 19, 'es', 'Cartier', 'Cartier es una casa de joyería y relojería francesa fundada en 1847. Es conocida por sus lujosas joyas, relojes y accesorios. Cartier combina la elegancia francesa con un estilo moderno, ofreciendo piezas para mujeres y hombres.', 'Cartier combina la elegancia francesa con un estilo moderno, ofreciendo piezas para mujeres y hombres. Meta Title: Cartier — joyas y relojes de lujo', 'Cartier — marca francesa que ofrece lujosas joyas, relojes y accesorios para mujeres y hombres.'),
(131, 19, 'fr', 'Cartier', 'Cartier est une maison de joaillerie et d’horlogerie française fondée en 1847. Elle est connue pour ses bijoux, montres et accessoires de luxe. Cartier allie élégance française et style moderne, proposant des créations pour femmes et hommes.', 'Cartier — bijoux et montres de luxe', 'Cartier — marque française proposant des bijoux, montres et accessoires de luxe pour femmes et hommes.'),
(132, 19, 'ja', 'フランスのジュエリ', 'Cartierは、1847年に設立されたフランスのジュエリーと時計のブランドです。高級ジュエリー、時計、アクセサリーで知られています。Cartierはフランスのエレガンスと現代的なスタイルを組み合わせ、女性・男性向けの作品を提供しています。', 'Cartier — 高級ジュエリーと時計', 'Cartier — 女性・男性向けの高級ジュエリー、時計、アクセサリーを提供するフランスブランド。'),
(133, 19, 'zh', 'Cartier', 'Cartier是1847年创立的法国珠宝和腕表品牌，以奢华珠宝、腕表和配饰而闻名。Cartier将法国优雅与现代风格结合，为男女提供精美作品', 'Cartier — 奢华珠宝与腕表', 'Cartier — 法国品牌，提供男女奢华珠宝、腕表和配饰。'),
(134, 20, 'ru', 'Patek Philippe', 'Patek Philippe — один из самых престижных и старейших швейцарских брендов часов, основанный в 1839 году польским часовщиком Антонием Норбертом де Патеком и чешским партнёром Францишеком Чапеком в Женеве. В 1845 году к ним присоединился французский мастер Жан-Адриен Филипп, изобретатель безключевого механизма завода, что привело к образованию компании Patek Philippe & Cie в 1851 году \r\nPatek Philippe SA.\r\n\r\nPatek Philippe известен своими высококачественными часами, сочетающими традиционное швейцарское мастерство с инновациями. Компания выпускает ограниченные серии часов, что делает их особенно ценными для коллекционеров.', 'Patek Philippe — роскошные швейцарские часы', 'Patek Philippe — швейцарский бренд, известный своими высококачественными часами, сочетающими традиционное мастерство и инновации.'),
(135, 20, 'en', 'Patek Philippe ', 'Patek Philippe is one of the most prestigious and oldest Swiss watch brands, founded in 1839 by Polish watchmaker Antoni Norbert de Patek and his Czech partner Franciszek Czapek in Geneva. In 1845, French master Jean-Adrien Philippe, inventor of the keyless winding mechanism, joined them, leading to the establishment of Patek Philippe & Cie in 1851. Patek Philippe is known for its high-quality watches, combining traditional Swiss craftsmanship with innovation. The company produces limited edition watches, making them particularly valuable to collectors.', 'Patek Philippe — Luxury Swiss Watches', 'Patek Philippe is a Swiss brand known for its high-quality timepieces, blending traditional craftsmanship with innovation.'),
(136, 20, 'de', 'Patek Philippe', 'Patek Philippe ist eine der angesehensten und ältesten Schweizer Uhrenmarken, gegründet 1839 von dem polnischen Uhrmacher Antoni Norbert de Patek und seinem tschechischen Partner Franciszek Czapek in Genf. 1845 trat der französische Meister Jean-Adrien Philippe, Erfinder des schlüssellosen Aufzugsmechanismus, hinzu, was 1851 zur Gründung von Patek Philippe & Cie führte. Patek Philippe ist bekannt für seine hochwertigen Uhren, die traditionelle Schweizer Handwerkskunst mit Innovation verbinden. Das Unternehmen produziert limitierte Uhrenserien, die für Sammler besonders wertvoll sind.', 'Patek Philippe — Luxus-Schweizer-Uhren', 'Patek Philippe ist eine Schweizer Marke, die für ihre hochwertigen Zeitmesser bekannt ist, die traditionelles Handwerk mit Innovation verbinden.'),
(137, 20, 'es', 'Patek Philippe', 'Patek Philippe es una de las marcas de relojes suizos más prestigiosas y antiguas, fundada en 1839 por el relojero polaco Antoni Norbert de Patek y su socio checo Franciszek Czapek en Ginebra. En 1845 se unió a ellos el maestro francés Jean-Adrien Philippe, inventor del mecanismo de cuerda sin llave, lo que llevó a la creación de Patek Philippe & Cie en 1851. Patek Philippe es conocido por sus relojes de alta calidad, que combinan la artesanía suiza tradicional con la innovación. La empresa produce ediciones limitadas de relojes, lo que los hace especialmente valiosos para los coleccionistas.', 'Patek Philippe — Relojes suizos de lujo', 'Patek Philippe es una marca suiza conocida por sus relojes de alta calidad, que combinan la artesanía tradicional con la innovación.'),
(138, 20, 'fr', 'Patek Philippe', 'Patek Philippe est l’une des marques de montres suisses les plus prestigieuses et anciennes, fondée en 1839 par l’horloger polonais Antoni Norbert de Patek et son partenaire tchèque Franciszek Czapek à Genève. En 1845, le maître français Jean-Adrien Philippe, inventeur du mécanisme de remontage sans clé, les a rejoints, ce qui a conduit à la création de Patek Philippe & Cie en 1851. Patek Philippe est réputé pour ses montres de haute qualité, alliant artisanat suisse traditionnel et innovation. L’entreprise produit des séries limitées de montres, les rendant particulièrement précieuses pour les collectionneurs.', 'Patek Philippe — Montres suisses de luxe', 'Patek Philippe est une marque suisse reconnue pour ses montres de haute qualité, alliant artisanat traditionnel et innovation.'),
(139, 20, 'ja', 'Patek Philippe', 'Patek Philippeは、1839年にポーランドの時計職人アントニ・ノルベルト・ド・パテックとチェコ人のパートナー、フランチシェク・チャペクによってジュネーブで設立された、最も権威ある古いスイスの時計ブランドのひとつです。1845年にはフランスの職人ジャン＝アドリアン・フィリップが合流し、鍵不要の巻き上げ機構を発明し、1851年にPatek Philippe & Cieが設立されました。Patek Philippeは、伝統的なスイスの職人技と革新を融合させた高品質な時計で知られています。会社は限定版の時計を製造しており、コレクターにとって特に価値があります。', 'Patek Philippe — 高級スイス時計', 'Patek Philippeは、伝統的な職人技と革新を融合させた高品質な時計で知られるスイスのブランドです。'),
(140, 20, 'zh', 'Patek Philippe', 'Patek Philippe是最负盛名和最古老的瑞士制表品牌之一，成立于1839年，由波兰制表师安东尼·诺贝尔特·德·帕特克和捷克伙伴弗朗西谢克·查佩克在日内瓦创立。1845年，法国大师让-阿德里安·菲利普加入，他们发明了无钥匙上链机制，并于1851年成立了Patek Philippe & Cie。Patek Philippe以高品质手表著称，融合了传统瑞士工艺与创新。公司生产限量版手表，使其对收藏家特别有价值。', 'Patek Philippe — 瑞士奢华手表', 'Patek Philippe 是一家瑞士品牌，以其高质量的手表而闻名，融合了传统工艺和创新'),
(141, 21, 'ru', 'Longines', 'Longines — один из старейших и самых известных швейцарских брендов часов, основанный в 1832 году в Сен-Имье. Он известен своими элегантными и точными часами, сочетающими швейцарское мастерство и инновации. Longines производит классические и спортивные часы, а также участвует в мировых спортивных соревнованиях в качестве официального хронометриста.', 'Longines — элегантные швейцарские часы', 'Longines — швейцарский бренд, предлагающий элегантные и точные часы для мужчин и женщин.'),
(142, 21, 'en', 'Longines', 'Longines is one of the oldest and most renowned Swiss watch brands, founded in 1832 in Saint-Imier. It is known for its elegant and precise watches, combining Swiss craftsmanship with innovation. Longines produces both classic and sports watches and serves as an official timekeeper in global sporting events.', 'Longines — elegant Swiss watches', 'Longines is a Swiss brand offering elegant and precise watches for men and women.'),
(143, 21, 'de', 'Longines', 'Longines ist eine der ältesten und bekanntesten Schweizer Uhrenmarken, gegründet 1832 in Saint-Imier. Bekannt für elegante und präzise Uhren, die Schweizer Handwerkskunst mit Innovation verbinden. Longines produziert klassische und Sportuhren und ist offizieller Zeitnehmer bei internationalen Sportveranstaltungen.', 'Longines — elegante Schweizer Uhren', 'Longines — Schweizer Marke, die elegante und präzise Uhren für Männer und Frauen anbietet.'),
(144, 21, 'es', 'Longines', 'Longines es una de las marcas de relojes suizos más antiguas y reconocidas, fundada en 1832 en Saint-Imier. Es conocida por sus relojes elegantes y precisos, que combinan la artesanía suiza con innovación. Longines produce relojes clásicos y deportivos, y actúa como cronometrador oficial en competiciones deportivas mundiales.', 'Longines — relojes suizos elegantes', 'Longines — marca suiza que ofrece relojes elegantes y precisos para hombres y mujeres.'),
(145, 21, 'fr', 'Longines', 'Longines est l’une des plus anciennes et célèbres marques suisses de montres, fondée en 1832 à Saint-Imier. Elle est connue pour ses montres élégantes et précises, alliant savoir-faire suisse et innovation. Longines produit des montres classiques et sportives et est chronométreur officiel lors de compétitions sportives mondiales.', 'Longines — montres suisses élégantes', 'Longines — marque suisse proposant des montres élégantes et précises pour hommes et femmes.'),
(146, 21, 'ja', 'Longines', 'Longinesは、1832年にサン＝イミエで設立された、最も古く有名なスイスの時計ブランドのひとつです。エレガントで正確な時計で知られ、スイスの職人技と革新を融合させています。Longinesはクラシック時計とスポーツ時計を製造し、世界のスポーツ大会で公式タイムキーパーを務めています。', 'Longines — エレガントなスイス時計', 'Longinesは、男性・女性向けのエレガントで正確な時計を提供するスイスのブランドです'),
(147, 21, 'zh', 'Longines', 'Longines是最古老和最著名的瑞士手表品牌之一，成立于1832年在圣伊米耶。以优雅和精确的手', 'Longines是最古老和最著名的瑞士手表品牌之一，成立于1832年在圣伊米耶。以优雅和精确的手表著称，融合瑞士工艺与创新。Longines生产经典和运动手表，并在全球体育赛事中担任官方计时员。 Meta Title: Longines — 优雅瑞士手表', 'Longines — 瑞士品牌，提供男女优雅且精确的手表。'),
(148, 22, 'ru', 'Christopher Ross', 'Christopher Ross — американский дизайнер и скульптор, основавший свой бренд в Нью-Йорке в 1975 году. Известен своими уникальными скульптурными пряжками для ремней, выполненными из серебра, золота и стеклянных глаз ручной работы. Его произведения сочетает в себе элементы изобразительного искусства, высокой моды и авангарда. Работы Ross были представлены в таких изданиях, как Vogue, L\'Officiel и Asia Tatler, а также на показах Rachel Roy и Art Basel. Его коллекции являются частью собраний таких музеев, как Метрополитен-музей в Нью-Йорке и Эрмитаж в Санкт-Петербурге.', 'Christopher Ross — ювелирное искусство и скульптурные аксессуары', 'Christopher Ross — американский дизайнер, создатель уникальных скульптурных пряжек и аксессуаров, сочетающих искусство и моду.'),
(149, 22, 'en', 'Christopher Ross', 'Christopher Ross is an American designer and sculptor who founded his brand in New York City in 1975. Known for his unique sculptural belt buckles made of silver, gold, and handcrafted glass eyes, his works blend fine art, haute couture, and avant-garde design. Ross\'s creations have been featured in publications like Vogue, L\'Officiel, and Asia Tatler, and showcased at events such as Rachel Roy’s AW 2013-14 digital runway show and Art Basel. His collections are part of museum collections including The Metropolitan Museum of Art in New York and The Hermitage in St. Petersburg.', 'Christopher Ross — wearable art and sculptural accessories', 'Christopher Ross is an American designer known for creating unique sculptural belt buckles and accessories that merge art and fashion.'),
(150, 22, 'de', 'Christopher Ross', 'Christopher Ross ist ein amerikanischer Designer und Bildhauer, der seine Marke 1975 in New York City gründete. Bekannt für seine einzigartigen skulpturalen Gürtelschnallen aus Silber, Gold und handgefertigten Glasaugen, vereinen seine Werke bildende Kunst, Haute Couture und avantgardistisches Design. Ross\' Kreationen wurden in Publikationen wie Vogue, L\'Officiel und Asia Tatler vorgestellt und auf Veranstaltungen wie Rachel Roys AW 2013-14 Digital Runway Show und Art Basel präsentiert. Seine Kollektionen sind Teil von Museumsbeständen, darunter das Metropolitan Museum of Art in New York und die Eremitage in St. Petersburg.', 'Christopher Ross — tragbare Kunst und skulpturale Accessoires', 'Christopher Ross ist ein amerikanischer Designer, bekannt für die Schaffung einzigartiger skulpturaler Gürtelschnallen und Accessoires, die Kunst und Mode verbinden.'),
(151, 22, 'es', 'Christopher Ross', 'Christopher Ross es un diseñador y escultor estadounidense que fundó su marca en Nueva York en 1975. Conocido por sus únicas hebillas de cinturón escultóricas hechas de plata, oro y ojos de vidrio hechos a mano, sus obras combinan arte, alta costura y diseño vanguardista. Las creaciones de Ross han sido presentadas en publicaciones como Vogue, L\'Officiel y Asia Tatler, y exhibidas en eventos como el desfile digital AW 2013-14 de Rachel Roy y Art Basel. Sus colecciones forman parte de colecciones museísticas, incluyendo el Metropolitan Museum of Art en Nueva York y el Hermitage en San Petersburgo', 'Christopher Ross — arte portátil y accesorios escultóricos', 'Christopher Ross es un diseñador estadounidense conocido por crear únicas hebillas de cinturón escultóricas y accesorios que fusionan arte y moda.'),
(152, 22, 'fr', 'Christopher Ross', 'Christopher Ross est un designer et sculpteur américain qui a fondé sa marque à New York en 1975. Connu pour ses boucles de ceinture sculpturales uniques en argent, or et yeux en verre faits main, ses œuvres mêlent art, haute couture et design avant-gardiste. Les créations de Ross ont été présentées dans des publications telles que Vogue, L\'Officiel et Asia Tatler, et exposées lors d\'événements tels que le défilé numérique AW 2013-14 de Rachel Roy et Art Basel. Ses collections font partie des collections muséales, dont le Metropolitan Museum of Art à New York et l\'Hermitage à Saint-Pétersbourg.', 'Christopher Ross — art portable et accessoires sculpturaux', 'Christopher Ross est un designer américain connu pour ses boucles de ceinture sculpturales uniques et ses accessoires alliant art et mode.'),
(153, 22, 'ja', 'Christopher Ross', 'Christopher Rossは、1975年にニューヨークでブランドを設立したアメリカのデザイナー兼彫刻家です。銀、金、手作りのガラスの目を使ったユニークな彫刻的なベルトバックルで知られ、彼の作品は美術、オートクチュール、前衛的なデザインを融合させています。Rossの作品は、Vogue、L\'Officiel、Asia Tatlerなどの出版物に掲載され、Rachel RoyのAW 2013-14デジタルランウェイショーやArt Baselなどのイベントで展示されました。彼のコレクションは、ニューヨークのメトロポリタン美術館やサンクトペテルブルクのエルミタージュ美術館などの美術館のコレクションの一部となっています。', 'Christopher Ross — 着用可能なアートと彫刻的アクセサリー', 'Christopher Rossは、アートとファッションを融合させたユニークな彫刻的ベルトバックルとアクセサリーを創造するアメリカのデザイナーです。'),
(154, 22, 'zh', 'Christopher Ross', 'Christopher Ross 是一位美国设计师和雕塑家，于 1975 年在纽约市创立了自己的品牌。以其独特的雕塑腰带扣而闻名，这些腰带扣由银、金和手工制作的玻璃眼睛制成，他的作品融合了美术、时尚和先锋设计。Ross 的作品曾出现在《Vogue》、《L\'Officiel》和《Asia Tatler》等出版物中，并在 Rachel Roy 的 2013-14 秋冬数字时装秀和 Art Basel 等活动中展出。他的作品被纽约大都会艺术博物馆和圣彼得堡的冬宫博物馆等博物馆收藏。', 'Christopher Ross — 可穿戴艺术和雕塑配饰', 'Christopher Ross 是一位美国设计师，以创作独特的雕塑腰带扣和融合艺术与时尚的配饰而闻名。'),
(155, 23, 'ru', 'E. Marinella', 'E. Marinella — итальянский бренд с более чем вековой историей, основанный в 1914 году Эудженио Маринеллой в Неаполе. Бренд известен своими уникальными шёлковыми галстуками и аксессуарами, выполненными вручную с использованием английского шёлка и традиционных неаполитанских техник. Каждый галстук — это произведение искусства, отражающее внимание к деталям и стремление к совершенству.', 'E. Marinella — Ручная работа и итальянская элегантность', 'E. Marinella — бренд с более чем 100-летней историей, предлагающий уникальные шёлковые галстуки и аксессуары, выполненные вручную в Неаполе.'),
(156, 23, 'en', 'E. Marinella', 'E. Marinella is an Italian brand with over a century of history, founded in 1914 by Eugenio Marinella in Naples. The brand is renowned for its unique handmade silk ties and accessories, crafted using English silk and traditional Neapolitan techniques. Each tie is a masterpiece, reflecting attention to detail and a commitment to perfection.', 'E. Marinella — Handcrafted Elegance from Italy', 'E. Marinella is a brand with over 100 years of history, offering unique handmade silk ties and accessories crafted in Naples.'),
(157, 23, 'de', 'E. Marinella', 'E. Marinella ist eine italienische Marke mit über hundertjähriger Geschichte, gegründet 1914 von Eugenio Marinella in Neapel. Die Marke ist bekannt für ihre einzigartigen handgefertigten Seidenkrawatten und Accessoires, die mit englischer Seide und traditionellen neapolitanischen Techniken gefertigt werden. Jede Krawatte ist ein Meisterwerk, das Liebe zum Detail und Streben nach Perfektion widerspiegelt.', 'E. Marinella — Handgefertigte Eleganz aus Italien', 'E. Marinella ist eine Marke mit über 100 Jahren Geschichte, die einzigartige handgefertigte Seidenkrawatten und Accessoires anbietet, die in Neapel gefertigt werden.');
INSERT INTO `brandstranslation` (`id`, `brand_id`, `locale`, `title`, `description`, `meta_title`, `meta_description`) VALUES
(158, 23, 'es', 'E. Marinella', 'E. Marinella es una marca italiana con más de un siglo de historia, fundada en 1914 por Eugenio Marinella en Nápoles. La marca es conocida por sus únicas corbatas de seda hechas a mano y accesorios, elaborados con seda inglesa y técnicas tradicionales napolitanas. Cada corbata es una obra maestra que refleja atención al detalle y un compromiso con la perfección.', 'E. Marinella — Elegancia artesanal desde Italia', 'E. Marinella es una marca con más de 100 años de historia, que ofrece corbatas de seda hechas a mano y accesorios elaborados en Nápoles.'),
(159, 23, 'fr', 'E. Marinella', 'E. Marinella est une marque italienne avec plus d\'un siècle d\'histoire, fondée en 1914 par Eugenio Marinella à Naples. La marque est renommée pour ses cravates en soie faites à la main et ses accessoires, fabriqués à l\'aide de soie anglaise et de techniques napolitaines traditionnelles. Chaque cravate est un chef-d\'œuvre, reflétant une attention aux détails et un engagement envers la perfection.', 'E. Marinella — Élégance artisanale d\'Italie', 'E. Marinella est une marque avec plus de 100 ans d\'histoire, offrant des cravates en soie faites à la main et des accessoires fabriqués à Naples.'),
(160, 23, 'ja', 'E. Marinella', 'E. Marinellaは、1914年にエウジェニオ・マリネッラによってナポリで創業された、100年以上の歴史を持つイタリアのブランドです。ブランドは、イギリス製のシルクと伝統的なナポリの技法を使用して手作りされたユニークなシルクのネクタイとアクセサリーで知られています。各ネクタイは、細部へのこだわりと完璧へのコミットメントを反映した傑作です。', 'E. Marinella — イタリアからの手作りのエレガンス', 'E. Marinellaは、ナポリで手作りされたユニークなシルクのネクタイとアクセサリーを提供する、100年以上の歴史を持つブランドです。'),
(161, 23, 'zh', 'E. Marinella', 'E. Marinella 是一家拥有百年历史的意大利品牌，由 Eugenio Marinella 于 1914 年在那不勒斯创立。该品牌以其独特的手工丝绸领带和配饰而闻名，采用英国产丝绸和传统的那不勒斯工艺制作而成。每条领带都是一件杰作，体现了对细节的关注和对完美的追求。', 'E. Marinella — 来自意大利的手工优雅', 'E. Marinella 是一家拥有超过 100 年历史的品牌，提供在那不勒斯手工制作的独特丝绸领带和配饰。'),
(162, 24, 'ru', 'Louis Vuitton', 'Louis Vuitton — французский бренд, основанный в 1854 году. Он известен своими роскошными сумками, чемоданами, одеждой, обувью, ювелирными украшениями и парфюмерией. Бренд сочетает традиции французской элегантности с современным дизайном, создавая уникальные люксовые изделия.', 'Louis Vuitton — роскошная мода и аксессуары', 'Louis Vuitton — французский бренд, предлагающий люксовые сумки, одежду, обувь, ювелирные украшения и парфюмерию.'),
(163, 24, 'en', 'Louis Vuitton', 'Louis Vuitton is a French brand founded in 1854, renowned for its luxury handbags, luggage, clothing, footwear, jewelry, and perfumes. The brand combines French elegance with modern design, creating unique luxury products worldwide.', 'Louis Vuitton — Luxury Fashion & Accessories', 'Louis Vuitton is a French brand offering luxury handbags, clothing, shoes, jewelry, and perfumes.'),
(164, 24, 'de', 'Louis Vuitton', 'Louis Vuitton ist eine französische Marke, gegründet 1854, bekannt für luxuriöse Taschen, Koffer, Kleidung, Schuhe, Schmuck und Parfums. Die Marke verbindet französische Eleganz mit modernem Design und schafft einzigartige Luxusprodukte weltweit.', 'Louis Vuitton — Luxusmode & Accessoires', 'Louis Vuitton ist eine französische Marke, die luxuriöse Taschen, Kleidung, Schuhe, Schmuck und Parfums anbietet.'),
(165, 24, 'es', 'Louis Vuitton', 'Louis Vuitton es una marca francesa fundada en 1854, reconocida por sus lujosos bolsos, equipaje, ropa, calzado, joyería y perfumes. La marca combina la elegancia francesa con un diseño moderno, creando productos de lujo únicos en todo el mundo.', 'Louis Vuitton — Moda y accesorios de lujo', 'Louis Vuitton es una marca francesa que ofrece bolsos de lujo, ropa, calzado, joyería y perfumes.'),
(166, 24, 'fr', 'Louis Vuitton', 'Louis Vuitton est une marque française fondée en 1854, connue pour ses sacs de luxe, bagages, vêtements, chaussures, bijoux et parfums. La marque allie élégance française et design moderne pour créer des produits de luxe uniques dans le monde entier.', 'Louis Vuitton — Mode et accessoires de luxe', 'Louis Vuitton est une marque française proposant des sacs de luxe, vêtements, chaussures, bijoux et parfums.'),
(167, 24, 'ja', 'Louis Vuitton', 'Louis Vuittonは1854年に設立されたフランスのブランドで、高級バッグ、スーツケース、衣類、靴、ジュエリー、香水で知られています。ブランドはフランスのエレガンスと現代デザインを融合させ、世界中で独自のラグジュアリープロダクトを展開しています。', 'Louis Vuitton — 高級ファッションとアクセサリー', 'Louis Vuittonは高級バッグ、衣類、靴、ジュエリー、香水を提供するフランスのブランドです。'),
(168, 24, 'zh', 'Louis Vuitton', 'Louis Vuitton是1854年创立的法国品牌，以奢华手袋、行李箱、服装、鞋履、珠宝和香水而闻名。品牌将法国优雅与现代设计结合，在全球创造独特的奢侈品。', 'Louis Vuitton — 奢华时尚与配饰', 'Louis Vuitton是提供奢华手袋、服装、鞋履、珠宝和香水的法国品牌。'),
(169, 25, 'ru', 'Fuzeau', 'Fuzeau — французский бренд с более чем 45-летней историей, специализирующийся на музыкальном образовании и школьной жизни. Компания предлагает качественные музыкальные инструменты, методические пособия и аудиокниги, используемые в школах, консерваториях и студиях по всему миру. Каждый продукт Fuzeau создан для облегчения обучения музыке и вдохновения учеников.', 'Fuzeau — музыкальные инструменты, методические материалы, аудиокниги', 'Fuzeau — французский бренд, предлагающий профессиональные музыкальные инструменты, обучающие материалы и аудиокниги для школ и консерваторий.'),
(170, 25, 'en', 'Fuzeau', 'Fuzeau is a French brand with over 45 years of experience in music education and school life. The company provides high-quality musical instruments, educational resources, and audiobooks used in schools, conservatories, and studios worldwide. Every Fuzeau product is designed to simplify music learning and inspire students.', 'Fuzeau — Musical Instruments, Educational Materials & Audiobooks', 'Fuzeau is a French brand offering professional musical instruments, educational resources, and audiobooks for schools and conservatories.'),
(171, 25, 'de', 'Fuzeau', 'Fuzeau ist eine französische Marke mit über 45 Jahren Erfahrung in der Musikpädagogik und Schulbildung. Das Unternehmen bietet hochwertige Musikinstrumente, Lehrmaterialien und Hörbücher, die weltweit in Schulen, Konservatorien und Studios verwendet werden. Jedes Produkt von Fuzeau wurde entwickelt, um das Musizieren zu erleichtern und Schüler zu inspirieren.', 'Fuzeau — Musikinstrumente, Lehrmaterialien & Hörbücher', 'Fuzeau ist eine französische Marke, die professionelle Musikinstrumente, Lehrmaterialien und Hörbücher für Schulen und Konservatorien anbietet.'),
(172, 25, 'es', 'Fuzeau', 'Fuzeau es una marca francesa con más de 45 años de experiencia en educación musical y vida escolar. La empresa ofrece instrumentos musicales de alta calidad, materiales educativos y audiolibros, utilizados en escuelas, conservatorios y estudios de todo el mundo. Cada producto Fuzeau está diseñado para facilitar el aprendizaje musical e inspirar a los estudiantes.', 'Fuzeau — Instrumentos musicales, materiales educativos y audiolibros', 'Fuzeau es una marca francesa que ofrece instrumentos musicales profesionales, recursos educativos y audiolibros para escuelas y conservatorios.'),
(173, 25, 'fr', 'Fuzeau', 'Fuzeau est une marque française avec plus de 45 ans d\'expérience dans l\'éducation musicale et la vie scolaire. L\'entreprise propose des instruments de musique de qualité, des ressources pédagogiques et des livres audio utilisés dans les écoles, conservatoires et studios du monde entier. Chaque produit Fuzeau est conçu pour faciliter l\'apprentissage de la musique et inspirer les élèves.', 'Fuzeau — Instruments de musique, ressources pédagogiques & livres audio', 'Fuzeau est une marque française proposant des instruments de musique professionnels, des ressources pédagogiques et des livres audio pour écoles et conservatoires.'),
(174, 25, 'ja', 'Fuzeau', 'Fuzeauは、45年以上の歴史を持つフランスのブランドで、音楽教育と学校生活に特化しています。学校、音楽院、スタジオで使用される高品質な楽器、教育資料、オーディオブックを提供。Fuzeauの製品は、音楽学習を簡単にし、学生にインスピレーションを与えるよう設計されています。', 'Fuzeau — 楽器、教育資料、オーディオブック', 'Fuzeauは、学校や音楽院向けにプロ仕様の楽器、教育資料、オーディオブックを提供するフランスのブランドです。'),
(175, 25, 'zh', 'Fuzeau', 'Fuzeau是一家拥有45年以上历史的法国家族品牌，专注于音乐教育和学校教育。公司提供高品质的乐器、教育资源和有声书，广泛应用于学校、音乐学院和工作室。每一款Fuzeau产品都旨在简化音乐学习，并激发学生的兴趣。', 'Fuzeau — 乐器、教育资源与有声书', 'Fuzeau是法国品牌，为学校和音乐学院提供专业乐器、教育资源和有声书。'),
(176, 26, 'ru', 'Guerlain', 'Guerlain — легендарный французский бренд, основанный в 1828 году Пьером-Франсуа Паскаль Гурленом. Известен своими эксклюзивными парфюмами, уходовой косметикой и декоративной косметикой. Guerlain сочетает традиции французской парфюмерии с инновационными формулами, создавая ароматы и продукты, которые подчеркивают элегантность и индивидуальность.', 'Guerlain — парфюмерия и косметика премиум-класса', 'Guerlain — французский бренд с более чем 190-летней историей, предлагающий эксклюзивные ароматы, уходовую и декоративную косметику, сочетающую традиции и инновации.'),
(177, 26, 'en', 'Guerlain', 'Guerlain is a legendary French brand founded in 1828 by Pierre-François Pascal Guerlain. Famous for its exclusive perfumes, skincare, and makeup, Guerlain combines the traditions of French perfumery with innovative formulas, creating products that highlight elegance and individuality.', 'Guerlain — Premium Perfumes and Cosmetics', 'Guerlain is a French brand with over 190 years of history, offering exclusive fragrances, skincare, and makeup that combine tradition and innovation.'),
(178, 26, 'de', 'Guerlain', 'Guerlain ist eine legendäre französische Marke, die 1828 von Pierre-François Pascal Guerlain gegründet wurde. Bekannt für exklusive Parfums, Hautpflege und dekorative Kosmetik, verbindet Guerlain die Tradition der französischen Parfümerie mit innovativen Formeln und schafft Produkte, die Eleganz und Individualität unterstreichen.', 'Guerlain — Premium-Parfums und Kosmetik', 'Guerlain ist eine französische Marke mit über 190 Jahren Geschichte, die exklusive Düfte, Hautpflege und dekorative Kosmetik anbietet und Tradition mit Innovation vereint.'),
(179, 26, 'es', 'Guerlain', 'Guerlain es una marca francesa legendaria fundada en 1828 por Pierre-François Pascal Guerlain. Famosa por sus perfumes exclusivos, cuidado de la piel y maquillaje, Guerlain combina la tradición de la perfumería francesa con fórmulas innovadoras, creando productos que resaltan la elegancia y la individualidad.', 'Guerlain — Perfumes y cosmética premium', 'Guerlain es una marca francesa con más de 190 años de historia, que ofrece perfumes exclusivos, cuidado de la piel y maquillaje combinando tradición e innovación.'),
(180, 26, 'fr', 'Guerlain', 'Guerlain est une marque française légendaire fondée en 1828 par Pierre-François Pascal Guerlain. Réputée pour ses parfums exclusifs, ses soins et son maquillage, Guerlain allie la tradition de la parfumerie française à des formules innovantes, créant des produits qui soulignent l’élégance et l’individualité.', 'Guerlain — Parfums et cosmétiques haut de gamme', 'Guerlain est une marque française de plus de 190 ans d’histoire, proposant des parfums exclusifs, des soins et du maquillage combinant tradition et innovation.'),
(181, 26, 'ja', 'Guerlain', 'Guerlainは1828年にピエール＝フランソワ・パスカル・ゲランによって創設された伝説的なフランスブランドです。独自の香水、スキンケア、メイクアップで有名で、フランスの香水伝統と革新的な処方を融合し、エレガンスと個性を際立たせる製品を提供しています。', 'Guerlain — 高級香水と化粧品', 'Guerlainは190年以上の歴史を持つフランスブランドで、独自の香水、スキンケア、メイクアップを提供し、伝統と革新を兼ね備えています。'),
(182, 26, 'zh', 'Guerlain', 'Guerlain是由皮埃尔-弗朗索瓦·帕斯卡·盖兰于1828年创立的传奇法国品牌。以其独特香水、护肤品和化妆品闻名，Guerlain将法国香水传统与创新配方相结合，创造出彰显优雅与个性的产品。', 'Guerlain — 高级香水与化妆品', 'Guerlain是拥有超过190年历史的法国品牌，提供独特香水、护肤品和化妆品，将传统与创新完美融合。'),
(183, 27, 'ru', 'Baccarat', 'Baccarat — французская компания, основанная в 1764 году, известная своими хрустальными изделиями и эксклюзивными парфюмами, такими как Les Larmes Sacrées de Thèbes. Ароматы Baccarat сочетают роскошь, искусство и уникальный дизайн.', 'Baccarat — роскошные парфюмы и хрустальные изделия', 'Откройте мир Baccarat — французской компании, выпускающей эксклюзивные парфюмы и хрустальные изделия. Среди них Les Larmes Sacrées de Thèbes, символ роскоши и утончённого вкуса.'),
(184, 27, 'en', 'Baccarat', 'Baccarat is a French company founded in 1764, renowned for its crystal creations and exclusive perfumes, such as Les Larmes Sacrées de Thèbes. Baccarat fragrances combine luxury, artistry, and unique design.', 'Baccarat — Luxury Perfumes and Crystal Creations', 'Discover Baccarat, the French company producing exclusive perfumes and crystal masterpieces, including Les Larmes Sacrées de Thèbes, a symbol of luxury and refined taste.'),
(185, 27, 'de', 'Baccarat', 'Baccarat ist ein französisches Unternehmen, das 1764 gegründet wurde und für seine Kristallkunstwerke und exklusiven Parfums wie Les Larmes Sacrées de Thèbes bekannt ist. Baccarat-Düfte verbinden Luxus, Kunst und einzigartiges Design.', 'Baccarat — Luxusparfums und Kristallkreationen', 'Entdecken Sie Baccarat, das französische Unternehmen, das exklusive Parfums und Kristallkunstwerke herstellt, darunter Les Larmes Sacrées de Thèbes, ein Symbol für Luxus und feinen Geschmack.'),
(186, 27, 'es', 'Baccarat', 'Baccarat es una empresa francesa fundada en 1764, conocida por sus creaciones en cristal y perfumes exclusivos como Les Larmes Sacrées de Thèbes. Los perfumes de Baccarat combinan lujo, arte y diseño único.', 'Baccarat — Perfumes de lujo y creaciones en cristal', 'Descubre Baccarat, la empresa francesa que produce perfumes exclusivos y creaciones de cristal, incluyendo Les Larmes Sacrées de Thèbes, símbolo de lujo y buen gusto.'),
(187, 27, 'fr', 'Baccarat', 'Baccarat est une entreprise française fondée en 1764, réputée pour ses créations en cristal et ses parfums exclusifs, tels que Les Larmes Sacrées de Thèbes. Les parfums Baccarat allient luxe, art et design unique.', 'Baccarat — Parfums de luxe et créations en cristal', 'Découvrez l’univers de Baccarat, la maison française produisant des parfums exclusifs et des créations en cristal, dont Les Larmes Sacrées de Thèbes, symbole de luxe et de raffinement.'),
(188, 27, 'ja', 'Baccarat', 'Baccaratは1764年に設立されたフランスの企業で、クリスタル製品とLes Larmes Sacrées de Thèbesのような高級香水で知られています。Baccaratの香水は、贅沢さ、芸術性、独自のデザインを兼ね備えています。', 'Baccarat — 高級香水とクリスタル作品', 'Baccaratの世界を発見してください。フランスの企業で、Les Larmes Sacrées de Thèbesなどの高級香水とクリスタル作品を製造し、贅沢さと洗練された美意識の象徴です。'),
(189, 27, 'zh', 'Baccarat', 'Baccarat 是一家成立于1764年的法国公司，以水晶制品和独家香水闻名，例如 Les Larmes Sacrées de Thèbes。Baccarat 香水融合了奢华、艺术性和独特设计。', 'Baccarat — 奢华香水与水晶精品', '探索 Baccarat，这家法国公司生产独家香水和水晶艺术品，其中包括 Les Larmes Sacrées de Thèbes，是奢华与精致品味的象征。');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) UNSIGNED DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `title`, `description`, `slug`, `image`, `seo_title`, `seo_description`) VALUES
(1, NULL, 'Для женщин', 'Винтажная парфюмерия, аксессуары и вещи для женщин. Уникальные находки с историей.', 'dlya-zhenchin', 'women.jpg', NULL, NULL),
(2, NULL, 'Для мужчин', NULL, 'dlya-muzhchin', 'men.jpg', NULL, NULL),
(3, NULL, 'Для детей', NULL, 'dlya-detey	', 'children.jpg', NULL, NULL),
(4, NULL, 'Для дома', NULL, 'dlya-doma	', 'home.jpg', NULL, NULL),
(5, NULL, 'Парфюмерия', NULL, 'parfumeriya', 'parfume.jpg', NULL, NULL),
(6, NULL, 'Косметика', NULL, 'kosmetika', 'cosmetic.jpg', NULL, NULL),
(7, 1, 'Сумки', 'Уникальные женские винтажные сумки от люксовых брендов. Редкие аксессуары с историей, стилем и безупречным качеством мировых модных домов.', '', 'bag', 'Купить женские винтажные сумки люксовых брендов онлайн | [vvintage]', 'Эксклюзивный выбор винтажных сумок для женщин: культовые модели люксовых брендов, проверенное временем качество и неповторимый стиль. Закажите онлайн с доставкой.'),
(8, 1, 'Очки', NULL, 'ochki-zhenskie', 'glasses', NULL, NULL),
(9, 1, 'Часы', NULL, 'chasy-zhenskie', 'watch', NULL, NULL),
(10, 1, 'Бижутерия', NULL, 'bizhuteriya-zhenskaya', 'earrings', NULL, NULL),
(11, 1, 'Косметика', NULL, 'kosmetika-zhenskaya', 'cosmetics', NULL, NULL),
(12, 1, 'Аксессуары', NULL, 'aksessuary-zhenskie', 'category_all', NULL, NULL),
(13, 2, 'Очки', NULL, 'ochki-muzhskie', 'glasses_men', NULL, NULL),
(14, 2, 'Часы', NULL, 'chasy-muzhskie', 'watch_man', NULL, NULL),
(15, 2, 'Ремни', NULL, 'remni-muzhskie', 'belt', NULL, NULL),
(16, 2, 'Галстуки', NULL, 'galstuki', 'necktie', NULL, NULL),
(17, 2, 'Сумки', NULL, '', 'suitcase', 'Сумки', ''),
(18, 2, 'Аксессуары', NULL, 'aksessuary-muzhskie', 'category_all', NULL, NULL),
(19, 3, 'Игрушки, музыкальные инструменты', NULL, 'igrushki-muzykalnye-instrumenty', 'toy', NULL, NULL),
(20, 5, 'Для Неё', NULL, '', 'parfume', NULL, NULL),
(21, 5, 'Для Него', NULL, '', 'parfume-men', NULL, NULL),
(22, 5, 'Для детей', NULL, '', 'parfume-kids', 'Парфюмерия для детей — безопасные и нежные ароматы', 'Широкий ассортимент детской парфюмерии: мягкие ароматы, безопасные для кожи детей, для малышей и подростков. Закажите онлайн с доставкой и подарите любимый запах вашему ребёнку.');

-- --------------------------------------------------------

--
-- Структура таблицы `categoriestranslation`
--

CREATE TABLE `categoriestranslation` (
  `id` int(11) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categoriestranslation`
--

INSERT INTO `categoriestranslation` (`id`, `category_id`, `locale`, `title`, `description`, `meta_title`, `meta_description`, `slug`) VALUES
(1, 1, 'ru', 'Для женщин', 'Винтажная парфюмерия, аксессуары и вещи для женщин. Уникальные находки с историей.', 'Винтаж для женщин — ароматы и аксессуары', 'Коллекция винтажной парфюмерии, украшений и аксессуаров для женщин. Отредактированные находки с историей.', ''),
(2, 1, 'en', 'For Women', 'Vintage perfumes, accessories and fashion for women. Unique finds with a story.', 'Vintage for Women — Perfumes & Accessories', 'Curated vintage perfumes, jewelry and accessories for women. Handpicked pieces with history.', ''),
(3, 1, 'de', 'Für Damen', 'Vintage-Parfums, Accessoires und Mode für Damen. Einzigartige Fundstücke mit Geschichte.', 'Vintage für Damen — Parfums & Accessoires', 'Kuratiere Vintage-Parfums, Schmuck und Accessoires für Damen. Handverlesene Stücke mit Geschichte.', ''),
(4, 1, 'fr', 'Pour femmes', 'Parfums, accessoires et mode vintage pour femmes. Des pièces uniques chargées d’histoire.', 'Vintage femme — Parfums & accessoires', 'Sélection de parfums, bijoux et accessoires vintage pour femmes. Pièces choisies avec une histoire.', ''),
(5, 1, 'es', 'Para mujeres', 'Perfumes, accesorios y moda vintage para mujeres. Hallazgos únicos con historia.', 'Vintage para mujer — Perfumes y accesorios', 'Selección de perfumes, joyería y accesorios vintage para mujer. Piezas con historia.', ''),
(6, 1, 'ja', 'レディース', '女性向けのヴィンテージ香水・アクセサリー・ウェア。歴史を纏う一点物。', 'レディース向けヴィンテージ — 香水＆アクセサリー', '女性のための厳選ヴィンテージ香水、ジュエリー、アクセサリー。物語のあるアイテム。', ''),
(7, 1, 'zh', '女士', '女士复古香水、配饰与服饰。每一件都承载故事。', '女士复古精选｜香水与配饰', '为女士甄选复古香水、首饰与配饰，承载时代记忆的精品。', ''),
(8, 2, 'ru', 'Для мужчин', 'Винтажные ароматы, аксессуары и стильные вещи для мужчин.', 'Винтаж для мужчин — ароматы и аксессуары', 'Редкие мужские ароматы, часы, ремни и аксессуары в ретро-стиле.', NULL),
(9, 2, 'en', 'For Men', 'Vintage fragrances, accessories and stylish pieces for men.', 'Vintage for Men — Fragrances & Accessories', 'Rare men’s fragrances, watches, belts and retro accessories.', NULL),
(10, 2, 'de', 'Für Herren', 'Vintage-Düfte, Accessoires und stilvolle Stücke für Herren.', 'Vintage für Herren — Düfte & Accessoires', 'Seltene Herrendüfte, Uhren, Gürtel und Retro-Accessoires.', NULL),
(11, 2, 'fr', 'Pour hommes', 'Parfums, accessoires et pièces vintage pour hommes.', 'Vintage homme — Parfums & accessoires', 'Parfums rares, montres, ceintures et accessoires rétro pour hommes.', NULL),
(12, 2, 'es', 'Para hombres', 'Fragancias, accesorios y piezas vintage para hombres.', 'Vintage hombre — Fragancias y accesorios', 'Fragancias raras, relojes, cinturones y accesorios retro para hombre.', NULL),
(13, 2, 'ja', 'メンズ', '男性向けのヴィンテージ香水・アクセサリー・ウェア。', 'メンズ向けヴィンテージ — 香水＆アクセサリー', '希少なメンズ香水、腕時計、ベルトなどのレトロ小物。', NULL),
(14, 2, 'zh', '男士', '男士复古香氛、配饰与型格单品。', '男士复古精选｜香氛与配饰', '甄选男士稀有香氛、腕表、腰带与复古配饰。', NULL),
(15, 3, 'ru', 'Для детей', 'Винтажные игрушки, книги и милые аксессуары для детей.', 'Винтаж для детей — игрушки и аксессуары', 'Редкие винтажные игрушки и аксессуары для детей — атмосфера прошлого в каждой детали.', NULL),
(16, 3, 'en', 'For Kids', 'Vintage toys, books and charming accessories for kids.', 'Vintage for Kids — Toys & Accessories', 'Rare vintage toys and accessories for children. Nostalgia in every detail.', NULL),
(17, 3, 'de', 'Für Kinder', 'Vintage-Spielzeuge, Bücher und hübsche Accessoires für Kinder.', 'Vintage für Kinder — Spielzeuge & Accessoires', 'Seltene Vintage-Spielzeuge und Accessoires für Kinder. Nostalgie in jedem Detail.', NULL),
(18, 3, 'fr', 'Pour enfants', 'Jouets, livres et accessoires vintage pour enfants.', 'Vintage enfant — Jouets & accessoires', 'Jouets et accessoires vintage rares pour enfants. Une touche de nostalgie.', NULL),
(19, 3, 'es', 'Para niños', 'Juguetes, libros y accesorios vintage para niños.', 'Vintage para niños — Juguetes y accesorios', 'Juguetes y accesorios vintage raros para niños. Nostalgia en cada detalle.', NULL),
(20, 3, 'ja', 'キッズ', '子ども向けヴィンテージ玩具・本・アクセサリー。', 'キッズ向けヴィンテージ — 玩具＆アクセサリー', 'ノスタルジー漂う、希少な子ども向けヴィンテージ玩具と小物。', NULL),
(21, 3, 'zh', '儿童', '儿童复古玩具、图书与可爱配件。', '儿童复古精选｜玩具与配饰', '稀有儿童复古玩具与配饰，细节里满是怀旧氛围。', NULL),
(22, 4, 'ru', 'Для дома', 'Винтажный декор, текстиль и предметы для домашнего уюта.', 'Винтаж для дома — декор и текстиль', 'Атмосферный винтажный декор и аксессуары для дома.', NULL),
(23, 4, 'en', 'For Home', 'Vintage décor, textiles and objects to elevate your home.', 'Vintage for Home — Décor & Textiles', 'Atmospheric vintage décor and accessories for a home with history.', NULL),
(24, 4, 'de', 'Für Zuhause', 'Vintage-Deko, Textilien und Objekte für ein Zuhause mit Geschichte.', 'Vintage für Zuhause — Deko & Textilien', 'Atmosphärische Vintage-Deko und Accessoires für Zuhause.', NULL),
(25, 4, 'fr', 'Pour la maison', 'Décoration, textiles et objets vintage pour la maison.', 'Vintage maison — Décoration & textiles', 'Décor vintage atmosphérique et accessoires pour un intérieur chargé d’histoire.', NULL),
(26, 4, 'es', 'Para el hogar', 'Decoración, textiles y objetos vintage para tu hogar.', 'Vintage hogar — Decoración y textiles', 'Decoración y accesorios vintage con historia para el hogar.', NULL),
(27, 4, 'ja', 'ホーム', 'ヴィンテージのインテリア、テキスタイル、ホームアイテム。', 'ヴィンテージ・ホーム — インテリア＆テキスタイル', '歴史を感じるヴィンテージの装飾とホームアクセサリー。', NULL),
(28, 4, 'zh', '家居', '复古家居装饰、纺织品与物件。', '复古家居｜装饰与纺织', '为家注入历史气息的复古装饰与家居配件。', NULL),
(29, 5, 'ru', 'Парфюмерия', 'Винтажные духи и редкие ароматы прошлых лет.', 'Винтажная парфюмерия — редкие ароматы', 'Коллекция винтажных духов и ароматов. Культовые композиции с историей.', NULL),
(30, 5, 'en', 'Perfumery', 'Vintage perfumes and rare fragrances from past decades.', 'Vintage Perfumery — Rare Fragrances', 'A curated collection of vintage perfumes. Iconic compositions with history.', NULL),
(31, 5, 'de', 'Parfümerie', 'Vintage-Parfums und seltene Düfte vergangener Jahrzehnte.', 'Vintage-Parfümerie — Seltene Düfte', 'Kuratiere Auswahl an Vintage-Parfums. Ikonische Kompositionen mit Geschichte.', NULL),
(32, 5, 'fr', 'Parfumerie', 'Parfums vintage et fragrances rares des décennies passées.', 'Parfumerie vintage — Fragrances rares', 'Sélection de parfums vintage. Compositions iconiques chargées d’histoire.', NULL),
(33, 5, 'es', 'Perfumería', 'Perfumes vintage y fragancias raras de décadas pasadas.', 'Perfumería vintage — Fragancias raras', 'Colección de perfumes vintage. Composiciones icónicas con historia.', NULL),
(34, 5, 'ja', '香水', '往年の名香や希少なヴィンテージフレグランス。', 'ヴィンテージ香水 — 希少なフレグランス', '歴史を語るヴィンテージ香水のセレクション。', NULL),
(35, 5, 'zh', '香水', '复古香水与往昔时代的稀有香氛。', '复古香水｜稀有香氛', '甄选复古香水，承载历史的经典配方。', NULL),
(36, 6, 'ru', 'Косметика', 'Редкая винтажная косметика и аксессуары для красоты.', 'Винтажная косметика — редкие находки', 'Коллекционная косметика и средства ухода с историей.', NULL),
(37, 6, 'en', 'Cosmetics', 'Rare vintage cosmetics and beauty accessories.', 'Vintage Cosmetics — Rare Finds', 'Collectible cosmetics and heritage care items.', NULL),
(38, 6, 'de', 'Kosmetik', 'Seltene Vintage-Kosmetik und Beauty-Accessoires.', 'Vintage-Kosmetik — Seltene Funde', 'Sammelbare Kosmetik und Pflegeklassiker mit Geschichte.', NULL),
(39, 6, 'fr', 'Cosmétiques', 'Cosmétiques vintage rares et accessoires beauté.', 'Cosmétiques vintage — Pièces rares', 'Cosmétiques de collection et soins d’antan chargés d’histoire.', NULL),
(40, 6, 'es', 'Cosmética', 'Cosmética vintage rara y accesorios de belleza.', 'Cosmética vintage — Hallazgos raros', 'Cosméticos de colección y cuidados con historia.', NULL),
(41, 6, 'ja', 'コスメ', '希少なヴィンテージコスメとビューティーアクセサリー。', 'ヴィンテージコスメ — レアアイテム', 'コレクション性のあるコスメや往年のケアアイテム。', NULL),
(42, 6, 'zh', '彩妆护肤', '稀有复古彩妆与美妆配件。', '复古彩妆｜稀有限量', '收藏级彩妆与有故事的护理用品。', NULL),
(43, 8, 'ru', 'Очки', 'Женские солнцезащитные и имиджевые очки в ретро-стиле.', 'Винтажные женские очки', 'Стильные женские очки с атмосферой прошлого.', NULL),
(44, 8, 'en', 'Glasses', 'Women’s vintage sunglasses and optical frames in retro style.', 'Vintage Women’s Glasses', 'Stylish women’s eyewear with a nostalgic vibe.', NULL),
(45, 8, 'de', 'Brillen', 'Vintage-Sonnenbrillen und Fassungen für Damen im Retro-Stil.', 'Vintage-Damenbrillen', 'Stilvolle Damenbrillen mit Nostalgie-Flair.', NULL),
(46, 8, 'fr', 'Lunettes', 'Lunettes de soleil et montures vintage pour femmes.', 'Lunettes vintage femme', 'Lunetterie femme au style rétro et à l’esprit nostalgique.', NULL),
(47, 8, 'es', 'Gafas', 'Gafas de sol y monturas vintage para mujer en estilo retro.', 'Gafas vintage mujer', 'Gafas de mujer con aire nostálgico.', NULL),
(48, 8, 'ja', 'アイウェア', 'レディースのヴィンテージサングラス＆フレーム。', 'レディース ヴィンテージアイウェア', 'ノスタルジックな雰囲気の女性向けアイウェア。', NULL),
(49, 8, 'zh', '眼镜', '女士复古太阳镜与光学镜框。', '女士复古眼镜', '带有怀旧气息的女士时尚眼镜。', NULL),
(50, 9, 'ru', 'Часы', 'Женские винтажные часы — от классики до необычных моделей.', 'Винтажные женские часы', 'Коллекционные и ретро-часы для женщин.', NULL),
(51, 9, 'en', 'Watches', 'Women’s vintage watches—from classics to striking pieces.', 'Vintage Women’s Watches', 'Collectible and retro watches for women.', NULL),
(52, 9, 'de', 'Uhren', 'Vintage-Damenuhren – von Klassikern bis zu besonderen Stücken.', 'Vintage-Damenuhren', 'Sammelbare Retro-Uhren für Damen.', NULL),
(53, 9, 'fr', 'Montres', 'Montres vintage pour femmes — des classiques aux pièces de créateurs.', 'Montres vintage femme', 'Garde-temps de collection et rétro pour femmes.', NULL),
(54, 9, 'es', 'Relojes', 'Relojes vintage para mujer: de clásicos a piezas de diseño.', 'Relojes vintage mujer', 'Relojes de colección y retro para mujer.', NULL),
(55, 9, 'ja', '腕時計', 'クラシックから個性派まで、女性向けのヴィンテージウォッチ。', 'レディース ヴィンテージ腕時計', 'コレクション向けのレトロなレディース腕時計。', NULL),
(56, 9, 'zh', '腕表', '女士复古腕表，从经典到设计款。', '女士复古腕表', '女士收藏级与复古时计。', NULL),
(57, 10, 'ru', 'Бижутерия', 'Винтажная женская бижутерия и украшения с историей.', 'Винтажная бижутерия', 'Редкая женская бижутерия и аксессуары прошлых лет.', NULL),
(58, 10, 'en', 'Jewelry', 'Women’s vintage costume and fine jewelry with a story.', 'Vintage Women’s Jewelry', 'Rare vintage jewelry and accessories for women.', NULL),
(59, 10, 'de', 'Schmuck', 'Vintage-Schmuck für Damen mit Geschichte.', 'Vintage-Damenschmuck', 'Seltene Vintage-Bijouterie und Accessoires für Damen.', NULL),
(60, 10, 'fr', 'Bijoux', 'Bijoux vintage pour femmes, chargés d’histoire.', 'Bijoux vintage femme', 'Bijoux vintage rares et accessoires pour femmes.', NULL),
(61, 10, 'es', 'Joyería', 'Joyería vintage para mujer con historia.', 'Joyería vintage mujer', 'Joyería y accesorios vintage raros para mujer.', NULL),
(62, 10, 'ja', 'ジュエリー', '物語を宿すレディースのヴィンテージジュエリー。', 'レディース ヴィンテージジュエリー', '女性向けの希少なヴィンテージジュエリー＆アクセサリー。', NULL),
(63, 10, 'zh', '首饰', '女士复古首饰，承载故事的光彩。', '女士复古首饰', '女士复古首饰与配饰的稀有之选。', NULL),
(64, 11, 'ru', 'Косметика', 'Женская винтажная косметика и аксессуары для красоты.', 'Винтажная косметика (женская)', 'Коллекционная женская косметика и ретро-аксессуары.', NULL),
(65, 11, 'en', 'Cosmetics', 'Women’s vintage cosmetics and beauty accessories.', 'Vintage Women’s Cosmetics', 'Collectible cosmetics and retro beauty accessories for women.', NULL),
(66, 11, 'de', 'Kosmetik', 'Vintage-Kosmetik und Beauty-Accessoires für Damen.', 'Vintage-Damenkosmetik', 'Sammelbare Kosmetik und Retro-Accessoires für Damen.', NULL),
(67, 11, 'fr', 'Cosmétiques', 'Cosmétiques vintage et accessoires beauté pour femmes.', 'Cosmétiques vintage femme', 'Cosmétiques de collection et accessoires rétro pour femmes.', NULL),
(68, 11, 'es', 'Cosmética', 'Cosmética vintage y accesorios de belleza para mujer.', 'Cosmética vintage mujer', 'Cosméticos de colección y accesorios retro para mujer.', NULL),
(69, 11, 'ja', 'コスメ', '女性向けのヴィンテージコスメ＆ビューティーアクセサリー。', 'レディース ヴィンテージコスメ', '女性のためのコレクション系コスメとレトロ小物。', NULL),
(70, 11, 'zh', '彩妆护肤', '女士复古彩妆与美妆配件。', '女士复古彩妆', '女士收藏级彩妆与复古美妆配饰。', NULL),
(71, 12, 'ru', 'Аксессуары', 'Женские винтажные аксессуары для завершения образа.', 'Винтажные женские аксессуары', 'Коллекционные аксессуары в ретро-стиле для женщин.', NULL),
(72, 12, 'en', 'Accessories', 'Women’s vintage accessories to complete the look.', 'Vintage Women’s Accessories', 'Collectible retro-style accessories for women.', NULL),
(73, 12, 'de', 'Accessoires', 'Vintage-Accessoires für Damen zur Abrundung des Looks.', 'Vintage-Damenaccessoires', 'Sammelbare Retro-Accessoires für Damen.', NULL),
(74, 12, 'fr', 'Accessoires', 'Accessoires vintage pour femmes pour parfaire la tenue.', 'Accessoires vintage femme', 'Accessoires rétro de collection pour femmes.', NULL),
(75, 12, 'es', 'Accesorios ', 'Accesorios vintage para mujer para completar el look.', 'Accesorios vintage mujer', 'Accesorios de colección en estilo retro para mujer.', NULL),
(76, 12, 'ja', 'アクセサリー', '装いを仕上げるレディースのヴィンテージアクセサリー。', 'レディース ヴィンテージアクセサリー', '女性向けのレトロなコレクションアクセサリー。', NULL),
(77, 12, 'zh', '配饰', '完善造型的女士复古配饰。', '女士复古配饰', '女士复古风收藏级配饰。', NULL),
(78, 13, 'ru', 'Очки', 'Мужские винтажные солнцезащитные и имиджевые очки.', 'Винтажные мужские очки', 'Редкие мужские очки в ретро-стиле.', NULL),
(79, 13, 'en', 'Glasses', 'Men’s vintage sunglasses and optical frames.', 'Vintage Men’s Glasses', 'Rare retro-style eyewear for men.', NULL),
(80, 13, 'de', 'Brillen', 'Vintage-Sonnenbrillen und Fassungen für Herren.', 'Vintage-Herrenbrillen', 'Seltene Retro-Brillen für Herren.', NULL),
(81, 13, 'fr', 'Lunettes', 'Lunettes de soleil et montures vintage pour hommes.', 'Lunettes vintage homme', 'Lunettes rétro rares pour hommes.', NULL),
(82, 13, 'es', 'Gafas', 'Gafas de sol y monturas vintage para hombre.', 'Gafas vintage hombre', 'Gafas retro raras para hombre.', NULL),
(83, 13, 'ja', 'アイウェア', '男性向けのヴィンテージサングラス＆フレーム。', 'メンズ ヴィンテージアイウェア', '男性用のレトロスタイル眼鏡。', NULL),
(84, 13, 'zh', '眼镜', '男士复古太阳镜与镜框。', '男士复古眼镜', '男士复古风稀有眼镜。', NULL),
(85, 14, 'ru', 'Часы', 'Мужские винтажные часы в стиле ретро.', 'Винтажные мужские часы', 'Редкие мужские часы с историей.', NULL),
(86, 14, 'en', 'Watches', 'Men’s vintage watches in retro style.', 'Vintage Men’s Watches', 'Rare men’s timepieces with history.', NULL),
(87, 14, 'de', 'Uhren', 'Herrenuhren im Vintage-Stil.', 'Vintage-Herrenuhren', 'Seltene Herrenuhren mit Geschichte.', NULL),
(88, 14, 'fr', 'Montres', 'Montres vintage pour hommes au style rétro.', 'Montres vintage homme', 'Montres rares pour hommes, chargées d’histoire.', NULL),
(89, 14, 'es', 'Relojes', 'Relojes vintage para hombre en estilo retro.', 'Relojes vintage hombre', 'Relojes raros para hombre con historia.', NULL),
(90, 14, 'ja', '腕時計', 'レトロスタイルのメンズ ヴィンテージウォッチ。', 'メンズ ヴィンテージ腕時計', '歴史を宿す男性用の希少なタイムピース。', NULL),
(91, 14, 'zh', '腕表', '男士复古风腕表。', '男士复古腕表', '承载历史的男士稀有时计。', NULL),
(92, 15, 'ru', 'Ремни', 'Мужские винтажные ремни из натуральных материалов.', 'Винтажные ремни (мужские)', 'Редкие ремни в ретро-стиле из натуральной кожи и тканей.', NULL),
(93, 15, 'en', 'Belts', 'Men’s vintage belts made of natural materials.', 'Vintage Men’s Belts', 'Rare retro-style belts in leather and textiles.', NULL),
(94, 15, 'de', 'Gürtel', 'Vintage-Herrengürtel aus natürlichen Materialien.', 'Vintage-Herrengürtel', 'Seltene Retro-Gürtel aus Leder und Textil.', NULL),
(95, 15, 'fr', 'Ceintures', 'Ceintures vintage pour hommes en matières naturelles.', 'Ceintures vintage homme', 'Ceintures rétro rares en cuir et textiles.', NULL),
(96, 15, 'es', 'Cinturones', 'Cinturones vintage para hombre de materiales naturales.', 'Cinturones vintage hombre', 'Cinturones retro raros de cuero y tejidos.', NULL),
(97, 15, 'ja', 'ベルト', '天然素材を使用したメンズのヴィンテージベルト。', 'メンズ ヴィンテージベルト', 'レザーやテキスタイルのレトロベルト。', NULL),
(98, 15, 'zh', '腰带', '男士复古腰带，选用天然材质。', '男士复古腰带', '皮革与织物的复古风男士腰带。', NULL),
(99, 16, 'ru', 'Галстуки', 'Мужские винтажные галстуки и бабочки.', 'Винтажные галстуки (мужские)', 'Редкие аксессуары для мужчин — галстуки и бабочки в ретро-стиле.', NULL),
(100, 16, 'en', 'Ties', 'Men’s vintage ties and bow ties.', 'Vintage Men’s Ties', 'Rare retro accessories — ties and bow ties for men.', NULL),
(101, 16, 'de', 'Krawatten', 'Vintage-Krawatten und Fliegen für Herren.', 'Vintage-Herrenkrawatten', 'Seltene Retro-Accessoires: Krawatten und Fliegen für Herren.', NULL),
(102, 16, 'fr', 'Cravates', 'Cravates et nœuds papillon vintage pour hommes.', 'Cravates vintage homme', 'Accessoires rétro rares : cravates et nœuds papillon pour hommes.', NULL),
(103, 16, 'es', 'Corbatas', 'Corbatas y pajaritas vintage para hombre.', 'Corbatas vintage hombre', 'Accesorios retro raros: corbatas y pajaritas para hombre.', NULL),
(104, 16, 'ja', 'ネクタイ', 'メンズのヴィンテージネクタイ＆ボウタイ。', 'メンズ ヴィンテージネクタイ', 'レトロなメンズアクセサリー：ネクタイ＆ボウタイ。', NULL),
(105, 16, 'zh', '领带', '男士复古领带与蝴蝶结。', '男士复古领带', '男士复古风配饰：领带与蝴蝶结。', NULL),
(106, 18, 'ru', 'Аксессуары', 'Мужские винтажные аксессуары: запонки, зажимы и другое.', 'Винтажные мужские аксессуары', 'Стильные мужские аксессуары в ретро-стиле.', NULL),
(107, 18, 'en', 'Accessories', 'Men’s vintage accessories: cufflinks, clips and more.', 'Vintage Men’s Accessories', 'Stylish retro accessories for men.', NULL),
(108, 18, 'de', 'Accessoires', 'Herren-Accessoires im Vintage-Stil: Manschettenknöpfe, Klammern u.v.m.', 'Vintage-Herrenaccessoires', 'Stilvolle Retro-Accessoires für Herren.', NULL),
(109, 18, 'fr', 'Accessoires', 'Accessoires vintage pour hommes : boutons de manchette, pinces, etc.', 'Accessoires vintage homme', 'Accessoires rétro élégants pour hommes.', NULL),
(110, 18, 'es', 'Accesorios', 'Accesorios vintage para hombre: gemelos, pinzas y más.', 'Accesorios vintage hombre', 'Accesorios retro elegantes para hombre.', NULL),
(111, 18, 'ja', 'アクセサリー', 'カフリンクスやタイクリップなど、男性向けのヴィンテージアクセサリー。', 'メンズ ヴィンテージアクセサリー', '男性向けのエレガントなレトロアクセサリー。', NULL),
(112, 18, 'zh', '配饰', '男士复古配饰：袖扣、领带夹等。', '男士复古配饰', '男士优雅的复古风配饰。', NULL),
(113, 19, 'ru', 'Игрушки и музыкальные инструменты', 'Винтажные игрушки и музыкальные инструменты для детей и коллекционеров.', 'Винтажные игрушки — коллекции', 'Редкие игрушки и музыкальные инструменты в винтажном стиле.', NULL),
(114, 19, 'en', 'Toys & Musical Instruments', 'Vintage toys and musical instruments for kids and collectors.', 'Vintage Toys — Collections', 'Rare toys and vintage-style musical instruments.', NULL),
(115, 19, 'de', 'Spielzeuge & Musikinstrumente', 'Vintage-Spielzeuge und Musikinstrumente für Kinder und Sammler.', 'Vintage-Spielzeuge — Sammlungen', 'Seltene Spielzeuge und Musikinstrumente im Retro-Stil.', NULL),
(116, 19, 'fr', 'Jouets & instruments de musique', 'Jouets vintage et instruments de musique pour enfants et collectionneurs.', 'Jouets vintage — Collections', 'Jouets rares et instruments de musique au style rétro.', NULL),
(117, 19, 'es', 'Juguetes e instrumentos musicales', 'Juguetes vintage e instrumentos musicales para niños y coleccionistas.', 'Juguetes vintage — Colecciones', 'Juguetes raros e instrumentos musicales de estilo retro.', NULL),
(118, 19, 'ja', '玩具・楽器', '子どもやコレクターのためのヴィンテージ玩具・楽器。', 'ヴィンテージ玩具 — コレクション', 'レトロスタイルの希少な玩具と楽器。', NULL),
(119, 19, 'zh', '玩具与乐器', '面向儿童与收藏者的复古玩具与乐器。', '复古玩具｜收藏', '复古风稀有玩具与乐器。', NULL),
(120, 17, 'ru', 'Сумки', 'Мужские винтажные сумки и портфели.', 'Купить мужские винтажные сумки люксовых брендов онлайн | VVintage', 'Редкие мужские сумки и портфели в ретро-стиле.', NULL),
(121, 17, 'en', 'Bags', 'Men’s vintage bags and briefcases.', 'Buy Men\'s Vintage Luxury Bags Online | VVintage', 'Rare men’s bags and retro-style briefcases.', NULL),
(122, 17, 'de', 'Herrentaschen', 'Vintage-Taschen und Aktentaschen für Herren.', 'Männer Vintage Luxus Taschen online kaufen | VVintage', 'Seltene Herrentaschen und Retro-Aktentaschen.', NULL),
(123, 17, 'es', 'Carteras', 'Bolsos y maletines vintage para hombre.', 'Comprar bolsos vintage de lujo para hombres online | VVintage', 'Bolsos y maletines retro raros para hombre.', NULL),
(124, 17, 'fr', 'Sacs pour hommes', 'Sacs et porte-documents vintage pour hommes.', 'Acheter des sacs vintage de luxe pour hommes en ligne | VVintage', 'Sacs rares pour hommes, porte-documents rétro.', NULL),
(125, 17, 'ja', 'メンズバッグ', '男性向けのヴィンテージバッグやブリーフケース。', 'メンズヴィンテージラグジュアリーバッグをオンラインで購入 | VVintage', '男性用のレトロなバッグ＆ブリーフケース。', NULL),
(126, 17, 'zh', '手袋', '男士复古包袋与公文包。', '在线购买男士奢侈复古手袋 | VVintage', '男士复古风包袋与公文包的稀有之选。', NULL),
(127, 22, 'ru', 'Для детей', 'Выбирайте детские духи и туалетную воду с мягким и безопасным составом. Идеальные ароматы для малышей и подростков — нежно, безопасно и красиво.', 'Парфюмерия для детей — безопасные и нежные ароматы', 'Широкий ассортимент детской парфюмерии: мягкие ароматы, безопасные для кожи детей, для малышей и подростков. Закажите онлайн с доставкой и подарите любимый запах вашему ребёнку.', NULL),
(128, 22, 'en', 'Children', 'Discover children’s perfumes and eau de toilette with soft, safe formulas. Perfect fragrances for kids and teens — gentle, safe, and delightful.', 'Children’s Perfume — Buy Safe Perfumes for Kids Online | [vvintage]', 'Wide range of children’s perfumes: mild fragrances safe for kids’ skin, suitable for toddlers and teens. Order online with delivery and gift your child a favorite scent.', NULL),
(129, 22, 'de', 'Kinder', 'Entdecken Sie Kinderparfüms und Eau de Toilette mit sanften, sicheren Formeln. Perfekte Düfte für Kinder und Jugendliche — zart, sicher und angenehm.', 'Kinderparfüm — sichere Parfums für Kinder online kaufen | [vvintage]', 'Große Auswahl an Kinderparfüms: leichte Düfte, sicher für empfindliche Haut, geeignet für Kinder und Teenager. Jetzt online bestellen und Freude schenken.', NULL),
(130, 22, 'es', 'Infantil', 'Descubra perfumes y aguas de colonia para niños con fórmulas suaves y seguras. Fragancias perfectas para pequeños y adolescentes.', 'Perfumería infantil — comprar perfumes seguros para niños online | [vvintage]', 'Amplia selección de perfumes infantiles: aromas ligeros y seguros para la piel de los niños, ideales para bebés y adolescentes. Pida online con entrega rápida.', NULL),
(131, 22, 'fr', 'Pour enfants', 'Découvrez des parfums et eaux de toilette pour enfants avec une composition douce et sécurisée. Des fragrances idéales pour les petits et les adolescents.', 'Parfumerie enfant — acheter des parfums sûrs pour enfants en ligne | [Nom du magasin]', 'Large choix de parfums pour enfants : senteurs légères et sûres pour la peau, adaptées aux tout-petits et aux ados. Commandez en ligne avec livraison rapide.', NULL),
(132, 22, 'ja', '子供用香水', 'お子様向けの香水やオードトワレを、肌にやさしい安全な処方でご用意。子供からティーンまでにぴったりの香りです。', '子供用香水 — 安全な子供向けフレグランスをオンラインで購入 | [店舗名]', '豊富な子供用香水：敏感な肌にも安心なやさしい香り。幼児からティーンまで幅広く対応。オンライン注文と配送可能。', NULL),
(133, 22, 'zh', '儿童香水', '探索儿童香水与淡香水，配方温和安全。适合儿童和青少年的理想香氛。', '儿童香水 — 在线购买安全的儿童香氛 | [商店名称]', '丰富的儿童香水选择：温和香气，安全呵护孩子娇嫩肌肤，适合婴童与青少年。立即在线下单，快速送达。', NULL),
(134, 7, 'ru', 'Сумки', 'Уникальные женские винтажные сумки от люксовых брендов. Редкие аксессуары с историей, стилем и безупречным качеством мировых модных домов.', 'Купить женские винтажные сумки люксовых брендов онлайн | [vvintage]', 'Эксклюзивный выбор винтажных сумок для женщин: культовые модели люксовых брендов, проверенное временем качество и неповторимый стиль. Закажите онлайн с доставкой.', ''),
(135, 7, 'en', 'Bags', 'Unique women’s vintage bags from luxury brands. Rare accessories with history, timeless style, and impeccable quality from iconic fashion houses.', 'Buy Women’s Vintage Luxury Bags Online | [vvintage]', 'Exclusive collection of women’s vintage bags: iconic luxury brand designs, heritage quality, and authentic style. Shop online with worldwide delivery.', ''),
(136, 7, 'de', 'Damentaschen', 'Einzigartige Vintage-Damentaschen von Luxusmarken. Seltene Accessoires mit Geschichte, zeitlosem Stil und höchster Qualität.', 'Vintage Damentaschen von Luxusmarken online kaufen | [vvintage]', 'Exklusive Auswahl an Vintage-Damentaschen: ikonische Modelle renommierter Luxusmarken, authentischer Stil und bewährte Qualität. Jetzt online bestellen.', ''),
(137, 7, 'es', 'Bolsos', 'Bolsos vintage exclusivos para mujer de marcas de lujo. Accesorios raros con historia, estilo atemporal y calidad impecable.', 'Comprar bolsos vintage de lujo para mujer online | [vvintage]', 'Colección exclusiva de bolsos vintage para mujer: diseños icónicos de marcas de lujo, calidad auténtica y estilo único. Compra online con entrega a domicilio.', ''),
(138, 7, 'fr', 'Sacs', 'Des sacs vintage uniques pour femmes issus de grandes marques de luxe. Des pièces rares avec histoire, élégance et qualité intemporelle.', 'Acheter des sacs vintage de luxe pour femmes en ligne | [vvintage]', 'Sélection exclusive de sacs vintage pour femmes : modèles iconiques de marques de luxe, style authentique et qualité inégalée. Commandez en ligne avec livraison.', ''),
(139, 7, 'ja', 'ジバッグ', '高級ブランドのレディースヴィンテージバッグ。歴史ある希少なアクセサリーで、永遠のスタイルと本物の魅力を。', 'レディース ヴィンテージ高級バッグをオンラインで購入 | [vvintage]', '厳選されたレディースヴィンテージバッグ：高級ブランドのアイコニックなモデル、時代を超えたスタイル、確かな品質。オンライン注文と配送可能。', ''),
(140, 7, 'zh', '手袋', '独特的奢侈品牌女士复古手袋。稀有配饰，兼具历史感、时尚风格和世界顶级时尚品牌的卓越品质。', '在线购买奢侈品牌女士复古手袋 | [vvintage]', '女士复古手袋独家精选：奢侈品牌标志性款式，经受时间考验的品质与独特风格。在线下单，送货上门。', ''),
(141, 20, 'ru', 'Для неё', 'Винтажные женские ароматы, вдохновлённые классикой и утончённостью прошлых эпох.', 'Для неё – винтажная парфюмерия', 'Коллекция винтажных женских ароматов для тех, кто ценит элегантность и неповторимый стиль.', NULL),
(142, 20, 'en', 'For Her', 'Vintage women\'s fragrances inspired by timeless classics and elegance of past eras.', 'For Her – Vintage Perfume', 'A collection of vintage women’s fragrances for those who value elegance and unique style.', NULL),
(143, 20, 'de', 'Für Sie', 'Vintage-Düfte für Frauen, inspiriert von Klassikern und der Eleganz vergangener Epochen.', 'Für Sie – Vintage-Parfum', 'Eine Kollektion von Vintage-Düften für Frauen, die Eleganz und Einzigartigkeit schätzen.', NULL),
(144, 20, 'fr', 'Pour Elle', 'Parfums vintage pour femme, inspirés par les classiques et l’élégance des époques passées', 'Pour Elle – Parfums Vintage', 'Collection de parfums vintage féminins pour celles qui apprécient l’élégance et le style unique.', NULL),
(145, 20, 'es', 'Para Ella', 'Fragancias vintage femeninas, inspiradas en la elegancia y los clásicos de épocas pasadas.', 'Para Ella – Perfumes Vintage', 'Colección de fragancias vintage femeninas para quienes valoran la elegancia y un estilo único.', NULL),
(146, 20, 'ja', '彼女のために', 'クラシックと過去の時代の優雅さにインスパイアされたヴィンテージ女性用フレグランス。', '彼女のために – ヴィンテージ香水', 'エレガンスと独自のスタイルを大切にする女性のためのヴィンテージ香水コレクション。', NULL),
(147, 20, 'zh', '她的专属', '受经典与往昔优雅启发的复古女士香氛。', '她的专属 – 复古香水', '为追求优雅与独特风格的女性打造的复古香氛系列。', NULL),
(148, 21, 'ru', 'Для него', 'Винтажные мужские ароматы с характером и шармом ушедших эпох.', 'Для него – винтажная парфюмерия\r\n', 'Коллекция винтажных мужских ароматов для ценителей стиля и уникальности.', NULL),
(149, 21, 'en', 'For Him\r\n', 'Vintage men’s fragrances with the character and charm of past times.\r\n', 'For Him – Vintage Perfume\r\n', 'A collection of vintage men’s fragrances for connoisseurs of style and uniqueness.', NULL),
(150, 21, 'de', 'Für Ihn\r\n', 'Vintage-Düfte für Männer mit dem Charakter und Charme vergangener Zeiten.\r\n', 'Für Ihn – Vintage-Parfum\r\n', 'Eine Kollektion von Vintage-Düften für Männer, die Stil und Einzigartigkeit schätzen.', NULL),
(151, 21, 'fr', 'Pour Lui\r\n', 'Parfums vintage pour homme avec le caractère et le charme des époques révolues.\r\n', 'Pour Lui – Parfums Vintage\r\n', 'Collection de parfums vintage masculins pour les amateurs de style et d’originalité.', NULL),
(152, 21, 'es', 'Para Él\r\n', 'Fragancias vintage masculinas con el carácter y el encanto de épocas pasadas.\r\n', 'Para Él – Perfumes Vintage\r\n', 'Colección de fragancias vintage masculinas para quienes aprecian el estilo y la singularidad.', NULL),
(153, 21, 'ja', '彼のために', '過ぎ去った時代の個性と魅力を持つヴィンテージ男性用フレグランス。', '彼のために – ヴィンテージ香水', 'スタイルと独自性を重んじる男性のためのヴィンテージ香水コレクション。', NULL),
(154, 21, 'zh', '他的专属', '融合往昔魅力与个性的复古男士香氛。', '他的专属 – 复古香水', '为注重品位与独特气质的男士打造的复古香氛系列。', NULL);

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
  `status` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `datetime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `email`, `name`, `message`, `phone`, `status`, `user_id`, `datetime`) VALUES
(1, 'info@yandex.ru', 'Elena Truman', 'Тестовое сообщение №1', 792577760741, NULL, NULL, '2025-08-10 22:58:38'),
(2, 'info@yandex.ru', 'Elena Truman', 'Тестовое сообщение №1', 792577760741, 'new', NULL, '2025-08-10 22:58:38'),
(3, 'ifrance@yandex.ru', 'Наталья Евгеньевна Балашова', 'Сообщение №2', 79258260741, 'new', NULL, '2025-08-10 22:58:38'),
(4, 'info@yandex.ru', 'RESIDENCE BONOMELLI', 'Сообщение №3', 792577760741, 'new', NULL, '2025-08-10 22:58:38'),
(5, 'info@yandex.ru', 'RESIDENCE BONOMELLI', 'Новое', 792577760741, 'new', 2, '2025-08-10 22:58:38'),
(6, 'info@yandex.ru', 'Admin Truman', 'Сообщение 3', 79256666666, 'new', 2, '2025-08-10 22:58:38'),
(7, 'info@yandex.ru', 'Admin Truman', 'Сообщение 3', 79256666666, NULL, 2, '2025-08-10 22:58:38'),
(8, 'info@yandex.ru', 'Elena Truman', 'Сообщение', 792577760741, 'new', 2, '2025-08-10 22:58:38'),
(10, 'info@yandex.ru', 'Admin Truman', 'Сообщение', 79256666666, 'new', 2, '2025-08-10 22:58:38'),
(11, 'info@yandex.ru', 'Admin Truman', 'Сообщение', 79256666666, 'new', 2, '2025-08-10 22:58:38'),
(12, 'info@yandex.ru', 'Admin Truman', 'Сообщение', 79256666666, 'new', 2, '2025-08-10 22:58:38'),
(13, 'info@yandex.ru', 'Admin Truman', 'Сообщение', 79256666666, 'new', 2, '2025-08-10 22:58:38'),
(18, 'test@google.com', 'Тестовое Имя и  Фамилия', 'Тестовое сообщение длинной больше ста символов наверное', 9256342312, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `surname` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `phone` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `address` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `paid` tinyint(1) UNSIGNED DEFAULT NULL,
  `cart` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `price` int(11) UNSIGNED DEFAULT NULL,
  `tracking_number` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `canceled_reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `comment` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `payment_type` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_520_ci NOT NULL,
  `edit_time` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `surname`, `email`, `phone`, `address`, `datetime`, `status`, `paid`, `cart`, `price`, `tracking_number`, `canceled_reason`, `comment`, `payment_type`, `edit_time`) VALUES
(1, 1, 'Admin', 'Truman', 'info@yandex.ru', '', 'BERGAME, VIA GEREMIA BONOMELLI 15', '2025-07-28 16:49:19', 'new', 0, '[{\"id\":4,\"title\":\"\\u0426\\u0435\\u043b\\u044c\\u043d\\u043e\\u0435 \\u043a\\u043e\\u043b\\u044c\\u0446\\u043e Chanel Gold 750\",\"price\":12000,\"amount\":1}]', 12000, '', '', '', '', NULL),
(2, 1, 'Надежда', 'Stepanova', 'user@mail.ru', '9253458675', 'BERGAME, VIA GEREMIA BONOMELLI 15', '2025-09-22 00:20:07', 'new', 0, '[{\"id\":4,\"title\":\"fdfdf\",\"price\":2323,\"amount\":1}]', 2323, '', '', '', '', NULL),
(3, 1, 'Надежда', 'Stepanova', 'user@mail.ru', '9253458675', 'BERGAME, VIA GEREMIA BONOMELLI 15', '2025-09-22 00:22:41', 'new', 0, '[{\"id\":4,\"title\":\"fdfdf\",\"price\":2323,\"amount\":1}]', 2323, '', '', '', '', NULL),
(4, 1, 'Надежда', 'Stepanova', 'user@mail.ru', '9253458675', 'BERGAME, VIA GEREMIA BONOMELLI 15', '2025-09-22 00:23:27', 'new', 0, '[{\"id\":4,\"title\":\"fdfdf\",\"price\":2323,\"amount\":1}]', 2323, '', '', '', '', NULL),
(6, 1, 'Elena', 'Балашова', '1@mail.ru', '79253458675', '', '2025-10-09 15:59:34', 'new', 0, '[{\"id\":43,\"title\":\"Les Larmes Sacr\\u00e9es de Th\\u00e8bes by Baccarat \\u2013 Extrait 7.5 ml\",\"price\":4000,\"amount\":1}]', 4000, '', '', '', '', NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pagefields`
--

CREATE TABLE `pagefields` (
  `id` int(11) UNSIGNED NOT NULL,
  `page_id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `field_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT 'text',
  `is_active` tinyint(1) DEFAULT '1',
  `display_order` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pagefields`
--

INSERT INTO `pagefields` (`id`, `page_id`, `name`, `value`, `field_type`, `is_active`, `display_order`, `created_at`, `updated_at`) VALUES
(1, 6, 'phone', '+33-0606459426', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22'),
(2, 6, 'email', 'vvintage.store@yandex.com', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22'),
(3, 6, 'address', '7 Rue Alain Fournier, 18230 Saint-Doulchard, France', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22'),
(4, 6, 'map', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2715.862570042332!2d2.3689981761541183!3d47.10176477114796!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47fa95928344d14f%3A0x25e4e1099de4acfb!2zNyBSdWUgQWxhaW4gRm91cm5pZXIsIDE4MjMwIFNhaW50LURvdWxjaGFyZCwg0KTRgNCw0L3RhtC40Y8!5e0!3m2!1sru!2sde!4v1748543016031!5m2!1sru!2sde', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22'),
(5, 1, 'categories_title', 'Категории', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22'),
(6, 1, 'new_products_title', 'Новинки магазина', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22'),
(7, 1, 'new_posts_title', 'Недавние публикации', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22'),
(8, 1, 'recommended_title', 'Рекомендованные товары', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22'),
(9, 1, 'popular_title', 'Популярное', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22'),
(10, 1, 'cite', 'Мода, вдохновленная прошлым...', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22'),
(11, 3, 'intro_title', 'Что мы предлагаем', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-06 00:34:01'),
(12, 3, 'intro_text', 'VVintage — это сайт, который предлагает большой ассортимент винтажных вещей известных брендов из Европы (Франция, Италия, Бельгия, Испания) с доставкой на ваш адрес. Все товары находятся в Европе и высылаются покупателям в любую точку мира под заказ.\r\n\r\nУ нас вы можете приобрести редкую парфюмерию, косметику, украшения, сумки, товары для дома, одежду и обувь. Также вы можете оставить нам заявку на поиск парфюмерных редкостей.\r\n\r\nВсе товары являются оригинальными, их происхождение гарантируется либо сертификатами аутентичности, которые предоставляются вместе с товарами, либо, если это невозможно, платформами, с которых они выкупаются.', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-06 00:34:01'),
(13, 4, 'order_steps_title', 'Оформление заказа', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-06 00:34:01'),
(14, 4, 'order_steps_1_text', '<p>Оформите заказ на сайте. Доступно после <a class=\"link\">регистрации</a></p>\r\n<p>Администратор проверит наличие товара и рассчитает итоговую стоимость.</p>', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-06 00:34:01'),
(15, 4, 'order_steps_2_text', '<p>Данные по оплате будут направлены на email</p>\r\n<p>Оплатить заказ нужно в течении 15 мин с момента подтверждения.</p>', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-06 00:34:01'),
(16, 4, 'order_steps_3_text', '<p>После получения оплаты выкупаем товар у поставщика.</p>\r\n<p>Товар поступает на склад в течение недели. </p>', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-06 00:34:01'),
(17, 4, 'order_steps_4_text', '<p>После проверки он отправляется покупателю государственной почтой вашей страны. В графе заказа в профиле появится трек-номер</p>', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-06 00:34:01'),
(18, 1, 'site_header', 'ВИНТАЖНЫЕ ТОВАРЫ', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22'),
(19, 5, 'blog_title', 'Блог о винтажной Франции', 'text', 1, NULL, '2025-10-05 23:36:22', '2025-10-05 23:36:22');

-- --------------------------------------------------------

--
-- Структура таблицы `pagefieldstranslation`
--

CREATE TABLE `pagefieldstranslation` (
  `id` int(10) UNSIGNED NOT NULL,
  `field_id` int(11) UNSIGNED NOT NULL,
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pagefieldstranslation`
--

INSERT INTO `pagefieldstranslation` (`id`, `field_id`, `locale`, `value`) VALUES
(1, 5, 'ru', 'Категории'),
(2, 5, 'en', 'Categories'),
(4, 5, 'de', 'Kategorien'),
(5, 5, 'fr', 'Catégories'),
(6, 5, 'es', 'Categorías'),
(7, 5, 'ja', 'カテゴリー'),
(8, 5, 'zh', '分类'),
(9, 6, 'ru', 'Новинки магазина'),
(10, 6, 'en', 'New Arrivals'),
(11, 6, 'de', 'Neuheiten'),
(12, 6, 'fr', 'Nouveautés'),
(13, 6, 'es', 'Novedades'),
(14, 6, 'ja', '新着アイテム'),
(15, 6, 'zh', '店铺新品'),
(16, 7, 'ru', 'Недавние публикации'),
(17, 7, 'en', 'Recent Posts'),
(18, 7, 'de', 'Neueste Beiträge'),
(19, 7, 'fr', 'Articles récents'),
(20, 7, 'es', 'Publicaciones recientes'),
(21, 7, 'ja', '最近の投稿'),
(22, 7, 'zh', '最新文章'),
(23, 8, 'ru', 'Рекомендованные товары'),
(24, 8, 'en', 'Recommended Products'),
(25, 8, 'de', 'Empfohlene Produkte'),
(26, 8, 'fr', 'Produits recommandés'),
(27, 8, 'es', 'Productos recomendados'),
(28, 8, 'ja', 'おすすめ商品'),
(31, 8, 'zh', '推荐商品'),
(32, 9, 'ru', 'Популярное'),
(33, 9, 'en', 'Popular'),
(34, 9, 'de', 'Beliebt'),
(35, 9, 'fr', 'Populaire'),
(36, 9, 'es', 'Popular'),
(37, 9, 'ja', '人気'),
(38, 9, 'zh', '热门'),
(39, 10, 'ru', 'Мода, вдохновленная прошлым…'),
(40, 10, 'en', 'Fashion Inspired by the Past…'),
(41, 10, 'de', 'Mode, inspiriert von der Vergangenheit…'),
(42, 10, 'fr', 'Mode inspirée du passé…'),
(43, 10, 'es', 'Moda inspirada en el pasado…'),
(44, 10, 'ja', '過去にインスパイアされたファッション…'),
(45, 10, 'zh', '灵感来自过去的时尚…'),
(46, 11, 'ru', 'Что мы предлагаем'),
(47, 11, 'en', 'What We Offer'),
(48, 11, 'de', 'Was wir anbieten'),
(49, 11, 'fr', 'Ce que nous proposons'),
(50, 11, 'es', 'Lo que ofrecemos'),
(51, 11, 'ja', '私たちの提供内容'),
(52, 11, 'zh', '我们提供的服务'),
(53, 12, 'ru', '<p>\n  VVintage&nbsp;— это сайт, который предлагает большой ассортимент винтажных вещей известных брендов из&nbsp;Европы (Франция, Италия,\n  Бельгия, Испания) c&nbsp;доставкой на&nbsp;ваш адрес. Все товары находятся в&nbsp;Европе и&nbsp;высылаются покупателям в&nbsp;любую точку мира\n  под заказ.\n</p>\n<p>\n  У&nbsp;нас вы&nbsp;можете приобрести редкую парфюмерию, косметику, украшения, сумки, товары для дома, одежду и&nbsp;обувь. Также\n  вы&nbsp;можете оставить нам заявку на&nbsp;поиск парфюмерных редкостей.\n</p>\n<p>\n  Все товары являются оригинальными товарами, которые продаются в&nbsp;Европе. Их&nbsp;происхождение гарантируется либо сертификатами\n  аутентификации, которые предоставляются вместе с&nbsp;товарами, либо, если это невозможно, теми площадками, с&nbsp;которых они выкупаются.\n</p>'),
(54, 12, 'en', '<p>\n  VVintage&nbsp;is a website offering a wide selection of vintage items from well-known European brands (France, Italy, Belgium, Spain),\n  with worldwide delivery to your address. All items are located in&nbsp;Europe and shipped to customers anywhere in&nbsp;the world on&nbsp;request.\n</p>\n<p>\n  Here you can purchase rare perfumes, cosmetics, jewelry, handbags, home goods, clothing, and footwear. You can also submit a request\n  for us&nbsp;to&nbsp;find rare perfumes for you.\n</p>\n<p>\n  All products are authentic items sold in&nbsp;Europe. Their origin is guaranteed either by&nbsp;authenticity certificates provided with\n  the goods or, when unavailable, by&nbsp;the verified platforms from which they are sourced.\n</p>'),
(56, 12, 'de', '<p>\n  VVintage&nbsp;ist eine Website, die eine große Auswahl an&nbsp;Vintage-Artikeln bekannter europäischer Marken (Frankreich, Italien,\n  Belgien, Spanien) mit Lieferung an&nbsp;Ihre Adresse anbietet. Alle Artikel befinden sich in&nbsp;Europa und werden weltweit auf&nbsp;Bestellung versendet.\n</p>\n<p>\n  Bei uns&nbsp;können Sie seltene Parfums, Kosmetik, Schmuck, Taschen, Wohnaccessoires, Kleidung und&nbsp;Schuhe erwerben. Sie können\n  uns&nbsp;auch eine Anfrage zur&nbsp;Suche nach&nbsp;seltenen Parfums senden.\n</p>\n<p>\n  Alle Produkte sind Originalwaren, die in&nbsp;Europa verkauft werden. Ihre Herkunft wird entweder durch Echtheitszertifikate\n  oder, falls dies nicht möglich ist, durch die Plattformen garantiert, von&nbsp;denen sie erworben wurden.\n</p>'),
(57, 12, 'fr', '<p>\n  VVintage&nbsp;est un site qui propose un large choix d’articles vintage de&nbsp;marques européennes renommées (France, Italie,\n  Belgique, Espagne) avec une livraison à&nbsp;votre adresse. Tous les produits se&nbsp;trouvent en&nbsp;Europe et&nbsp;sont expédiés sur&nbsp;commande dans&nbsp;le monde entier.\n</p>\n<p>\n  Vous pouvez y&nbsp;acheter des parfums rares, des produits cosmétiques, des bijoux, des sacs, des articles pour la maison, des vêtements et&nbsp;des chaussures.\n  Vous pouvez également nous&nbsp;laisser une demande pour la recherche de&nbsp;parfums rares.\n</p>\n<p>\n  Tous les articles sont authentiques et&nbsp;vendus en&nbsp;Europe. Leur provenance est garantie soit par&nbsp;des certificats d’authenticité fournis\n  avec les produits, soit, lorsque cela n’est pas possible, par&nbsp;les plateformes officielles auprès desquelles ils sont achetés.\n</p>'),
(58, 12, 'es', '<p>\n  VVintage&nbsp;es un sitio web que ofrece una amplia selección de&nbsp;artículos vintage de&nbsp;marcas europeas reconocidas (Francia, Italia,\n  Bélgica, España) con envío a&nbsp;su dirección. Todos los productos se&nbsp;encuentran en&nbsp;Europa y&nbsp;se envían a&nbsp;cualquier parte del mundo bajo pedido.\n</p>\n<p>\n  Aquí puede comprar perfumes raros, cosméticos, joyas, bolsos, artículos para el hogar, ropa y&nbsp;calzado. También puede enviarnos una solicitud\n  para buscar perfumes raros.\n</p>\n<p>\n  Todos los productos son auténticos y&nbsp;se venden en&nbsp;Europa. Su origen está garantizado por&nbsp;certificados de&nbsp;autenticidad incluidos con los artículos\n  o, si no están disponibles, por&nbsp;las plataformas oficiales de&nbsp;compra.\n</p>'),
(59, 12, 'ja', '<p>\n  VVintage&nbsp;は、ヨーロッパの有名ブランド（フランス、イタリア、ベルギー、スペイン）からのヴィンテージ商品を幅広く取り揃え、\n  世界中へお届けするサイトです。すべての商品はヨーロッパにあり、ご注文に応じて世界各地に発送されます。\n</p>\n<p>\n  珍しい香水、化粧品、ジュエリー、バッグ、インテリア用品、衣類、靴などを購入できます。また、希少な香水の\n  探索リクエストも承っております。\n</p>\n<p>\n  すべての商品はヨーロッパで販売されている正規品です。商品の出所は、付属する真正証明書、\n  または購入元の公式プラットフォームによって保証されています。\n</p>'),
(60, 12, 'zh', '<p>\n  VVintage&nbsp;是一个提供来自欧洲知名品牌（法国、意大利、比利时、西班牙）复古商品的网站，\n  支持配送到您的地址。所有商品均位于欧洲，可根据订单寄往世界各地。\n</p>\n<p>\n  我们提供稀有香水、化妆品、首饰、手袋、家居用品、服装和鞋类。您还可以提交请求，\n  让我们为您寻找稀有香水。\n</p>\n<p>\n  所有商品均为在欧洲销售的正品。其来源由随附的真品证书或可靠的采购平台保证。\n</p>\n'),
(61, 18, 'ru', 'ВИНТАЖНЫЕ ТОВАРЫ'),
(62, 18, 'en', 'VINTAGE ITEMS'),
(63, 18, 'de', 'VINTAGE-ARTIKEL'),
(64, 18, 'fr', 'ARTICLES VINTAGE'),
(65, 18, 'es', 'ARTÍCULOS VINTAGE'),
(66, 18, 'ja', 'ヴィンテージ商品'),
(67, 18, 'zh', '复古商品'),
(68, 19, 'ru', 'Блог о винтажной Франции'),
(69, 19, 'en', 'Blog about Vintage Franc'),
(70, 19, 'de', 'Blog über Vintage Frankreich'),
(71, 19, 'fr', 'Blog sur la France vintage'),
(72, 19, 'es', 'Blog sobre la Francia vintage'),
(73, 19, 'ja', 'ヴィンテージフランスのブログ'),
(74, 19, 'zh', '关于复古法国的博客');

-- --------------------------------------------------------

--
-- Структура таблицы `pages`
--

CREATE TABLE `pages` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `visible` tinyint(1) NOT NULL,
  `show_in_navigation` tinyint(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pages`
--

INSERT INTO `pages` (`id`, `slug`, `title`, `content`, `visible`, `show_in_navigation`) VALUES
(1, 'main', 'Главная', '', 1, 1),
(2, 'shop', 'Магазин ', '', 1, 1),
(3, 'about', 'О нас', '', 1, 1),
(4, 'delivery', 'Оплата и доставка', '', 1, 1),
(5, 'blog', 'Блог', '', 1, 1),
(6, 'contacts', 'Контакты', '', 1, 1),
(7, 'cart', 'Корзина', '', 1, NULL),
(8, 'privacy-policy', 'Политика конфиденциальности', '', 1, NULL),
(9, 'terms-of-offer', 'Публичная оферта', '', 1, NULL),
(10, 'services', 'О предоставлении услуг', '', 1, NULL),
(11, 'favorites', 'Избранное', '', 1, NULL),
(12, 'neworder', 'Оформление заказа', '', 1, NULL),
(13, 'ordercreated', 'Заказ получен', '', 1, NULL),
(14, 'profile', 'Профиль пользователя', '', 1, NULL),
(15, 'profile/edit', 'Редактировать профиль', '', 1, NULL),
(16, 'login', 'Логин', '', 1, NULL),
(17, 'registration', 'Регистрация', '', 1, NULL),
(18, 'lost-password', 'Восстановить пароль', '', 1, NULL),
(19, 'setnewpass', 'Установить новый пароль', '', 1, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `pagestranslation`
--

CREATE TABLE `pagestranslation` (
  `id` int(10) UNSIGNED NOT NULL,
  `page_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `pagestranslation`
--

INSERT INTO `pagestranslation` (`id`, `page_id`, `locale`, `title`, `description`, `meta_title`, `meta_description`) VALUES
(1, 6, 'ru', 'Контакты', NULL, 'Контакты интернет-магазина винтажных вещей Vvintage', 'Свяжитесь с нами: адрес, телефон, электронная почта и форма обратной связи. Мы всегда рады вашим вопросам и предложениям.'),
(2, 6, 'en', 'Contacts', NULL, 'Contacts Vvintage – Vintage Online Store', 'Get in touch with Vvintage, your trusted vintage online store. Contact us for questions about orders, shipping, or collaborations.'),
(3, 6, 'de', 'Kontakte', NULL, 'Kontakte – Vvintage Online-Shop für Vintage-Artikel', 'Kontaktieren Sie Vvintage, Ihren Online-Shop für Vintage-Stücke. Wir beantworten gerne Fragen zu Bestellungen, Versand und Kooperationen.'),
(4, 6, 'es', 'Contactos', NULL, 'Contactos – Tienda vintage en línea Vvintage', 'Póngase en contacto con Vvintage, su tienda vintage en línea. Le ayudaremos con consultas sobre pedidos, envíos o colaboraciones.'),
(5, 6, 'fr', 'Contacts', NULL, 'Contacts – Boutique vintage en ligne Vvintage', 'Contactez Vvintage, votre boutique vintage en ligne. Nous répondons à vos questions sur les commandes, la livraison ou les collaborations.'),
(6, 6, 'ja', 'お問い合わせ', NULL, 'お問い合わせ – Vvintage ヴィンテージオンラインストア', 'ご注文、配送、またはコラボレーションに関するお問い合わせは、ヴィンテージオンラインストアVvintageまでご連絡ください。'),
(7, 6, 'zh', '联系方式', NULL, '联系方式 – Vvintage 复古网店', '联系复古网店Vvintage，了解订单、配送或合作事宜。'),
(8, 7, 'ru', 'Корзина', NULL, 'Корзина интернет-магазина Vvintage', 'Просмотрите товары в вашей корзине интернет-магазина винтажных вещей Vvintage и переходите к оформлению заказа.'),
(9, 7, 'en', 'Cart\r\n', NULL, 'Cart – Vvintage Vintage Online Store\r\n', 'View the items in your cart at Vvintage, your trusted vintage online store, and proceed to checkout.'),
(10, 7, 'de', 'Warenkorb ', NULL, 'Warenkorb – Vvintage Online-Shop für Vintage-Artikel', 'Sehen Sie die Artikel in Ihrem Warenkorb im Vvintage Online-Shop und fahren Sie mit dem Bestellvorgang fort.'),
(11, 7, 'es', 'Carrito', NULL, 'Carrito – Tienda vintage en línea Vvintage', 'Vea los artículos en su carrito de Vvintage y proceda a la compra.'),
(12, 7, 'fr', 'Panier', NULL, 'Panier – Boutique vintage en ligne Vvintage', 'Consultez les articles dans votre panier sur Vvintage et procédez à la commande.'),
(13, 7, 'ja', 'カート', NULL, 'カート – Vvintage ヴィンテージオンラインストア\r\n', 'Vvintage のカート内の商品を確認し、購入手続きに進んでください。'),
(14, 7, 'zh', '购物车', NULL, '购物车 – Vvintage 复古网店', '查看您在 Vvintage 的购物车商品，并进行结算。'),
(15, 3, 'ru', 'О нас', NULL, 'О нас – интернет-магазин винтажных вещей Vvintage', 'Узнайте больше о Vvintage, нашем бутике винтажных вещей. История бренда, ценности и подход к подбору уникальных коллекционных предметов.'),
(16, 3, 'en', 'About Us', NULL, 'About Us – Vvintage Vintage Online Store\r\n', 'Learn more about Vvintage, our vintage online boutique. Discover our story, values, and approach to curating unique collectible items.'),
(17, 3, 'de', 'Über uns', NULL, 'Über uns – Vvintage Online-Shop für Vintage-Artikel\r\n', 'Erfahren Sie mehr über Vvintage, unseren Online-Shop für Vintage-Stücke. Unsere Geschichte, Werte und Auswahl einzigartiger Sammlerstücke.'),
(18, 3, 'fr', 'À propos', NULL, 'À propos – Boutique vintage en ligne Vvintage\r\n', 'Découvrez Vvintage, notre boutique vintage en ligne. Histoire de la marque, valeurs et sélection d’objets de collection uniques.'),
(19, 3, 'es', 'Sobre nosotros', NULL, 'Sobre nosotros – Tienda vintage en línea Vvintage\r\n', 'Conozca Vvintage, nuestra tienda vintage en línea. Historia de la marca, valores y selección de artículos de colección únicos.'),
(20, 3, 'ja', '私たちについて', NULL, '私たちについて – Vvintage ヴィンテージオンラインストア', 'Vvintage について詳しくご紹介します。ブランドの歴史、価値観、ユニークなコレクションアイテムのセレクト方法。'),
(21, 3, 'zh', '关于我们', NULL, '关于我们 – Vvintage 复古网店', '了解 Vvintage，我们的复古网店。品牌故事、价值观及独特收藏品的精选理念。'),
(22, 4, 'ru', 'Оплата и доставка', NULL, 'Оплата и доставка – интернет-магазин винтажных вещей Vvintage ', 'Узнайте о способах оплаты и условиях доставки в интернет-магазине Vvintage. Удобные варианты оплаты и безопасная доставка ваших винтажных покупок.'),
(23, 4, 'en', 'Payment & Shipping', NULL, 'Payment & Shipping – Vvintage Vintage Online Store\r\n', 'Learn about payment methods and shipping options at Vvintage. Convenient payment and safe delivery for your vintage purchases.'),
(24, 4, 'de', 'Zahlung & Versand', NULL, 'Zahlung & Versand – Vvintage Online-Shop für Vintage-Artikel', 'Erfahren Sie mehr über Zahlungsmethoden und Versandoptionen bei Vvintage. Bequeme Bezahlung und sichere Lieferung Ihrer Vintage-Käufe.'),
(25, 4, 'fr', 'Paiement & Livraison', NULL, 'Paiement & Livraison – Boutique vintage en ligne Vvintage\r\nmeta_description: ', 'Découvrez les modes de paiement et les options de livraison chez Vvintage. Paiement pratique et livraison sécurisée de vos achats vintage.'),
(26, 4, 'es', 'Pago y Envío', NULL, 'Pago y Envío – Tienda vintage en línea Vvintage\r\n', 'Conozca los métodos de pago y las opciones de envío en Vvintage. Pago cómodo y entrega segura de sus compras vintage.'),
(27, 4, 'ja', '支払いと配送 ', NULL, '支払いと配送 – Vvintage ヴィンテージオンラインストア', 'Vvintage での支払い方法と配送オプションをご案内します。便利な支払い方法と安全な配送でヴィンテージ商品をお届け。'),
(28, 4, 'zh', '付款与配送', NULL, '付款与配送 – Vvintage 复古网店', '了解 Vvintage 的付款方式和配送选项。便捷付款，安全送达您的复古购买。'),
(29, 2, 'ru', 'Магазин', NULL, 'Магазин – интернет-магазин винтажных вещей Vvintage', 'Просмотрите наш ассортимент винтажных вещей в интернет-магазине Vvintage. Уникальные коллекционные предметы и аксессуары ждут вас.'),
(30, 2, 'en', 'Shop', NULL, 'Shop – Vvintage Vintage Online Store', 'Browse our collection of vintage items at Vvintage. Discover unique collectibles and accessories.'),
(33, 2, 'de', 'Shop', NULL, 'Shop – Vvintage Online-Shop für Vintage-Artikel', 'Entdecken Sie unser Sortiment an Vintage-Artikeln im Vvintage Online-Shop. Einzigartige Sammlerstücke und Accessoires warten auf Sie.'),
(34, 2, 'fr', 'Boutique', NULL, 'Boutique – Boutique vintage en ligne Vvintage', 'Parcourez notre collection d’objets vintage sur Vvintage. Découvrez des pièces uniques et des accessoires de collection.'),
(35, 2, 'es', 'Tienda', NULL, 'Tienda – Tienda vintage en línea Vvintage', 'Explore nuestra colección de artículos vintage en Vvintage. Descubra objetos y accesorios únicos de colección.'),
(36, 2, 'ja', 'ショップ', NULL, 'ショップ – Vvintage ヴィンテージオンラインストア', 'Vvintage のヴィンテージ商品コレクションをご覧ください。ユニークなコレクションアイテムやアクセサリーが揃っています。'),
(37, 2, 'zh', '商店', NULL, '商店 – Vvintage 复古网店', '浏览 Vvintage 的复古商品系列。发现独特的收藏品和配件。'),
(38, 5, 'ru', 'Блог', NULL, 'Блог – интернет-магазин винтажных вещей Vvintage', 'Читайте статьи о винтажных вещах, коллекционировании и тенденциях моды в блоге интернет-магазина Vvintage.'),
(39, 5, 'en', 'Blog', NULL, 'Blog – Vvintage Vintage Online Store', 'Read articles about vintage items, collecting, and fashion trends on the Vvintage blog.'),
(40, 5, 'de', 'Blog', NULL, 'Blog – Vvintage Online-Shop für Vintage-Artikel\r\nmeta_description: ', 'Lesen Sie Artikel über Vintage-Artikel, Sammlungen und Modetrends im Vvintage Blog.'),
(41, 5, 'fr', 'Blog', NULL, 'Blog – Boutique vintage en ligne Vvintage', 'Lisez des articles sur les objets vintage, la collection et les tendances de la mode sur le blog Vvintage.'),
(42, 5, 'es', 'Blog', NULL, 'Blog – Tienda vintage en línea Vvintage', 'Lea artículos sobre artículos vintage, coleccionismo y tendencias de moda en el blog de Vvintage.'),
(43, 5, 'ja', 'ブログ', NULL, 'ブログ – Vvintage ヴィンテージオンラインストア', 'Vvintage のブログで、ヴィンテージアイテム、コレクション、ファッショントレンドに関する記事をお読みください。'),
(44, 5, 'zh', '博客', NULL, '博客 – Vvintage 复古网店', '在 Vvintage 博客中阅读有关复古物品、收藏和时尚趋势的文章。'),
(46, 1, 'en', 'Home', NULL, 'Vvintage – Vintage Online Store', 'Welcome to Vvintage! Discover unique vintage items, accessories, and collectibles from around the world.'),
(47, 1, 'de', 'Startseite', NULL, 'Vvintage – Online-Shop für Vintage-Artikel', 'Willkommen bei Vvintage! Entdecken Sie einzigartige Vintage-Artikel, Accessoires und Sammlerstücke aus aller Welt.'),
(48, 1, 'fr', 'Accueil', NULL, 'Vvintage – Boutique vintage en ligne', 'Bienvenue chez Vvintage ! Découvrez des objets vintage uniques, accessoires et pièces de collection du monde entier.'),
(49, 1, 'es', 'Inicio', NULL, 'Vvintage – Tienda vintage en línea', '¡Bienvenido a Vvintage! Descubre artículos vintage únicos, accesorios y objetos de colección de todo el mundo.'),
(50, 1, 'ja', 'ホーム', NULL, 'Vvintage – ヴィンテージオンラインストア', 'Vvintage へようこそ！世界中のユニークなヴィンテージアイテム、アクセサリー、コレクション品をお楽しみください。'),
(51, 1, 'zh', '首页', NULL, 'Vvintage – 复古网店', '欢迎来到 Vvintage！发现来自世界各地的独特复古商品、配件和收藏品。'),
(52, 11, 'ru', 'Избранное', 'Ваши избранные товары, сохранённые для удобного просмотра и покупки.', 'Избранные товары — VVintage', 'Просмотрите ваши избранные товары в интернет-магазине VVintage. Легко вернуться к понравившимся вещам и оформить заказ.'),
(53, 11, 'en', 'Favorites\r\n', 'Your favorite items saved for easy viewing and purchase.\r\n', 'Favorite Items — VVintage\r\n', 'View your favorite products on VVintage. Easily revisit and purchase the items you love.'),
(54, 11, 'de', 'Favoriten\r\n', 'Ihre gespeicherten Lieblingsartikel für eine einfache Ansicht und einen bequemen Einkauf.\r\n', 'Favoriten — VVintage\r\n', 'Sehen Sie sich Ihre Lieblingsartikel im VVintage-Shop an und kaufen Sie Ihre Favoriten mit nur einem Klick.'),
(55, 11, 'fr', 'Favoris\r\n', 'Vos articles favoris enregistrés pour un accès et un achat faciles.\r\n', 'Articles favoris — VVintage\r\n', 'Consultez vos articles favoris sur VVintage. Retrouvez et achetez facilement les pièces que vous aimez.'),
(56, 11, 'es', 'Favoritos\r\n', 'Tus artículos favoritos guardados para verlos y comprarlos fácilmente.\r\n\r\n', 'Artículos favoritos — VVintage\r\n', 'Revisa tus productos favoritos en VVintage y compra fácilmente lo que más te gusta.'),
(57, 11, 'ja', 'お気に入り\r\n\r\n', '簡単に確認して購入できるように保存したお気に入り商品。\r\n\r\n\r\n', 'お気に入り商品 — VVintage\r\n', 'VVintageでお気に入り商品をチェック。気に入ったアイテムを簡単に見つけて購入できます。'),
(58, 11, 'zh', '收藏夹\r\n', '您保存的收藏商品，方便查看和购买。\r\n\r\n\r\n\r\n', '收藏商品 — VVintage\r\n', '在VVintage查看您的收藏商品，轻松找到并购买您喜欢的物品。'),
(59, 1, 'ru', 'Главная\r\n', 'Добро пожаловать в интернет-магазин винтажных вещей VVintage. Найдите уникальные аксессуары, сумки, украшения и парфюмерию.\r\n\r\n\r\n\r\n', 'Главная — VVintage\r\n', 'VVintage — магазин винтажных вещей из Европы. Откройте для себя редкие и оригинальные находки от известных брендов.'),
(61, 12, 'ru', 'Оформление заказа\r\n', 'Заполните данные для оформления заказа в интернет-магазине VVintage. Быстрая и безопасная покупка винтажных вещей.\r\n\r\n\r\n', 'Оформление заказа — VVintage', 'Оформите заказ на оригинальные винтажные вещи с доставкой по всему миру. Безопасная оплата и гарантированное качество.'),
(62, 12, 'en', 'Checkout', 'Complete your order details on VVintage. Safe and easy purchase of authentic vintage items.', 'Checkout — VVintage', 'Place your order for vintage fashion and accessories with worldwide delivery. Secure payment and authentic products.'),
(64, 12, 'de', 'Kasse\r\n', 'Geben Sie Ihre Bestelldaten bei VVintage ein. Einfacher und sicherer Kauf von Vintage-Artikeln.\r\n', 'Kasse — VVintage\r\n', 'Bestellen Sie originale Vintage-Produkte mit weltweitem Versand. Sichere Zahlung und garantierte Echtheit.'),
(65, 12, 'fr', 'Commande\r\n', 'Finalisez votre commande sur VVintage. Achat facile et sécurisé d’articles vintage authentiques.\r\n', 'Commande — VVintage\r\n', 'Commandez des articles vintage originaux avec livraison mondiale. Paiement sécurisé et qualité garantie.'),
(66, 12, 'es', 'Finalizar pedido\r\n', 'Complete su pedido en VVintage. Compra fácil y segura de artículos vintage auténticos.\r\n', 'Finalizar pedido — VVintage\r\n', 'Realice su pedido de artículos vintage con envío internacional. Pago seguro y autenticidad garantizada.'),
(67, 12, 'ja', 'ご注文手続き\r\n', 'VVintageで注文手続きを完了してください。本物のヴィンテージ商品を安全かつ簡単に購入できます。\r\n', 'ご注文手続き — VVintage\r\n', '世界中への配送対応。安全な支払いでヴィンテージアイテムを安心購入。'),
(69, 12, 'zh', '结账\r\n', '在VVintage填写订单信息，安全快捷地购买正品复古商品。\r\n', '结账 — VVintage\r\n', '在VVintage下单购买正品复古时尚与配饰，支持全球配送与安全支付。'),
(70, 13, 'ru', 'Заказ получен\r\n', 'Спасибо за ваш заказ! Мы свяжемся с вами в ближайшее время для подтверждения и доставки.\r\n', 'Заказ получен — VVintage\r\n', 'Ваш заказ успешно оформлен. Скоро мы свяжемся с вами для уточнения деталей и доставки.'),
(71, 13, 'en', 'Order received', 'Thank you for your order! We’ll contact you shortly to confirm and arrange delivery.', 'Order received — VVintage', 'Your order has been successfully placed. We’ll reach out soon to confirm details and shipping.'),
(72, 13, 'de', 'Bestellung erhalten\r\n', 'Vielen Dank für Ihre Bestellung! Wir kontaktieren Sie in Kürze zur Bestätigung und Lieferung.\r\n', 'Bestellung erhalten — VVintage\r\n', 'Ihre Bestellung wurde erfolgreich aufgegeben. Wir melden uns bald, um die Details zu bestätigen.'),
(73, 13, 'fr', 'Commande reçue\r\n', 'Merci pour votre commande ! Nous vous contacterons bientôt pour la confirmation et la livraison.\r\n', 'Commande reçue — VVintage\r\n', 'Votre commande a été enregistrée avec succès. Nous vous contacterons prochainement pour les détails.'),
(74, 13, 'es', 'Pedido recibido\r\n', '¡Gracias por su pedido! Nos pondremos en contacto con usted en breve para confirmar la entrega.\r\n', 'Pedido recibido — VVintage\r\n', 'Su pedido se ha realizado correctamente. Nos comunicaremos pronto para confirmar los detalles y el envío.'),
(75, 13, 'ja', 'ご注文を受け付けました\r\n', 'ご注文ありがとうございます。確認と発送のため、近日中にご連絡いたします。\r\n', 'ご注文完了 — VVintage\r\n', 'ご注文が正常に完了しました。詳細確認後、すぐにご連絡いたします。'),
(76, 13, 'zh', '订单已收到\r\n', '感谢您的订单！我们会尽快与您联系以确认和安排发货。\r\n', '订单已收到 — VVintage\r\n', '您的订单已成功提交。我们将尽快联系您确认详情并安排配送。'),
(77, 14, 'ru', 'Профиль пользователя', 'Страница профиля пользователя с личными данными и историей заказов.', 'Профиль пользователя — VVintage', 'Просмотр и редактирование личных данных, история заказов и настройки профиля.'),
(78, 14, 'en', 'User Profile', 'User profile page with personal data and order history.', 'User Profile — VVintage', 'View and edit your personal details, order history, and account settings.'),
(80, 14, 'de', 'Benutzerprofil', 'Profilseite des Benutzers mit persönlichen Daten und Bestellverlauf.', 'Benutzerprofil — VVintage', 'Anzeigen und Bearbeiten persönlicher Daten, Bestellverlauf und Kontoeinstellungen.'),
(81, 14, 'fr', 'Profil utilisateur', 'Page du profil utilisateur avec les informations personnelles et l’historique des commandes.', 'Profil utilisateur — VVintage', 'Consultez et modifiez vos informations personnelles, votre historique de commandes et vos paramètres de compte.'),
(82, 14, 'es', 'Perfil del usuario', 'Página de perfil del usuario con información personal e historial de pedidos.', 'Perfil del usuario — VVintage', 'Consulta y edita tus datos personales, historial de pedidos y configuración de cuenta.'),
(83, 14, 'ja', 'ユーザープロフィール', '個人情報と注文履歴を表示するユーザープロフィールページです。', 'ユーザープロフィール — VVintage', '個人情報の確認と編集、注文履歴やアカウント設定を管理できます。'),
(84, 14, 'zh', '用户资料', '用户资料页面，包含个人信息和订单历史。', '用户资料 — VVintage', '查看和编辑个人信息、订单历史及账户设置。'),
(85, 15, 'ru', 'Редактировать профиль', 'Раздел для изменения личных данных и загрузки аватара.', 'Редактировать профиль — VVintage', 'Измените свои личные данные, загрузите аватар и обновите контактную информацию.'),
(86, 15, 'en', 'Edit Profile', 'Section for updating personal information and uploading an avatar.', 'Edit Profile — VVintage', 'Update your personal information, upload an avatar, and manage your account details.'),
(87, 15, 'de', 'Profil bearbeiten', 'Bereich zum Ändern persönlicher Daten und Hochladen eines Avatars.', 'Profil bearbeiten — VVintage', 'Ändern Sie Ihre persönlichen Daten, laden Sie ein Profilbild hoch und aktualisieren Sie Ihre Kontoinformationen.'),
(88, 15, 'fr', 'Modifier le profil', 'Section pour modifier les informations personnelles et télécharger un avatar.', 'Modifier le profil — VVintage', 'Modifiez vos informations personnelles, téléchargez un avatar et mettez à jour vos coordonnées.'),
(89, 15, 'es', 'Editar perfil', 'Sección para actualizar la información personal y subir un avatar.', 'Editar perfil — VVintage', 'Actualiza tus datos personales, sube un avatar y modifica la información de tu cuenta.'),
(90, 15, 'ja', 'プロフィールを編集', '個人情報の更新やアバターのアップロードができるセクションです。', 'プロフィールを編集 — VVintage', '個人情報を更新し、アバターをアップロードして、連絡先情報を管理します。'),
(91, 15, 'zh', '编辑资料', '修改个人信息和上传头像的页面。', '编辑资料 — VVintage', '更新个人资料、上传头像并管理联系方式。'),
(92, 16, 'ru', 'Логин', 'Войдите в свой аккаунт на Vvintage, чтобы получить доступ ко всем функциям сайта.', 'Вход на сайт Vvintage\r\n', 'Войдите на Vvintage и управляйте своими заказами и профилем.'),
(93, 16, 'en', 'Login', 'Sign in to your Vvintage account to access all site features.', 'Vvintage Login', 'Log in to Vvintage to manage your orders and profile.'),
(94, 16, 'de', 'Anmeldung', 'Melden Sie sich bei Ihrem Vvintage-Konto an, um alle Funktionen zu nutzen.', 'Vvintage Anmeldung\r\n', 'Melden Sie sich bei Vvintage an, um Ihre Bestellungen und Ihr Profil zu verwalten.'),
(95, 16, 'fr', 'Connexion\r\n', 'Connectez-vous à votre compte Vvintage pour accéder à toutes les fonctionnalités.\r\n', 'Connexion Vvintage\r\n', 'Connectez-vous à Vvintage pour gérer vos commandes et votre profil.'),
(96, 16, 'es', 'Iniciar sesión\r\n', 'Inicie sesión en su cuenta de Vvintage para acceder a todas las funciones del sitio.\r\n', 'Inicio de sesión Vvintage\r\n', 'Inicie sesión en Vvintage para administrar sus pedidos y perfil.'),
(97, 16, 'ja', 'ログイン\r\n', 'Vvintage アカウントにサインインして、すべてのサイト機能にアクセスします。\r\n', 'Vvintage ログイン\r\n', 'Vvintage にログインして注文やプロフィールを管理します。'),
(98, 16, 'zh', '登录\r\n', '登录您的Vvintage账户以访问网站的所有功能。\r\n', 'Vvintage 登录\r\n', '登录Vvintage以管理您的订单和个人资料。'),
(100, 17, 'ru', 'Регистрация\r\n\r\n', 'Создайте аккаунт на Vvintage, чтобы получать доступ к эксклюзивным винтажным товарам.\r\n', 'Регистрация на Vvintage\r\n', 'Создайте аккаунт на Vvintage и получайте доступ к редким товарам.'),
(102, 17, 'en', 'Register\r\n', 'Create an account on Vvintage to access exclusive vintage items.\r\n', 'Vvintage Register\r\n', 'Register on Vvintage to get access to rare items.'),
(103, 17, 'de', 'Registrierung\r\n', 'Erstellen Sie ein Konto bei Vvintage, um Zugriff auf exklusive Vintage-Artikel zu erhalten.\r\n', 'Vvintage Registrierung\r\n', 'Erstellen Sie ein Konto bei Vvintage und greifen Sie auf seltene Artikel zu.'),
(104, 17, 'fr', 'Inscription\r\n', 'Créez un compte sur Vvintage pour accéder aux articles vintage exclusifs.\r\n', 'Inscription Vvintage\r\n', 'Créez un compte Vvintage et accédez aux articles rares.'),
(105, 17, 'es', 'Registrarse\r\n', 'Cree una cuenta en Vvintage para acceder a artículos vintage exclusivos.\r\n', 'Registro Vvintage\r\n', 'Regístrese en Vvintage para acceder a artículos raros.'),
(106, 17, 'ja', '登録\r\n', 'Vvintage でアカウントを作成し、限定ヴィンテージ商品にアクセスできます。\r\n', 'Vvintage 登録\r\n', 'Vvintage にアカウントを作成して、希少な商品にアクセスします。'),
(107, 17, 'zh', '注册\r\n', '在Vvintage创建账户以访问独家复古商品。\r\n', 'Vvintage 注册\r\n', '在Vvintage注册以获取稀有商品访问权限。'),
(108, 18, 'ru', 'Восстановить пароль\r\n', 'Введите ваш email, чтобы получить ссылку для восстановления пароля.\r\n', 'Восстановление пароля\r\n', 'Получите ссылку для сброса пароля на Vvintage.'),
(109, 18, 'en', 'Reset Password\r\n', 'Enter your email to receive a password reset link.\r\n', 'Vvintage Password Reset\r\n', 'Receive a link to reset your Vvintage account password.'),
(110, 18, 'de', 'Passwort zurücksetzen\r\n', 'Geben Sie Ihre E-Mail ein, um einen Link zum Zurücksetzen des Passworts zu erhalten.\r\n', 'Vvintage Passwort zurücksetzen\r\n', 'Erhalten Sie einen Link, um Ihr Vvintage-Passwort zurückzusetzen.'),
(111, 18, 'fr', 'Réinitialiser le mot de passe\r\n', 'Entrez votre email pour recevoir un lien de réinitialisation du mot de passe.\r\n', 'Réinitialisation du mot de passe Vvintage\r\n', 'Recevez un lien pour réinitialiser votre mot de passe Vvintage.'),
(112, 18, 'es', 'Restablecer contraseña\r\n', 'Introduzca su correo electrónico para recibir un enlace de restablecimiento de contraseña.\r\n', 'Restablecer contraseña Vvintage\r\n', 'Reciba un enlace para restablecer su contraseña de Vvintage.'),
(113, 18, 'ja', 'パスワードをリセット\r\n', 'メールアドレスを入力してパスワードリセットリンクを受け取ります。\r\n', 'パスワードリセット\r\n', 'Vvintage のパスワードをリセットするリンクを受け取ります。'),
(114, 18, 'zh', '重置密码\r\n', '输入您的邮箱以获取重置密码链接。\r\n', 'Vvintage 重置密码\r\n', '接收链接以重置Vvintage账户密码。'),
(115, 19, 'ru', 'Установить новый пароль\r\n', 'Установите новый пароль для вашего аккаунта на Vvintage.\r\n', 'Новый пароль\r\n', 'Безопасно установите новый пароль для вашего аккаунта.'),
(116, 19, 'en', 'Set New Password\r\n', 'Set a new password for your Vvintage account.\r\n', 'New Password\r\n', 'Securely set a new password for your account.'),
(117, 19, 'de', 'Neues Passwort festlegen\r\n', 'Legen Sie ein neues Passwort für Ihr Vvintage-Konto fest.\r\n', 'Neues Passwort\r\n', 'Legen Sie sicher ein neues Passwort für Ihr Konto fest.'),
(118, 19, 'fr', 'Définir un nouveau mot de passe\r\n', 'Définissez un nouveau mot de passe pour votre compte Vvintage.\r\n', 'Nouveau mot de passe\r\n', 'Définissez en toute sécurité un nouveau mot de passe pour votre compte.'),
(119, 19, 'es', 'Establecer nueva contraseña\r\n', 'Establezca una nueva contraseña para su cuenta de Vvintage.\r\n', 'Nueva contraseña\r\n', 'Configure de manera segura una nueva contraseña para su cuenta.'),
(120, 19, 'zh', '设置新密码\r\n', '为您的Vvintage账户设置新密码。\r\n', '新密码\r\n', '安全地为您的账户设置新密码。'),
(121, 19, 'ja', '新しいパスワードを設定\r\n', 'Vvintage アカウントの新しいパスワードを設定します。\r\n', '新しいパスワード\r\n', 'アカウントの新しいパスワードを安全に設定します。');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `category_id` int(5) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_520_ci,
  `views` tinyint(1) UNSIGNED DEFAULT NULL,
  `cover` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `cover_small` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `datetime` datetime DEFAULT NULL,
  `edit_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `title`, `slug`, `category_id`, `description`, `content`, `views`, `cover`, `cover_small`, `datetime`, `edit_time`) VALUES
(1, 'История бренда Balmain', 'balmain-history', 7, 'Balmain был основан в Париже в 1945 году кутюрье Пьером Бальманом, который уже в 1946 году выпустил первые духи — Elysées 64‑83. ', 'Balmain был основан в Париже в 1945 году кутюрье Пьером Бальманом, который уже в 1946 году выпустил первые духи — Elysées 64‑83. В 1947 появился культовый аромат Vent Vert, за ним Jolie Madame в 1953, Ivoire в 1979 и Ébène в 1983. После смерти основателя бренд возглавляли легендарные дизайнеры, а с 2011 года креативным директором является Оливье Рустьен. Сегодня под его руководством собирается коллекция Les Éternels, где переплетаются наследие и современность.', 0, '366213370501.png', '290-366213370501.png', '2025-08-08 10:32:18', '2025-08-08 07:32:18'),
(2, 'Легенда аромата Chanel №5', 'legenda-chanel-no-5', 8, 'История создания самого знаменитого аромата в мире.', 'Полное содержание статьи про Chanel №5...', 0, 'cover_chanel.jpg', 'cover_chanel_small.jpg', '2025-08-08 10:32:18', '2025-08-08 07:32:18'),
(3, 'Возвращение винтажных ароматов', 'vozvrashchenie-vintazhnykh-aromatov', 7, 'Почему винтаж снова в моде и где его найти?', 'Полное содержание статьи про винтажные духи...', 0, 'cover_chanel.jpg', 'cover_chanel.jpg', '2025-08-08 10:32:18', '2025-08-08 07:32:18'),
(4, 'Парфюмерные дома Франции', 'parfyumernye-doma-frantsii', 7, 'Знаковые бренды, определившие французскую парфюмерию.', 'Полное содержание статьи про французские бренды...', 0, 'cover_chanel.jpg', 'cover_chanel.jpg', '2025-08-08 10:32:18', '2025-08-08 07:32:18');

-- --------------------------------------------------------

--
-- Структура таблицы `postscategories`
--

CREATE TABLE `postscategories` (
  `id` int(11) UNSIGNED NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_title` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `postscategories`
--

INSERT INTO `postscategories` (`id`, `parent_id`, `title`, `slug`, `image`, `seo_title`, `seo_description`) VALUES
(1, NULL, '', 'history-of-parfyumery', '', '', ''),
(2, NULL, 'Французские бренды', 'frantsuzskie-brendy', NULL, NULL, NULL),
(3, NULL, 'Винтажные духи', 'vintazhnye-dukhi', NULL, NULL, NULL),
(4, NULL, 'Люксовые парфюмерные дома', 'lyuksovye-parfyumernye-doma', NULL, NULL, NULL),
(5, NULL, 'Знаменитые парфюмеры', 'znamenitye-parfyumery', NULL, NULL, NULL),
(6, 1, 'Эпоха 20 века', 'parfyumery-of-20-century', '', 'Эпоха 20 века | Категория парфюмерии', 'Узнайте больше о эпоха 20 века в мире винтажных ароматов.'),
(7, 1, 'Ароматы эпохи ар-деко', 'aromaty-epokhi-ar-deko', NULL, NULL, NULL),
(8, 2, 'Chanel и Coco', 'chanel-i-coco', NULL, NULL, NULL),
(9, 2, 'Guerlain: семейная история', 'guerlain-semeynaya-istoriya', NULL, NULL, NULL),
(10, 3, 'Редкие флаконы', 'redkie-flakony', NULL, NULL, NULL),
(11, 3, 'Отзывы коллекционеров', 'otzyvy-kollektsionerov', NULL, NULL, NULL),
(12, 4, 'Dior', 'dior', NULL, NULL, NULL),
(13, 4, 'Yves Saint Laurent', 'yves-saint-laurent', NULL, NULL, NULL),
(14, 5, 'Эрнест Бо', 'ernest-bo', NULL, NULL, NULL),
(15, 5, 'Жан-Поль Герлен', 'zhan-pol-gerlen', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `postscategoriestranslation`
--

CREATE TABLE `postscategoriestranslation` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `postscategoriestranslation`
--

INSERT INTO `postscategoriestranslation` (`id`, `category_id`, `locale`, `title`, `description`, `meta_title`, `meta_description`) VALUES
(1, 1, 'ru', 'История ароматов', 'Читайте статьи и материалы по теме «История ароматов» в нашем парфюмерном архиве.', 'История ароматов | Архив Парфюмерии', 'Читайте статьи и материалы по теме «История ароматов» в нашем парфюмерном архиве.'),
(2, 1, 'de', 'Geschichte der Parfums', 'Entdecken Sie Artikel über geschichte der parfums in unserem Parfümarchiv.', 'Geschichte der Parfums | Perfume Archive', 'Entdecken Sie Artikel über geschichte der parfums in unserem Parfümarchiv.'),
(3, 1, 'en', 'History of Perfumes', 'Explore articles and insights about history of perfumes in our curated perfume collection.', 'History of Perfumes | Perfume Archive', 'Explore articles and insights about history of perfumes in our curated perfume collection.'),
(4, 1, 'fr', 'Histoire des Parfums', 'Découvrez des articles sur histoire des parfums dans notre collection de parfums.', 'Histoire des Parfums | Perfume Archive', 'Découvrez des articles sur histoire des parfums dans notre collection de parfums.'),
(5, 1, 'es', 'Historia de los Perfumes', 'Explora artículos sobre historia de los perfumes en nuestra colección de perfumes.', 'Historia de los Perfumes | Perfume Archive', 'Explora artículos sobre historia de los perfumes en nuestra colección de perfumes.'),
(6, 1, 'ja', 'ブランドの歴史', '日本語でのブランドの歴史の説明。', 'ブランドの歴史', 'ブランドの歴史と進化について学びましょう。'),
(7, 1, 'zh', '香水历史', '探索我们精选香水收藏中关于香水历史的文章和见解。', '香水历史 | Perfume Archive', '探索我们精选香水收藏中关于香水历史的文章和见解。'),
(8, 2, 'ru', 'Французские бренды', NULL, 'Французские бренды | Архив парфюмерии', 'Читайте статьи и материалы о французских брендах.'),
(9, 2, 'en', 'French Brands', NULL, 'French Brands | Perfume Archive', 'Explore articles and materials about French perfume brands.'),
(10, 2, 'de', 'Französische Marken', NULL, 'Französische Marken | Parfümarchiv', 'Lesen Sie Artikel und Materialien über französische Marken.'),
(11, 2, 'fr', 'Marques Françaises', NULL, 'Marques Françaises | Archives de parfum', 'Découvrez des articles et des documents sur les marques françaises.'),
(12, 2, 'es', 'Marcas Francesas', NULL, 'Marcas Francesas | Archivo de perfumes', 'Lea artículos y materiales sobre marcas francesas.'),
(13, 2, 'ja', 'フランスのブランド', NULL, 'フランスのブランド | 香水アーカイブ', 'フランスのブランドに関する記事や資料をご覧ください。'),
(14, 2, 'zh', '法国品牌', NULL, '法国品牌 | 香水档案', '阅读有关法国品牌的文章和资料。'),
(15, 3, 'ru', 'Винтажные духи', NULL, 'Винтажные духи | Архив парфюмерии', 'Читайте статьи и материалы о винтажных духах.'),
(16, 3, 'en', 'Vintage Perfumes', NULL, 'Vintage Perfumes | Perfume Archive', 'Explore articles and materials about vintage perfumes.'),
(17, 3, 'de', 'Vintage-Düfte', NULL, 'Vintage-Düfte | Parfümarchiv', 'Lesen Sie Artikel und Materialien über Vintage-Düfte.'),
(18, 3, 'fr', 'Parfums Vintage', NULL, 'Parfums Vintage | Archives de parfum', 'Découvrez des articles et des documents sur les parfums vintage.'),
(19, 3, 'es', 'Perfumes Vintage', NULL, 'Perfumes Vintage | Archivo de perfumes', 'Lea artículos y materiales sobre perfumes vintage.'),
(20, 3, 'ja', 'ヴィンテージ香水', NULL, 'ヴィンテージ香水 | 香水アーカイブ', 'ヴィンテージ香水に関する記事や資料をご覧ください。'),
(21, 3, 'zh', '复古香水', NULL, '复古香水 | 香水档案', '阅读有关复古香水的文章和资料。'),
(22, 4, 'ru', 'Люксовые парфюмерные дома', NULL, 'Люксовые парфюмерные дома | Архив парфюмерии', 'Читайте статьи и материалы о люксовых парфюмерных домах.'),
(23, 4, 'en', 'Luxury Perfume Houses', NULL, 'Luxury Perfume Houses | Perfume Archive', 'Explore articles and materials about luxury perfume houses.'),
(24, 4, 'de', 'Luxus-Parfümhäuser', NULL, 'Luxus-Parfümhäuser | Parfümarchiv', 'Lesen Sie Artikel und Materialien über Luxus-Parfümhäuser.'),
(25, 4, 'fr', 'Maisons de Parfum de Luxe', NULL, 'Maisons de Parfum de Luxe | Archives de parfum', 'Découvrez des articles et des documents sur les maisons de parfum de luxe.'),
(26, 4, 'es', 'Casas de Perfume de Lujo', NULL, 'Casas de Perfume de Lujo | Archivo de perfumes', 'Lea artículos y materiales sobre casas de perfume de lujo.'),
(27, 4, 'ja', 'ラグジュアリーパフュームハウス', NULL, 'ラグジュアリーパフュームハウス | 香水アーカイブ', 'ラグジュアリーパフュームハウスに関する記事や資料をご覧ください。'),
(28, 4, 'zh', '奢华香水品牌', NULL, '奢华香水品牌 | 香水档案', '阅读有关奢华香水品牌的文章和资料。'),
(29, 5, 'ru', 'Знаменитые парфюмеры', NULL, 'Знаменитые парфюмеры | Архив парфюмерии', 'Читайте статьи и материалы о знаменитых парфюмерах.'),
(30, 5, 'en', 'Famous Perfumers', NULL, 'Famous Perfumers | Perfume Archive', 'Explore articles and materials about famous perfumers.'),
(31, 5, 'de', 'Berühmte Parfümeure', NULL, 'Berühmte Parfümeure | Parfümarchiv', 'Lesen Sie Artikel und Materialien über berühmte Parfümeure.'),
(32, 5, 'fr', 'Parfumeurs Célèbres', NULL, 'Parfumeurs Célèbres | Archives de parfum', 'Découvrez des articles et des documents sur les parfumeurs célèbres.'),
(33, 5, 'es', 'Perfumeros Famosos', NULL, 'Perfumeros Famosos | Archivo de perfumes', 'Lea artículos y materiales sobre perfumeros famosos.'),
(34, 5, 'ja', '有名な調香師', NULL, '有名な調香師 | 香水アーカイブ', '有名な調香師に関する記事や資料をご覧ください。'),
(35, 5, 'zh', '著名调香师', NULL, '著名调香师 | 香水档案', '阅读有关著名调香师的文章和资料。'),
(36, 6, 'ru', 'Эпоха 20 века', 'Эпоха 20 века - подкатегория парфюмерной тематики', 'Эпоха 20 века | Категория парфюмерии', 'Узнайте больше о эпоха 20 века в мире винтажных ароматов.'),
(37, 6, 'en', '20th Century Era', '20th Century Era - подкатегория парфюмерной тематики', '20th Century Era | Категория парфюмерии', 'Узнайте больше о 20th century era в мире винтажных ароматов.'),
(38, 6, 'de', 'Epoche des 20. Jahrhunderts', 'Epoche des 20. Jahrhunderts - подкатегория парфюмерной тематики', 'Epoche des 20. Jahrhunderts | Категория парфюмерии', 'Узнайте больше о epoche des 20. jahrhunderts в мире винтажных ароматов.'),
(39, 6, 'fr', 'Époque du XXe siècle', 'Époque du XXe siècle - подкатегория парфюмерной тематики', 'Époque du XXe siècle | Категория парфюмерии', 'Узнайте больше о époque du xxe siècle в мире винтажных ароматов.'),
(40, 6, 'es', 'Época del siglo XX', 'Época del siglo XX - подкатегория парфюмерной тематики', 'Época del siglo XX | Категория парфюмерии', 'Узнайте больше о época del siglo xx в мире винтажных ароматов.'),
(41, 6, 'ja', '20世紀の時代', '20世紀の時代 - подкатегория парфюмерной тематики', '20世紀の時代 | Категория парфюмерии', 'Узнайте больше о 20世紀の時代 в мире винтажных ароматов.'),
(42, 6, 'zh', '20世纪时代', '20世纪时代 - подкатегория парфюмерной тематики', '20世纪时代 | Категория парфюмерии', 'Узнайте больше о 20世纪时代 в мире винтажных ароматов.'),
(43, 7, 'ru', 'Ароматы эпохи ар-деко', 'Ароматы эпохи ар-деко - подкатегория парфюмерной тематики', 'Ароматы эпохи ар-деко | Категория парфюмерии', 'Узнайте больше о ароматы эпохи ар-деко в мире винтажных ароматов.'),
(44, 7, 'en', 'Art Deco Era Scents', 'Art Deco Era Scents - подкатегория парфюмерной тематики', 'Art Deco Era Scents | Категория парфюмерии', 'Узнайте больше о art deco era scents в мире винтажных ароматов.'),
(45, 7, 'de', 'Düfte der Art-Déco-Ära', 'Düfte der Art-Déco-Ära - подкатегория парфюмерной тематики', 'Düfte der Art-Déco-Ära | Категория парфюмерии', 'Узнайте больше о düfte der art-déco-ära в мире винтажных ароматов.'),
(46, 7, 'fr', 'Parfums de l époque Art déco', 'Parfums de l époque Art déco - подкатегория парфюмерной тематики', 'Parfums de l époque Art déco | Категория парфюмерии', 'Узнайте больше о parfums de l\'époque art déco в мире винтажных ароматов.'),
(47, 7, 'es', 'Aromas de la era Art Deco', 'Aromas de la era Art Deco - подкатегория парфюмерной тематики', 'Aromas de la era Art Deco | Категория парфюмерии', 'Узнайте больше о aromas de la era art deco в мире винтажных ароматов.'),
(48, 7, 'ja', 'アールデコ時代の香り', 'アールデコ時代の香り - подкатегория парфюмерной тематики', 'アールデコ時代の香り | Категория парфюмерии', 'Узнайте больше о アールデコ時代の香り в мире винтажных ароматов.'),
(49, 7, 'zh', '装饰艺术时代的香氛', '装饰艺术时代的香氛 - подкатегория парфюмерной тематики', '装饰艺术时代的香氛 | Категория парфюмерии', 'Узнайте больше о 装饰艺术时代的香氛 в мире винтажных ароматов.'),
(50, 8, 'ru', 'Chanel и Coco', 'Chanel и Coco - подкатегория парфюмерной тематики', 'Chanel и Coco | Категория парфюмерии', 'Узнайте больше о chanel и coco в мире винтажных ароматов.'),
(51, 8, 'en', 'Chanel and Coco', 'Chanel and Coco - подкатегория парфюмерной тематики', 'Chanel and Coco | Категория парфюмерии', 'Узнайте больше о chanel and coco в мире винтажных ароматов.'),
(52, 8, 'fr', 'Chanel et Coco', 'Chanel et Coco - подкатегория парфюмерной тематики', 'Chanel et Coco | Категория парфюмерии', 'Узнайте больше о chanel et coco в мире винтажных ароматов.'),
(53, 8, 'es', 'Chanel y Coco', 'Chanel y Coco - подкатегория парфюмерной тематики', 'Chanel y Coco | Категория парфюмерии', 'Узнайте больше о chanel y coco в мире винтажных ароматов.'),
(54, 8, 'ja', 'シャネルとココ', 'シャネルとココ - подкатегория парфюмерной тематики', 'シャネルとココ | Категория парфюмерии', 'Узнайте больше о シャネルとココ в мире винтажных ароматов.'),
(55, 8, 'zh', '香奈儿与可可', '香奈儿与可可 - подкатегория парфюмерной тематики', '香奈儿与可可 | Категория парфюмерии', 'Узнайте больше о 香奈儿与可可 в мире винтажных ароматов.'),
(56, 9, 'ru', 'Guerlain: семейная история', 'Guerlain: семейная история - подкатегория парфюмерной тематики', 'Guerlain: семейная история | Категория парфюмерии', 'Узнайте больше о guerlain: семейная история в мире винтажных ароматов.'),
(57, 9, 'en', 'Guerlain: A Family Story', 'Guerlain: A Family Story - подкатегория парфюмерной тематики', 'Guerlain: A Family Story | Категория парфюмерии', 'Узнайте больше о guerlain: a family story в мире винтажных ароматов.'),
(58, 9, 'de', 'Guerlain: Eine Familiengeschichte', 'Guerlain: Eine Familiengeschichte - подкатегория парфюмерной тематики', 'Guerlain: Eine Familiengeschichte | Категория парфюмерии', 'Узнайте больше о guerlain: eine familiengeschichte в мире винтажных ароматов.'),
(59, 9, 'fr', 'Guerlain : Une histoire de famille', 'Guerlain : Une histoire de famille - подкатегория парфюмерной тематики', 'Guerlain : Une histoire de famille | Категория парфюмерии', 'Узнайте больше о guerlain : une histoire de famille в мире винтажных ароматов.'),
(60, 9, 'es', 'Guerlain: Una historia familiar', 'Guerlain: Una historia familiar - подкатегория парфюмерной тематики', 'Guerlain: Una historia familiar | Категория парфюмерии', 'Узнайте больше о guerlain: una historia familiar в мире винтажных ароматов.'),
(61, 9, 'ja', 'ゲラン：家族の物語', 'ゲラン：家族の物語 - подкатегория парфюмерной тематики', 'ゲラン：家族の物語 | Категория парфюмерии', 'Узнайте больше о ゲラン：家族の物語 в мире винтажных ароматов.'),
(62, 9, 'zh', '娇兰：家族传承', '娇兰：家族传承 - подкатегория парфюмерной тематики', '娇兰：家族传承 | Категория парфюмерии', 'Узнайте больше о 娇兰：家族传承 в мире винтажных ароматов.'),
(63, 10, 'ru', 'Редкие флаконы', 'Редкие флаконы - подкатегория парфюмерной тематики', 'Редкие флаконы | Категория парфюмерии', 'Узнайте больше о редкие флаконы в мире винтажных ароматов.'),
(64, 10, 'en', 'Rare Bottles', 'Rare Bottles - подкатегория парфюмерной тематики', 'Rare Bottles | Категория парфюмерии', 'Узнайте больше о rare bottles в мире винтажных ароматов.'),
(65, 10, 'de', 'Seltene Flakons', 'Seltene Flakons - подкатегория парфюмерной тематики', 'Seltene Flakons | Категория парфюмерии', 'Узнайте больше о seltene flakons в мире винтажных ароматов.'),
(66, 10, 'fr', 'Flacons rares', 'Flacons rares - подкатегория парфюмерной тематики', 'Flacons rares | Категория парфюмерии', 'Узнайте больше о flacons rares в мире винтажных ароматов.'),
(67, 10, 'es', 'Frascos raros', 'Frascos raros - подкатегория парфюмерной тематики', 'Frascos raros | Категория парфюмерии', 'Узнайте больше о frascos raros в мире винтажных ароматов.'),
(68, 10, 'ja', '希少なボトル', '希少なボトル - подкатегория парфюмерной тематики', '希少なボトル | Категория парфюмерии', 'Узнайте больше о 希少なボトル в мире винтажных ароматов.'),
(69, 10, 'zh', '稀有香水瓶', '稀有香水瓶 - подкатегория парфюмерной тематики', '稀有香水瓶 | Категория парфюмерии', 'Узнайте больше о 稀有香水瓶 в мире винтажных ароматов.'),
(70, 11, 'ru', 'Отзывы коллекционеров', 'Отзывы коллекционеров - подкатегория парфюмерной тематики', 'Отзывы коллекционеров | Категория парфюмерии', 'Узнайте больше о отзывы коллекционеров в мире винтажных ароматов.'),
(71, 11, 'en', 'Collector Reviews', 'Collector Reviews - подкатегория парфюмерной тематики', 'Collector Reviews | Категория парфюмерии', 'Узнайте больше о collector reviews в мире винтажных ароматов.'),
(72, 11, 'de', 'Sammlerbewertungen', 'Sammlerbewertungen - подкатегория парфюмерной тематики', 'Sammlerbewertungen | Категория парфюмерии', 'Узнайте больше о sammlerbewertungen в мире винтажных ароматов.'),
(73, 11, 'fr', 'Avis des collectionneurs', 'Avis des collectionneurs - подкатегория парфюмерной тематики', 'Avis des collectionneurs | Категория парфюмерии', 'Узнайте больше о avis des collectionneurs в мире винтажных ароматов.'),
(74, 11, 'es', 'Opiniones de coleccionistas', 'Opiniones de coleccionistas - подкатегория парфюмерной тематики', 'Opiniones de coleccionistas | Категория парфюмерии', 'Узнайте больше о opiniones de coleccionistas в мире винтажных ароматов.'),
(75, 11, 'ja', 'コレクターのレビュー', 'コレクターのレビュー - подкатегория парфюмерной тематики', 'コレクターのレビュー | Категория парфюмерии', 'Узнайте больше о コレクターのレビュー в мире винтажных ароматов.'),
(76, 11, 'zh', '收藏家点评', '收藏家点评 - подкатегория парфюмерной тематики', '收藏家点评 | Категория парфюмерии', 'Узнайте больше о 收藏家点评 в мире винтажных ароматов.'),
(77, 12, 'ru', 'Dior', 'Dior - подкатегория парфюмерной тематики', 'Dior | Категория парфюмерии', 'Узнайте больше о dior в мире винтажных ароматов.'),
(78, 12, 'en', 'Dior', 'Dior - подкатегория парфюмерной тематики', 'Dior | Категория парфюмерии', 'Узнайте больше о dior в мире винтажных ароматов.'),
(79, 12, 'de', 'Dior', 'Dior - подкатегория парфюмерной тематики', 'Dior | Категория парфюмерии', 'Узнайте больше о dior в мире винтажных ароматов.'),
(80, 12, 'fr', 'Dior', 'Dior - подкатегория парфюмерной тематики', 'Dior | Категория парфюмерии', 'Узнайте больше о dior в мире винтажных ароматов.'),
(81, 12, 'es', 'Dior', 'Dior - подкатегория парфюмерной тематики', 'Dior | Категория парфюмерии', 'Узнайте больше о dior в мире винтажных ароматов.'),
(82, 12, 'ja', 'ディオール', 'ディオール - подкатегория парфюмерной тематики', 'ディオール | Категория парфюмерии', 'Узнайте больше о ディオール в мире винтажных ароматов.'),
(83, 12, 'zh', '迪奥', '迪奥 - подкатегория парфюмерной тематики', '迪奥 | Категория парфюмерии', 'Узнайте больше о 迪奥 в мире винтажных ароматов.'),
(84, 13, 'ru', 'Yves Saint Laurent', 'Yves Saint Laurent - подкатегория парфюмерной тематики', 'Yves Saint Laurent | Категория парфюмерии', 'Узнайте больше о yves saint laurent в мире винтажных ароматов.'),
(85, 13, 'en', 'Yves Saint Laurent', 'Yves Saint Laurent - подкатегория парфюмерной тематики', 'Yves Saint Laurent | Категория парфюмерии', 'Узнайте больше о yves saint laurent в мире винтажных ароматов.'),
(86, 13, 'de', 'Yves Saint Laurent', 'Yves Saint Laurent - подкатегория парфюмерной тематики', 'Yves Saint Laurent | Категория парфюмерии', 'Узнайте больше о yves saint laurent в мире винтажных ароматов.'),
(87, 13, 'fr', 'Yves Saint Laurent', 'Yves Saint Laurent - подкатегория парфюмерной тематики', 'Yves Saint Laurent | Категория парфюмерии', 'Узнайте больше о yves saint laurent в мире винтажных ароматов.'),
(88, 13, 'es', 'Yves Saint Laurent', 'Yves Saint Laurent - подкатегория парфюмерной тематики', 'Yves Saint Laurent | Категория парфюмерии', 'Узнайте больше о yves saint laurent в мире винтажных ароматов.'),
(89, 13, 'ja', 'イヴ・サンローラン', 'イヴ・サンローラン - подкатегория парфюмерной тематики', 'イヴ・サンローラン | Категория парфюмерии', 'Узнайте больше о イヴ・サンローラン в мире винтажных ароматов.'),
(90, 13, 'zh', '伊夫·圣洛朗', '伊夫·圣洛朗 - подкатегория парфюмерной тематики', '伊夫·圣洛朗 | Категория парфюмерии', 'Узнайте больше о 伊夫·圣洛朗 в мире винтажных ароматов.'),
(91, 14, 'ru', 'Эрнест Бо', 'Эрнест Бо - подкатегория парфюмерной тематики', 'Эрнест Бо | Категория парфюмерии', 'Узнайте больше о эрнест бо в мире винтажных ароматов.'),
(92, 14, 'en', 'Ernest Beaux', 'Ernest Beaux - подкатегория парфюмерной тематики', 'Ernest Beaux | Категория парфюмерии', 'Узнайте больше о ernest beaux в мире винтажных ароматов.'),
(93, 14, 'de', 'Ernest Beaux', 'Ernest Beaux - подкатегория парфюмерной тематики', 'Ernest Beaux | Категория парфюмерии', 'Узнайте больше о ernest beaux в мире винтажных ароматов.'),
(94, 14, 'fr', 'Ernest Beaux', 'Ernest Beaux - подкатегория парфюмерной тематики', 'Ernest Beaux | Категория парфюмерии', 'Узнайте больше о ernest beaux в мире винтажных ароматов.'),
(95, 14, 'es', 'Ernest Beaux', 'Ernest Beaux - подкатегория парфюмерной тематики', 'Ernest Beaux | Категория парфюмерии', 'Узнайте больше о ernest beaux в мире винтажных ароматов.'),
(96, 14, 'ja', 'エルネスト・ボー', 'エルネスト・ボー - подкатегория парфюмерной тематики', 'エルネスト・ボー | Категория парфюмерии', 'Узнайте больше о エルネスト・ボー в мире винтажных ароматов.'),
(97, 14, 'zh', '欧内斯特·博', '欧内斯特·博 - подкатегория парфюмерной тематики', '欧内斯特·博 | Категория парфюмерии', 'Узнайте больше о 欧内斯特·博 в мире винтажных ароматов.'),
(98, 15, 'ru', 'Жан-Поль Герлен', 'Жан-Поль Герлен - подкатегория парфюмерной тематики', 'Жан-Поль Герлен | Категория парфюмерии', 'Узнайте больше о жан-поль герлен в мире винтажных ароматов.'),
(99, 15, 'en', 'Jean-Paul Guerlain', 'Jean-Paul Guerlain - подкатегория парфюмерной тематики', 'Jean-Paul Guerlain | Категория парфюмерии', 'Узнайте больше о jean-paul guerlain в мире винтажных ароматов.'),
(100, 15, 'de', 'Jean-Paul Guerlain', 'Jean-Paul Guerlain - подкатегория парфюмерной тематики', 'Jean-Paul Guerlain | Категория парфюмерии', 'Узнайте больше о jean-paul guerlain в мире винтажных ароматов.'),
(101, 15, 'fr', 'Jean-Paul Guerlain', 'Jean-Paul Guerlain - подкатегория парфюмерной тематики', 'Jean-Paul Guerlain | Категория парфюмерии', 'Узнайте больше о jean-paul guerlain в мире винтажных ароматов.'),
(102, 15, 'es', 'Jean-Paul Guerlain', 'Jean-Paul Guerlain - подкатегория парфюмерной тематики', 'Jean-Paul Guerlain | Категория парфюмерии', 'Узнайте больше о jean-paul guerlain в мире винтажных ароматов.'),
(103, 15, 'ja', 'ジャン＝ポール・ゲラン', 'ジャン＝ポール・ゲラン - подкатегория парфюмерной тематики', 'ジャン＝ポール・ゲラン | Категория парфюмерии', 'Узнайте больше о ジャン＝ポール・ゲラン в мире винтажных ароматов.'),
(104, 15, 'zh', '让-保罗·娇兰', '让-保罗·娇兰 - подкатегория парфюмерной тематики', '让-保罗·娇兰 | Категория парфюмерии', 'Узнайте больше о 让-保罗·娇兰 в мире винтажных ароматов.');

-- --------------------------------------------------------

--
-- Структура таблицы `poststranslation`
--

CREATE TABLE `poststranslation` (
  `id` int(11) NOT NULL,
  `post_id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `poststranslation`
--

INSERT INTO `poststranslation` (`id`, `post_id`, `slug`, `locale`, `title`, `description`, `content`, `meta_title`, `meta_description`) VALUES
(1, 1, 'balmain-history', 'ru', 'История бренда Balmain', 'Balmain был основан в Париже в 1945 году кутюрье Пьером Бальманом, который уже в 1946 году выпустил первые духи — Elysées 64‑83. ', 'Balmain был основан в Париже в 1945 году кутюрье Пьером Бальманом, который уже в 1946 году выпустил первые духи — Elysées 64‑83. В 1947 появился культовый аромат Vent Vert, за ним Jolie Madame в 1953, Ivoire в 1979 и Ébène в 1983. После смерти основателя бренд возглавляли легендарные дизайнеры, а с 2011 года креативным директором является Оливье Рустьен. Сегодня под его руководством собирается коллекция Les Éternels, где переплетаются наследие и современность.', 'История Balmain', 'История бренда и ключевые ароматы Balmain'),
(2, 1, 'balmain-history', 'en', 'Balmain brand history', 'Balmain was founded in Paris in 1945 by couturier Pierre Balmain, who launched the first fragrance Elysées 64‑83 in 1946.', 'Balmain was founded in Paris in 1945 by couturier Pierre Balmain, who launched the first fragrance Elysées 64‑83 in 1946. In 1947 came the iconic Vent Vert, followed by Jolie Madame in 1953, Ivoire in 1979 and Ébène in 1983. After the founder’s death, the house was led by legendary designers; since 2011 Olivier Rousteing has been Creative Director. Today under his leadership the Les Éternels collection continues to bridge heritage and modernity.', 'Balmain History', 'The history and iconic perfumes of Balmain'),
(3, 1, 'balmain-history', 'fr', 'Histoire de la marque Balmain', 'Balmain a été fondée à Paris en 1945 par le couturier Pierre Balmain, qui lança son premier parfum, Elysées 64‑83, en 1946.', 'Balmain a été fondée à Paris en 1945 par le couturier Pierre Balmain, qui lança son premier parfum, Elysées 64‑83, en 1946. En 1947 arriva l’iconique Vent Vert, suivi de Jolie Madame en 1953, Ivoire en 1979 et Ébène en 1983. Après la mort du fondateur, la maison fut dirigée par des designers légendaires ; depuis 2011 Olivier Rousteing en est le directeur artistique. Aujourd’hui, sous sa direction, la collection Les Éternels poursuit la fusion entre héritage et modernité.', 'Histoire Balmain', 'L’histoire et les parfums emblématiques de Balmain'),
(4, 1, 'balmain-history', 'es', 'Historia de la marca Balmain', 'La marca Balmain fue fundada en París en 1945 por el modista Pierre Balmain, quien lanzó el primer perfume Elysées 64‑83 en 1946.', 'La marca Balmain fue fundada en París en 1945 por el modista Pierre Balmain, quien lanzó el primer perfume Elysées 64‑83 en 1946. En 1947 llegó el icónico Vent Vert, seguido de Jolie Madame en 1953, Ivoire en 1979 y Ébène en 1983. Tras la muerte del fundador, la casa fue liderada por diseñadores legendarios; desde 2011 Olivier Rousteing es director creativo. Hoy, bajo su liderazgo, la colección Les Éternels continúa fusionando patrimonio y modernidad.', 'Historia Balmain', 'Historia y fragancias icónicas de Balmain'),
(5, 1, 'balmain-history', 'de', 'Markengeschichte von Balmain', 'Balmain wurde 1945 in Paris von Couturier Pierre Balmain gegründet, der 1946 den ersten Duft Elysées 64‑83 lancierte.', 'Balmain wurde 1945 in Paris von Couturier Pierre Balmain gegründet, der 1946 den ersten Duft Elysées 64‑83 lancierte. 1947 kam das ikonische Vent Vert, gefolgt von Jolie Madame 1953, Ivoire 1979 und Ébène 1983. Nach dem Tod des Gründers führten legendäre Designer das Haus; seit 2011 ist Olivier Rousteing Kreativdirektor. Heute sorgt unter seiner Leitung die Kollektion Les Éternels für die Verbindung von Erbe und Moderne.', 'Balmain Geschichte', 'Geschichte und ikonische Düfte von Balmain'),
(6, 1, 'balmain-history', 'ja', 'バルマン ブランドの歴史', 'バルマンは1945年にパリでクチュリエ、ピエール・バルマンによって設立され、1946年には最初の香水Elysées 64‑83を発売しました。', 'バルマンは1945年にパリでクチュリエ、ピエール・バルマンによって設立され、1946年には最初の香水Elysées 64‑83を発売しました。1947年には象徴的なVent Vert、1953年にJolie Madame、1979年にIvoire、1983年にÉbèneが続きました。創業者の死後、伝説的なデザイナーたちがブランドを率い、2011年以降はオリヴィエ・ルステンがクリエイティブディレクターを務めています。現在、彼の指揮の下、Les Éternelsコレクションは伝統と現代性を融合させています。', 'バルマンの歴史', 'バルマンの歴史と代表的な香水'),
(7, 1, 'balmain-history', 'zh', 'Balmain 品牌历史', 'Balmain 由法国时装设计师 Pierre Balmain 于1945年在巴黎创立，并于1946年推出首款香水 Elysées 64‑83。', 'Balmain 由法国时装设计师 Pierre Balmain 于1945年在巴黎创立，并于1946年推出首款香水 Elysées 64‑83。1947 年诞生了标志性香氛 Vent Vert，随后分别于1953年、1979年和1983年推出 Jolie Madame、Ivoire 和 Ébène。创始人去世后，多位传奇设计师接任品牌领导，自2011 年以来，Olivier Rousteing 担任创意总监。如今在他的领导下，Les Éternels 香水系列延续品牌传统与现代的融合。', 'Balmain 历史', 'Balmain 的历史及其标志性香水');

-- --------------------------------------------------------

--
-- Структура таблицы `productimages`
--

CREATE TABLE `productimages` (
  `id` int(11) UNSIGNED NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image_order` int(11) NOT NULL,
  `alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `productimages`
--

INSERT INTO `productimages` (`id`, `product_id`, `filename`, `image_order`, `alt`) VALUES
(1, 1, '816963142595.webp', 1, ''),
(2, 1, '248510657064.webp', 2, ''),
(3, 1, '458345875394.webp', 3, ''),
(4, 1, '735694672718.webp', 0, ''),
(5, 1, '346338759961.webp', 4, ''),
(6, 1, '656074391279.webp', 5, ''),
(7, 1, '207720982307.webp', 6, ''),
(8, 1, '543180240404.webp', 7, ''),
(9, 1, '861430668201.webp', 8, ''),
(10, 1, '404215969541.webp', 9, ''),
(11, 1, '381991770538.webp', 10, ''),
(12, 2, '151894572636.webp', 5, ''),
(13, 2, '727298765357.webp', 7, ''),
(14, 2, '633258882661.webp', 8, ''),
(15, 2, '294826916190.webp', 1, ''),
(16, 2, '997267815121.webp', 0, ''),
(17, 2, '916548653743.webp', 4, ''),
(18, 2, '507682542373.webp', 2, ''),
(19, 2, '844304600161.webp', 6, ''),
(20, 3, '983446345340.webp', 0, ''),
(21, 3, '541273936994.webp', 1, ''),
(22, 3, '562046481457.webp', 2, ''),
(23, 3, '672236936130.webp', 3, ''),
(24, 2, '399021182292.webp', 3, ''),
(25, 4, '160780981994.webp', 0, ''),
(26, 4, '134193963632.webp', 1, ''),
(27, 4, '583803856290.webp', 2, ''),
(28, 4, '886824995572.webp', 3, ''),
(29, 4, '985006944088.webp', 4, ''),
(30, 4, '963750709074.webp', 5, ''),
(31, 4, '730345000493.webp', 6, ''),
(32, 4, '662321797177.webp', 7, ''),
(33, 4, '474884052540.webp', 8, ''),
(34, 4, '858995822307.webp', 9, ''),
(35, 4, '491636375085.webp', 10, ''),
(36, 4, '409304888915.webp', 11, ''),
(37, 5, '480317216119.webp', 0, ''),
(38, 5, '628188203505.webp', 1, ''),
(39, 5, '242650270005.webp', 2, ''),
(40, 5, '603129363641.webp', 3, ''),
(41, 5, '653455739509.webp', 4, ''),
(42, 5, '816241701462.webp', 5, ''),
(43, 5, '855065031941.webp', 6, ''),
(44, 5, '687267914730.webp', 7, ''),
(45, 5, '819090922848.webp', 8, ''),
(46, 5, '971574566282.webp', 9, ''),
(47, 5, '414384318232.webp', 10, ''),
(48, 6, '499383225452.webp', 0, ''),
(49, 6, '547029202857.webp', 1, ''),
(50, 6, '673322555663.webp', 2, ''),
(51, 6, '858273597960.webp', 3, ''),
(52, 6, '719076735165.webp', 4, ''),
(53, 6, '498206583965.webp', 5, ''),
(54, 6, '408191506286.webp', 6, ''),
(55, 6, '244902404036.webp', 7, ''),
(56, 6, '913663313489.webp', 8, ''),
(57, 6, '638985272509.webp', 9, ''),
(58, 6, '336244791271.webp', 10, ''),
(59, 6, '168498182529.webp', 11, ''),
(60, 7, '222690241027.webp', 0, ''),
(61, 7, '523782281928.webp', 1, ''),
(62, 7, '181442818823.webp', 2, ''),
(63, 7, '195019879454.webp', 3, ''),
(64, 7, '706447681028.webp', 4, ''),
(65, 7, '828376863908.webp', 5, ''),
(66, 7, '424897068687.webp', 6, ''),
(67, 7, '427314823997.webp', 7, ''),
(68, 7, '424500438893.webp', 8, ''),
(69, 7, '443822531204.webp', 9, ''),
(70, 7, '644822517384.webp', 10, ''),
(71, 7, '244430988436.webp', 11, ''),
(72, 7, '980891581809.webp', 12, ''),
(73, 8, '393909505067.webp', 0, ''),
(74, 8, '908155335871.webp', 1, ''),
(75, 8, '365663533293.webp', 2, ''),
(76, 8, '134792559312.webp', 3, ''),
(77, 8, '345519146885.webp', 4, ''),
(78, 8, '859476708965.webp', 5, ''),
(79, 8, '613042593707.webp', 6, ''),
(80, 8, '992759656950.webp', 7, ''),
(81, 8, '889052570245.webp', 8, ''),
(82, 8, '672079566555.webp', 9, ''),
(83, 8, '605305048352.webp', 10, ''),
(84, 8, '596162441574.webp', 11, ''),
(85, 8, '478233983819.webp', 12, ''),
(86, 8, '410561777063.webp', 13, ''),
(87, 8, '227392670490.webp', 14, ''),
(88, 8, '174230842177.webp', 15, ''),
(89, 8, '590422911007.webp', 16, ''),
(90, 8, '393461279372.webp', 17, ''),
(91, 9, '521671514488.webp', 0, ''),
(92, 9, '507214127907.webp', 1, ''),
(93, 9, '788529719564.webp', 2, ''),
(94, 9, '342414224803.webp', 3, ''),
(95, 10, '263102691125.webp', 0, ''),
(96, 10, '668742975201.webp', 1, ''),
(97, 10, '417192119013.webp', 2, ''),
(98, 10, '508191018313.webp', 3, ''),
(99, 10, '111903263537.webp', 4, ''),
(100, 11, '311955248091.webp', 0, ''),
(101, 11, '810143003621.webp', 1, ''),
(102, 11, '962370521804.webp', 2, ''),
(103, 11, '532554125880.webp', 3, ''),
(104, 11, '161589543173.webp', 4, ''),
(105, 11, '111238789476.webp', 5, ''),
(106, 12, '532708043769.webp', 0, ''),
(107, 12, '660452410748.webp', 1, ''),
(108, 12, '566793709888.webp', 2, ''),
(109, 12, '364136243568.webp', 3, ''),
(110, 12, '361720299391.webp', 4, ''),
(111, 12, '853800847878.webp', 5, ''),
(112, 12, '332469648160.webp', 6, ''),
(113, 12, '815521374355.webp', 7, ''),
(114, 13, '222292635751.webp', 0, ''),
(115, 13, '924722538671.webp', 1, ''),
(116, 13, '200167994577.webp', 2, ''),
(117, 13, '562364374293.webp', 3, ''),
(118, 13, '988406832353.webp', 4, ''),
(119, 14, '995733560411.webp', 0, ''),
(120, 14, '317197444678.webp', 1, ''),
(121, 14, '929322470341.webp', 2, ''),
(122, 14, '254945876249.webp', 3, ''),
(123, 14, '714613713794.webp', 4, ''),
(124, 14, '492453453394.webp', 5, ''),
(125, 14, '237139566825.webp', 6, ''),
(126, 14, '855399878370.webp', 7, ''),
(127, 15, '419666599933.webp', 0, ''),
(128, 15, '955276492136.webp', 1, ''),
(129, 15, '363448106938.webp', 2, ''),
(130, 15, '107298774257.webp', 3, ''),
(131, 15, '153270059008.webp', 4, ''),
(132, 15, '468507229016.webp', 5, ''),
(133, 16, '751599640645.webp', 0, ''),
(134, 16, '180695749545.webp', 1, ''),
(135, 16, '194600839189.webp', 2, ''),
(136, 16, '410440272154.webp', 3, ''),
(137, 16, '952230205372.webp', 4, ''),
(138, 16, '246236876288.webp', 5, ''),
(139, 16, '868183375465.webp', 6, ''),
(140, 16, '580315725356.webp', 7, ''),
(141, 16, '705844013821.webp', 8, ''),
(142, 16, '535971542780.webp', 9, ''),
(143, 16, '945012414290.webp', 10, ''),
(144, 16, '360119940016.webp', 11, ''),
(145, 16, '620381926679.webp', 12, ''),
(146, 16, '239531790923.webp', 13, ''),
(147, 17, '328250030642.webp', 0, ''),
(148, 17, '535168262977.webp', 1, ''),
(149, 17, '119179021292.webp', 2, ''),
(150, 17, '317409220564.webp', 3, ''),
(151, 17, '535103886876.webp', 4, ''),
(152, 17, '676168238831.webp', 5, ''),
(153, 17, '642438176501.webp', 6, ''),
(154, 17, '532592494809.webp', 7, ''),
(155, 18, '923089655713.webp', 0, ''),
(156, 18, '549491079303.webp', 1, ''),
(157, 18, '754681967787.webp', 2, ''),
(158, 18, '455656737683.webp', 3, ''),
(159, 18, '916587373653.webp', 4, ''),
(160, 18, '347831662701.webp', 5, ''),
(161, 18, '555957365609.webp', 6, ''),
(162, 18, '712852553532.webp', 7, ''),
(163, 18, '408312845932.webp', 8, ''),
(164, 18, '513940991048.webp', 9, ''),
(165, 18, '382037903891.webp', 10, ''),
(166, 18, '928098931049.webp', 11, ''),
(167, 18, '477570185729.webp', 12, ''),
(168, 18, '658754001357.webp', 13, ''),
(169, 18, '412897042474.webp', 14, ''),
(170, 18, '931177388923.webp', 15, ''),
(171, 19, '152684636094.webp', 0, ''),
(172, 19, '234787864749.webp', 1, ''),
(173, 19, '382900610583.webp', 2, ''),
(174, 19, '797284982679.webp', 3, ''),
(175, 19, '898833875498.webp', 4, ''),
(176, 19, '197040676319.webp', 5, ''),
(177, 19, '866562324776.webp', 6, ''),
(178, 19, '881783351037.webp', 7, ''),
(179, 19, '764166398931.webp', 8, ''),
(180, 19, '524742955076.webp', 9, ''),
(181, 19, '679707840998.webp', 10, ''),
(182, 19, '496714429848.webp', 11, ''),
(183, 19, '848009258976.webp', 12, ''),
(184, 19, '960901411207.webp', 13, ''),
(185, 20, '792412065159.webp', 0, ''),
(186, 20, '504852577091.webp', 1, ''),
(187, 20, '517521850113.webp', 2, ''),
(188, 20, '733746996693.webp', 3, ''),
(189, 21, '767072668609.webp', 0, ''),
(190, 21, '479614247549.webp', 1, ''),
(191, 21, '838162589739.webp', 2, ''),
(192, 21, '127467654274.webp', 3, ''),
(193, 21, '577107411857.webp', 4, ''),
(194, 22, '246089521351.webp', 0, ''),
(195, 22, '970266434342.webp', 1, ''),
(196, 22, '589820881771.webp', 2, ''),
(197, 22, '435691581726.webp', 3, ''),
(198, 22, '986903178139.webp', 4, ''),
(199, 23, '645657690760.webp', 0, ''),
(200, 23, '956276318939.webp', 1, ''),
(201, 23, '337600450131.webp', 2, ''),
(202, 23, '639093319584.webp', 3, ''),
(203, 23, '909902741971.webp', 4, ''),
(204, 23, '831521556482.webp', 5, ''),
(205, 23, '459034918711.webp', 6, ''),
(206, 23, '591580274376.webp', 7, ''),
(207, 23, '481816316550.webp', 8, ''),
(208, 24, '594287179987.webp', 0, ''),
(209, 24, '678476110172.webp', 1, ''),
(210, 24, '227374348768.webp', 2, ''),
(211, 24, '227465039649.webp', 3, ''),
(212, 24, '257619373427.webp', 4, ''),
(213, 24, '746979351752.webp', 5, ''),
(214, 25, '516541755616.webp', 0, ''),
(215, 25, '739293537190.webp', 1, ''),
(216, 25, '644846948962.webp', 2, ''),
(217, 25, '647885151799.webp', 3, ''),
(218, 25, '786992573101.webp', 4, ''),
(219, 25, '341089151054.webp', 5, ''),
(220, 25, '366799165549.webp', 6, ''),
(221, 25, '598419495065.webp', 7, ''),
(222, 25, '430663458424.webp', 8, ''),
(223, 25, '285591977786.webp', 9, ''),
(224, 25, '950551563896.webp', 10, ''),
(225, 25, '952032748607.webp', 11, ''),
(226, 25, '592633138254.webp', 12, ''),
(227, 25, '638818646979.webp', 13, ''),
(228, 25, '441470020461.webp', 14, ''),
(229, 25, '189111531490.webp', 15, ''),
(230, 25, '411807611631.webp', 16, ''),
(231, 26, '416866704092.webp', 0, ''),
(232, 26, '386210825620.webp', 1, ''),
(233, 26, '956290830342.webp', 2, ''),
(234, 26, '979829287734.webp', 3, ''),
(235, 26, '832889366886.webp', 4, ''),
(236, 26, '750396820563.webp', 5, ''),
(237, 26, '123989110913.webp', 6, ''),
(238, 27, '733226859724.webp', 0, ''),
(239, 27, '925130229408.webp', 1, ''),
(240, 27, '582950691447.webp', 2, ''),
(241, 27, '455274052550.webp', 3, ''),
(242, 27, '263038383873.webp', 4, ''),
(243, 27, '383862250497.webp', 5, ''),
(244, 27, '154711876240.webp', 6, ''),
(245, 27, '466911679216.webp', 7, ''),
(246, 27, '495106394788.webp', 8, ''),
(247, 28, '674097386965.webp', 0, ''),
(248, 28, '333507383076.webp', 1, ''),
(313, 41, '730937009468.webp', 0, ''),
(314, 41, '641776480995.webp', 1, ''),
(325, 43, '998423318681.webp', 2, ''),
(326, 43, '477880832566.webp', 0, ''),
(327, 43, '527338819888.webp', 1, ''),
(346, 42, '571185594694.webp', 0, ''),
(347, 42, '842995675593.webp', 1, ''),
(348, 42, '474946955650.webp', 2, ''),
(349, 42, '695904371728.webp', 3, ''),
(350, 42, '501704335747.webp', 4, ''),
(351, 42, '267846891793.webp', 5, ''),
(352, 40, '106741883361.webp', 1, ''),
(353, 40, '761253321883.webp', 2, ''),
(354, 40, '523145323316.webp', 0, ''),
(355, 40, '380845410989.webp', 3, ''),
(356, 40, '551909978986.webp', 4, ''),
(357, 39, '607259851614.webp', 0, ''),
(358, 39, '832216253104.webp', 1, ''),
(359, 39, '532189680514.webp', 2, ''),
(360, 39, '860721867883.webp', 3, ''),
(361, 38, '536705049695.webp', 1, ''),
(362, 38, '146679644540.webp', 0, ''),
(363, 38, '323983843256.webp', 2, ''),
(364, 38, '485796511878.webp', 3, ''),
(373, 37, '191427452692.webp', 1, ''),
(374, 37, '971710794956.webp', 0, ''),
(375, 37, '972398699849.webp', 2, ''),
(376, 37, '251327394183.webp', 3, ''),
(377, 36, '975735204070.webp', 0, ''),
(378, 36, '302377982576.webp', 1, ''),
(379, 36, '327398828103.webp', 2, ''),
(380, 36, '472818766879.webp', 3, ''),
(381, 36, '860204491397.webp', 4, ''),
(382, 36, '862777546123.webp', 5, ''),
(383, 36, '586686578928.webp', 6, ''),
(384, 36, '584712372144.webp', 7, ''),
(385, 36, '967526164183.webp', 8, ''),
(386, 36, '804798711331.webp', 9, ''),
(387, 35, '168946245302.webp', 0, ''),
(388, 35, '575813728608.webp', 1, ''),
(389, 35, '753334309876.webp', 2, ''),
(390, 35, '767292807622.webp', 3, ''),
(391, 35, '692335972670.webp', 4, ''),
(392, 35, '118017257552.webp', 5, ''),
(393, 35, '247540145724.webp', 6, ''),
(394, 35, '286354150271.webp', 7, ''),
(395, 35, '191049516385.webp', 8, ''),
(396, 35, '583814387395.webp', 9, ''),
(397, 35, '455265958936.webp', 10, ''),
(398, 35, '924827772541.webp', 11, ''),
(399, 35, '546424206222.webp', 12, ''),
(400, 35, '520574519853.webp', 13, ''),
(401, 35, '212107038727.webp', 14, ''),
(402, 35, '617196731871.webp', 15, ''),
(403, 34, '280486199548.webp', 0, ''),
(404, 34, '697238603861.webp', 1, ''),
(405, 34, '819277616577.webp', 2, ''),
(406, 34, '288648659588.webp', 3, ''),
(407, 32, '486711216955.webp', 0, ''),
(408, 32, '204259512780.webp', 1, ''),
(409, 32, '248572467229.webp', 2, ''),
(410, 32, '298173465708.webp', 3, ''),
(421, 33, '154675822950.webp', 0, ''),
(422, 33, '315963997400.webp', 1, ''),
(423, 33, '350853886781.webp', 2, ''),
(424, 33, '144123067396.webp', 3, ''),
(425, 33, '743448314310.webp', 4, ''),
(426, 33, '573207778224.webp', 5, ''),
(427, 33, '425526928543.webp', 6, ''),
(428, 33, '818544285145.webp', 7, ''),
(429, 33, '952549525987.webp', 8, ''),
(430, 33, '500620529065.webp', 9, ''),
(431, 31, '872838264603.webp', 0, ''),
(432, 31, '584346502817.webp', 1, ''),
(433, 31, '604879076343.webp', 2, ''),
(434, 31, '726192565268.webp', 3, ''),
(435, 31, '437277467828.webp', 4, ''),
(436, 31, '268055425054.webp', 5, ''),
(437, 31, '477705895597.webp', 6, ''),
(438, 31, '215460748320.webp', 7, ''),
(439, 30, '597132233321.webp', 0, ''),
(440, 30, '310693201858.webp', 1, ''),
(441, 30, '142041450664.webp', 2, ''),
(442, 30, '280631522261.webp', 3, ''),
(443, 30, '313107839112.webp', 4, ''),
(444, 29, '267546223426.webp', 0, ''),
(445, 29, '308300433809.webp', 1, ''),
(446, 29, '903510271462.webp', 2, '');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int(11) NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` bigint(10) NOT NULL,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','hidden','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `edit_time` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `slug`, `title`, `description`, `price`, `url`, `sku`, `stock`, `datetime`, `status`, `edit_time`) VALUES
(1, 7, 1, 'сamellia-bag-chanel-01', 'Сумка в форме камелии от бренда Chanel', 'Элегантная мини-сумочка камелия из резины со стразами для выходов в свет.\r\nВечерняя сумка-клатч идеально подойдет для любого коллекционера, ее очень трудно найти! Она была представлена на показе Chanel Осень-зима 2018, внутренняя часть отделана черной овечьей кожей. ВЫ НИГДЕ НЕ УВИДИТЕ ЭТУ СУМКУ!!! Этих сумочек выпущено всего 15 экземпляров. Детали просто великолепны, каждый камень обработан вручную, чтобы создать великолепный цветок, которая переливается на свету!! Можно использовать в качестве сумки через плечо или как клатч!', 40000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 15:25:35', 'active', 1758550010),
(2, 7, 1, 'black-chanelbag-with-beads-and-rhinestones-02', 'Сумка черная Chanel c бисером и стразами', 'Оригинальня сумочка Chanel из смолы, создано всего лишь 500 таких сумок, очень хорошее состояние, в комплекте идет сумка для хранения, была в носке всего пару раз. Очень элегантная и рафинированная. Частная коллекция.', 38000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-22 17:18:23', 'active', 1758551570),
(3, 7, 1, 'bag-bauletto-chanel-nero-90s', 'Cумка-саквояж Bauletto Chanel Nero,90-е гг', 'Сумочка-саквояж, косметичка, была в продаже с 1991 по 1994 годы, идеальное состояние, очень редкий экземпляр.', 33000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-22 17:31:23', 'active', 1758551489),
(4, 10, 5, 'bracelet-christian-dior', 'Браслет Christian Dior', 'Браслет Christian Dior Germany с подписью на внутренней стороне застежки.\r\nДлина 19,5 см ширина 3 см\r\nВнушительный с самым красивым эффектом\r\nОчень хорошее состояние, позолота не повреждена', 230, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 17:55:54', 'active', 1758552962),
(5, 10, 4, 'set-сiner-brand-3-piece ', 'Сет из 3-ех предметов ', 'Украшение Ciner - лот из 3х  предметов.\r\n\r\nВысококачественные винтажные ювелирные изделия хорошего качества.\r\nОжерелье, браслет и серьги-клипсы\r\nРазмеры на фотографиях\r\nКомплект в отличном состоянии (новый на вид)', 310, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 18:08:36', 'active', 1758553728),
(6, 10, 6, 'rare-antique-jewelry-swarovski', 'Редкое старинное украшение от Swarovski', 'Редкое старинное украшение от Swarovski\r\nЗастежка-зажим\r\nЗакрытый браслет 18,5 см\r\nОжерелье 44 см\r\nНетронутая позолота в идеальном состоянии', 360, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 18:28:35', 'active', 1758554924),
(7, 10, 7, 'bracelet-manoush-01', 'Браслет марки Manoush', 'Очень красивый браслет manoush\r\nДевять с\r\nзолотой этикеткой из чистого золота', 150, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 18:45:46', 'active', 1758555953),
(8, 10, 12, 'rare-1976-givenchy-vintage-necklace', 'Редкий кулон-колье 1976 года', 'Редкое винтажное ожерелье с подвеской Givenchy.\r\nМодель Givenchy, Париж, Нью-Йорк, 1976 год.\r\nРазмеры : длина кулона : 12,5 см, диаметр : 5 см, длина цепочки: 68 см.\r\nВ кулоне отсутствуют 3 бусинки, остальные в отличном состоянии', 130, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 19:09:35', 'active', 1758557375),
(9, 10, 12, 'gold-clip-on-earrings-givenchy-01', 'Золотые серьги-клипсы', 'Винтажные серьги-клипсы в очень хорошем состоянии\r\nКоллекция подписанных ароматов Givenchy France', 230, '', 123456, 1, '2025-09-22 19:21:07', 'active', 1758558067),
(10, 10, 12, 'orecchini-clip-earrings-01', 'Серьги-клипсы Orecchini', 'Редкие винтажные клипсы из коллекции Givenchy 1980-х годов.\r\nЗолотого цвета в форме цветка с красным камнем. Идеально подходит для любого случая.', 420, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 22:15:59', 'hidden', 1758568559),
(11, 10, 12, 'givenchy-earrings-with-red-stone', 'Серьги ', 'Красивые серьги Givenchy c красным камнем. Ни разу не использовались.', 320, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 22:49:23', 'hidden', 1758570563),
(12, 10, 12, 'givenchy-clip-earrings-vintage-1980s', 'Серьги-клипсы 1980-х ', 'Винтаж 1980-х годов.\r\nВинтажные серьги-клипсы Givenchy в форме груши золотого цвета с черным камнем и стразами. В очень хорошем состоянии.', 180, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 23:02:11', 'hidden', 1758571331),
(13, 10, 1, 'chanel-collectible-gold-ring-with-precious-stones', 'Коллекционное золотое кольцо с драгоценными камнями', 'Цельное кольцо Chanel Gold 750 с драгоценными камнями.\r\nРазмер: 17 вес: 14,3 грамма\r\nКоллекционное.', 12000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 23:17:58', 'hidden', 1758572278),
(14, 10, 1, 'chanel-necklace-with-gold-and-diamonds-01', 'Драгоценное колье ', 'Колье Chanel, белое золото и бриллианты.', 14000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 23:39:23', 'hidden', 1758573563),
(15, 10, 1, 'сhanel-сoco-сrush-bracelet-gold-and-9-diamonds-01', 'Драгоценный браслет', 'Браслет Chanel Coco Crush золото и 9 бриллиантов.', 16000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-22 23:55:51', 'hidden', 1758574551),
(16, 10, 1, 'chanel-cruise-2005-collectible-necklace', 'Коллекционное колье ', 'Колье коллекционное Chanel Cruise 2005.\r\nИзготовлено во Франции.', 10000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-23 00:12:03', 'active', 1758575523),
(17, 10, 1, 'chanel-chain-and-pendant-in-the-shape-of-a-cross', 'Цепочка и подвеска в форме креста ', 'Цепочка и подвеска Chanel в форме креста из золотистого металла со стразами и жемчужно-белыми бусинами.', 9000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-23 00:32:17', 'active', 1759157796),
(18, 7, 13, 'chyc-ysl-satchel-bag-01', 'Сумка саквояж YSL', 'Модель Chyc YSL, выполненная в трех оттенках кожи, с двойной ручкой из свернутой кожи, застежкой-молнией сверху и макси-логотипом из золотистого металла. Безупречное состояние, идеальные углы, без потертостей и запахов.\r\n\r\nРазмеры: ширина 36 см, высота 26 см, глубина 15 см', 3500, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-29 14:34:48', 'hidden', 1759145688),
(19, 7, 14, 'hermès-mini-kelly-bag-rare-red-edition', 'Сумка Hermès Mini Kelly – редкий красный экземпляр', 'Редкая ярко-красная сумочка Hermès Mini Kelly с позолоченной застежкой, изготовлена во Франции. Внутренняя отделка из красной кожи. Сумка в очень хорошем состоянии, есть небольшие царапины на металле. Размеры: 20×14×8 см. Продается с плечевым ремнем. Оригинал.\r\n', 41000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 123456, 1, '2025-09-29 14:50:14', 'hidden', 1759146614),
(20, 7, 14, 'hermès-kelly-25-bag–matte-crocodile-leather-with-diamonds', 'Сумка Hermès Kelly 25 – матовая крокодиловая кожа с бриллиантами', 'Роскошная сумка Hermès Kelly 25 см, специальный заказ. \r\nМатовая крокодиловая кожа Niloticus, белое золото 18 карат, украшена бриллиантами. \r\nЦвет: Белые Гималаи. Сумка на плечо и с верхней ручкой, внутреннее отделение из серой кожи. \r\n\r\nКомплект: мешок для пыли, коробка, замок, ключи, застежка, плечевой ремень, защитный фетр, брошюра по уходу. \r\nПодлинность подтверждена штампом с датой изготовления (2022). \r\nРазмеры: 25×19×9 см, ручка 10 см, ремешок 42 см. Поворотный замок, навесной замок. \r\nСделано во Франции.', 250000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 15:25:01', 'hidden', 1759148701),
(21, 7, 15, 'valentino-garavani-bag–new-with-gold-rhinestones-01', 'Новая сумка Valentino Garavani', 'Новая сумка Valentino Garavani.\r\nУкрашена золотыми стразами, эффектно смотрится как вечерний аксессуар.\r\n\r\nСостояние: абсолютно новая.', 3800, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 6916074327, 1, '2025-09-29 15:39:05', 'hidden', 1759149545),
(22, 9, 16, 'tabbahsaga-sea-watch–rare-limited-edition-01', 'Часы Tabbah Saga Sea – редкий лимитированный выпуск', 'Часы от бренда Tabbah, модель Saga Sea.\r\nВыпущено всего 10 экземпляров.\r\n\r\nЭмаль на циферблате выполнена мастерами из Швейцарии Оливье и Доминик Воше.\r\nРаковина моллюска из перламутра и белого золота.\r\n\r\nКорпус из золота, инкрустация бриллиантами.\r\nИзначальная цена — 215 000 $.', 120000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 6916074327, 1, '2025-09-29 16:03:39', 'hidden', 1759151019),
(23, 9, 17, 'chopard-happy-sport-watch–limited-edition-with-diamonds', 'Часы Chopard Happy Sport – лимитированная серия с бриллиантами', 'Элегантные часы Chopard \"Happy Sport\" с бриллиантами.\r\nЦиферблат «зебра» диаметром 36 мм, кожаный ремешок.\r\n\r\nАртикул № 278475-2003, серийный номер 1502424.\r\nВ комплекте фирменный футляр и сертификат.\r\n\r\nОчень хорошее состояние, как новые.\r\nВыпущено 500 экземпляров.\r\nАктуальная стоимость — 48 420 €.', 39000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 6916074327, 1, '2025-09-29 16:16:20', 'hidden', 1759151780),
(24, 10, 18, 'vintage-guy-laroche-paris-clip-on-earrings', 'Серьги-клипсы винтаж Guy Laroche Paris', 'Винтажные серьги-клипсы от Guy Laroche Paris.\r\nСостояние хорошее.', 105, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 23324324, 1, '2025-09-29 16:26:54', 'hidden', 1759152414),
(25, 13, 19, 'cartier-piccadilly-sunglasses-with-gold-plating-and-gradient-lenses', 'Очки Cartier Piccadilly с позолотой и градиентными линзами', 'Позолоченные очки Cartier Piccadilly с градиентными коричневыми линзами огранки «бриллиант».\r\nВ комплект входит коробка и сертификат подлинности Cartier.', 2500, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 6916074327, 1, '2025-09-29 16:55:49', 'hidden', 1759154149),
(26, 14, 20, 'patek-philippe-aquanaut-5066a-watch-2004', 'Часы Patek Philippe Aquanaut 5066A, 2004 год', 'Часы Patek Philippe Aquanaut 5066A, выпущенные в 2004 году.\r\nИдеальное состояние: носились несколько раз в год, проходили регулярное сервисное обслуживание в мастерской.', 55000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 6916074327, 1, '2025-09-29 17:34:35', 'hidden', 1759156475),
(27, 14, 21, 'longines-gold-watch-with-l619.2-movement', 'Золотые часы Longines с механизмом L619.2', 'Золотые часы Longines с калибром L619.2.\r\nПрактически новые, использовались всего несколько раз.', 42000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 17:43:17', 'hidden', 1759156997),
(28, 14, 19, 'cartier-silver-men-watch-01', 'Часы Cartier серебряные', 'Серебряные часы Cartier без коробки, застежка не входит в комплект.\r\nСостояние – удовлетворительное.', 35000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 17:56:07', 'hidden', 1759157767),
(29, 14, 19, 'men-cartier-watch-good-condition-01', 'Часы Cartier', 'Часы Cartier в хорошем состоянии.', 25000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 19:09:44', 'active', 1761788075),
(30, 14, 19, 'cartier-pasha-chrono-hybrid–18-karat-gold-30009', 'Часы Cartier Pasha Chrono Hybrid золото', 'Часы Cartier Pasha Chrono Hybrid, артикул 30009, из 18-каратного золота.\r\nЭлектромеханический механизм, сапфир-кабошон, кожаный ремешок.\r\nВ комплекте: оригинальная коробка Cartier и документ о законном происхождении.', 27000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 19:32:19', 'active', 1761788038),
(31, 15, 22, 'christopher-ross-gold-bunny-belt-buckle–24k-vintage', 'Золотая пряжка для ремня с кроликом Christopher Ross', 'Массивная пряжка для ремня с кроликом из 24-каратного золота от Christopher Ross.\r\nИдеальный подарок для любителей животных или поклонников скульптурных украшений.\r\nChristopher Ross – скульптор из Нью-Йорка, чьи работы выставлялись в Метрополитен-музее, Йельской художественной галерее, Бостонском музее изящных искусств, Большом Эрмитаже и Национальных музеях Шотландии.\r\n\r\nРазмеры: 8 дюймов × 3 дюйма.\r\nПодходит для ремешка до 1,5 дюйма (ремешок не входит).\r\nКлеймо CHRISTOPHER ROSS, 1987.\r\nБывшая в употреблении/винтажная, минимальные следы износа.\r\nОригинальная коробка отсутствует.', 3000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 19:58:02', 'active', 1761787948),
(32, 16, 23, 'e.marinella-tie-set–9-pieces-premium-quality', 'Набор галстуков E.Marinella', 'Лот из 9 галстуков E.Marinella. Бесподобное качество и изысканность.', 2000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 20:19:57', 'active', 1761787710),
(33, 17, 24, 'louis-vuitton-vachetta-cotteville-40-suitcase-silver-2021-excellent-condition', 'Серебристый зеркальный чемодан Louis Vuitton Vachetta Cotteville 40', 'Чемодан Louis Vuitton, модель Vachetta Cotteville 40 серебристое зеркало с монограммой из винила и воловьей кожи.\r\nСерийный номер: 2017689, год изготовления: 2021.\r\nПол: унисекс.\r\n\r\nВ комплекте: сумка для пыли Louis Vuitton, коробка, багажная бирка, колокольчик, ключи.\r\nПодлинность подтверждена штампом с датой (Сделано во Франции).\r\n\r\nРазмеры: 41 × 31 × 15 см.\r\nВ очень хорошем состоянии, использовался всего пару раз.', 26000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 21:14:14', 'active', 1761787826),
(34, 19, 25, 'fuzeau-metallonotes-xylophone-musical-toy-for-kids-3-years-01', 'Металлофон Fuzeau Metallonotes ', 'Красочный металлофон Fuzeau Metallonotes с привлекательным дизайном, пробуждающим музыкальное любопытство у детей.\r\nПодходит для маленьких рук от 3 лет – раннее знакомство с музыкой.\r\nПрост в использовании благодаря цветным пластинам и молоточкам в комплекте.\r\n\r\nПортативный: с ручкой и футляром можно играть где угодно.\r\nУниверсален: обучение нотам, воспроизведение простых мелодий, исследование звука.\r\nОчень хорошее качество и великолепный звук. Игрушка в хорошем состоянии.', 45, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 21:21:53', 'active', 1761787661),
(35, 10, 11, 'orena-vintage-jewelry-set-necklace-and-earrings', 'Сет колье и серьги Orena винтаж', 'Элегантный сет украшений Orena: колье и серьги.\r\nИзготовлены из металла с эмалью, в хорошем состоянии.\r\nСтильный винтажный комплект, подходящий как для повседневного образа, так и для особых случаев.', 35, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 21:43:07', 'active', 1761787580),
(36, 7, 8, 'the-kooples-emily-small-red-bag-excellent-condition', 'Сумка The Kooples Emily Small красная', 'Элегантная сумка The Kooples модель Emily Small в красном цвете.\r\nВ комплекте оригинальный мешок для пыли.\r\nОтличное состояние.', 170, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 21:49:50', 'active', 1761787488),
(37, 20, 9, 'vent-vert-by-pierre-balmain–vintage-eau-de-toilette-new', 'Туалетная вода Vent Vert Pierre Balmain винтаж', 'Туалетная вода Vent Vert от Pierre Balmain.\r\nНовая, в закрытой упаковке.\r\nРедкий винтажный аромат, выпуск прекращён.', 200, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 23:01:20', 'active', 1761787460),
(38, 20, 3, 'fidji-by-guy-laroche-eau-de-toilette-50ml-legendary-perfume', 'Туалетная вода Fidji Guy Laroche 50 мл', 'Легендарная туалетная вода Fidji от Guy Laroche.\r\nКлассический женственный аромат, полюбившийся во всем мире.', 110, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 23:16:07', 'active', 1761787115),
(39, 20, 18, 'fidji-du-soir-guy-laroche–concentrated-eau-de-toilette-50ml-vintage', 'Туалетная концентрированная вода Fidji du Soir Guy Laroche 50 мл винтаж', 'Редкая туалетная концентрированная вода Fidji du Soir от Guy Laroche.\r\nВыпуск 90-х годов, винтаж.\r\nФлакон в упаковке, наполненность около 95%.', 220, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 23:23:37', 'active', 1761776275),
(40, 20, 2, 'nino-cerruti-pour-femme–eau-de-toilette-100ml-vintage-90s', 'Туалетная вода Nino Cerruti Pour Femme 100 мл винтаж', 'Редкая туалетная вода Nino Cerruti Pour Femme 100 мл.\r\nОригинальная упаковка, новый флакон.\r\nВыпуск середины 90-х годов, винтаж.', 240, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-29 23:40:04', 'active', 1761776114),
(41, 20, 18, 'fidji-de-guy-laroche–vintage-miniature-sample-perfume-01', 'Миниатюра Fidji de Guy Laroche – пробник винтаж', 'Редкая миниатюра парфюма Fidji de Guy Laroche.\r\nОригинальный пробник в винтажном исполнении.\r\nКоллекционный экземпляр для ценителей классики.', 30, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-30 00:00:38', 'active', 1759179638),
(42, 20, 27, 'shalimar-guerlain-vintage-baccarat-perfume-30ml-limited-edition', 'Парфюм Shalimar Guerlain – винтаж Baccarat 30 мл', 'Великолепный винтажный парфюм Shalimar от Guerlain.\r\nФлакон из хрусталя Baccarat Paris, лимитированный выпуск 80-х годов, № 929/4450.\r\nОбъем 30 мл, оригинальный бархатный футляр, сертификат подлинности.\r\nСостояние новое, без царапин и сколов.', 2000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-30 00:12:29', 'active', 1761773217),
(43, 21, 27, 'les-larmes-sacrées-de-thèbes-baccarat-7.5ml-extrait-new', 'Парфюм Les Larmes Sacrées de Thèbes Baccarat – экстракт 7,5 мл', 'Священные слезы Фив от Baccarat, выпуск 1998 года.\r\nОдин из самых дорогих духов в мире, экстракт 7,5 мл.\r\nВысота флакона 13 см, запечатанный, пронумерованный.\r\nСертификат подлинности, коробка и упаковка в идеальном состоянии.\r\nСостояние новое.', 4000, 'https://www.vinted.fr/items/6916074327-vintage-dior-sunglasses?referrer=catalog', 1234, 1, '2025-09-30 00:38:46', 'active', 1761858644);

-- --------------------------------------------------------

--
-- Структура таблицы `productstranslation`
--

CREATE TABLE `productstranslation` (
  `id` int(11) NOT NULL,
  `product_id` int(11) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `productstranslation`
--

INSERT INTO `productstranslation` (`id`, `product_id`, `slug`, `locale`, `title`, `description`, `meta_title`, `meta_description`) VALUES
(1, 1, '', 'ru', 'Сумка в форме камелии от бренда Chanel', 'Элегантная мини-сумочка камелия из резины со стразами для выходов в свет.\r\nВечерняя сумка-клатч идеально подойдет для любого коллекционера, ее очень трудно найти! Она была представлена на показе Chanel Осень-зима 2018, внутренняя часть отделана черной овечьей кожей. ВЫ НИГДЕ НЕ УВИДИТЕ ЭТУ СУМКУ!!! Этих сумочек выпущено всего 15 экземпляров. Детали просто великолепны, каждый камень обработан вручную, чтобы создать великолепный цветок, которая переливается на свету!! Можно использовать в качестве сумки через плечо или как клатч!', 'Сумка в форме камелии от бренда Chanel', 'Сумка в форме камелии от бренда Chanel'),
(2, 1, '', 'en', 'Camellia-shaped bag from Chanel brand', 'Elegant camellia mini handbag made of rubber with rhinestones for going out.\r\nAn evening clutch bag is perfect for any collector, it\'s very hard to find! It was presented at the Chanel Fall-Winter 2018 show, the inside is trimmed with black sheep leather. YOU WON\'T SEE THIS BAG ANYWHERE!!! There are only 15 copies of these handbags. The details are simply magnificent, each stone is hand-crafted to create a gorgeous flower that shimmers in the light!! Can be used as a shoulder bag or as a clutch!', 'Camellia-shaped bag from Chanel brand', 'Camellia-shaped bag from Chanel brand'),
(3, 1, '', 'de', 'Kamelienförmige Tasche der Marke Chanel', 'Eine elegante Mini-Camellia-Handtasche aus Gummi mit Strasssteinen zum Leuchten.\r\nDie Abendtasche ist perfekt für jeden Sammler geeignet, sie ist sehr schwer zu finden! Es wurde auf der Chanel Herbst-Winter-Show 2018 vorgestellt, das Innere ist mit schwarzem Schafleder getrimmt. SIE WERDEN DIESE TASCHE NIRGENDWO SEHEN!!! Es gibt nur 15 Exemplare dieser Taschen. Die Details sind einfach wunderschön, jeder Stein ist von Hand gefertigt, um eine wunderschöne Blume zu schaffen, die im Licht schimmert!! Kann als Umhängetasche oder als Handtasche verwendet werden!', 'Kamelienförmige Tasche der Marke Chanel', 'Kamelienförmige Tasche der Marke Chanel'),
(4, 1, '', 'es', 'Bolso en forma de Camelia de Chanel', 'Elegante Mini bolso Camelia de goma con diamantes de imitación para salir a la luz.\r\nEl bolso de noche es perfecto para cualquier Coleccionista, ¡es muy difícil de encontrar! Ella fue presentada en el desfile de Chanel Otoño-invierno 2018, el interior está acabado con cuero de oveja negro. ¡NO VERÁS ESTA BOLSA EN NINGUNA PARTE!!! Estos bolsos solo se produjeron copias de 15. Los detalles son simplemente magníficos, cada piedra se trabaja a mano para crear una hermosa flor que brilla en la luz!! ¡Se puede utilizar como bolso de hombro o como bolso de embrague!', 'Bolso en forma de Camelia de Chanel', 'Bolso en forma de Camelia de Chanel'),
(5, 1, '', 'fr', 'Sac en forme de camélia de la marque Chanel', 'Élégant mini sac à main camélia en caoutchouc avec strass pour les sorties dans la lumière.\r\nLe sac d\'embrayage de soirée est parfait pour tout collectionneur, il est très difficile à trouver! Elle a été présentée au défilé Chanel Automne-hiver 2018, l\'intérieur est Garni de cuir de mouton noir. VOUS NE VERREZ PAS CE SAC NULLE PART!!! Ces sacs ont été produits à seulement 15 exemplaires. Les détails sont tout simplement magnifiques, chaque pierre est travaillée à la main pour créer une magnifique fleur qui brille à la lumière!! Peut être utilisé comme un sac à bandoulière ou comme une pochette!', 'Sac en forme de camélia de la marque Chanel', 'Sac en forme de camélia de la marque Chanel'),
(6, 1, '', 'ja', 'シャネルブランドの椿の形をしたバッグ', '外出用のラインストーンが付いたゴム製のエレガントなカメリアミニハンドバッグ。\r\n夜のクラッチバッグはどんなコレクターにもぴったりです、それを見つけるのは非常に難しいです！ シャネルの2018年秋冬ショーで発表され、内側は黒い羊の革でトリミングされています。 あなたはどこにもこのバッグを見ることはありません！!! これらのハンドバッグのコピーは15個しかありません。 細部は単に壮大です、それぞれの石は光の中できらめくゴージャスな花を作成するために手作りされています！! ショルダーバッグとしてもクラッチとしても使えます！', 'シャネルブランドの椿の形をしたバッグ', 'シャネルブランドの椿の形をしたバッグ'),
(7, 1, '', 'zh', '香奈儿品牌的茶花形包', '优雅的茶花迷你手提包由橡胶制成，配有水钻，用于外出。\r\n一个晚上的离合器袋是完美的任何收藏家,这是很难找到! 它在香奈儿2018秋冬秀场上亮相，内侧饰有黑羊皮革。 你在任何地方都看不到这个包！!! 这些手袋只有15份。 细节简直是华丽的，每块石头都是手工制作的，创造出一朵华丽的花，在光线下闪闪发光！! 既可以当单肩包，也可以当手拿包！', '香奈儿品牌的茶花形包', '香奈儿品牌的茶花形包'),
(8, 2, '', 'ru', 'Сумка черная Chanel c бисером и стразами', 'Оригинальня сумочка Chanel из смолы, создано всего лишь 500 таких сумок, очень хорошее состояние, в комплекте идет сумка для хранения, была в носке всего пару раз. Очень элегантная и рафинированная. Частная коллекция.', 'Сумка черная Chanel c бисером и стразами', 'Сумка черная Chanel c бисером и стразами'),
(9, 2, '', 'en', 'Black Chanel bag with beads and rhinestones', 'The original Chanel resin handbag, only 500 such bags were created, very good condition, comes with a storage bag, was worn only a couple of times. Very elegant and refined. Private collection.', 'Black Chanel bag with beads and rhinestones', 'Black Chanel bag with beads and rhinestones'),
(10, 2, '', 'de', 'Schwarze Chanel Tasche mit Perlen und Strass', 'Die ursprüngliche Chanel-Handtasche aus Harz, erstellt von nur 500 solchen Taschen, sehr guter Zustand, enthält eine Aufbewahrungstasche, wurde nur ein paar Mal getragen. Sehr elegant und raffiniert. Private Sammlung.', 'Schwarze Chanel Tasche mit Perlen und Strass', 'Schwarze Chanel Tasche mit Perlen und Strass'),
(11, 2, '', 'es', 'Bolso Chanel negro con cuentas y pedrería', 'Bolso Chanel original hecho de resina, creado por solo 500 de estas bolsas, muy buen estado, viene con una bolsa de almacenamiento, se ha usado solo un par de veces. Muy elegante y refinado. Colección privada.', 'Bolso Chanel negro con cuentas y pedrería', 'Bolso Chanel negro con cuentas y pedrería'),
(12, 2, '', 'fr', 'Sac à bandoulière avec perles et strass-noir Chanel', 'Original Chanel sac à main en résine, créé seulement 500 de ces sacs, très bon état, est livré avec un sac de rangement, a été porté seulement quelques fois. Très élégant et raffiné. Collection privée.', 'Sac à bandoulière avec perles et strass-noir Chanel', 'Sac à bandoulière avec perles et strass-noir Chanel'),
(13, 2, '', 'ja', 'ビーズとラインストーンが付いた黒いシャネルバッグ', 'オリジナルのシャネル樹脂ハンドバッグは、わずか500そのようなバッグが作成された、非常に良好な状態は、収納袋が付属して、数回だけ着用しました。 とてもエレガントで洗練されています。 プライベートコレクション。', 'ビーズとラインストーンが付いた黒いシャネルバッグ', 'ビーズとラインストーンが付いた黒いシャネルバッグ'),
(14, 2, '', 'zh', '黑色香奈儿包与珠子和水钻', '原来的香奈儿树脂手袋，只创造了500个这样的袋子，非常好的条件，带有一个储物袋，只穿了几次。 非常优雅和精致。 私人收藏。', '黑色香奈儿包与珠子和水钻', '黑色香奈儿包与珠子和水钻'),
(15, 3, '', 'ru', 'Cумка-саквояж Bauletto Chanel Nero,90-е гг', 'Сумочка-саквояж, косметичка, была в продаже с 1991 по 1994 годы, идеальное состояние, очень редкий экземпляр.', 'Cумка-саквояж Bauletto Chanel Nero,90-е гг', 'Cумка-саквояж Bauletto Chanel Nero,90-е гг'),
(16, 3, '', 'en', 'Bag Bauletto Chanel Nero,90s', 'A handbag, a cosmetic bag, was on sale from 1991 to 1994, in perfect condition, a very rare specimen.', 'Bag Bauletto Chanel Nero,90s', 'Bag Bauletto Chanel Nero,90s'),
(17, 3, '', 'de', 'Bauletto Chanel Nero Umhängetasche,90er Jahre', 'Eine Handtasche, eine Kosmetiktasche, war von 1991 bis 1994 im Handel erhältlich, perfekter Zustand, ein sehr seltenes Exemplar.', 'Bauletto Chanel Nero Umhängetasche,90er Jahre', 'Bauletto Chanel Nero Umhängetasche,90er Jahre'),
(18, 3, '', 'es', 'Bolso Bauletto Chanel Nero,años 90', 'El bolso de mano, una bolsa de cosméticos, estaba a la venta desde 1991 hasta 1994, en perfecto estado, un ejemplar muy raro.', 'Bolso Bauletto Chanel Nero,años 90', 'Bolso Bauletto Chanel Nero,años 90'),
(19, 3, '', 'fr', 'Sac de voyage Bauletto Chanel Nero, années 90', 'Le sac à main, sac cosmétique, était en vente de 1991 à 1994, état parfait, exemplaire très rare.', 'Sac de voyage Bauletto Chanel Nero, années 90', 'Sac de voyage Bauletto Chanel Nero, années 90'),
(20, 3, '', 'ja', 'バッグバウレットシャネルネロ90年代', 'ハンドバッグ、化粧品バッグは、1991年から1994年まで、完璧な状態で、非常にまれな標本で販売されていました。', 'バッグバウレットシャネルネロ90年代', ''),
(21, 3, '', 'zh', '包包包Bauletto香奈儿尼禄,90年代', '一个手提包，一个化妆包，从1991年到1994年出售，在完美的条件下，一个非常罕见的标本。', '包包包Bauletto香奈儿尼禄,90年代', '包包包Bauletto香奈儿尼禄,90年代'),
(22, 4, '', 'ru', 'Браслет Christian Dior', 'Браслет Christian Dior Germany с подписью на внутренней стороне застежки.\r\nДлина 19,5 см ширина 3 см\r\nВнушительный с самым красивым эффектом\r\nОчень хорошее состояние, позолота не повреждена', 'Браслет Christian Dior', 'Браслет Christian Dior'),
(23, 4, '', 'en', 'A bracelet Christian Dior', 'Christian Dior Germany bracelet with a signature on the inside of the clasp.\r\nLength 19.5cm width 3 cm\r\nImpressive with the most beautiful effect\r\nVery good condition, the gilding is not damaged', 'A bracelet Christian Dior', 'A bracelet Christian Dior'),
(24, 4, '', 'de', 'Armband Christian Dior', 'Christian Dior Germany Armband mit Unterschrift auf der Innenseite des Verschlusses.\r\nLänge 19,5 cm Breite 3 cm\r\nImposant mit dem schönsten Effekt\r\nSehr guter Zustand, Vergoldung ist intakt', 'Armband Christian Dior', 'Armband Christian Dior'),
(25, 4, '', 'es', 'Pulsera Christian Dior', 'Pulsera Christian Dior Germany con firma en el interior del cierre.\r\nLongitud 19,5 cm ancho 3 cm\r\nImpresionante con el efecto más hermoso\r\nMuy buen estado, chapado en oro intacto', 'Pulsera Christian Dior', 'Pulsera Christian Dior'),
(26, 4, '', 'fr', 'Bracelet Christian Dior', 'Bracelet Christian Dior Germany signé à l\'intérieur du fermoir.\r\nLongueur 19.5 cm largeur 3 cm\r\nImpressionnant avec le plus bel effet\r\nTrès bon état, la dorure n\'est pas endommagée', 'Bracelet Christian Dior', 'Bracelet Christian Dior'),
(27, 4, '', 'ja', 'ブレスレット クリスチャン-ディオール', 'クラスプの内側に署名が付いたクリスチャンディオールドイツのブレスレット。\r\n長さ19.5cm幅3cm\r\n最も美しい効果と印象的\r\n非常に良好な状態、金メッキは損傷していません', 'ブレスレット クリスチャン-ディオール', 'ブレスレット クリスチャン-ディオール'),
(28, 4, '', 'zh', '手镯 克里斯汀*迪奥', '克里斯汀迪奥德国手镯与签名内的扣.\r\n长19.5厘米宽3厘米\r\n令人印象深刻的最美丽的效果\r\n非常好的条件，镀金没有损坏', '手镯 克里斯汀*迪奥', '手镯 克里斯汀*迪奥'),
(29, 5, '', 'ru', 'Сет из 3-ех предметов ', 'Украшение Ciner - лот из 3х  предметов.\r\n\r\nВысококачественные винтажные ювелирные изделия хорошего качества.\r\nОжерелье, браслет и серьги-клипсы\r\nРазмеры на фотографиях\r\nКомплект в отличном состоянии (новый на вид)', 'Сет из 3-ех предметов бренд Ciner', 'Сет из 3-ех предметов бренд Ciner'),
(30, 5, '', 'en', 'A set of 3 items', 'Ciner jewelry - a lot of 3 items.\r\n\r\nHigh quality vintage jewelry of good quality.\r\nNecklace, bracelet and clip earrings\r\nDimensions shown in photos\r\nThe kit is in excellent condition (new in appearance)', '3-piece set Ciner brand', '3-piece set Ciner brand'),
(31, 5, '', 'de', '3-teiliges Set', 'Ciner Dekoration ist ein Los aus 3 Teilen.\r\n\r\nHochwertiger Vintage-Schmuck von guter Qualität.\r\nHalskette, Armband und Clipohrringe\r\nAbmessungen in Fotos\r\nDas Kit ist in sehr gutem Zustand (neu im Aussehen)', '3-teiliges Set Marke Ciner', '3-teiliges Set Marke Ciner'),
(32, 5, '', 'es', 'Conjunto de 3 piezas', 'Decoración Ciner-lote de 3 piezas.\r\n\r\nJoyería Vintage de alta calidad de buena calidad.\r\nCollar, pulsera y pendientes de clip\r\nDimensiones en las fotos\r\nKit en perfecto estado (nuevo en apariencia)', 'Conjunto de 3 piezas marca Ciner', 'Conjunto de 3 piezas marca Ciner'),
(33, 5, '', 'fr', 'Ensemble de 3 pièces', 'Décoration Ciner-lot de 3 pièces.\r\n\r\nBijoux Vintage de haute qualité de bonne qualité.\r\nCollier, bracelet et boucles d\'oreilles\r\nTaille sur les photos\r\nKit en excellent état (neuf en apparence)', 'Ensemble de 3 pièces Ciner', 'Ensemble de 3 pièces Ciner'),
(34, 5, '', 'ja', '3点セット', 'Cinerの宝石類-3つの項目の多く。\r\n\r\n良質の高品質のヴィンテージジュエリー。\r\nネックレス、ブレスレットおよびクリップイヤリング\r\n写真に示されている次元\r\nキットは優れた状態にあります（外観が新しい）', '3点セットシナーブランド', '3点セットシナーブランド'),
(35, 5, '', 'zh', '一套三个项目', 'Ciner珠宝-很多3个项目。\r\n\r\n高品质的复古首饰质量好。\r\n项链、手镯及夹式耳环\r\n照片中显示的尺寸\r\n该套件状况良好（外观新颖）', '三件套Ciner品牌', '三件套Ciner品牌'),
(36, 6, '', 'ru', 'Редкое старинное украшение от Swarovski', 'Редкое старинное украшение от Swarovski\r\nЗастежка-зажим\r\nЗакрытый браслет 18,5 см\r\nОжерелье 44 см\r\nНетронутая позолота в идеальном состоянии', 'Редкое старинное украшение от Swarovski', 'Редкое старинное украшение от Swarovski'),
(37, 6, '', 'en', 'A rare antique jewelry from Swarovski', 'A rare antique jewelry from Swarovski\r\nClip closure\r\nClosed bracelet 18.5 cm\r\nNecklace 44 cm\r\nPristine gilding in perfect condition', 'A rare antique jewelry from Swarovski', 'A rare antique jewelry from Swarovski'),
(38, 6, '', 'de', 'Seltene Vintage-Dekoration von Swarovski', 'Seltene Vintage-Dekoration von Swarovski\r\nClip-Verschluss\r\nGeschlossenes Armband 18,5 cm\r\nHalskette 44cm\r\nUnberührte Vergoldung in einwandfreiem Zustand', 'Seltene Vintage-Dekoration von Swarovski', 'Seltene Vintage-Dekoration von Swarovski'),
(39, 6, '', 'es', 'Raro adorno Vintage de Swarovski', 'Raro adorno Vintage de Swarovski\r\nCierre de clip\r\nPulsera cerrada 18,5 cm\r\nCollar de 44 cm\r\nDorado prístino en perfecto estado', 'Raro adorno Vintage de Swarovski', 'Raro adorno Vintage de Swarovski'),
(40, 6, '', 'fr', 'Décoration Vintage rare de Swarovski', 'Décoration Vintage rare de Swarovski\r\nClip de fixation\r\nBracelet fermé 18,5 cm\r\nCollier 44 cm\r\nDorure vierge en parfait état', 'Décoration Vintage rare de Swarovski', 'Décoration Vintage rare de Swarovski'),
(41, 6, '', 'ja', 'スワロフスキーの希少なアンティークジュエリー', 'スワロフスキーの希少なアンティークジュエリー\r\nクリップ閉鎖\r\n閉じたブレスレット18.5cm\r\nネックレス44センチ\r\n完璧な状態で手付かずの金メッキ', 'スワロフスキーの希少なアンティークジュエリー', 'スワロフスキーの希少なアンティークジュエリー'),
(42, 6, '', 'zh', '施华洛世奇罕见的古董珠宝', '施华洛世奇罕见的古董珠宝\r\n剪辑关闭\r\n闭合手镯18.5厘米\r\n项链44厘米\r\n完美状态的原始镀金', '施华洛世奇罕见的古董珠宝', '施华洛世奇罕见的古董珠宝'),
(43, 7, '', 'ru', 'Браслет марки Manoush', 'Очень красивый браслет manoush\r\nДевять с\r\nзолотой этикеткой из чистого золота', 'Браслет марки Manoush', 'Браслет марки Manoush'),
(44, 7, '', 'en', 'Manoush brand bracelet', 'A very beautiful manoush bracelet\r\nNine with\r\na gold label made of pure gold', 'Manoush brand bracelet', 'Manoush brand bracelet'),
(45, 7, '', 'de', 'Armband der Marke Manoush', 'Sehr schönes Manoush-Armband\r\nNeun mit\r\ngoldenes Etikett aus reinem Gold', 'Armband der Marke Manoush', 'Armband der Marke Manoush'),
(46, 7, '', 'es', 'Pulsera de la marca Manoush', 'Muy hermosa pulsera manoush\r\nNueve con\r\netiqueta de oro de oro puro', 'Pulsera de la marca Manoush', 'Pulsera de la marca Manoush'),
(47, 7, '', 'fr', 'Bracelet de marque Manoush', 'Très beau bracelet manoush\r\nNeuf s\r\nétiquette en or pur', 'Bracelet de marque Manoush', 'Bracelet de marque Manoush'),
(48, 7, '', 'ja', 'Manoushブランドブレスレット', '非常に美しいmanoushブレスレット\r\nナインと\r\n純金で作られたゴールドラベル', 'Manoushブランドブレスレット', 'Manoushブランドブレスレットv'),
(49, 7, '', 'zh', 'Manoush品牌手链', '一个非常漂亮的manoush手镯\r\n九与\r\n纯金制成的黄金标签', 'Manoush品牌手链', 'Manoush品牌手链'),
(50, 8, '', 'ru', 'Редкий кулон-колье 1976 года', 'Редкое винтажное ожерелье с подвеской Givenchy.\r\nМодель Givenchy, Париж, Нью-Йорк, 1976 год.\r\nРазмеры : длина кулона : 12,5 см, диаметр : 5 см, длина цепочки: 68 см.\r\nВ кулоне отсутствуют 3 бусинки, остальные в отличном состоянии', 'Редкий кулон-колье 1976 года Givenchy винтаж ', 'Редкий кулон-колье 1976 года Givenchy винтаж '),
(51, 8, '', 'en', 'A rare 1976 necklace pendant', 'A rare vintage Givenchy pendant necklace.\r\nGivenchy model, Paris, New York, 1976.\r\nSize : pendant length : 12.5cm, diameter : 5 cm, chain length : 68 cm.\r\nThe pendant is missing 3 beads, the rest are in excellent condition.', 'Rare 1976 Givenchy Vintage Necklace', 'Rare 1976 Givenchy Vintage Necklace'),
(52, 8, '', 'de', 'Seltener Halskette-Anhänger aus dem Jahr 1976', 'Seltene Vintage-Halskette mit Anhänger Givenchy.\r\nModell Givenchy, Paris, New York, 1976.\r\nMaße : Anhänger länge : 12,5 cm, durchmesser : 5 cm, kettenlänge: 68 cm.\r\nDer Anhänger hat keine 3 Perlen, der Rest ist in ausgezeichnetem Zustand', 'Seltene 1976 Givenchy Vintage Halskette Anhänger', 'Seltene 1976 Givenchy Vintage Halskette Anhänger'),
(53, 8, '', 'es', 'Collar colgante raro de 1976', 'Collar Vintage raro con colgante Givenchy.\r\nModelo Givenchy, París, nueva York, 1976.\r\nDimensiones: longitud del colgante: 12,5 cm, diámetro : 5 cm, longitud de cadena: 68 cm.\r\nEn el colgante faltan 3 cuentas, el resto en perfecto estado', 'Collar colgante raro Givenchy Vintage de 1976', 'Collar colgante raro Givenchy Vintage de 1976'),
(54, 8, '', 'fr', 'Collier pendentif rare 1976', 'Rare collier Vintage avec pendentif Givenchy.\r\nGivenchy, Paris, New York, 1976.\r\nDimensions: longueur du pendentif: 12,5 cm, diamètre : 5 cm, longueur de la chaîne: 68 cm.\r\nIl manque 3 perles dans le pendentif, le reste est en excellent état', 'Rare collier pendentif 1976 Givenchy Vintage', 'Rare collier pendentif 1976 Givenchy Vintage'),
(55, 8, '', 'ja', 'レア1976年ネックレスペンダント', '珍しいヴィンテージのジバンシィペンダントネックレス。\r\nジバンシィモデル、パリ、ニューヨーク、1976年。\r\nサイズ：ペンダントの長さ：12.5cm、直径：5cm、チェーンの長さ：68cm。\r\nペンダントには3つのビーズが欠けており、残りは良好な状態です。', 'レア1976ジバンシィヴィンテージネックレス', 'レア1976ジバンシィヴィンテージネックレス'),
(56, 8, '', 'zh', '1976年罕见的项链吊坠', '一个罕见的复古纪梵希吊坠项链。\r\n纪梵希模型，巴黎，纽约，1976年。\r\n尺寸：吊坠长度：12.5厘米，直径：5厘米，链长：68厘米。\r\n吊坠中缺少3个珠子，其余的都处于良好状态。', '罕见的1976年纪梵希古董项链', '罕见的1976年纪梵希古董项链'),
(57, 9, '', 'ru', 'Золотые серьги-клипсы', 'Винтажные серьги-клипсы в очень хорошем состоянии\r\nКоллекция подписанных ароматов Givenchy France', 'Золотые серьги-клипсы с логотипом Givenchy', 'Золотые серьги-клипсы с логотипом Givenchy'),
(58, 9, '', 'en', 'Gold Clip-on Earrings', 'Vintage clip earrings in very good condition\r\nGivenchy France Signature Fragrance Collection', 'Gold clip-on earrings with Givenchy logo', 'Gold clip-on earrings with Givenchy logo'),
(59, 9, '', 'de', 'Ohrclips aus Gold', 'Vintage Clip Ohrringe in sehr gutem Zustand\r\nGivenchy France signierte Duftkollektion', 'Ohrringe mit Givenchy-Logo in Gold', 'Ohrringe mit Givenchy-Logo in Gold'),
(60, 9, '', 'es', 'Pendientes de clip de oro', 'Pendientes de clip Vintage en muy buenas condiciones\r\nLa colección de fragancias firmadas de Givenchy France', 'Pendientes de clip de oro con el logotipo de Givenchy', 'Pendientes de clip de oro con el logotipo de Givenchy'),
(61, 9, '', 'fr', 'Boucles d\'oreilles en or', 'Boucles d\'oreilles Vintage en très bon état\r\nCollection de parfums signés Givenchy France', 'Boucles d\'oreilles en or avec logo Givenchy', 'Boucles d\'oreilles en or avec logo Givenchy'),
(62, 9, '', 'ja', 'ゴールドクリップオンピアス', '非常に良い状態でヴィンテージクリップイヤリング\r\nジバンシィフランスシグネチャーフレグランスコレクション', 'ジバンシィのロゴが入ったゴールドのクリップオンイヤリング', 'ジバンシィのロゴが入ったゴールドのクリップオンイヤリング'),
(63, 9, '', 'zh', '金夹式耳环', '复古夹耳环在非常好的条件\r\n纪梵希法国签名香水系列', '金夹式耳环与纪梵希标志', '金夹式耳环与纪梵希标志'),
(64, 10, '', 'ru', 'Серьги-клипсы Orecchini', 'Редкие винтажные клипсы из коллекции Givenchy 1980-х годов.\r\nЗолотого цвета в форме цветка с красным камнем. Идеально подходит для любого случая.', 'Серьги-клипсы Orecchini', 'Серьги-клипсы Orecchini'),
(65, 10, '', 'en', 'Orecchini Clip Earrings', 'Rare vintage clips from the Givenchy collection from the 1980s.\r\nGolden in the shape of a flower with a red stone. Perfect for any occasion.', 'Orecchini Clip Earrings', 'Orecchini Clip Earrings'),
(66, 10, '', 'de', 'Orecchini Clip Ohrringe', 'Seltene Vintage-Clips aus der Givenchy-Kollektion der 1980er Jahre.\r\nGoldene Farbe in Form einer Blume mit einem roten Stein. Perfekt für jeden Anlass.', 'Orecchini Clip Ohrringe', 'Orecchini Clip Ohrringe'),
(67, 10, '', 'es', 'Pendientes de clip Orecchini', 'Clips Vintage raros de la colección Givenchy de la década de 1980.\r\nColor dorado en forma de flor con piedra roja. Perfecto para cualquier ocasión.', 'Pendientes de clip Orecchini', 'Pendientes de clip Orecchini'),
(68, 10, '', 'fr', 'Boucles d\'oreilles Orecchini', 'Clips Vintage rares de la collection Givenchy des années 1980.\r\nCouleur or en forme de fleur avec pierre rouge. Parfait pour toute occasion.', 'Boucles d\'oreilles Orecchini', 'Boucles d\'oreilles Orecchini'),
(69, 10, '', 'ja', 'オレッキーニクリップピアス', '1980年代のジバンシィコレクションからの珍しいヴィンテージクリップ。\r\n赤い石の花の形をした金色。 あらゆる機会に最適です。', 'オレッキーニクリップピアス', 'オレッキーニクリップピアス'),
(70, 10, '', 'zh', 'Orecchini夹式耳环', '20世纪80年代纪梵希收藏的稀有古董剪辑。\r\n金色的花与红色的石头的形状。 适合任何场合。', 'Orecchini夹式耳环', 'Orecchini夹式耳环'),
(71, 11, '', 'ru', 'Серьги ', 'Красивые серьги Givenchy c красным камнем. Ни разу не использовались.', 'Серьги Givenchy', 'Серьги Givenchy'),
(72, 11, '', 'en', 'Earrings', 'Beautiful Givenchy earrings with red stone. They have never been used.', 'Givenchy Earrings', 'Givenchy Earrings'),
(73, 11, '', 'de', 'Ohrringe', 'Schöne Givenchy Ohrringe mit rotem Stein. Noch nie verwendet wurden.', 'Givenchy Ohrringe', 'Givenchy Ohrringe'),
(74, 11, '', 'es', 'Pendientes ', 'Hermosos pendientes Givenchy con piedra roja. Nunca se ha utilizado.', 'Pendientes Givenchy', 'Pendientes Givenchy'),
(75, 11, '', 'fr', 'Pendants', 'Belles boucles d\'oreilles Givenchy avec pierre rouge. Jamais utilisé.', 'Boucles D\'Oreilles Givenchy', 'Boucles D\'Oreilles Givenchy'),
(76, 11, '', 'ja', 'ピアス', '赤い石が付いている美しいジバンシィのイヤリング。 それらは決して使用されていません。', 'ジバンシィピアス', 'ジバンシィピアス'),
(77, 11, '', 'zh', '耳环', '美丽的纪梵希耳环与红色石头。 它们从未被使用过。', '纪梵希耳环', '纪梵希耳环'),
(78, 12, '', 'ru', 'Серьги-клипсы 1980-х ', 'Винтаж 1980-х годов.\r\nВинтажные серьги-клипсы Givenchy в форме груши золотого цвета с черным камнем и стразами. В очень хорошем состоянии.', 'Серьги-клипсы Givenchy, винтаж 1980-х ', 'Серьги-клипсы Givenchy, винтаж 1980-х '),
(79, 12, '', 'en', 'Clip-on earrings from the 1980s', 'Vintage 1980s.\r\nVintage Givenchy pear-shaped clip earrings in gold with black stone and rhinestones. In very good condition.', 'Givenchy clip earrings, vintage 1980s', 'Givenchy clip earrings, vintage 1980s'),
(80, 12, '', 'de', 'Ohrclips der 1980er Jahre', 'Jahrgang der 1980er Jahre.\r\nVintage Givenchy Clip Ohrringe in goldfarbener Birnenform mit schwarzem Stein und Strasssteinen. In sehr gutem Zustand.', 'Givenchy Clip Ohrringe, Jahrgang der 1980er Jahre', 'Givenchy Clip Ohrringe, Jahrgang der 1980er Jahre'),
(81, 12, '', 'es', 'Pendientes de clip de la década de 1980', 'Vintage de los años 80.\r\nPendientes de clip Vintage Givenchy en forma de pera de color dorado con piedra negra y diamantes de imitación. En muy buen estado.', 'Pendientes de clip Givenchy, Vintage de 1980', 'Pendientes de clip Givenchy, Vintage de 1980'),
(82, 12, '', 'fr', 'Boucles d\'oreilles clip des années 1980', 'Vintage des années 1980.\r\nBoucles d\'oreilles Vintage Givenchy en forme de poire couleur or avec pierre noire et strass. En très bon état.', 'Boucles d\'oreilles clip Givenchy, Vintage des années 1980', 'Boucles d\'oreilles clip Givenchy, Vintage des années 1980'),
(83, 12, '', 'ja', '1980年代からのクリップオンイヤリング', 'ヴィンテージ1980年代。\r\n黒の石とラインストーンが付いたヴィンテージジバンシィの洋ナシの形をしたゴールドクリップイヤリング。 非常に良い状態で。', 'ジバンシィクリップイヤリング、ヴィンテージ1980年代', 'ジバンシィクリップイヤリング、ヴィンテージ1980年代'),
(84, 12, '', 'zh', '20世纪80年代的夹式耳环', '20世纪80年代的年份。\r\n复古纪梵希梨形金夹耳环与黑色石头和水钻。 状态非常好。', '纪梵希夹耳环，20世纪80年代复古', '纪梵希夹耳环，20世纪80年代复古'),
(85, 13, '', 'ru', 'Коллекционное золотое кольцо с драгоценными камнями', 'Цельное кольцо Chanel Gold 750 с драгоценными камнями.\r\nРазмер: 17 вес: 14,3 грамма\r\nКоллекционное.', 'Коллекционное золотое кольцо Chanel с драгоценными камнями', 'Коллекционное золотое кольцо Chanel  с драгоценными камнями'),
(86, 13, '', 'en', 'Chanel collectible gold ring with precious stones', 'One-piece Chanel Gold 750 ring with precious stones.\r\nSize: 17 weight: 14.3 grams\r\nCollectible.', 'Chanel collectible gold ring with precious stones', 'Chanel collectible gold ring with precious stones'),
(87, 13, '', 'de', 'Sammlerring aus Gold mit Edelsteinen', 'Ein ganzer Chanel Gold 750 Ring mit Edelsteinen.\r\nGröße: 17 Gewicht: 14,3 Gramm\r\nSammlerstück.', 'Chanel-Sammler-Goldring mit Edelsteinen', 'Chanel-Sammler-Goldring mit Edelsteinen'),
(88, 13, '', 'es', 'Anillo de piedras preciosas de oro coleccionable', 'Anillo de una pieza Chanel Gold 750 con piedras preciosas.\r\nTamaño: 17 peso: 14.3 gramos\r\nDe colección.', 'Anillo de oro Chanel con piedras preciosas', 'Anillo de oro Chanel con piedras preciosas'),
(89, 13, '', 'fr', 'Bague Collector en or avec pierres précieuses', 'Une seule pièce Chanel Gold 750 avec des pierres précieuses.\r\nTaille: 17 poids: 14,3 grammes\r\nDe collection.', 'Bague en or à collectionner Chanel avec pierres précieuses', 'Bague en or à collectionner Chanel avec pierres précieuses'),
(90, 13, '', 'ja', '貴重な石とコレクタブルゴールドリング', '貴重な石が付いているワンピースのシャネルの金750リング。\r\nサイズ：17重さ：14.3グラム\r\nコレクタブル。', '貴重な石とシャネルコレクタブルゴールドリング', '貴重な石とシャネルコレクタブルゴールドリング'),
(91, 13, '', 'zh', '珍贵宝石收藏金戒指', '一件香奈儿金750戒指与宝石.\r\n尺寸：17重量：14.3克\r\n收藏品。', '香奈儿珍藏金戒指与宝石', '香奈儿珍藏金戒指与宝石'),
(92, 14, '', 'ru', 'Драгоценное колье ', 'Колье Chanel, белое золото и бриллианты.', 'Колье Chanel с золотом и бриллиантами', 'Колье Chanel с золотом и бриллиантами'),
(93, 14, '', 'en', 'A precious necklace', 'Chanel necklace, white gold and diamonds.', 'Chanel necklace with gold and diamonds', 'Chanel necklace with gold and diamonds'),
(94, 14, '', 'de', 'Kostbare Halskette', 'Chanel-Halskette, Weißgold und Diamanten.', 'Chanel Halskette mit Gold und Diamanten', 'Chanel Halskette mit Gold und Diamanten'),
(95, 14, '', 'es', 'Collar precioso', 'Collar Chanel, oro blanco y diamantes.', 'Collar Chanel con oro y diamantes', 'Collar Chanel con oro y diamantes'),
(96, 14, '', 'fr', 'Collier précieux', 'Collier Chanel, or blanc et diamants.', 'Collier Chanel avec or et diamants', 'Collier Chanel avec or et diamants'),
(97, 14, '', 'ja', '貴重なネックレス', 'シャネルのネックレス、ホワイトゴールドとダイヤモンド。', 'ゴールドとダイヤモンドのシャネルネックレス', 'ゴールドとダイヤモンドのシャネルネックレス'),
(98, 14, '', 'zh', '一条珍贵的项链', '香奈儿项链，白金和钻石。', '香奈儿项链与黄金和钻石', '香奈儿项链与黄金和钻石'),
(99, 15, '', 'ru', 'Драгоценный браслет', 'Браслет Chanel Coco Crush золото и 9 бриллиантов.', 'Браслет Chanel Coco Crush из золота и 9 бриллиантов.', 'Браслет Chanel Coco Crush из золота и 9 бриллиантов.'),
(100, 15, '', 'en', 'A precious bracelet', 'Chanel Coco Crush bracelet in gold and 9 diamonds.', 'Chanel Coco Crush bracelet made of gold and 9 diamonds.', 'Chanel Coco Crush bracelet made of gold and 9 diamonds.'),
(101, 15, '', 'de', 'Edelstein-Armband', 'Chanel Coco Crush Armband aus Gold und 9 Diamanten.', 'Chanel Coco Crush Armband aus Gold und 9 Diamanten.', 'Chanel Coco Crush Armband aus Gold und 9 Diamanten.'),
(102, 15, '', 'es', 'Pulsera de piedras preciosas', 'Chanel Coco Crush pulsera de oro y 9 diamantes.', 'Pulsera Chanel Coco Crush en oro y 9 diamantes.', 'Pulsera Chanel Coco Crush en oro y 9 diamantes.'),
(103, 15, '', 'fr', 'Bracelet précieux', 'Bracelet Chanel Coco Crush or et 9 diamants.', 'Bracelet Chanel Coco Crush en or et 9 diamants.', 'Bracelet Chanel Coco Crush en or et 9 diamants.'),
(104, 15, '', 'ja', '貴重なブレスレット', 'シャネルココクラッシュブレスレットゴールドと9ダイヤモンド。', '金と9つのダイヤモンドで作られたシャネルココクラッシュブレスレット。', '金と9つのダイヤモンドで作られたシャネルココクラッシュブレスレット。'),
(105, 15, '', 'zh', '珍贵的手镯', '香奈儿可可粉碎手镯在黄金和9颗钻石。', '香奈儿Coco Crush手镯由黄金和9颗钻石制成。', '香奈儿Coco Crush手镯由黄金和9颗钻石制成。'),
(106, 16, '', 'ru', 'Коллекционное колье ', 'Колье коллекционное Chanel Cruise 2005.\r\nИзготовлено во Франции.', 'Колье коллекционное Chanel Cruise 2005', 'Колье коллекционное Chanel Cruise 2005'),
(107, 16, '', 'en', 'Collectible necklace', 'Collectible necklace Chanel Cruise 2005.\r\nMade in France.', 'Chanel Cruise 2005 Collectible Necklace', 'Chanel Cruise 2005 Collectible Necklace'),
(108, 16, '', 'de', 'Sammler-Halskette', 'Chanel Cruise Sammlerhalskette 2005.\r\nHergestellt in Frankreich.', 'Chanel Cruise Sammlerhalskette 2005', 'Chanel Cruise Sammlerhalskette 2005'),
(109, 16, '', 'es', 'Collar de colección', 'Colección Chanel Cruise 2005.\r\nFabricado en Francia.', 'Colección Chanel Cruise 2005', 'Colección Chanel Cruise 2005'),
(110, 16, '', 'fr', 'Collier de collection', 'Collier collection Chanel Cruise 2005.\r\nFabriqué en France.', 'Collier de collection Chanel Cruise 2005', 'Collier de collection Chanel Cruise 2005'),
(111, 16, '', 'ja', 'コレクタブルネックレス', 'コレクタブルネックレスシャネルクルーズ2005.\r\nフランス製。', 'シャネルクルーズ2005コレクタブルネックレス', 'シャネルクルーズ2005コレクタブルネックレス'),
(112, 16, '', 'zh', '收藏项链', '收藏项链香奈儿巡航2005.\r\n法国制造。', '香奈儿邮轮2005年收藏项链', '香奈儿邮轮2005年收藏项链'),
(113, 17, '', 'ru', 'Цепочка и подвеска в форме креста ', 'Цепочка и подвеска Chanel в форме креста из золотистого металла со стразами и жемчужно-белыми бусинами.', 'Цепочка и подвеска Chanel в форме креста со стразами и бусинами', 'Цепочка и подвеска Chanel в форме креста со стразами и бусинами'),
(114, 17, '', 'en', 'Chain and pendant in the shape of a cross', 'Chanel chain and pendant in the shape of a cross made of golden metal with rhinestones and pearl-white beads.', 'Chanel chain and pendant in the shape of a cross with rhinestones and beads', 'Chanel chain and pendant in the shape of a cross with rhinestones and beads'),
(115, 17, '', 'de', 'Kreuzförmige Kette und Anhänger', 'Chanel Kette und Anhänger in Kreuzform aus goldfarbenem Metall mit Strasssteinen und perlweißen Perlen.', 'Kreuzförmige Chanel Kette und Anhänger mit Strasssteinen und Perlen', 'Kreuzförmige Chanel Kette und Anhänger mit Strasssteinen und Perlen'),
(116, 17, '', 'es', 'Cadena y colgante en forma de Cruz', 'Cadena y colgante Chanel en forma de Cruz de metal dorado con pedrería y perlas blancas.', 'Cadena y colgante Chanel en forma de Cruz con cuentas de diamantes de imitación', 'Cadena y colgante Chanel en forma de Cruz con cuentas de diamantes de imitación'),
(117, 17, '', 'fr', 'Chaîne et pendentif en forme de Croix', 'Chaîne et pendentif Chanel en forme de Croix en métal doré avec strass et perles blanches.', 'Chaîne et pendentif en forme de Croix Chanel avec strass et perles', 'Chaîne et pendentif en forme de Croix Chanel avec strass et perles'),
(118, 17, '', 'ja', '十字架の形をしたチェーンとペンダント', 'ラインストーンとパールホワイトのビーズが付いた金色の金属で作られた十字架の形をしたシャネルのチェーンとペンダント。', 'ラインストーンとビーズの十字架の形をしたシャネルのチェーンとペンダント', 'ラインストーンとビーズの十字架の形をしたシャネルのチェーンとペンダント'),
(119, 17, '', 'zh', '十字架形状的链子和吊坠', '香奈儿链和吊坠在一个十字架的形状由金色金属与水钻和珍珠白色珠子。', '香奈儿链和吊坠的形状与水钻和珠子的十字架', '香奈儿链和吊坠的形状与水钻和珠子的十字架'),
(120, 18, '', 'ru', 'Сумка саквояж YSL', 'Модель Chyc YSL, выполненная в трех оттенках кожи, с двойной ручкой из свернутой кожи, застежкой-молнией сверху и макси-логотипом из золотистого металла. Безупречное состояние, идеальные углы, без потертостей и запахов.\r\n\r\nРазмеры: ширина 36 см, высота 26 см, глубина 15 см', 'Сумка саквояж Yves Saint Laurent Chyc YSL – идеальное состояние', 'Роскошная сумка Chyc YSL от Yves Saint Laurent в трех оттенках кожи, с двойной ручкой, застежкой-молнией и золотым логотипом. Безупречное состояние, 36×26×15 см.'),
(121, 18, '', 'en', 'Chyc YSL Satchel Bag', 'Chyc YSL model crafted in three shades of leather, featuring double rolled leather handles, a top zipper closure, and a gold-tone maxi logo. Impeccable condition, perfect corners, no scuffs or odors.\r\n\r\nDimensions: width 36 cm, height 26 cm, depth 15 cm', 'Yves Saint Laurent Chyc YSL Satchel Bag – Excellent Condition', 'Luxury Chyc YSL bag by Yves Saint Laurent in three leather tones, with double rolled handles, top zipper, and gold-tone logo. Perfect condition, 36×26×15 cm.'),
(122, 18, '', 'de', 'Chyc YSL Satchel-Tasche', 'Chyc YSL Modell aus drei Lederfarben, mit doppelten gerollten Ledergriffen, Reißverschluss oben und Maxi-Logo aus goldfarbenem Metall. Makelloser Zustand, perfekte Ecken, keine Abnutzung oder Gerüche.\r\n\r\nMaße: Breite 36 cm, Höhe 26 cm, Tiefe 15 cm', 'Yves Saint Laurent Chyc YSL Satchel-Tasche – Makelloser Zustand', 'Luxuriöse Chyc YSL Tasche von Yves Saint Laurent in drei Lederfarben, mit doppelten Griffen, Reißverschluss und goldfarbenem Logo. Perfekter Zustand, 36×26×15 cm.'),
(123, 18, '', 'es', 'Bolso tipo doctor Chyc YSL', 'Modelo Chyc YSL realizado en tres tonos de cuero, con doble asa de cuero enrollado, cierre superior de cremallera y logo maxi en metal dorado. Estado impecable, esquinas perfectas, sin rozaduras ni olores.\r\n\r\nDimensiones: ancho 36 cm, alto 26 cm, profundidad 15 cm', 'Bolso tipo doctor Yves Saint Laurent Chyc YSL – Estado Impecable', 'Lujoso bolso Chyc YSL de Yves Saint Laurent en tres tonos de cuero, con doble asa, cierre de cremallera y logo dorado. Estado perfecto, 36×26×15 cm.'),
(124, 18, '', 'fr', 'Sac Cabas Chyc YSL', 'Modèle Chyc YSL en trois teintes de cuir, avec double poignée en cuir roulé, fermeture éclair sur le dessus et maxi logo en métal doré. État impeccable, coins parfaits, sans usure ni odeurs.\r\n\r\nDimensions: largeur 36 cm, hauteur 26 cm, profondeur 15 cm', 'Sac cabas Yves Saint Laurent Chyc YSL – État Impeccable', 'Sac Chyc YSL de luxe par Yves Saint Laurent en trois tons de cuir, avec double poignée, fermeture éclair et logo doré. État parfait, 36×26×15 cm.'),
(125, 18, '', 'ja', 'サッチェルバッグ Chyc YSL ', '3色のレザーを使用したChyc YSLモデル。ダブルロールドレザーのハンドル、トップジッパー、ゴールドメタルのマキシロゴ付き。状態は完璧で、角も美しく、擦れや臭いなし。\r\n\r\nサイズ: 幅36 cm、高さ26 cm、奥行15 cm', 'イヴ・サンローラン Chyc YSL サッチェルバッグ – 完璧な状態', 'イヴ・サンローランの高級Chyc YSLバッグ、3色のレザー、ダブルハンドル、トップジッパー、ゴールドロゴ付き。完璧な状態、36×26×15 cm。'),
(126, 18, '', 'zh', 'Chyc YSL 手提包', 'Chyc YSL款，采用三种色调皮革制成，配有双卷皮手柄、顶部拉链和金色金属大Logo。状态完美，角落无损，无磨损和异味。\r\n\r\n尺寸: 宽36 cm，高26 cm，深15 cm', '伊夫·圣洛朗 Chyc YSL 手提包 – 完美状态', '伊夫·圣洛朗奢华Chyc YSL手提包，三色皮革，双卷手柄，顶部拉链，金色Logo。完美状态，36×26×15 cm。'),
(127, 19, '', 'ru', 'Сумка Hermès Mini Kelly – редкий красный экземпляр', 'Редкая ярко-красная сумочка Hermès Mini Kelly с позолоченной застежкой, изготовлена во Франции. Внутренняя отделка из красной кожи. Сумка в очень хорошем состоянии, есть небольшие царапины на металле. Размеры: 20×14×8 см. Продается с плечевым ремнем. Оригинал.\r\n', 'Сумка Hermès Mini Kelly – редкая красная сумка, отличное состояние', 'Редкая ярко-красная сумка Hermès Mini Kelly 20 см, позолоченная застежка, внутренняя отделка из красной кожи, с плечевым ремнем. Отличное состояние, оригинал, редкий экземпляр.'),
(128, 19, '', 'en', 'Hermès Mini Kelly Bag – Rare Red Edition', 'Rare bright red Hermès Mini Kelly bag with gold-plated clasp, made in France. Bright red leather interior. Bag in very good condition, minor metal scratches. Size: 20×14×8 cm. Comes with shoulder strap. Authentic and rare.', 'Hermès Mini Kelly Bag – Rare Red Bag, Excellent Condition', 'Rare bright red Hermès Mini Kelly 20 cm bag with gold clasp and red leather interior. Comes with shoulder strap. Excellent condition, authentic, collectible.'),
(129, 19, '', 'de', 'Hermès Mini Kelly Tasche – Seltene Rote Edition', 'Seltene leuchtend rote Hermès Mini Kelly Tasche mit vergoldetem Verschluss, hergestellt in Frankreich. Innenauskleidung aus rotem Leder. Sehr guter Zustand, kleine Kratzer am Metall. Größe: 20×14×8 cm. Mit Schulterriemen. Original.\r\n', 'Hermès Mini Kelly Tasche – Seltene rote Tasche, sehr guter Zustand', 'Seltene leuchtend rote Hermès Mini Kelly 20 cm Tasche, vergoldeter Verschluss, rotes Leder innen, mit Schulterriemen. Sehr guter Zustand, Original, seltenes Sammlerstück.'),
(130, 19, '', 'es', 'Bolso Hermès Mini Kelly – Edición Roja Rara', 'Raro bolso Hermès Mini Kelly rojo brillante con cierre dorado, hecho en Francia. Interior de cuero rojo. Bolsa en muy buen estado, con pequeños arañazos en el metal. Tamaño: 20×14×8 cm. Se vende con correa de hombro. Original y raro.', 'Hermès Mini Kelly – Bolso rojo raro, excelente estado', 'Raro bolso Hermès Mini Kelly 20 cm rojo brillante, cierre dorado, interior de cuero rojo, con correa de hombro. Excelente estado, original, pieza rara.'),
(131, 19, '', 'fr', 'Sac Hermès Mini Kelly – Édition Rouge Rare', 'Rare sac Hermès Mini Kelly rouge vif avec fermoir doré, fabriqué en France. Intérieur en cuir rouge. Sac en très bon état, quelques rayures sur le métal. Taille : 20×14×8 cm. Livré avec bandoulière. Authentique et rare.', 'Sac Hermès Mini Kelly – Sac rouge rare, excellent état', 'Rare sac Hermès Mini Kelly 20 cm rouge vif, fermoir doré, intérieur en cuir rouge, avec bandoulière. Excellent état, authentique, pièce rare.'),
(132, 19, '', 'ja', 'エルメス ミニ ケリー – レアレッドバッグ', 'フランス製の希少な鮮やかな赤のエルメス ミニ ケリー、金メッキ留め具付き。内装は赤いレザー。非常に良い状態、金具に小さな傷あり。サイズ：20×14×8 cm。ショルダーストラップ付き。正規品で希少。', 'エルメス ミニ ケリー – レア赤バッグ、良好な状態', '希少な赤のエルメス ミニ ケリー 20 cm、金メッキ留め具、赤いレザー内装、ショルダーストラップ付き。良好な状態、正規品、コレクション向き。'),
(133, 19, '', 'zh', 'Hermès Mini Kelly 手提包 – 稀有红色款', '稀有亮红色 Hermès Mini Kelly 手提包，金色扣环，法国制造。内衬红色皮革。包包状态非常好，金属有轻微划痕。尺寸：20×14×8 cm。附带肩带。正品，稀有收藏。', 'Hermès Mini Kelly 手提包 – 稀有红色手提包，极佳状态', '稀有亮红色 Hermès Mini Kelly 20 cm 手提包，金扣、红色皮革内衬，附肩带。极佳状态，正品，收藏稀有款。'),
(134, 20, '', 'ru', 'Сумка Hermès Kelly 25 – матовая крокодиловая кожа с бриллиантами', 'Роскошная сумка Hermès Kelly 25 см, специальный заказ. \r\nМатовая крокодиловая кожа Niloticus, белое золото 18 карат, украшена бриллиантами. \r\nЦвет: Белые Гималаи. Сумка на плечо и с верхней ручкой, внутреннее отделение из серой кожи. \r\n\r\nКомплект: мешок для пыли, коробка, замок, ключи, застежка, плечевой ремень, защитный фетр, брошюра по уходу. \r\nПодлинность подтверждена штампом с датой изготовления (2022). \r\nРазмеры: 25×19×9 см, ручка 10 см, ремешок 42 см. Поворотный замок, навесной замок. \r\nСделано во Франции.', 'Hermès Kelly 25 – матовая крокодиловая кожа, бриллианты, Белые Гималаи', 'Роскошная Hermès Kelly 25 см, матовая крокодиловая кожа Niloticus, белое золото 18 карат, бриллианты. Цвет Белые Гималаи, плечевой ремень, подлинность 2022, Франция.'),
(135, 20, '', 'en', 'Hermès Kelly 25 Bag – Matte Crocodile Leather with Diamonds', 'Luxurious Hermès Kelly 25 cm, special order.\r\nNiloticus matte crocodile leather, 18k white gold, adorned with diamonds.\r\nColor: White Himalaya. Shoulder and top handle bag, interior in grey leather.\r\n\r\nIncludes dust bag, box, lock, keys, clasp, shoulder strap, protective felt, care booklet.\r\nAuthenticity verified with 2022 date stamp.\r\nSize: 25×19×9 cm, handle 10 cm, strap 42 cm. Turn-lock closure, padlock.\r\nMade in France.', 'Hermès Kelly 25 – Matte Crocodile Leather, Diamonds, White Himalaya', 'Luxurious Hermès Kelly 25 cm bag, Niloticus matte crocodile leather, 18k white gold, diamonds. White Himalaya color, shoulder strap included, authentic 2022, made in France.'),
(136, 20, '', 'de', 'Hermès Kelly 25 Tasche – Matte Krokodilleder mit Diamanten', 'Luxuriöse Hermès Kelly 25 cm, Sonderanfertigung.\r\nNiloticus mattes Krokodilleder, 18 Karat Weißgold, mit Diamanten besetzt.\r\nFarbe: Weißer Himalaya. Schulter- und Obergriff, Innenraum aus grauem Leder.\r\n\r\nInklusive Staubbeutel, Box, Schloss, Schlüssel, Verschluss, Schulterriemen, Schutzfilz, Pflegebroschüre.\r\nEchtheit bestätigt durch Datumstempel 2022.\r\nGröße: 25×19×9 cm, Griff 10 cm, Riemen 42 cm. Drehverschluss, Vorhängeschloss.\r\nHergestellt in Frankreich.', 'Hermès Kelly 25 – Mattes Krokodilleder, Diamanten, Weißer Himalaya', 'Luxuriöse Hermès Kelly 25 cm Tasche aus Niloticus Krokodilleder, 18 Karat Weißgold, Diamanten. Weißer Himalaya, Schulterriemen, Echtheit 2022, Frankreich.'),
(137, 20, '', 'es', 'Bolso Hermès Kelly 25 – Piel de Cocodrilo Mate con Diamantes', 'Lujoso Hermès Kelly 25 cm, pedido especial.\r\nPiel de cocodrilo Niloticus mate, oro blanco de 18 quilates, adornado con diamantes.\r\nColor: Blanco Himalaya. Bolso de hombro y asa superior, interior de cuero gris.\r\n\r\nIncluye bolsa antipolvo, caja, cerradura, llaves, cierre, correa, fieltro protector, folleto de cuidado.\r\nAutenticidad verificada con sello de fecha 2022.\r\nTamaño: 25×19×9 cm, asa 10 cm, correa 42 cm. Cierre de giro, candado.\r\nHecho en Francia.', 'Hermès Kelly 25 – Piel de Cocodrilo Mate, Diamantes, Blanco Himalaya', 'Lujoso bolso Hermès Kelly 25 cm, piel de cocodrilo Niloticus mate, oro blanco 18k, diamantes. Color Blanco Himalaya, correa de hombro incluida, autenticidad 2022, hecho en Francia.'),
(138, 20, '', 'fr', 'Sac Hermès Kelly 25 – Cuir Crocodile Mat avec Diamants', 'Sac de luxe Hermès Kelly 25 cm, commande spéciale.\r\nCuir crocodile Niloticus mat, or blanc 18 carats, orné de diamants.\r\nCouleur : Blanc Himalaya. Sac à main et bandoulière, intérieur en cuir gris.\r\n\r\nInclus : housse anti-poussière, boîte, serrure, clés, fermoir, bandoulière, feutre protecteur, livret d’entretien.\r\nAuthenticité confirmée par tampon de date 2022.\r\nDimensions : 25×19×9 cm, poignée 10 cm, bandoulière 42 cm. Fermeture tourniquet, cadenas.\r\nFabriqué en France.', 'Hermès Kelly 25 – Cuir Crocodile Mat, Diamants, Blanc Himalaya', 'Luxueux Hermès Kelly 25 cm, cuir crocodile Niloticus mat, or blanc 18 carats, diamants. Couleur Blanc Himalaya, bandoulière, authenticité 2022, fabriqué en France.'),
(139, 20, '', 'ja', 'エルメス ケリー 25 – マットクロコダイルレザー＆ダイヤモンド', '豪華なエルメス ケリー 25 cm、特注モデル。\r\nマットクロコダイルレザー（Niloticus）、18Kホワイトゴールド、ダイヤモンド装飾。\r\n色：ホワイトヒマラヤ。ショルダーおよびトップハンドルバッグ、内装はグレーのレザー。\r\n\r\n付属品：ダストバッグ、ボックス、ロック、キー、留め具、ショルダーストラップ、保護フェルト、ケアブックレット。\r\n正規品確認済（2022年製）。\r\nサイズ：25×19×9 cm、ハンドル10 cm、ストラップ42 cm。ターンロック＆南京錠。\r\nフランス製。', 'エルメス ケリー 25 – マットクロコダイル、ダイヤモンド、ホワイトヒマラヤ', 'エルメス ケリー 25 cm、マットクロコダイルレザー（Niloticus）、18Kホワイトゴールド、ダイヤモンド。ホワイトヒマラヤ、ショルダーストラップ付、正規品2022年製、フランス製。'),
(140, 20, '', 'zh', 'Hermès Kelly 25 手提包 – 哑光鳄鱼皮镶钻', '奢华 Hermès Kelly 25 cm，特别定制。\r\nNiloticus 哑光鳄鱼皮，18K 白金，镶嵌钻石。\r\n颜色：白色喜马拉雅。肩背及手提，内衬灰色皮革。\r\n\r\n附带防尘袋、盒子、锁、钥匙、扣件、肩带、防护毡、护理手册。\r\n正品认证（2022 年制造）。\r\n尺寸：25×19×9 cm，手柄10 cm，肩带42 cm。旋转锁，挂锁。\r\n法国制造。', 'Hermès Kelly 25 – 哑光鳄鱼皮，钻石，白色喜马拉雅', '奢华 Hermès Kelly 25 cm 手提包，Niloticus 哑光鳄鱼皮，18K 白金，镶钻。白色喜马拉雅，附肩带，正品2022年，法国制造。'),
(141, 21, '', 'ru', 'Новая сумка Valentino Garavani', 'Новая сумка Valentino Garavani.\r\nУкрашена золотыми стразами, эффектно смотрится как вечерний аксессуар.\r\n\r\nСостояние: абсолютно новая.', 'Сумка Valentino Garavani – новая с золотыми стразами', 'Новая сумка Valentino Garavani, украшена золотыми стразами. Элегантный аксессуар для вечернего образа.'),
(142, 21, '', 'en', 'New Valentino Garavani bag', 'Brand new Valentino Garavani bag.\r\nAdorned with gold rhinestones, perfect as an evening accessory.\r\n\r\nCondition: completely new.', 'Valentino Garavani Bag – New with Gold Rhinestones', 'Brand new Valentino Garavani bag decorated with gold rhinestones. Elegant accessory for evening looks.'),
(143, 21, '', 'de', 'Neue Valentino Garavani Tasche', 'Neue Valentino Garavani Tasche.\r\nMit goldenen Strasssteinen verziert, ideal als Abendaccessoire.\r\n\r\nZustand: komplett neu.', 'Valentino Garavani Tasche – Neu mit goldenen Strasssteinen', 'Neue Valentino Garavani Tasche, verziert mit goldenen Strasssteinen. Elegantes Accessoire für Abendlooks.'),
(144, 21, '', 'es', 'Bolso Valentino Garavani nuevo', 'Bolso Valentino Garavani nuevo.\r\nAdornado con piedras doradas, perfecto como accesorio de noche.\r\n\r\nEstado: completamente nuevo.', 'Bolso Valentino Garavani – Nuevo con piedras doradas', 'Bolso Valentino Garavani nuevo, decorado con piedras doradas. Elegante accesorio para la noche.'),
(145, 21, '', 'fr', 'Sac Valentino Garavani neuf', 'Sac Valentino Garavani neuf.\r\nOrné de strass dorés, parfait comme accessoire de soirée.\r\n\r\nÉtat : complètement neuf.', 'Sac Valentino Garavani – Neuf avec strass dorés', 'Sac Valentino Garavani neuf, décoré de strass dorés. Accessoire élégant pour les soirées.'),
(146, 21, '', 'ja', '新品 Valentino Garavani バッグ', '新品 Valentino Garavani バッグ。\r\nゴールドのラインストーン装飾、イブニングアクセサリーに最適。\r\n\r\n状態：新品。', 'Valentino Garavani バッグ – 新品、ゴールドラインストーン付き', '新品のValentino Garavaniバッグ、ゴールドのラインストーン装飾。エレガントなイブニングアクセサリー。'),
(147, 21, '', 'zh', '全新 Valentino Garavani 手提包', '全新 Valentino Garavani 手提包。\r\n镶有金色水钻，完美的晚宴配饰。\r\n\r\n状态：全新。', 'Valentino Garavani 手提包 – 全新，金色水钻', '全新 Valentino Garavani 手提包，镶有金色水钻。优雅的晚宴配饰。'),
(148, 22, '', 'ru', 'Часы Tabbah Saga Sea – редкий лимитированный выпуск', 'Часы от бренда Tabbah, модель Saga Sea.\r\nВыпущено всего 10 экземпляров.\r\n\r\nЭмаль на циферблате выполнена мастерами из Швейцарии Оливье и Доминик Воше.\r\nРаковина моллюска из перламутра и белого золота.\r\n\r\nКорпус из золота, инкрустация бриллиантами.\r\nИзначальная цена — 215 000 $.', 'Часы Tabbah Saga Sea – лимитированная серия, всего 10 экземпляров', 'Редкие часы Tabbah Saga Sea, созданные мастерами из Швейцарии. Золото, бриллианты, перламутр. Всего 10 экземпляров.'),
(149, 22, '', 'en', 'Tabbah Saga Sea Watch – Rare Limited Edition', 'Tabbah watch, model Saga Sea.\r\nOnly 10 pieces ever produced.\r\n\r\nDial enamel crafted by Swiss masters Olivier and Dominique Vaucher.\r\nSeashell motif in mother-of-pearl and white gold.\r\n\r\nGold case, diamond-set.\r\nOriginal price: $215,000.', 'Tabbah Saga Sea Watch – Limited Edition, Only 10 Made', 'Rare Tabbah Saga Sea watch. Swiss craftsmanship, gold, diamonds, and mother-of-pearl. Only 10 pieces exist.'),
(150, 22, '', 'de', 'Tabbah Saga Sea Uhr – Seltene Limitierte Edition', 'Tabbah Uhr, Modell Saga Sea.\r\nNur 10 Stück weltweit produziert.\r\n\r\nEmaille auf dem Zifferblatt von den Schweizer Meistern Olivier und Dominique Vaucher gefertigt.\r\nMuschel aus Perlmutt und Weißgold.\r\n\r\nGehäuse aus Gold, mit Diamanten besetzt.\r\nUrsprünglicher Preis: 215.000 $.', 'Tabbah Saga Sea Uhr – Limitierte Edition, nur 10 Stück', 'Seltene Tabbah Saga Sea Uhr. Schweizer Handwerk, Gold, Diamanten, Perlmutt. Nur 10 Exemplare existieren.'),
(151, 22, '', 'es', 'Reloj Tabbah Saga Sea – Rara Edición Limitada', 'Reloj de la marca Tabbah, modelo Saga Sea.\r\nSolo se produjeron 10 unidades.\r\n\r\nEsmalte de la esfera realizado por los maestros suizos Olivier y Dominique Vaucher.\r\nConcha en nácar y oro blanco.\r\n\r\nCaja de oro con diamantes.\r\nPrecio original: 215.000 $.', 'Reloj Tabbah Saga Sea – Edición Limitada, Solo 10 Unidades', 'Reloj raro Tabbah Saga Sea. Artesanía suiza, oro, diamantes y nácar. Solo existen 10 ejemplares.'),
(152, 22, '', 'fr', 'Montre Tabbah Saga Sea – Rare Édition Limitée', 'Montre de la maison Tabbah, modèle Saga Sea.\r\nSeulement 10 exemplaires produits.\r\n\r\nÉmail du cadran réalisé par les maîtres suisses Olivier et Dominique Vaucher.\r\nCoquillage en nacre et or blanc.\r\n\r\nBoîtier en or serti de diamants.\r\nPrix d’origine : 215 000 $.', 'Montre Tabbah Saga Sea – Édition Limitée, 10 Exemplaires', 'Montre rare Tabbah Saga Sea. Artisanat suisse, or, diamants et nacre. Édition limitée à 10 exemplaires.'),
(153, 22, '', 'ja', 'タバー Saga Sea ウォッチ – 希少な限定版', 'タバーの時計、Saga Sea モデル。\r\n世界でわずか10本のみ製造。\r\n\r\n文字盤のエナメルは、スイスの名匠オリヴィエ＆ドミニク・ヴォーシェによる作品。\r\n貝殻は白蝶貝とホワイトゴールドで制作。\r\n\r\nケースはゴールド製、ダイヤモンドをセッティング。\r\n当初価格：215,000ドル。', 'タバー Saga Sea ウォッチ – 限定10本', '希少なタバー Saga Sea 時計。スイス製作、ゴールド、ダイヤモンド、白蝶貝。世界で10本のみ。'),
(154, 22, '', 'zh', 'Tabbah Saga Sea 手表 – 稀有限量版', 'Tabbah 品牌手表，Saga Sea 款式。\r\n全球仅生产 10 枚。\r\n\r\n表盘珐琅由瑞士大师 Olivier 和 Dominique Vaucher 制作。\r\n贝壳装饰采用珍珠母和白金。\r\n\r\n黄金表壳，镶嵌钻石。\r\n原价：215,000 美元。', 'Tabbah Saga Sea 手表 – 限量版，仅 10 枚', '稀有 Tabbah Saga Sea 手表。瑞士工艺，黄金、钻石、珍珠母。全球仅有 10 枚。'),
(155, 23, '', 'ru', 'Часы Chopard Happy Sport – лимитированная серия с бриллиантами', 'Элегантные часы Chopard \"Happy Sport\" с бриллиантами.\r\nЦиферблат «зебра» диаметром 36 мм, кожаный ремешок.\r\n\r\nАртикул № 278475-2003, серийный номер 1502424.\r\nВ комплекте фирменный футляр и сертификат.\r\n\r\nОчень хорошее состояние, как новые.\r\nВыпущено 500 экземпляров.\r\nАктуальная стоимость — 48 420 €.', 'Часы Chopard Happy Sport – лимитированный выпуск, 500 экземпляров', 'Элегантные часы Chopard Happy Sport с бриллиантами, циферблат «зебра», кожаный ремешок. Лимитированная серия, всего 500 экземпляров.'),
(156, 23, '', 'en', 'Chopard Happy Sport Watch – Limited Edition with Diamonds', 'Elegant Chopard \"Happy Sport\" watch with diamonds.\r\n36 mm zebra-pattern dial and leather strap.\r\n\r\nRef. 278475-2003, serial no. 1502424.\r\nComes with original box and certificate.\r\n\r\nVery good condition, like new.\r\nLimited edition of 500 pieces.\r\nCurrent value: €48,420.', 'Chopard Happy Sport Watch – Limited Edition, 500 Pieces', 'Elegant Chopard Happy Sport watch with diamonds, zebra dial and leather strap. Limited edition of 500, excellent condition.'),
(157, 23, '', 'de', 'Chopard Happy Sport Uhr – Limitierte Edition mit Diamanten', 'Elegante Chopard \"Happy Sport\" Uhr mit Diamanten.\r\nZebra-Zifferblatt, 36 mm, Lederarmband.\r\n\r\nRef. 278475-2003, Seriennummer 1502424.\r\nMit Originalbox und Zertifikat.\r\n\r\nSehr guter Zustand, wie neu.\r\nLimitierte Auflage von 500 Stück.\r\nAktueller Wert: 48.420 €.', 'Chopard Happy Sport Uhr – Limitierte Serie, 500 Stück', 'Elegante Chopard Happy Sport Uhr mit Diamanten, Zebra-Zifferblatt und Lederarmband. Limitierte Serie, 500 Exemplare.'),
(158, 23, '', 'es', 'Reloj Chopard Happy Sport – Edición Limitada con Diamantes', 'Elegante reloj Chopard \"Happy Sport\" con diamantes.\r\nEsfera con diseño cebra de 36 mm, correa de cuero.\r\n\r\nRef. 278475-2003, nº de serie 1502424.\r\nIncluye estuche original y certificado.\r\n\r\nMuy buen estado, como nuevo.\r\nEdición limitada de 500 unidades.\r\nValor actual: 48.420 €.', 'Reloj Chopard Happy Sport – Edición Limitada, 500 Unidades', 'Reloj Chopard Happy Sport con diamantes, esfera cebra y correa de cuero. Serie limitada de 500 piezas, excelente estado.'),
(159, 23, '', 'fr', 'Montre Chopard Happy Sport – Édition Limitée avec Diamants', 'Élégante montre Chopard \"Happy Sport\" sertie de diamants.\r\nCadran zébré de 36 mm, bracelet en cuir.\r\n\r\nRéf. 278475-2003, n° de série 1502424.\r\nLivrée avec boîte et certificat d’origine.\r\n\r\nTrès bon état, comme neuve.\r\nÉdition limitée à 500 exemplaires.\r\nValeur actuelle : 48 420 €.', 'Montre Chopard Happy Sport – Édition Limitée, 500 Exemplaires', 'Montre Chopard Happy Sport avec diamants, cadran zébré et bracelet cuir. Édition limitée à 500 pièces, excellent état.'),
(160, 23, '', 'ja', 'ショパール Happy Sport ウォッチ – ダイヤ付き限定版', 'エレガントなショパール「Happy Sport」ダイヤモンドウォッチ。\r\n36mm ゼブラ模様の文字盤、レザーストラップ。\r\n\r\nRef. 278475-2003、シリアル番号 1502424。\r\nオリジナルボックスと証明書付き。\r\n\r\n非常に良い状態、ほぼ新品同様。\r\n限定 500 本。\r\n現在の価値：48,420€。', 'ショパール Happy Sport – 限定500本', 'ショパール Happy Sport ダイヤモンドウォッチ。ゼブラ文字盤、レザーストラップ。限定500本、優れた状態。'),
(161, 23, '', 'zh', '萧邦 Happy Sport 腕表 – 限量版镶钻', '优雅的萧邦“Happy Sport”腕表，镶嵌钻石。\r\n36 毫米斑马纹表盘，皮革表带。\r\n\r\n型号 278475-2003，序列号 1502424。\r\n附原装表盒和证书。\r\n\r\n品相极佳，如新。\r\n限量 500 枚。\r\n现价：48,420 欧元。', '萧邦 Happy Sport 腕表 – 限量500枚', '萧邦 Happy Sport 镶钻腕表，斑马纹表盘，皮革表带。限量500枚，状态极佳。'),
(162, 24, '', 'ru', 'Серьги-клипсы винтаж Guy Laroche Paris', 'Винтажные серьги-клипсы от Guy Laroche Paris.\r\nСостояние хорошее.', 'Серьги-клипсы Guy Laroche Paris – винтаж, хорошее состояние', 'Винтажные серьги-клипсы Guy Laroche Paris. Элегантное украшение в хорошем состоянии.');
INSERT INTO `productstranslation` (`id`, `product_id`, `slug`, `locale`, `title`, `description`, `meta_title`, `meta_description`) VALUES
(163, 24, '', 'en', 'Vintage Guy Laroche Paris Clip-On Earrings', 'Vintage clip-on earrings by Guy Laroche Paris.\r\nGood condition.', 'Guy Laroche Paris Clip-On Earrings – Vintage, Good Condition', 'Vintage Guy Laroche Paris clip-on earrings. Elegant jewelry piece in good condition.'),
(164, 24, '', 'de', 'Vintage Guy Laroche Paris Clip-Ohrringe', 'Vintage Clip-Ohrringe von Guy Laroche Paris.\r\nGuter Zustand.', 'Guy Laroche Paris Clip-Ohrringe – Vintage, guter Zustand', 'Vintage Clip-Ohrringe von Guy Laroche Paris. Elegantes Schmuckstück im guten Zustand.'),
(165, 24, '', 'es', 'Pendientes vintage clip Guy Laroche Paris', 'Pendientes de clip vintage de Guy Laroche Paris.\r\nEn buen estado.', 'Pendientes de clip Guy Laroche Paris – Vintage, buen estado', 'Pendientes de clip Guy Laroche Paris – Vintage, buen estado'),
(166, 24, '', 'fr', 'Boucles d’oreilles vintage clip Guy Laroche Paris', 'Boucles d’oreilles clip vintage de Guy Laroche Paris.\r\nBon état.', 'Boucles d’oreilles clip Guy Laroche Paris – Vintage, bon état', 'Boucles d’oreilles clip vintage Guy Laroche Paris. Bijou élégant en bon état.'),
(167, 24, '', 'ja', 'ヴィンテージ Guy Laroche Paris クリップイヤリング', 'Guy Laroche Paris のヴィンテージクリップイヤリング。\r\n状態：良好。', 'Guy Laroche Paris クリップイヤリング – ヴィンテージ、良好な状態', 'ヴィンテージ Guy Laroche Paris クリップイヤリング。エレガントで良好な状態のジュエリー。'),
(168, 24, '', 'zh', '复古 Guy Laroche Paris 耳夹', 'Guy Laroche Paris 复古耳夹。\r\n品相良好。', 'Guy Laroche Paris 耳夹 – 复古，良好状态', '复古 Guy Laroche Paris 耳夹。优雅首饰，保存良好。'),
(169, 25, '', 'ru', 'Очки Cartier Piccadilly с позолотой и градиентными линзами', 'Позолоченные очки Cartier Piccadilly с градиентными коричневыми линзами огранки «бриллиант».\r\nВ комплект входит коробка и сертификат подлинности Cartier.', 'Очки Cartier Piccadilly – позолоченные, градиентные линзы, сертификат', 'Позолоченные очки Cartier Piccadilly с градиентными коричневыми линзами. В комплекте коробка и сертификат подлинности.'),
(170, 25, '', 'en', 'Cartier Piccadilly Sunglasses with Gold Plating and Gradient Lenses', 'Gold-plated Cartier Piccadilly sunglasses with diamond-cut brown gradient lenses.\r\nComes with Cartier box and certificate of authenticity.', 'Cartier Piccadilly Sunglasses – Gold-Plated, Gradient Lenses, Authenticity Certificate', 'Gold-plated Cartier Piccadilly sunglasses with brown gradient lenses. Includes box and Cartier authenticity certificate.'),
(171, 25, '', 'de', 'Cartier Piccadilly Sonnenbrille mit Vergoldung und Farbverlaufgläsern', 'Vergoldete Cartier Piccadilly Sonnenbrille mit braunen Farbverlaufgläsern im Diamantschliff.\r\nGeliefert mit Cartier-Box und Echtheitszertifikat.', 'Cartier Piccadilly Sonnenbrille – vergoldet, Farbverlaufgläser, Echtheitszertifikat', 'Vergoldete Cartier Piccadilly Sonnenbrille mit braunen Farbverlaufgläsern. Inklusive Box und Echtheitszertifikat.'),
(172, 25, '', 'es', 'Gafas de sol Cartier Piccadilly doradas con lentes degradadas', 'Gafas Cartier Piccadilly bañadas en oro con lentes marrones degradadas de corte diamante.\r\nIncluye caja y certificado de autenticidad Cartier.', 'Gafas Cartier Piccadilly – Doradas, lentes degradadas, certificado autenticidad', 'Gafas de sol Cartier Piccadilly bañadas en oro con lentes degradadas. Se entregan con caja y certificado de autenticidad.'),
(173, 25, '', 'fr', 'Lunettes de soleil Cartier Piccadilly dorées avec verres dégradés', 'Lunettes Cartier Piccadilly dorées avec verres bruns dégradés taillés en diamant.\r\nLivrées avec boîte et certificat d’authenticité Cartier.', 'Lunettes Cartier Piccadilly – Dorées, verres dégradés, certificat d’authenticité', 'Lunettes de soleil Cartier Piccadilly dorées avec verres dégradés bruns. Fournies avec boîte et certificat d’authenticité.'),
(174, 25, '', 'ja', 'カルティエ Piccadilly サングラス ゴールドプレート & グラデーションレンズ', 'ゴールドプレート仕様のカルティエ Piccadilly サングラス。ブラウングラデーションのダイヤモンドカットレンズ。\r\nカルティエの箱と真正証明書付き。', 'カルティエ Piccadilly サングラス – ゴールドプレート、グラデーションレンズ、真正証明書付き', 'ゴールドプレートのカルティエ Piccadilly サングラス。ブラウングラデーションレンズ。箱と真正証明書付き。'),
(175, 25, '', 'zh', '卡地亚 Piccadilly 金镀层渐变太阳镜', '卡地亚 Piccadilly 金镀层太阳镜，棕色渐变钻石切割镜片。\r\n附带卡地亚原装盒和真品证书。', '卡地亚 Piccadilly 太阳镜 – 金镀层，渐变镜片，真品证书', '卡地亚 Piccadilly 金镀层太阳镜，棕色渐变镜片。配原装盒和卡地亚真品证书。'),
(176, 26, '', 'ru', 'Часы Patek Philippe Aquanaut 5066A, 2004 год', 'Часы Patek Philippe Aquanaut 5066A, выпущенные в 2004 году.\r\nИдеальное состояние: носились несколько раз в год, проходили регулярное сервисное обслуживание в мастерской.', 'Часы Patek Philippe Aquanaut 5066A – 2004 год, идеальное состояние', 'Patek Philippe Aquanaut 5066A, 2004 год. Идеальное состояние, носились редко, сервисное обслуживание проведено.'),
(177, 26, '', 'en', 'Patek Philippe Aquanaut 5066A Watch, 2004', 'Patek Philippe Aquanaut 5066A watch, released in 2004.\r\nIn excellent condition: worn only a few times per year, with regular service maintenance.', 'Patek Philippe Aquanaut 5066A – 2004, Excellent Condition', 'Patek Philippe Aquanaut 5066A, 2004 release. Rarely worn, perfect condition, regularly serviced.'),
(178, 26, '', 'de', 'Patek Philippe Aquanaut 5066A Uhr, 2004', 'Patek Philippe Aquanaut 5066A, Baujahr 2004.\r\nPerfekter Zustand: nur wenige Male im Jahr getragen, regelmäßig gewartet.', 'Patek Philippe Aquanaut 5066A – 2004, perfekter Zustand', 'Patek Philippe Aquanaut 5066A von 2004. Selten getragen, perfekter Zustand, regelmäßig gewartet.'),
(179, 26, '', 'es', 'Reloj Patek Philippe Aquanaut 5066A, 2004', 'Reloj Patek Philippe Aquanaut 5066A, fabricado en 2004.\r\nEn perfecto estado: usado solo unas pocas veces al año, con mantenimiento periódico en taller.', 'Patek Philippe Aquanaut 5066A – 2004, perfecto estado', 'Reloj Patek Philippe Aquanaut 5066A de 2004. Rara vez usado, en perfecto estado, con servicio regular.'),
(180, 26, '', 'fr', 'Montre Patek Philippe Aquanaut 5066A, 2004', 'Montre Patek Philippe Aquanaut 5066A, sortie en 2004.\r\nÉtat impeccable : portée seulement quelques fois par an, entretien régulier effectué en atelier.', 'Patek Philippe Aquanaut 5066A – 2004, état impeccable', 'Montre Patek Philippe Aquanaut 5066A, édition 2004. Rarement portée, parfait état, service régulier.'),
(181, 26, '', 'ja', 'パテック フィリップ アクアノート 5066A 腕時計, 2004年', '2004年製のパテック フィリップ アクアノート 5066A。\r\nコンディションは完璧：年に数回のみ使用、定期的に工房でメンテナンス済み。', 'パテック フィリップ アクアノート 5066A – 2004年製、完璧な状態', 'パテック フィリップ アクアノート 5066A (2004年)。希少使用、完璧な状態、定期メンテナンス済み。'),
(182, 26, '', 'zh', '百达翡丽 Patek Philippe Aquanaut 5066A 手表，2004年', '百达翡丽 Patek Philippe Aquanaut 5066A，2004年出品。\r\n品相极佳：每年仅佩戴几次，定期在工坊保养。', '百达翡丽 Patek Philippe Aquanaut 5066A – 2004年，完美品相', '百达翡丽 Patek Philippe Aquanaut 5066A，2004年款。极少佩戴，完美状态，定期保养。'),
(183, 27, '', 'ru', 'Золотые часы Longines с механизмом L619.2', 'Золотые часы Longines с калибром L619.2.\r\nПрактически новые, использовались всего несколько раз.', 'Золотые часы Longines – механизм L619.2, почти новые', 'Longines gold с калибром L619.2. Практически новые, использовались всего несколько раз.'),
(184, 27, '', 'en', 'Longines Gold Watch with L619.2 Movement', 'Longines gold watch featuring the L619.2 caliber.\r\nAlmost new, worn only a few times.', 'Longines Gold Watch – L619.2 Movement, Almost New', 'Longines gold watch with L619.2 movement. In near-new condition, worn only a few times.'),
(185, 27, '', 'de', 'Longines Golduhr mit Kaliber L619.2', 'Longines Golduhr mit Kaliber L619.2.\r\nNahezu neuwertig, nur wenige Male getragen.', 'Longines Golduhr – Kaliber L619.2, fast neuwertig', 'Longines Golduhr mit L619.2 Werk. In fast neuwertigem Zustand, nur selten getragen.'),
(186, 27, '', 'es', 'Reloj de oro Longines con movimiento L619.2', 'Reloj Longines de oro con calibre L619.2.\r\nCasi nuevo, usado solo unas pocas veces.', 'Reloj de oro Longines – Movimiento L619.2, casi nuevo', 'Reloj Longines de oro con movimiento L619.2. En estado casi nuevo, usado muy pocas veces.'),
(187, 27, '', 'fr', 'Montre en or Longines avec mouvement L619.2', 'Montre Longines en or équipée du calibre L619.2.\r\nPresque neuve, portée seulement quelques fois.', 'Montre Longines en or – Mouvement L619.2, presque neuve', 'Montre Longines en or avec calibre L619.2. Excellent état, très peu portée.'),
(188, 27, '', 'ja', 'ロンジン ゴールド腕時計 L619.2 ムーブメント搭載', 'L619.2 キャリバー搭載のロンジン ゴールド腕時計。\r\nほぼ新品で、数回のみ使用。', 'ロンジン ゴールド腕時計 – L619.2 ムーブメント、ほぼ新品', 'ロンジン ゴールド腕時計 L619.2 ムーブメント搭載。ほぼ新品、数回のみ着用。'),
(189, 27, '', 'zh', '浪琴 Longines 黄金腕表 L619.2 机芯', '浪琴黄金腕表，搭载 L619.2 机芯。\r\n几乎全新，仅佩戴过几次。', '浪琴 Longines 黄金腕表 – L619.2 机芯，近乎全新', '浪琴 Longines 黄金腕表，配备 L619.2 机芯。近乎全新，仅佩戴几次。'),
(190, 28, '', 'ru', 'Часы Cartier серебряные', 'Серебряные часы Cartier без коробки, застежка не входит в комплект.\r\nСостояние – удовлетворительное.', 'Часы Cartier серебряные – без коробки, удовлетворительное состояние', 'Серебряные часы Cartier в удовлетворительном состоянии. Без коробки, застежка отсутствует.'),
(191, 28, '', 'en', 'Cartier Silver Watch', 'Cartier silver watch without box, clasp not included.\r\nCondition – fair.', 'Cartier Silver Watch – No Box, Fair Condition', 'Cartier silver watch in fair condition. Comes without box, clasp not included.'),
(192, 28, '', 'de', 'Cartier Silberuhr', 'Cartier Silberuhr ohne Box, Schließe nicht im Lieferumfang.\r\nZustand – akzeptabel.', 'Cartier Silberuhr – ohne Box, akzeptabler Zustand', 'Cartier Silberuhr im akzeptablen Zustand. Wird ohne Box geliefert, Schließe fehlt.'),
(193, 28, '', 'es', 'Reloj de plata Cartier', 'Reloj Cartier de plata sin caja, cierre no incluido.\r\nEstado – aceptable.', 'Reloj de plata Cartier – sin caja, estado aceptable', 'Reloj Cartier de plata en estado aceptable. Se entrega sin caja y sin cierre.'),
(194, 28, '', 'fr', 'Montre en argent Cartier', 'Montre Cartier en argent sans boîte, fermoir non inclus.\r\nÉtat – correct.', 'Montre Cartier en argent – sans boîte, état correct', 'Montre Cartier en argent en état correct. Vendue sans boîte, fermoir absent.'),
(195, 28, '', 'ja', 'カルティエ シルバー腕時計', 'カルティエのシルバー腕時計。箱なし、留め具は付属しません。\r\nコンディション：可。', 'カルティエ シルバー腕時計 – 箱なし、可状態', 'カルティエのシルバー腕時計。箱なし、留め具なし。状態は可。'),
(196, 28, '', 'zh', '卡地亚 Cartier 银质腕表', '卡地亚银质腕表，无原装盒，表扣不包含在内。\r\n成色：一般。', '卡地亚 Cartier 银质腕表 – 无盒，成色一般', '卡地亚银质腕表，成色一般。无盒，表扣缺失。'),
(197, 29, '', 'ru', 'Часы Cartier', 'Часы Cartier в хорошем состоянии.', 'Часы Cartier – хорошее состояние', 'Оригинальные часы Cartier в хорошем состоянии.'),
(198, 29, '', 'en', 'Cartier Watch', 'Cartier watch in good condition.', 'Cartier Watch – Good Condition', 'Authentic Cartier watch in good condition.'),
(199, 29, '', 'de', 'Cartier Uhr', 'Cartier Uhr in gutem Zustand.', 'Cartier Uhr – guter Zustand', 'Original Cartier Uhr in gutem Zustand.'),
(200, 29, '', 'es', 'Reloj Cartier', 'Reloj Cartier en buen estado.', 'Reloj Cartier – buen estado', 'Reloj Cartier auténtico en buen estado.'),
(201, 29, '', 'fr', 'Montre Cartier', 'Montre Cartier en bon état.', 'Montre Cartier – bon état', 'Montre Cartier authentique en bon état.'),
(202, 29, '', 'ja', 'カルティエ 腕時計', 'カルティエの腕時計。状態：良好。', 'カルティエ 腕時計 – 良好な状態', '本物のカルティエ腕時計。良好なコンディション。'),
(203, 29, '', 'zh', '卡地亚 Cartier 手表', '卡地亚手表，品相良好。', '卡地亚 Cartier 手表 – 品相良好', '正品卡地亚手表，整体状况良好。'),
(204, 30, '', 'ru', 'Часы Cartier Pasha Chrono Hybrid золото', 'Часы Cartier Pasha Chrono Hybrid, артикул 30009, из 18-каратного золота.\r\nЭлектромеханический механизм, сапфир-кабошон, кожаный ремешок.\r\nВ комплекте: оригинальная коробка Cartier и документ о законном происхождении.', 'Часы Cartier Pasha Chrono Hybrid – золото 18 карат, артикул 30009', 'Часы Cartier Pasha Chrono Hybrid в корпусе из 18-каратного золота. Электромеханический механизм, сапфир-кабошон, кожаный ремешок. В комплекте коробка Cartier и документ о происхождении.'),
(205, 30, '', 'en', 'Cartier Pasha Chrono Hybrid Gold Watch', 'Cartier Pasha Chrono Hybrid, reference 30009, crafted in 18k gold.\r\nElectromechanical movement, sapphire cabochon, leather strap.\r\nComes with original Cartier box and certificate of legal origin.', 'Cartier Pasha Chrono Hybrid – 18k Gold, Ref. 30009', 'Cartier Pasha Chrono Hybrid watch in 18k gold. Electromechanical movement, sapphire cabochon, leather strap. Includes Cartier box and certificate of origin.'),
(206, 30, '', 'de', 'Cartier Pasha Chrono Hybrid Golduhr', 'Cartier Pasha Chrono Hybrid, Referenz 30009, aus 18 Karat Gold.\r\nElektromechanisches Uhrwerk, Saphircabochon, Lederarmband.\r\nGeliefert mit originaler Cartier-Box und Herkunftszertifikat.', 'Cartier Pasha Chrono Hybrid – 18 Karat Gold, Ref. 30009', 'Cartier Pasha Chrono Hybrid Golduhr, 18 Karat. Elektromechanisches Werk, Saphircabochon, Lederarmband. Inklusive Cartier-Box und Zertifikat.'),
(207, 30, '', 'es', 'Reloj Cartier Pasha Chrono Hybrid oro', 'Cartier Pasha Chrono Hybrid, referencia 30009, en oro de 18 quilates.\r\nMovimiento electromecánico, cabujón de zafiro, correa de cuero.\r\nIncluye caja original de Cartier y certificado de procedencia legal.', 'Cartier Pasha Chrono Hybrid – oro 18k, ref. 30009', 'Reloj Cartier Pasha Chrono Hybrid en oro de 18 quilates. Movimiento electromecánico, cabujón de zafiro, correa de cuero. Con caja Cartier y certificado de origen.'),
(208, 30, '', 'fr', 'Montre Cartier Pasha Chrono Hybrid or', 'Cartier Pasha Chrono Hybrid, référence 30009, en or 18 carats.\r\nMouvement électromécanique, cabochon saphir, bracelet en cuir.\r\nLivrée avec boîte Cartier et certificat d’origine légale.', 'Cartier Pasha Chrono Hybrid – or 18 carats, réf. 30009', 'Montre Cartier Pasha Chrono Hybrid en or 18 carats. Mouvement électromécanique, cabochon saphir, bracelet cuir. Avec boîte Cartier et certificat d’origine.'),
(209, 30, '', 'ja', 'カルティエ パシャ Chrono Hybrid ゴールド腕時計', 'カルティエ パシャ Chrono Hybrid、リファレンス30009、18金製。\r\nエレクトロメカニカル ムーブメント、サファイアカボション、レザーストラップ。\r\nカルティエ純正ボックスと真正証明書付き。', 'カルティエ パシャ Chrono Hybrid – 18金、Ref. 30009', 'カルティエ パシャ Chrono Hybrid 18金腕時計。エレクトロメカニカルムーブメント、サファイアカボション、レザーストラップ。純正ボックスと証明書付き。'),
(210, 30, '', 'zh', '卡地亚 Cartier Pasha Chrono Hybrid 黄金腕表', '卡地亚 Pasha Chrono Hybrid，型号 30009，18K 黄金打造。\r\n电机芯，蓝宝石弧面切割，皮革表带。\r\n附带原装 Cartier 盒子和合法来源证明。', '卡地亚 Pasha Chrono Hybrid – 18K 黄金，型号 30009', '卡地亚 Pasha Chrono Hybrid 18K 黄金腕表。电机芯，蓝宝石弧面，皮革表带。配 Cartier 盒子和来源证明。'),
(211, 31, '', 'ru', 'Золотая пряжка для ремня с кроликом Christopher Ross', 'Массивная пряжка для ремня с кроликом из 24-каратного золота от Christopher Ross.\r\nИдеальный подарок для любителей животных или поклонников скульптурных украшений.\r\nChristopher Ross – скульптор из Нью-Йорка, чьи работы выставлялись в Метрополитен-музее, Йельской художественной галерее, Бостонском музее изящных искусств, Большом Эрмитаже и Национальных музеях Шотландии.\r\n\r\nРазмеры: 8 дюймов × 3 дюйма.\r\nПодходит для ремешка до 1,5 дюйма (ремешок не входит).\r\nКлеймо CHRISTOPHER ROSS, 1987.\r\nБывшая в употреблении/винтажная, минимальные следы износа.\r\nОригинальная коробка отсутствует.', 'Золотая пряжка для ремня Christopher Ross – кролик, 24К, винтаж', 'Винтажная золотая пряжка Christopher Ross с кроликом, 24К золота, 1987 год. Размер 8×3 дюйма, ремешок до 1,5 дюйма. Минимальные следы износа.'),
(212, 31, '', 'en', 'Christopher Ross Gold Bunny Belt Buckle', 'Massive 24k gold bunny belt buckle by Christopher Ross.\r\nPerfect for animal lovers or fans of sculptural jewelry.\r\nChristopher Ross, a New York sculptor, exhibited works at the Metropolitan Museum of Art, Yale University Art Gallery, Museum of Fine Arts Boston, Hermitage Museum, and National Museums of Scotland.\r\n\r\nDimensions: 8\" × 3\".\r\nFits belts up to 1.5\" wide (belt not included).\r\nStamped CHRISTOPHER ROSS, 1987.\r\nVintage, minimal signs of wear. Original box not included.', 'Christopher Ross Gold Bunny Belt Buckle – 24K, Vintage', 'Vintage 24k gold bunny belt buckle by Christopher Ross, 1987. Size 8×3\", fits belts up to 1.5\". Minimal wear, original box not included.'),
(213, 31, '', 'de', 'Christopher Ross Goldene Hasen-Gürtelschnalle', 'Massive 24-karätige Gold-Gürtelschnalle mit Hasenmotiv von Christopher Ross.\r\nPerfekt für Tierliebhaber oder Fans von skulpturalem Schmuck.\r\nChristopher Ross, New Yorker Bildhauer, stellte Werke im Metropolitan Museum of Art, Yale University Art Gallery, Museum of Fine Arts Boston, Hermitage Museum und National Museums of Scotland aus.\r\n\r\nMaße: 8\" × 3\".\r\nFür Gürtel bis 1,5\" Breite geeignet (Gürtel nicht enthalten).\r\nGeprägt: CHRISTOPHER ROSS, 1987.\r\nVintage, minimale Gebrauchsspuren. Originalverpackung fehlt.', 'Christopher Ross Goldene Hasen-Gürtelschnalle – 24K, Vintage', 'Vintage Gürtelschnalle mit Hasenmotiv von Christopher Ross, 24K Gold, 1987. Maße 8×3\", für Gürtel bis 1,5\" geeignet. Minimale Gebrauchsspuren, keine Originalverpackung.'),
(214, 31, '', 'es', 'Hebilla de cinturón de oro con conejo Christopher Ross', 'Hebilla de cinturón masiva en oro de 24 quilates con conejo, por Christopher Ross.\r\nPerfecta para amantes de los animales o fans de joyería escultórica.\r\nChristopher Ross, escultor de Nueva York, expuso en el Metropolitan Museum of Art, Yale University Art Gallery, Museum of Fine Arts Boston, Hermitage Museum y National Museums of Scotland.\r\n\r\nDimensiones: 8\" × 3\".\r\nApta para cinturones de hasta 1,5\" de ancho (cinturón no incluido).\r\nSello: CHRISTOPHER ROSS, 1987.\r\nVintage, con mínimas señales de uso. Caja original no incluida.', 'Hebilla de cinturón de oro Christopher Ross – 24K, Vintage', 'Hebilla de cinturón vintage con conejo de Christopher Ross, oro 24K, 1987. Tamaño 8×3\", cinturones hasta 1,5\". Uso mínimo, sin caja original.'),
(215, 31, '', 'fr', 'Boucle de ceinture lapin en or Christopher Ross', 'Boucle de ceinture massive en or 24 carats avec motif lapin par Christopher Ross.\r\nParfaite pour les amoureux des animaux ou les amateurs de bijoux sculpturaux.\r\nChristopher Ross, sculpteur new-yorkais, exposé au Metropolitan Museum of Art, Yale University Art Gallery, Museum of Fine Arts Boston, Musée de l’Ermitage et National Museums of Scotland.\r\n\r\nDimensions : 8\" × 3\".\r\nConvient pour des ceintures jusqu’à 1,5\" de large (ceinture non incluse).\r\nPoinçon CHRISTOPHER ROSS, 1987.\r\nVintage, traces d’usure minimes. Boîte d’origine non incluse.', 'Boucle de ceinture lapin en or Christopher Ross – 24K, Vintage', 'Boucle de ceinture lapin vintage Christopher Ross, or 24K, 1987. Dimensions 8×3\", pour ceintures jusqu’à 1,5\". Usure minimale, boîte originale non incluse.'),
(216, 31, '', 'ja', 'クリストファー・ロス 24K ゴールド バニー ベルトバックル', 'クリストファー・ロスによる24金製バニー（ウサギ）ベルトバックル。\r\n動物愛好家や彫刻ジュエリーファンに最適。\r\nニューヨークの彫刻家クリストファー・ロスの作品は、メトロポリタン美術館、イェール大学美術館、ボストン美術館、エルミタージュ美術館、スコットランド国立博物館に展示されました。\r\n\r\nサイズ：8インチ × 3インチ。\r\nベルト幅最大1.5インチまで対応（ベルトは含まれません）。\r\n刻印：CHRISTOPHER ROSS, 1987。\r\nヴィンテージ、使用感ほとんどなし。オリジナルボックスなし。', 'クリストファー・ロス ゴールド バニー ベルトバックル – 24K、ヴィンテージ', 'クリストファー・ロス 24K ゴールド バニー ベルトバックル、1987年製。サイズ8×3インチ、ベルト幅最大1.5インチ対応。使用感少なめ、オリジナルボックスなし。'),
(217, 31, '', 'zh', 'Christopher Ross 24K 黄金兔子腰带扣', 'Christopher Ross 24K 黄金兔子腰带扣，造型硕大。\r\n非常适合动物爱好者或雕塑饰品收藏者。\r\n纽约雕塑家 Christopher Ross 的作品曾在大都会艺术博物馆、耶鲁大学艺术馆、波士顿美术馆、艾尔米塔什博物馆及苏格兰国家博物馆展出。\r\n\r\n尺寸：8 × 3 英寸。\r\n适用于宽度不超过 1.5 英寸的腰带（不含腰带）。\r\n印记：CHRISTOPHER ROSS, 1987。\r\n复古品，使用痕迹极少。无原装盒。', 'Christopher Ross 黄金兔子腰带扣 – 24K，复古', '复古 Christopher Ross 24K 黄金兔子腰带扣，1987年款。尺寸8×3英寸，适合1.5英寸以内腰带。轻微使用痕迹，无原装盒。'),
(218, 32, '', 'ru', 'Набор галстуков E.Marinella', 'Лот из 9 галстуков E.Marinella. Бесподобное качество и изысканность.', 'Набор галстуков E.Marinella – 9 штук, высочайшее качество', 'Лот из 9 галстуков E.Marinella. Роскошные ткани, исключительное качество и элегантный дизайн.'),
(219, 32, '', 'en', 'E.Marinella Tie Set', 'Set of 9 E.Marinella ties. Unmatched quality and elegance.', 'E.Marinella Tie Set – 9 Pieces, Premium Quality', 'Set of 9 E.Marinella ties. Luxurious fabrics, exceptional quality, and refined design.'),
(220, 32, '', 'de', 'E.Marinella Krawatten Set', 'Lot mit 9 E.Marinella Krawatten. Unvergleichliche Qualität und Eleganz.', 'E.Marinella Krawatten Set – 9 Stück, Premium Qualität', 'Lot mit 9 E.Marinella Krawatten. Luxuriöse Stoffe, herausragende Qualität und elegantes Design.'),
(221, 32, '', 'es', 'Set de corbatas E.Marinella', 'Lote de 9 corbatas E.Marinella. Calidad y elegancia incomparables.', 'Set de corbatas E.Marinella – 9 piezas, calidad premium', 'Lote de 9 corbatas E.Marinella. Tejidos lujosos, calidad excepcional y diseño refinado.'),
(222, 32, '', 'fr', 'Lot de cravates E.Marinella', 'Lot de 9 cravates E.Marinella. Qualité et élégance incomparables.', 'Lot de cravates E.Marinella – 9 pièces, qualité supérieure', 'Lot de 9 cravates E.Marinella. Tissus luxueux, qualité exceptionnelle et design raffiné.'),
(223, 32, '', 'ja', 'E.Marinella ネクタイセット', 'E.Marinella のネクタイ9本セット。比類なき品質とエレガンス。', 'E.Marinella ネクタイセット – 9本入り、高品質', 'E.Marinella のネクタイ9本セット。高級生地、優れた品質、洗練されたデザイン。'),
(224, 32, '', 'zh', 'E.Marinella 领带套装', '9 条 E.Marinella 领带套装。无与伦比的品质与优雅。', 'E.Marinella 领带套装 – 9 条，高端品质', '9 条 E.Marinella 领带套装。奢华面料，卓越品质，精致设计。'),
(225, 33, '', 'ru', 'Серебристый зеркальный чемодан Louis Vuitton Vachetta Cotteville 40', 'Чемодан Louis Vuitton, модель Vachetta Cotteville 40 серебристое зеркало с монограммой из винила и воловьей кожи.\r\nСерийный номер: 2017689, год изготовления: 2021.\r\nПол: унисекс.\r\n\r\nВ комплекте: сумка для пыли Louis Vuitton, коробка, багажная бирка, колокольчик, ключи.\r\nПодлинность подтверждена штампом с датой (Сделано во Франции).\r\n\r\nРазмеры: 41 × 31 × 15 см.\r\nВ очень хорошем состоянии, использовался всего пару раз.', 'Чемодан Louis Vuitton Vachetta Cotteville 40 – серебристый, 2021, очень хорошее состояние', 'Серебристый зеркальный чемодан Louis Vuitton Vachetta Cotteville 40, 2021 года. Комплект: коробка, пыльник, багажная бирка, колокольчик, ключи. Минимальное использование, отличное состояние.'),
(226, 33, '', 'en', 'Louis Vuitton Vachetta Cotteville 40 Silver Mirror Suitcase', 'Louis Vuitton Vachetta Cotteville 40 suitcase with silver mirror finish, vinyl monogram, and cowhide leather.\r\nSerial number: 2017689, year: 2021.\r\nUnisex.\r\n\r\nIncludes: Louis Vuitton dust bag, box, luggage tag, bell, keys.\r\nAuthenticity confirmed by date stamp (Made in France).\r\n\r\nDimensions: 41 × 31 × 15 cm.\r\nExcellent condition, used only a few times.', 'Louis Vuitton Vachetta Cotteville 40 Suitcase – Silver, 2021, Excellent Condition', 'Louis Vuitton Vachetta Cotteville 40 silver mirror suitcase, 2021. Includes box, dust bag, luggage tag, bell, keys. Minimal use, excellent condition.'),
(227, 33, '', 'de', 'Louis Vuitton Vachetta Cotteville 40 Silberkoffer', 'Louis Vuitton Vachetta Cotteville 40 Koffer, silberner Spiegel, Vinyl-Monogramm und Rindsleder.\r\nSeriennummer: 2017689, Herstellungsjahr: 2021.\r\nUnisex.\r\n\r\nLieferumfang: Louis Vuitton Staubbeutel, Box, Gepäckanhänger, Glocke, Schlüssel.\r\nEchtheit bestätigt durch Datumstempel (Hergestellt in Frankreich).\r\n\r\nMaße: 41 × 31 × 15 cm.\r\nSehr guter Zustand, nur wenige Male benutzt.', 'Louis Vuitton Vachetta Cotteville 40 Koffer – Silber, 2021, sehr guter Zustand', 'Louis Vuitton Vachetta Cotteville 40 Silberkoffer, Baujahr 2021. Mit Box, Staubbeutel, Gepäckanhänger, Glocke, Schlüssel. Kaum benutzt, sehr guter Zustand.'),
(228, 33, '', 'es', 'Maleta Louis Vuitton Vachetta Cotteville 40 espejo plateado', 'Maleta Louis Vuitton Vachetta Cotteville 40 con acabado espejo plateado, monograma de vinilo y cuero de vaca.\r\nNúmero de serie: 2017689, año: 2021.\r\nUnisex.\r\n\r\nIncluye: bolsa de polvo Louis Vuitton, caja, etiqueta de equipaje, campanilla, llaves.\r\nAutenticidad confirmada por sello de fecha (Hecho en Francia).\r\n\r\nDimensiones: 41 × 31 × 15 cm.\r\nExcelente estado, usado solo un par de veces.', 'Maleta Louis Vuitton Vachetta Cotteville 40 – Plateada, 2021, Excelente Estado', 'Maleta Louis Vuitton Vachetta Cotteville 40 espejo plateado, 2021. Incluye caja, bolsa de polvo, etiqueta, campanilla, llaves. Uso mínimo, excelente estado.'),
(229, 33, '', 'fr', 'Valise Louis Vuitton Vachetta Cotteville 40 miroir argenté', 'Valise Louis Vuitton Vachetta Cotteville 40, finition miroir argenté, monogramme en vinyle et cuir de vache.\r\nNuméro de série : 2017689, année : 2021.\r\nUnisexe.\r\n\r\nComprend : housse Louis Vuitton, boîte, étiquette de bagage, clochette, clés.\r\nAuthenticité confirmée par estampille de date (Fabriqué en France).\r\n\r\nDimensions : 41 × 31 × 15 cm.\r\nEn très bon état, utilisé seulement quelques fois.', 'Valise Louis Vuitton Vachetta Cotteville 40 – Argentée, 2021, excellent état', 'Valise Louis Vuitton Vachetta Cotteville 40 miroir argenté, 2021. Comprend boîte, housse, étiquette, clochette, clés. Utilisation minimale, excellent état.'),
(230, 33, '', 'ja', 'ルイ・ヴィトン Vachetta Cotteville 40 シルバーミラー スーツケース', 'ルイ・ヴィトン Vachetta Cotteville 40 スーツケース、シルバーミラー仕上げ、ビニールモノグラム、カウハイドレザー。\r\nシリアル番号：2017689、製造年：2021。\r\nユニセックス。\r\n\r\n付属品：ルイ・ヴィトン ダストバッグ、ボックス、ラゲッジタグ、ベル、キー。\r\n製造年スタンプで本物を確認済み（フランス製）。\r\n\r\nサイズ：41 × 31 × 15 cm。\r\n非常に良い状態、数回のみ使用。', 'ルイ・ヴィトン Vachetta Cotteville 40 スーツケース – シルバー、2021年製、良好状態', 'ルイ・ヴィトン Vachetta Cotteville 40 シルバーミラー スーツケース、2021年製。ボックス、ダストバッグ、ラゲッジタグ、ベル、キー付き。使用ほとんどなし、良好状態。'),
(231, 33, '', 'zh', '路易威登 Louis Vuitton Vachetta Cotteville 40 银镜行李箱', 'Louis Vuitton Vachetta Cotteville 40 行李箱，银镜面、乙烯基字母标志和牛皮材质。\r\n序列号：2017689，年份：2021。\r\n男女通用。\r\n\r\n配件：Louis Vuitton 防尘袋、盒子、行李标签、铃铛、钥匙。\r\n通过日期印记确认正品（法国制造）。\r\n\r\n尺寸：41 × 31 × 15 厘米。\r\n状况非常好，仅使用过几次。', 'Louis Vuitton Vachetta Cotteville 40 行李箱 – 银色，2021，极佳状态', 'Louis Vuitton Vachetta Cotteville 40 银镜行李箱，2021年。包含盒子、防尘袋、行李标签、铃铛、钥匙。使用极少，状态极佳。'),
(232, 34, '', 'ru', 'Металлофон Fuzeau Metallonotes ', 'Красочный металлофон Fuzeau Metallonotes с привлекательным дизайном, пробуждающим музыкальное любопытство у детей.\r\nПодходит для маленьких рук от 3 лет – раннее знакомство с музыкой.\r\nПрост в использовании благодаря цветным пластинам и молоточкам в комплекте.\r\n\r\nПортативный: с ручкой и футляром можно играть где угодно.\r\nУниверсален: обучение нотам, воспроизведение простых мелодий, исследование звука.\r\nОчень хорошее качество и великолепный звук. Игрушка в хорошем состоянии.', 'Металлофон Fuzeau Metallonotes – детский музыкальный инструмент, 3+', 'Красочный металлофон Fuzeau Metallonotes для детей от 3 лет. Цветные пластины, молоточки, портативный футляр. Отличное качество, великолепный звук.'),
(233, 34, '', 'en', 'Fuzeau Metallonotes Xylophone', 'Colorful Fuzeau Metallonotes xylophone with an attractive design that sparks children’s musical curiosity.\r\nSuitable for small hands from age 3 – an early introduction to music.\r\nEasy to use with colored bars and included mallets.\r\n\r\nPortable: comes with a handle and case, can be played anywhere.\r\nVersatile: learn notes, play simple melodies, and explore sounds.\r\nVery good quality, excellent sound. Toy in good condition.', 'Fuzeau Metallonotes Xylophone – Musical Toy for Kids 3+', 'Colorful Fuzeau Metallonotes xylophone for children from 3 years. With mallets, case, and handle. Excellent sound quality, good condition.'),
(234, 34, '', 'de', 'Fuzeau Metallonotes Xylophon', 'Farbenfrohes Fuzeau Metallonotes Xylophon mit attraktivem Design, das die musikalische Neugier von Kindern weckt.\r\nGeeignet für kleine Hände ab 3 Jahren – früher Einstieg in die Musik.\r\nEinfache Handhabung dank farbiger Platten und beiliegender Schlägel.\r\n\r\nTragbar: mit Griff und Etui, überall spielbar.\r\nVielseitig: Noten lernen, einfache Melodien spielen und Klänge erforschen.\r\nSehr gute Qualität, hervorragender Klang. Spielzeug in gutem Zustand.', 'Fuzeau Metallonotes Xylophon – Musikinstrument für Kinder ab 3 Jahren', 'Farbenfrohes Fuzeau Metallonotes Xylophon für Kinder ab 3 Jahren. Mit Schlägeln und Tragetasche. Hervorragender Klang, guter Zustand.'),
(235, 34, '', 'es', 'Metalófono Fuzeau Metallonotes', 'Metalófono Fuzeau Metallonotes colorido con diseño atractivo que despierta la curiosidad musical de los niños.\r\nAdecuado para manos pequeñas a partir de 3 años – introducción temprana a la música.\r\nFácil de usar con placas de colores y mazos incluidos.\r\n\r\nPortátil: con asa y estuche, se puede tocar en cualquier lugar.\r\nVersátil: aprender notas, tocar melodías simples y explorar sonidos.\r\nMuy buena calidad y excelente sonido. Juguete en buen estado.', 'Metalófono Fuzeau Metallonotes – juguete musical infantil 3+', 'Metalófono Fuzeau Metallonotes colorido para niños desde 3 años. Incluye mazos y estuche portátil. Excelente sonido, buen estado.'),
(236, 34, '', 'fr', 'Métallophone Fuzeau Metallonotes ', 'Métallophone Fuzeau Metallonotes coloré au design attrayant, éveillant la curiosité musicale des enfants.\r\nAdapté aux petites mains dès 3 ans – une première approche de la musique.\r\nFacile à utiliser grâce aux lames colorées et aux maillets inclus.\r\n\r\nPortable : avec poignée et étui, peut être joué partout.\r\nPolyvalent : apprentissage des notes, jeu de mélodies simples et exploration des sons.\r\nTrès bonne qualité, son superbe. Jouet en bon état.', 'Métallophone Fuzeau Metallonotes – jouet musical enfant 3+', 'Métallophone Fuzeau Metallonotes coloré pour enfants dès 3 ans. Avec maillets et étui portable. Très bonne qualité sonore, bon état.'),
(237, 34, '', 'ja', 'Fuzeau Metallonotes', 'カラフルで魅力的なデザインの Fuzeau Metallonotes メタロフォンは、子供たちの音楽的好奇心を育みます。\r\n3歳からの小さな手に最適 – 音楽への早期導入。\r\nカラフルな鍵盤と付属のマレットで簡単に演奏できます。\r\n\r\n持ち運び可能：ハンドル付きケースでどこでも演奏可能。\r\n多用途：音符の学習、簡単なメロディーの演奏、音の探求。\r\nとても良い品質、素晴らしい音。良好な状態のおもちゃです。', 'Fuzeau Metallonotes メタロフォン – 子供用楽器 3歳以上', 'Fuzeau Metallonotes カラフルな子供用メタロフォン。マレットとケース付き。高音質、良好な状態。'),
(238, 34, '', 'zh', 'Fuzeau Metallonotes', 'Fuzeau Metallonotes 彩色金属琴，设计吸引人，激发儿童的音乐好奇心。\r\n适合 3 岁以上小手 – 早期音乐启蒙。\r\n彩色音条，附带敲槌，使用简单。\r\n\r\n便携式：带手柄和琴盒，可随时随地演奏。\r\n多功能：学习音符、演奏简单旋律、探索声音。\r\n品质优良，音色出色。玩具状况良好。', 'Fuzeau Metallonotes 儿童金属琴 – 音乐玩具 3+', 'Fuzeau Metallonotes 彩色儿童金属琴，适合 3 岁以上。附带敲槌和琴盒。音质优秀，保存良好。'),
(239, 35, '', 'ru', 'Сет колье и серьги Orena винтаж', 'Элегантный сет украшений Orena: колье и серьги.\r\nИзготовлены из металла с эмалью, в хорошем состоянии.\r\nСтильный винтажный комплект, подходящий как для повседневного образа, так и для особых случаев.', 'Сет колье и серьги Orena – винтажный комплект украшений', 'Винтажный сет украшений Orena: колье и серьги из металла с эмалью. Хорошее состояние, элегантный стиль.'),
(240, 35, '', 'en', 'Orena Necklace and Earrings Set – Vintage', 'Elegant Orena jewelry set: necklace and earrings.\r\nMade of metal with enamel, in good condition.\r\nA stylish vintage set, perfect for both everyday wear and special occasions.', 'Orena Vintage Jewelry Set – Necklace and Earrings', 'Vintage Orena set: necklace and earrings in metal with enamel. Good condition, elegant design.'),
(241, 35, '', 'de', 'Orena Schmuckset Halskette & Ohrringe – Vintage', 'Description:\r\nElegantes Schmuckset von Orena: Halskette und Ohrringe.\r\nGefertigt aus Metall mit Emaille, in gutem Zustand.\r\nEin stilvolles Vintage-Set, ideal für Alltag und besondere Anlässe.', 'Orena Vintage Schmuckset – Halskette und Ohrringe', 'Vintage Orena Set: Halskette und Ohrringe aus Metall mit Emaille. Guter Zustand, elegantes Design.'),
(242, 35, '', 'es', 'Conjunto vintage Orena – Collar y pendientes', 'Elegante conjunto de joyería Orena: collar y pendientes.\r\nRealizado en metal con esmalte, en buen estado.\r\nUn set vintage con estilo, perfecto para uso diario o eventos especiales.', 'Conjunto Orena vintage – Collar y pendientes', 'Set vintage Orena: collar y pendientes de metal con esmalte. Buen estado, diseño elegante.'),
(243, 35, '', 'fr', 'Parure collier et boucles d’oreilles Orena – Vintage', 'Élégante parure Orena : collier et boucles d’oreilles.\r\nRéalisée en métal et émail, en bon état.\r\nUn ensemble vintage raffiné, parfait au quotidien ou pour des occasions spéciales.', 'Parure vintage Orena – collier et boucles d’oreilles', 'Ensemble Orena vintage : collier et boucles d’oreilles en métal et émail. Bon état, style élégant.'),
(244, 35, '', 'ja', 'オレナ ネックレス＆イヤリングセット – ヴィンテージ', 'エレガントなオレナのジュエリーセット：ネックレスとイヤリング。\r\n金属とエナメル製で、良好なコンディション。\r\n日常使いにも特別なシーンにも合うスタイリッシュなヴィンテージセット。', 'オレナ ヴィンテージジュエリーセット – ネックレス＆イヤリング', 'オレナのヴィンテージセット：金属とエナメルのネックレス＆イヤリング。良好な状態、エレガントなデザイン。'),
(245, 35, '', 'zh', 'Orena 复古项链和耳环套装', '优雅的 Orena 首饰套装：项链和耳环。\r\n采用金属和珐琅制作，状况良好。\r\n时尚的复古套装，适合日常佩戴或特殊场合。', 'Orena 复古首饰套装 – 项链与耳环', 'Orena 复古套装：金属与珐琅项链和耳环。保存良好，设计优雅。'),
(246, 36, '', 'ru', 'Сумка The Kooples Emily Small красная', 'Элегантная сумка The Kooples модель Emily Small в красном цвете.\r\nВ комплекте оригинальный мешок для пыли.\r\nОтличное состояние.', 'Сумка The Kooples Emily Small – красная, отличное состояние', 'Красная сумка The Kooples Emily Small. В комплекте dustbag, состояние отличное.'),
(247, 36, '', 'en', 'The Kooples Emily Small Bag – Red', 'Elegant The Kooples Emily Small bag in red.\r\nComes with original dustbag.\r\nExcellent condition.', 'The Kooples Emily Small Red Bag – Excellent Condition', 'The Kooples Emily Small red bag. Includes dustbag, excellent condition.'),
(248, 36, '', 'de', 'The Kooples Emily Small Tasche – Rot', 'Elegante The Kooples Tasche, Modell Emily Small in Rot.\r\nWird mit originalem Staubbeutel geliefert.\r\nAusgezeichneter Zustand.', 'The Kooples Emily Small Tasche Rot – ausgezeichneter Zustand', 'The Kooples Emily Small Tasche in Rot. Mit Staubbeutel, sehr guter Zustand.'),
(249, 36, '', 'es', 'Bolso The Kooples Emily Small – Rojo', 'Elegante bolso The Kooples modelo Emily Small en color rojo.\r\nIncluye bolsa para polvo original.\r\nEn excelente estado.', 'Bolso The Kooples Emily Small rojo – excelente estado', 'Bolso rojo The Kooples Emily Small. Incluye dustbag, excelente estado.'),
(250, 36, '', 'fr', 'Sac The Kooples Emily Small – Rouge', 'Élégant sac The Kooples modèle Emily Small en rouge.\r\nFourni avec son dustbag d’origine.\r\nExcellent état.', 'Sac The Kooples Emily Small rouge – excellent état', 'Sac The Kooples Emily Small rouge. Avec dustbag, en excellent état.'),
(251, 36, '', 'ja', 'The Kooples エミリー スモール バッグ – レッド', 'エレガントなThe Kooples「Emily Small」バッグ、赤色。\r\nオリジナルの保存袋付き。\r\nコンディションは非常に良好です。', 'The Kooples エミリー スモール レッドバッグ – 良好な状態', 'The Kooples「Emily Small」赤バッグ。保存袋付き、状態は非常に良い。'),
(252, 36, '', 'zh', 'The Kooples Emily Small 红色手袋', '优雅的 The Kooples Emily Small 红色手袋。\r\n配有原装防尘袋。\r\n状态极佳。', 'The Kooples Emily Small 红色手袋 – 极佳状态', 'The Kooples Emily Small 红色手袋。附带 dustbag，保存状态极佳。'),
(253, 37, '', 'ru', 'Туалетная вода Vent Vert Pierre Balmain винтаж', 'Туалетная вода Vent Vert от Pierre Balmain.\r\nНовая, в закрытой упаковке.\r\nРедкий винтажный аромат, выпуск прекращён.', 'Туалетная вода Vent Vert Pierre Balmain – винтаж, новая', 'Редкая винтажная туалетная вода Vent Vert Pierre Balmain. Новая, в закрытой упаковке, больше не производится.'),
(254, 37, '', 'en', 'Vent Vert Eau de Toilette by Pierre Balmain – Vintage', 'Vent Vert Eau de Toilette by Pierre Balmain.\r\nBrand new, sealed packaging.\r\nA rare vintage fragrance, no longer in production.', 'Vent Vert by Pierre Balmain – Vintage Eau de Toilette, New', 'Rare vintage fragrance Vent Vert by Pierre Balmain. Brand new, sealed box, discontinued.'),
(255, 37, '', 'de', 'Vent Vert Eau de Toilette von Pierre Balmain – Vintage', 'Vent Vert Eau de Toilette von Pierre Balmain.\r\nNeu, in versiegelter Verpackung.\r\nSeltener Vintage-Duft, nicht mehr hergestellt.', 'Vent Vert Pierre Balmain – Vintage Eau de Toilette, Neu', 'Seltener Vintage-Duft Vent Vert von Pierre Balmain. Neu, versiegelt, nicht mehr im Handel.'),
(256, 37, '', 'es', 'Agua de tocador Vent Vert Pierre Balmain – Vintage', 'Agua de tocador Vent Vert de Pierre Balmain.\r\nNueva, en envase sellado.\r\nFragancia vintage rara, ya no se produce.', 'Vent Vert Pierre Balmain – Agua de tocador vintage, nueva', 'Fragancia vintage rara Vent Vert de Pierre Balmain. Nueva, en caja sellada, descontinuada.'),
(257, 37, '', 'fr', 'Eau de toilette Vent Vert Pierre Balmain – Vintage', 'Eau de toilette Vent Vert par Pierre Balmain.\r\nNeuf, en emballage scellé.\r\nUn parfum vintage rare, aujourd’hui discontinué.', 'Vent Vert Pierre Balmain – Eau de toilette vintage, neuf', 'Parfum rare Vent Vert Pierre Balmain. Neuf, scellé, parfum discontinué.'),
(258, 37, '', 'ja', 'ピエール・バルマン Vent Vert オードトワレ – ヴィンテージ', 'ピエール・バルマンのVent Vert オードトワレ。\r\n新品・未開封。\r\n現在は製造されていない希少なヴィンテージ香水', 'Vent Vert ピエール・バルマン – ヴィンテージ香水、新品', '希少なヴィンテージ香水 Vent Vert ピエール・バルマン。新品・未開封、廃盤品。'),
(259, 37, '', 'zh', 'Pierre Balmain Vent Vert 香水 – 复古', 'Pierre Balmain Vent Vert 淡香水。\r\n全新，未开封包装。\r\n稀有复古香氛，已停产。', 'Pierre Balmain Vent Vert 淡香水 – 复古，全新', '稀有复古香水 Pierre Balmain Vent Vert。全新未开封，已停产。'),
(260, 38, '', 'ru', 'Туалетная вода Fidji Guy Laroche 50 мл', 'Легендарная туалетная вода Fidji от Guy Laroche.\r\nКлассический женственный аромат, полюбившийся во всем мире.', 'Туалетная вода Fidji Guy Laroche – 50 мл, легендарный аромат', 'Туалетная вода Fidji от Guy Laroche, 50 мл. Легендарный аромат, женственный и утончённый.'),
(261, 38, '', 'en', 'Fidji Eau de Toilette by Guy Laroche 50 ml', 'The legendary Fidji Eau de Toilette by Guy Laroche.\r\nA timeless feminine fragrance loved worldwide.', 'Fidji by Guy Laroche – Eau de Toilette 50 ml, Legendary Perfume', 'Fidji Eau de Toilette by Guy Laroche, 50 ml. A legendary, elegant feminine fragrance.'),
(262, 38, '', 'de', 'Fidji Eau de Toilette von Guy Laroche 50 ml', 'Das legendäre Fidji Eau de Toilette von Guy Laroche.\r\nEin zeitloser, femininer Duft, weltweit beliebt.', 'Fidji Guy Laroche – Eau de Toilette 50 ml, legendärer Duft', 'Fidji Eau de Toilette von Guy Laroche, 50 ml. Legendärer, femininer und eleganter Duft.'),
(263, 38, '', 'es', 'Agua de tocador Fidji Guy Laroche 50 ml', 'La legendaria agua de tocador Fidji de Guy Laroche.\r\nUna fragancia femenina atemporal, amada en todo el mundo.', 'Fidji Guy Laroche – Agua de tocador 50 ml, fragancia legendaria', 'Agua de tocador Fidji de Guy Laroche, 50 ml. Fragancia femenina elegante y legendaria.'),
(264, 38, '', 'fr', 'Eau de toilette Fidji Guy Laroche 50 ml', 'La légendaire eau de toilette Fidji de Guy Laroche.\r\nUn parfum féminin intemporel, adoré dans le monde entier.', 'Fidji Guy Laroche – Eau de toilette 50 ml, parfum légendaire', 'Eau de toilette Fidji de Guy Laroche, 50 ml. Un parfum féminin raffiné et légendaire.'),
(265, 38, '', 'ja', 'ギ・ラロッシュ Fidji オードトワレ 50ml', 'ギ・ラロッシュの伝説的な香水「Fidji」オードトワレ。\r\n世界中で愛されるタイムレスでフェミニンな香り。', 'Fidji ギ・ラロッシュ – オードトワレ 50ml, 伝説の香り', 'ギ・ラロッシュの「Fidji」オードトワレ 50ml。女性らしくエレガントな伝説のフレグランス。'),
(266, 38, '', 'zh', 'Guy Laroche Fidji 淡香水 50 毫升', 'Guy Laroche 的传奇香水 Fidji 淡香水。\r\n经典的女性香氛，广受世界喜爱。', 'Guy Laroche Fidji 淡香水 – 50 毫升，传奇香氛', 'Fidji 淡香水，Guy Laroche 出品，50 毫升。传奇女性香水，优雅而经典。'),
(267, 39, '', 'ru', 'Туалетная концентрированная вода Fidji du Soir Guy Laroche 50 мл винтаж', 'Редкая туалетная концентрированная вода Fidji du Soir от Guy Laroche.\r\nВыпуск 90-х годов, винтаж.\r\nФлакон в упаковке, наполненность около 95%.', 'Fidji du Soir Guy Laroche – туалетная концентрированная вода 50 мл, винтаж', 'Винтажная туалетная концентрированная вода Fidji du Soir Guy Laroche, 50 мл. 90-е годы, в упаковке, наполненность 95%.'),
(268, 39, '', 'en', 'Fidji du Soir Concentrated Eau de Toilette by Guy Laroche 50 ml – Vintage', 'Rare Fidji du Soir concentrated eau de toilette by Guy Laroche.\r\nVintage from the 1990s.\r\nComes in its box, bottle filled at about 95%.', 'Fidji du Soir Guy Laroche – Concentrated Eau de Toilette 50 ml, Vintage', 'Vintage Fidji du Soir concentrated eau de toilette by Guy Laroche, 50 ml. 1990s release, boxed, 95% full.'),
(269, 39, '', 'de', 'Fidji du Soir Konzentriertes Eau de Toilette von Guy Laroche 50 ml – Vintage', 'Seltenes Fidji du Soir Konzentriertes Eau de Toilette von Guy Laroche.\r\nVintage aus den 1990er Jahren.\r\nIn Originalverpackung, Füllstand ca. 95%.', 'Fidji du Soir Guy Laroche – Konzentriertes Eau de Toilette 50 ml, Vintage', 'Vintage Fidji du Soir Konzentriertes Eau de Toilette von Guy Laroche, 50 ml. 1990er Jahre, Box, ca. 95% voll.'),
(270, 39, '', 'es', 'Agua de tocador concentrada Fidji du Soir Guy Laroche 50 ml – Vintage', 'Rara agua de tocador concentrada Fidji du Soir de Guy Laroche.\r\nVintage de los años 90.\r\nCon caja, frasco lleno al 95 %.', 'Fidji du Soir Guy Laroche – Agua de tocador concentrada 50 ml, vintage', 'Agua de tocador concentrada Fidji du Soir de Guy Laroche, 50 ml. Años 90, con caja, frasco lleno al 95 %.'),
(271, 39, '', 'fr', 'Eau de toilette concentrée Fidji du Soir Guy Laroche 50 ml – Vintage', 'Rare eau de toilette concentrée Fidji du Soir de Guy Laroche.\r\nParfum vintage des années 1990.\r\nFlacon en boîte, rempli à environ 95 %.', 'Fidji du Soir Guy Laroche – Eau de toilette concentrée 50 ml, vintage', 'Eau de toilette concentrée Fidji du Soir de Guy Laroche, 50 ml. Années 1990, en boîte, remplissage 95 %.'),
(272, 39, '', 'ja', 'ギ・ラロッシュ Fidji du Soir 濃縮オードトワレ 50ml – ヴィンテージ', 'ギ・ラロッシュの希少なFidji du Soir 濃縮オードトワレ。\r\n1990年代のヴィンテージ。\r\n箱付き、内容量は約95%。', 'Fidji du Soir ギ・ラロッシュ – 濃縮オードトワレ 50ml, ヴィンテージ', 'ギ・ラロッシュ Fidji du Soir 濃縮オードトワレ 50ml。1990年代、箱入り、内容量約95%。'),
(273, 39, '', 'zh', 'Guy Laroche Fidji du Soir 浓缩淡香水 50 毫升 – 复古', '稀有的 Guy Laroche Fidji du Soir 浓缩淡香水。\r\n90 年代复古。\r\n带盒，瓶内约 95% 保存。', 'Fidji du Soir Guy Laroche – 浓缩淡香水 50 毫升，复古', 'Guy Laroche Fidji du Soir 浓缩淡香水 50ml。90 年代复古，带盒，瓶内约 95%。'),
(274, 40, '', 'ru', 'Туалетная вода Nino Cerruti Pour Femme 100 мл винтаж', 'Редкая туалетная вода Nino Cerruti Pour Femme 100 мл.\r\nОригинальная упаковка, новый флакон.\r\nВыпуск середины 90-х годов, винтаж.', 'Nino Cerruti Pour Femme – туалетная вода 100 мл, винтаж 90-х', 'Винтажная туалетная вода Nino Cerruti Pour Femme, 100 мл. Новый флакон, оригинальная упаковка, середина 90-х годов.'),
(275, 40, '', 'en', 'Nino Cerruti Pour Femme Eau de Toilette 100 ml – Vintage', 'Rare Nino Cerruti Pour Femme eau de toilette 100 ml.\r\nNew bottle in original packaging.\r\nVintage release from the mid-1990s.', 'Nino Cerruti Pour Femme – Eau de Toilette 100 ml, Vintage 90s', 'Vintage Nino Cerruti Pour Femme eau de toilette, 100 ml. New, sealed in original packaging, mid-1990s release.'),
(276, 40, '', 'de', 'Nino Cerruti Pour Femme Eau de Toilette 100 ml – Vintage', 'Seltenes Nino Cerruti Pour Femme Eau de Toilette 100 ml.\r\nNeu, in Originalverpackung.\r\nVintage aus der Mitte der 1990er Jahre.', 'Nino Cerruti Pour Femme – Eau de Toilette 100 ml, Vintage 90er', 'Vintage Nino Cerruti Pour Femme Eau de Toilette, 100 ml. Neu, versiegelt in Originalverpackung, Mitte der 1990er Jahre.'),
(277, 40, '', 'es', 'Agua de tocador Nino Cerruti Pour Femme 100 ml – Vintage', 'Rara agua de tocador Nino Cerruti Pour Femme 100 ml.\r\nNuevo, en su embalaje original.\r\nVintage de mediados de los años 90.', 'Nino Cerruti Pour Femme – Agua de tocador 100 ml, vintage 90s', 'Agua de tocador vintage Nino Cerruti Pour Femme, 100 ml. Nuevo, en embalaje original, lanzamiento de mediados de los 90.'),
(278, 40, '', 'fr', 'Eau de toilette Nino Cerruti Pour Femme 100 ml – Vintage', 'Rare eau de toilette Nino Cerruti Pour Femme 100 ml.\r\nFlacon neuf, dans son emballage d’origine.\r\nParfum vintage du milieu des années 1990.', 'Nino Cerruti Pour Femme – Eau de toilette 100 ml, vintage 90s', 'Eau de toilette vintage Nino Cerruti Pour Femme, 100 ml. Flacon neuf, emballage d’origine, sortie milieu des années 1990.'),
(279, 40, '', 'ja', 'ニノ・チェルッティ Pour Femme オードトワレ 100ml – ヴィンテージ', '希少なニノ・チェルッティ Pour Femme オードトワレ 100ml。\r\n新品、オリジナルパッケージ入り。\r\n1990年代半ばのヴィンテージ。', 'ニノ・チェルッティ Pour Femme – オードトワレ 100ml, ヴィンテージ', 'ニノ・チェルッティ Pour Femme オードトワレ 100ml。1990年代半ば、オリジナル包装の新品ヴィンテージ。'),
(280, 40, '', 'zh', 'Nino Cerruti Pour Femme 淡香水 100 毫升 – 复古', '稀有的 Nino Cerruti Pour Femme 淡香水 100 毫升。\r\n全新，原装包装。\r\n90 年代中期复古。', 'Nino Cerruti Pour Femme – 淡香水 100 毫升，90年代复古', 'Nino Cerruti Pour Femme 淡香水 100ml。全新，原装包装，90年代中期复古。'),
(281, 41, '', 'ru', 'Миниатюра Fidji de Guy Laroche – пробник винтаж', 'Редкая миниатюра парфюма Fidji de Guy Laroche.\r\nОригинальный пробник в винтажном исполнении.\r\nКоллекционный экземпляр для ценителей классики.', 'Fidji de Guy Laroche – миниатюра пробник, винтажный парфюм', 'Винтажная миниатюра Fidji de Guy Laroche. Коллекционный пробник, редкий экземпляр для коллекции и ценителей парфюма.'),
(282, 41, '', 'en', 'Fidji de Guy Laroche Miniature – Vintage Sample', 'Rare miniature of Fidji de Guy Laroche perfume.\r\nOriginal vintage sample bottle.\r\nA collectible item for fragrance lovers.', 'Fidji de Guy Laroche – Vintage Miniature Sample Perfume', 'Vintage miniature Fidji de Guy Laroche. Rare sample, collectible perfume for connoisseurs.'),
(283, 41, '', 'de', 'Fidji de Guy Laroche Miniatur – Vintage Probe', 'Seltene Miniatur des Parfums Fidji de Guy Laroche.\r\nOriginal-Vintage-Probe.\r\nEin Sammlerstück für Parfumliebhaber.', 'Fidji de Guy Laroche – Miniatur, Vintage Probeparfum', 'Vintage-Miniatur Fidji de Guy Laroche. Seltene Probe, Sammlerstück für Parfumliebhaber.'),
(284, 41, '', 'es', 'Miniatura Fidji de Guy Laroche – Muestra vintage', 'Rara miniatura del perfume Fidji de Guy Laroche.\r\nMuestra original vintage.\r\nUn frasco de colección para amantes de los perfumes.', 'Fidji de Guy Laroche – Miniatura vintage, muestra de perfume', 'Miniatura vintage Fidji de Guy Laroche. Rara muestra de colección para aficionados a los perfumes.'),
(285, 41, '', 'fr', 'Miniature Fidji de Guy Laroche – Échantillon vintage', 'Rare miniature du parfum Fidji de Guy Laroche.\r\nÉchantillon original vintage.\r\nUn flacon de collection pour amateurs de parfums.', 'Fidji de Guy Laroche – Miniature vintage, échantillon parfum', 'Miniature vintage Fidji de Guy Laroche. Échantillon rare, pièce de collection pour passionnés de parfums.'),
(286, 41, '', 'ja', 'フィジー Guy Laroche ミニチュア – ヴィンテージ サンプル', '希少なフィジー Guy Laroche 香水のミニチュア。\r\nオリジナルのヴィンテージサンプル。\r\n香水愛好家のためのコレクションアイテム。', 'フィジー Guy Laroche – ヴィンテージ ミニチュア サンプル', 'フィジー Guy Laroche ヴィンテージミニチュア。希少なサンプル、香水コレクター向け。'),
(287, 41, '', 'zh', 'Fidji de Guy Laroche 迷你香水 – 复古试用装', '稀有的 Fidji de Guy Laroche 香水迷你版。\r\n原装复古试用瓶。\r\n香水爱好者的收藏品。', 'Fidji de Guy Laroche – 复古迷你试用香水', 'Fidji de Guy Laroche 复古迷你香水。稀有试用装，香水收藏爱好者必备。'),
(288, 42, '', 'ru', 'Парфюм Shalimar Guerlain – винтаж Baccarat 30 мл', 'Великолепный винтажный парфюм Shalimar от Guerlain.\r\nФлакон из хрусталя Baccarat Paris, лимитированный выпуск 80-х годов, № 929/4450.\r\nОбъем 30 мл, оригинальный бархатный футляр, сертификат подлинности.\r\nСостояние новое, без царапин и сколов.', 'Shalimar Guerlain – винтажный парфюм Baccarat 30 мл, лимитированный выпуск', 'Винтажный парфюм Shalimar Guerlain в флаконе Baccarat, 30 мл. Лимитированный выпуск 80-х годов с сертификатом подлинности, отличное состояние.'),
(289, 42, '', 'en', 'Shalimar by Guerlain Perfume – Vintage Baccarat 30 ml', 'Magnificent vintage Shalimar perfume by Guerlain.\r\nCrystal bottle by Baccarat Paris, limited edition from the 1980s, No. 929/4450.\r\n30 ml, original velvet case, certificate of authenticity.\r\nCondition: new, no scratches or chips.', 'Shalimar Guerlain – Vintage Baccarat Perfume 30 ml, Limited Edition', 'Vintage Shalimar Guerlain perfume in Baccarat crystal bottle, 30 ml. Limited 1980s release with certificate of authenticity, excellent condition.'),
(290, 42, '', 'de', 'Shalimar von Guerlain Parfum – Vintage Baccarat 30 ml', 'Wundervolles Vintage-Parfum Shalimar von Guerlain.\r\nKristallflakon von Baccarat Paris, limitierte Auflage aus den 1980er Jahren, Nr. 929/4450.\r\n30 ml, originaler Samtetui, Echtheitszertifikat.\r\nZustand: neu, ohne Kratzer oder Absplitterungen.', 'Shalimar Guerlain – Vintage Baccarat Parfum 30 ml, limitierte Auflage', 'Vintage Shalimar Guerlain Parfum im Baccarat-Kristallflakon, 30 ml. Limitierte Auflage der 1980er Jahre mit Echtheitszertifikat, hervorragender Zustand.'),
(291, 42, '', 'es', 'Perfume Shalimar Guerlain – Vintage Baccarat 30 ml', 'Magnífico perfume vintage Shalimar de Guerlain.\r\nFrasco de cristal de Baccarat Paris, edición limitada de los años 80, Nº 929/4450.\r\n30 ml, estuche original de terciopelo, certificado de autenticidad.\r\nEstado: nuevo, sin rayaduras ni daños.', 'Shalimar Guerlain – Perfume vintage Baccarat 30 ml, edición limitada', 'Perfume vintage Shalimar Guerlain en frasco Baccarat de 30 ml. Edición limitada de los 80 con certificado de autenticidad, estado impecable.'),
(292, 42, '', 'fr', 'Parfum Shalimar Guerlain – Vintage Baccarat 30 ml', 'Superbe parfum vintage Shalimar de Guerlain.\r\nFlacon en cristal Baccarat Paris, édition limitée des années 80, n° 929/4450.\r\n30 ml, écrin en velours violet d’origine, certificat d’authenticité.\r\nÉtat neuf, sans rayures ni éclats.', 'Shalimar Guerlain – Parfum vintage Baccarat 30 ml, édition limitée', 'Parfum vintage Shalimar Guerlain en flacon Baccarat, 30 ml. Édition limitée des années 80 avec certificat d’authenticité, état parfait.'),
(293, 42, '', 'ja', 'ゲラン シャリマー 香水 – ヴィンテージ バカラ 30ml', 'ゲランのヴィンテージ香水シャリマー。\r\nバカラ・パリ製クリスタルボトル、1980年代限定版、No. 929/4450。\r\n30ml、オリジナルのベルベットケース、真正証明書付き。\r\n状態：新品、傷や欠けなし。', 'ゲラン シャリマー – ヴィンテージ バカラ香水 30ml 限定版', 'ゲラン シャリマー ヴィンテージ香水、バカラクリスタルボトル入り30ml。1980年代限定版、真正証明書付き、極美品。'),
(294, 42, '', 'zh', '娇兰 Shalimar 香水 – 复古 Baccarat 30 毫升', '娇兰 Shalimar 复古香水。\r\n巴黎 Baccarat 水晶瓶，1980 年代限量版，编号 929/4450。\r\n30 毫升，原装紫色天鹅绒盒，附带真品证书。\r\n状态：全新，无划痕或破损。', '娇兰 Shalimar – 复古 Baccarat 香水 30ml，限量版', '娇兰 Shalimar 复古香水，Baccarat 水晶瓶装 30 毫升。1980 年代限量版，附真品证书，品相极佳。'),
(295, 43, '', 'ru', 'Парфюм Les Larmes Sacrées de Thèbes Baccarat – экстракт 7,5 мл', 'Священные слезы Фив от Baccarat, выпуск 1998 года.\r\nОдин из самых дорогих духов в мире, экстракт 7,5 мл.\r\nВысота флакона 13 см, запечатанный, пронумерованный.\r\nСертификат подлинности, коробка и упаковка в идеальном состоянии.\r\nСостояние новое.', 'Les Larmes Sacrées de Thèbes Baccarat – экстракт 7,5 мл, новое состояние', 'Экстракт духов Les Larmes Sacrées de Thèbes Baccarat 7,5 мл, 1998 года. Запечатанный, пронумерованный, с сертификатом подлинности и оригинальной упаковкой.');
INSERT INTO `productstranslation` (`id`, `product_id`, `slug`, `locale`, `title`, `description`, `meta_title`, `meta_description`) VALUES
(296, 43, '', 'en', 'Les Larmes Sacrées de Thèbes by Baccarat – Extrait 7.5 ml', 'Les Larmes Sacrées de Thèbes by Baccarat, 1998 release.\r\nOne of the most expensive perfumes in the world, 7.5 ml extrait.\r\nBottle height 13 cm, sealed, numbered.\r\nCertificate of authenticity, box and packaging in perfect condition.\r\nCondition: new.', 'Les Larmes Sacrées de Thèbes Baccarat – 7.5 ml Extrait, New', 'Extrait perfume Les Larmes Sacrées de Thèbes Baccarat 7.5 ml, 1998. Sealed, numbered, with certificate of authenticity and original packaging.'),
(297, 43, '', 'de', 'Les Larmes Sacrées de Thèbes Baccarat Parfum – Extrait 7,5 ml', 'Les Larmes Sacrées de Thèbes von Baccarat, 1998.\r\nEines der teuersten Parfums der Welt, 7,5 ml Extrait.\r\nFlaschengröße 13 cm, versiegelt, nummeriert.\r\nEchtheitszertifikat, Box und Verpackung in perfektem Zustand.\r\nZustand: neu.', 'Les Larmes Sacrées de Thèbes Baccarat – Extrait 7,5 ml, Neu', 'Extrait Parfum Les Larmes Sacrées de Thèbes Baccarat 7,5 ml, 1998. Versiegelt, nummeriert, mit Echtheitszertifikat und Originalverpackung.'),
(298, 43, '', 'es', 'Perfume Les Larmes Sacrées de Thèbes Baccarat – Extrait 7,5 ml', 'Les Larmes Sacrées de Thèbes de Baccarat, edición 1998.\r\nUno de los perfumes más caros del mundo, extrait 7,5 ml.\r\nAltura del frasco 13 cm, sellado y numerado.\r\nCertificado de autenticidad, caja y embalaje en perfecto estado.\r\nEstado: nuevo.', 'Les Larmes Sacrées de Thèbes Baccarat – Extrait 7,5 ml, estado nuevo', 'Extrait de perfume Les Larmes Sacrées de Thèbes Baccarat 7,5 ml, 1998. Sellado, numerado, con certificado de autenticidad y embalaje original.'),
(299, 43, '', 'fr', 'Parfum Les Larmes Sacrées de Thèbes Baccarat – Extrait 7,5 ml', 'Les Larmes Sacrées de Thèbes de Baccarat, édition 1998.\r\nUn des parfums les plus chers au monde, extrait 7,5 ml.\r\nHauteur du flacon 13 cm, scellé, numéroté.\r\nCertificat d’authenticité, boîte et emballage en parfait état.\r\nÉtat : neuf.', 'Les Larmes Sacrées de Thèbes Baccarat – Extrait 7,5 ml, état neuf', 'Extrait de parfum Les Larmes Sacrées de Thèbes Baccarat 7,5 ml, 1998. Scellé, numéroté, avec certificat d’authenticité et emballage d’origine.'),
(300, 43, '', 'ja', 'バカラ Les Larmes Sacrées de Thèbes 香水 – エクストレ 7.5ml', 'BaccaratのLes Larmes Sacrées de Thèbes、1998年発売。\r\n世界で最も高価な香水の1つ、7.5ml エクストレ。\r\nボトル高さ13cm、未開封、番号入り。\r\n証明書、箱、パッケージは完璧な状態。\r\n状態：新品。', 'バカラ Les Larmes Sacrées de Thèbes – エクストレ 7.5ml、新品', 'Les Larmes Sacrées de Thèbes Baccarat エクストレ 7.5ml、1998年。未開封、番号入り、証明書付き、オリジナルパッケージ。'),
(301, 43, '', 'zh', 'Baccarat Les Larmes Sacrées de Thèbes 香水 – 浓缩 7.5 ml', 'Baccarat Les Larmes Sacrées de Thèbes，1998 年发行。\r\n世界上最昂贵的香水之一，7.5 ml 浓缩香水。\r\n瓶高 13 厘米，密封编号。\r\n附真品证书，盒子和包装完好。\r\n状态：全新。', 'Baccarat Les Larmes Sacrées de Thèbes – 浓缩 7.5 ml，全新', 'Les Larmes Sacrées de Thèbes Baccarat 浓缩香水 7.5 ml，1998 年。密封、编号、附真品证书及原装包装。');

-- --------------------------------------------------------

--
-- Структура таблицы `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `section` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `settings`
--

INSERT INTO `settings` (`id`, `section`, `name`, `value`) VALUES
(1, 'contacts', 'about_title', 'ОБО МНЕ'),
(2, 'contacts', 'about_text', '<p>Занимаюсь разработкой современных сайтов и приложений. Мне нравится делать интересные и современные проекты. Этот сайт я сделал в рамках обучения в школе онлайн обучения WebCademy. Чуть позже я обновлю в нём свой контент. А пока посмотрите, как тут всё классно!</p>'),
(3, 'contacts', 'services_title', 'НАПРАВЛЕНИЯ, КОТОРЫМИ Я ЗАНИМАЮСЬ'),
(4, 'contacts', 'services_text', '<ul>\r\n	<li>Верстка сайтов</li>\r\n	<li>Frontend</li>\r\n	<li>UI/UX дизайн</li>\r\n</ul>'),
(5, 'contacts', 'contacts_title', 'Контакты'),
(6, 'contacts', 'contacts_text', '<p><strong>Email:&nbsp;</strong><a href=\"mailto:hi@digitalnomad.pro\">hi@digitalnomad.pro</a></p>\r\n\r\n<p><strong>Мобильный:&nbsp;</strong><a href=\"tel:+79055557788\">+7 (905) 555-77-88</a></p>\r\n\r\n<p><strong>Адрес:</strong> Москва, Пресненская набережная, д. 6, стр. 2</p>'),
(12, 'settings', 'site_title', 'Vvintage'),
(13, 'settings', 'site_slogan', 'Мода, вдохновленная прошлым…'),
(14, 'settings', 'copyright_name', 'Балашова Наталья Евгеньевна'),
(15, 'settings', 'copyright_year', 'Создано в WebCademy.ru в августе в 2024 году.'),
(16, 'settings', 'status_on', 'on'),
(17, 'settings', 'status_label', 'Свободен для новых проектов и предложений'),
(18, 'settings', 'status_text', 'Рассматриваю предложения по верстке и frontend разработке. Подробности по ссылке'),
(19, 'settings', 'status_link', 'https://portfolio-php/contacts'),
(20, 'settings', 'youtube', 'https://vvintage/admin/2'),
(21, 'settings', 'instagram', 'https://vvintage/admin/3'),
(22, 'settings', 'facebook', 'https://vvintage/admin/'),
(23, 'settings', 'vkontakte', 'https://vvintage/admin/'),
(24, 'settings', 'dzen', ''),
(25, 'settings', 'telegram', ''),
(26, 'main', 'hero_title', 'Откройте для себя VVintage'),
(27, 'main', 'hero_text', 'Мода, вдохновленная прошлым…'),
(28, 'main', 'services_title', 'Что для нас важно'),
(29, 'main', 'services_text', 'Верстка сайтов\r\nFrontend\r\nUI/UX дизайн'),
(30, 'main', 'main_img', 'section-about-main.jpg'),
(31, 'main', 'cats_header', 'Категории'),
(32, 'main', 'cats_cats', '[]'),
(33, 'main', 'features_header', 'Что для нас важно'),
(34, 'main', 'features_list', 'on'),
(35, 'settings', 'html_on', 'on'),
(36, 'settings', 'css_on', 'on'),
(37, 'settings', 'js_on', ''),
(38, 'settings', 'card_on_page_shop', '6'),
(39, 'settings', 'card_on_page_blog', '6');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) UNSIGNED NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `role` enum('customer','admin','manager') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'customer',
  `status` enum('active','inactive','banned') COLLATE utf8mb4_unicode_520_ci NOT NULL DEFAULT 'active',
  `registration_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `last_login` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `newsletter_subscribed` tinyint(1) DEFAULT '0',
  `loyalty_points` int(11) DEFAULT '0',
  `password` varchar(255) COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `cart` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `fav_list` varchar(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `surname` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `city` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `avatar_small` varchar(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `recovery_code` varchar(100) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `role`, `status`, `registration_date`, `last_login`, `updated_at`, `newsletter_subscribed`, `loyalty_points`, `password`, `cart`, `fav_list`, `name`, `surname`, `country`, `city`, `phone`, `avatar`, `avatar_small`, `recovery_code`) VALUES
(1, '1@mail.ru', 'admin', 'active', '2025-08-11 07:04:51', NULL, '2025-08-25 18:48:55', 0, 0, '$2y$10$cKK4bB1G/kMDC6mQ5IOaqek6610YPZRbwDHx4e4Poj9eJrcJuhO6a', '[]', '[]', 'Наталья', 'Балашова', '', '', '79253458675', '298804198814.jpg', '48-298804198814.jpg', NULL),
(2, 'user@mail.ru', 'customer', 'active', '2025-08-27 11:28:48', NULL, '2025-08-27 11:28:48', 0, 0, '$2y$10$UFCxu..vzaEtjkXXOrzLbekRUqUDxjJa8umbNc7YZV4EJysWn0RI2', '[]', '[]', 'Надежда', 'Stepanova', 'USA', 'Adminsk', '79253458675', '390637457638.jpg', '48-390637457638.jpg', NULL),
(3, 'info@mail.ru', 'customer', 'active', '2025-08-28 09:39:15', NULL, '2025-08-28 09:39:15', 0, 0, '$2y$10$YX5Q2OZ8J.soGmmwNHhlrufNwhNfJ4Bd/yFMrZn6CCmP.3SOLn6hm', '{\"2\":1}', '[]', '', NULL, '', '', '', '', '', NULL),
(4, 'nha805858@mail.ru', 'customer', 'active', '2025-10-29 14:43:01', NULL, '2025-10-29 14:43:01', 0, 0, '$2y$10$QiK00n1K41xI9NXzVh2jS.9zTF0vBsPbA/B8fD088BhqYL6UPA39i', '[]', '[]', 'Elena', 'Braz', '', '', '', '', '', NULL),
(5, 'infeoedtr@yandex.ru', 'customer', 'active', '2025-10-29 15:10:59', NULL, '2025-10-29 15:10:59', 0, 0, '$2y$10$kfBSQkoDVYXR/E6feQ6J6uzQ0R1CuJ0.hSz3m3urTnMjzdc.y7Vne', '[]', '[]', 'Sofie', 'Braz', '', '', '', '209170595865.jpg', '48-209170595865.jpg', NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `address`
--
ALTER TABLE `address`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `blogcategories`
--
ALTER TABLE `blogcategories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`);

--
-- Индексы таблицы `brandstranslation`
--
ALTER TABLE `brandstranslation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_id` (`brand_id`,`locale`),
  ADD UNIQUE KEY `unique_categories_locale` (`brand_id`,`locale`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_categories_parent` (`parent_id`);

--
-- Индексы таблицы `categoriestranslation`
--
ALTER TABLE `categoriestranslation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_id` (`category_id`,`locale`),
  ADD UNIQUE KEY `unique_categories_locale` (`category_id`,`locale`);

--
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_messages_user` (`user_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `index_foreignkey_orders_user` (`user_id`);

--
-- Индексы таблицы `pagefields`
--
ALTER TABLE `pagefields`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_page_field` (`page_id`);

--
-- Индексы таблицы `pagefieldstranslation`
--
ALTER TABLE `pagefieldstranslation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_id` (`field_id`,`locale`) USING BTREE;

--
-- Индексы таблицы `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pagestranslation`
--
ALTER TABLE `pagestranslation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `page_id` (`page_id`,`locale`) USING BTREE;

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `postscategories`
--
ALTER TABLE `postscategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Индексы таблицы `postscategoriestranslation`
--
ALTER TABLE `postscategoriestranslation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_id` (`category_id`,`locale`);

--
-- Индексы таблицы `poststranslation`
--
ALTER TABLE `poststranslation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_id` (`post_id`,`locale`);

--
-- Индексы таблицы `productimages`
--
ALTER TABLE `productimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_product_images` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `productstranslation`
--
ALTER TABLE `productstranslation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `product_id` (`product_id`,`locale`);

--
-- Индексы таблицы `settings`
--
ALTER TABLE `settings`
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
-- AUTO_INCREMENT для таблицы `address`
--
ALTER TABLE `address`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `blogcategories`
--
ALTER TABLE `blogcategories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `brandstranslation`
--
ALTER TABLE `brandstranslation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=190;

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `categoriestranslation`
--
ALTER TABLE `categoriestranslation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `pagefields`
--
ALTER TABLE `pagefields`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `pagefieldstranslation`
--
ALTER TABLE `pagefieldstranslation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT для таблицы `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `pagestranslation`
--
ALTER TABLE `pagestranslation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `postscategories`
--
ALTER TABLE `postscategories`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `postscategoriestranslation`
--
ALTER TABLE `postscategoriestranslation`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT для таблицы `poststranslation`
--
ALTER TABLE `poststranslation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `productimages`
--
ALTER TABLE `productimages`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=447;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT для таблицы `productstranslation`
--
ALTER TABLE `productstranslation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=302;

--
-- AUTO_INCREMENT для таблицы `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `brandstranslation`
--
ALTER TABLE `brandstranslation`
  ADD CONSTRAINT `fk_brands_translation_brand_id` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `categories`
--
ALTER TABLE `categories`
  ADD CONSTRAINT `fk_categories_parent` FOREIGN KEY (`parent_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Ограничения внешнего ключа таблицы `categoriestranslation`
--
ALTER TABLE `categoriestranslation`
  ADD CONSTRAINT `fk_category_translation` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `c_fk_orders_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Ограничения внешнего ключа таблицы `pagefields`
--
ALTER TABLE `pagefields`
  ADD CONSTRAINT `fk_page_field` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `pagefieldstranslation`
--
ALTER TABLE `pagefieldstranslation`
  ADD CONSTRAINT `fk_pages_fields_translation` FOREIGN KEY (`field_id`) REFERENCES `pagefields` (`id`);

--
-- Ограничения внешнего ключа таблицы `pagestranslation`
--
ALTER TABLE `pagestranslation`
  ADD CONSTRAINT `fk_pages_translation` FOREIGN KEY (`page_id`) REFERENCES `pages` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `postscategoriestranslation`
--
ALTER TABLE `postscategoriestranslation`
  ADD CONSTRAINT `postscategoriestranslation_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `postscategories` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `poststranslation`
--
ALTER TABLE `poststranslation`
  ADD CONSTRAINT `poststranslation_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `productimages`
--
ALTER TABLE `productimages`
  ADD CONSTRAINT `fk_product_images` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `productstranslation`
--
ALTER TABLE `productstranslation`
  ADD CONSTRAINT `fk_product_translation_product_id` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
