-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Сен 16 2022 г., 17:49
-- Версия сервера: 5.7.38
-- Версия PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `prod`
--

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL COMMENT 'Уникальный идентификатор раздела товаров',
  `name` varchar(255) NOT NULL COMMENT 'Название раздела товаров',
  `description` varchar(255) NOT NULL COMMENT 'Описание раздела товаров'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Женщины', 'Товары для женщин'),
(2, 'Мужчины', 'Товары для мужчин'),
(3, 'Дети', 'Товары для детей'),
(4, 'Аксессуары', 'Аксессуары');

-- --------------------------------------------------------

--
-- Структура таблицы `categories_products`
--

CREATE TABLE `categories_products` (
  `category_id` int(11) NOT NULL COMMENT 'Уникальный идентификатор раздела товара',
  `product_id` int(11) NOT NULL COMMENT 'Уникальный идентификатор товара'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `categories_products`
--

INSERT INTO `categories_products` (`category_id`, `product_id`) VALUES
(1, 273),
(4, 273),
(1, 275),
(1, 276),
(1, 277),
(1, 278),
(2, 280),
(4, 280),
(1, 282),
(1, 283),
(1, 288),
(2, 289),
(1, 292),
(3, 293),
(1, 295),
(2, 296);

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL COMMENT 'Уникальный идентификатор группы',
  `name` varchar(255) NOT NULL COMMENT 'Название группы',
  `description` varchar(255) NOT NULL COMMENT 'Описание группы'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'administrator', 'Пользователь может заходить в административный интерфейс, видеть список заказов и управлять товарами'),
(2, 'operator', 'Пользователь может заходить в административный интерфейс и видеть список заказов'),
(3, 'another', 'Все остальные пользователи');

-- --------------------------------------------------------

--
-- Структура таблицы `group_user`
--

CREATE TABLE `group_user` (
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `group_user`
--

INSERT INTO `group_user` (`user_id`, `group_id`) VALUES
(1, 1),
(1, 2),
(2, 2),
(1, 3),
(2, 3),
(3, 3),
(4, 3),
(5, 3),
(6, 3),
(7, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL COMMENT 'Уникальный идентификатор заказа',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания заказа',
  `created_by` varchar(255) NOT NULL COMMENT 'ФИО клиента',
  `phone` varchar(20) DEFAULT NULL COMMENT 'Номер телефона',
  `email` varchar(255) NOT NULL COMMENT 'Электронная почта',
  `product_id` int(11) NOT NULL COMMENT 'Уникальный идентификатор товара',
  `price` decimal(10,2) NOT NULL COMMENT 'Стоимость заказа, учитывая доставку',
  `delivery` varchar(255) NOT NULL COMMENT 'Информация о доставке (самовывоз / адрес)',
  `payment` tinyint(1) NOT NULL COMMENT 'Информация об оплате (наличные (1) / карта (0))',
  `status` tinyint(1) DEFAULT '0' COMMENT 'Статус заказа (обработан (1) / не обработан (0))',
  `comment` varchar(255) DEFAULT NULL COMMENT 'Комментарий к заказу'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `created_at`, `created_by`, `phone`, `email`, `product_id`, `price`, `delivery`, `payment`, `status`, `comment`) VALUES
(88, '2022-09-13 10:14:09', 'Рябов Артём Юрьевич', '+7383286825', 'mortemus@ngs.ru', 292, '300000.00', 'г. Новосибирск, ул. Физкультурная, д. 9, кв. 14', 0, 0, 'Сдачи не надо'),
(89, '2022-09-13 10:16:34', 'Иванов Иван ', '+7383286825', 'ivanov@gmail.com', 283, '12000.00', 'Самовывоз', 1, 1, ''),
(94, '2022-09-15 12:16:23', 'Петров Иван ', '+7999999987', 'petrov@gmail.com', 280, '250000.83', 'Самовывоз', 1, 1, ''),
(96, '2022-09-16 07:15:59', 'Сидоров Иван Иванович', '+79039981515', 'sidorov@gmail.com', 293, '780.00', 'г. Москва, ул. Ленина, д. 9, кв. 2', 0, 0, 'Домофона нет');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL COMMENT 'Уникальный идентификатор товара',
  `name` varchar(255) NOT NULL COMMENT 'Название товара',
  `img_name` varchar(255) NOT NULL COMMENT 'Название файла с изображением товара',
  `price` decimal(10,2) NOT NULL COMMENT 'Цена товара',
  `new` tinyint(1) NOT NULL COMMENT 'Признак "Новинка"',
  `sale` tinyint(1) NOT NULL COMMENT 'Признак "Распродажа"'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `img_name`, `price`, `new`, `sale`) VALUES
(273, 'Часы', '273.jpg', '29000.00', 1, 0),
(275, 'Платье белое', '275.jpg', '15000.00', 0, 0),
(276, 'Рубашка', '276.jpg', '5000.00', 0, 0),
(277, 'Шорты', '277.jpg', '3000.00', 0, 1),
(278, 'Платье красное', '278.jpg', '27000.00', 1, 0),
(280, 'Часы', '280.png', '250000.83', 1, 0),
(282, 'Сапоги', '282.jpg', '9000.00', 1, 1),
(283, 'Джинсы', '283.jpg', '12000.00', 0, 0),
(288, 'Шорты', '288.PNG', '2367.00', 1, 0),
(289, 'Шорты', '289.PNG', '900.00', 0, 1),
(292, 'Платье', '292.jpg', '300000.00', 1, 0),
(293, 'Рюкзак', '293.png', '500.00', 1, 0),
(295, 'Пальто', '295.jpg', '15000.00', 0, 0),
(296, 'Часы', '296.png', '19999.00', 0, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'Уникальный идентификатор пользователя',
  `full_name` varchar(255) NOT NULL COMMENT 'ФИО',
  `email` varchar(255) NOT NULL COMMENT 'Электронная почта (логин)',
  `password` varchar(255) NOT NULL COMMENT 'Пароль (в зашифрованном виде)',
  `phone` varchar(20) DEFAULT NULL COMMENT 'Номер телефона',
  `active_en` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Флаг активности пользователя (активен ''1'' / неактивен ''0'')',
  `notify_en` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Флаг согласия на получение уведомлений по email (согласен ''1'' / не согласен ''0'')'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `full_name`, `email`, `password`, `phone`, `active_en`, `notify_en`) VALUES
(1, 'Иванов Иван Иванович', 'ivanov@gmail.com', '$2y$10$2JZkDrjAmyy998bsHwzqyO/UhKeEajoqKYoeGHsVSV6x5YYEUUife', '+74951111111', 0, 1),
(2, 'Петров Пётр Петрович', 'petrov@gmail.com', '$2y$10$bWMB8bpsgCUG639YPC3sU.hNotseZsbZGvuoNqMqT7810oIE5sVC.', NULL, 0, 0),
(3, 'Сидоров Сидор Сидорович', 'sidorov@gmail.com', '$2y$10$XtIeUhwA6nLBtaCTzJLKX.YZDl4XZSJ2I7C7XEaF8G4AZ2skpKc.a', '+74953333333', 0, 0),
(4, 'Васильев Василий Васильевич', 'vasiliev@gmail.com', '$2y$10$bZbHhWIfGNUA9UHNe0HNc.6XK9J3e2Y56v0FOU1IkQo.oy9yc29Zy', NULL, 0, 0),
(5, 'Андреев Андрей Андреевич', 'andreev@gmail.com', '$2y$10$7vWGrFJf35Hj/o/5FL.90uLvhctur1cuXyWsbRJCTLFB.qBnGho7W', NULL, 0, 0),
(6, 'Александров Александр Александрович', 'aleksandrov@gmail.com', '$2y$10$u1Paw83vBxpxwkrboOo80upkk3RV8vTm.mfGtZle8VscKvZUVs/d.', '+74956666666', 0, 1),
(7, 'Любаев Любим Любимович', 'lyubaev@gmail.com', '$2y$10$LPU0n1/UawbLhZxVkj.AZePDkTu8lK69JuXIKqddSDcbMP./vZBda', '+79991112345', 0, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories_products`
--
ALTER TABLE `categories_products`
  ADD PRIMARY KEY (`category_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `group_user`
--
ALTER TABLE `group_user`
  ADD PRIMARY KEY (`user_id`,`group_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор раздела товаров', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор группы', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор заказа', AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор товара', AUTO_INCREMENT=298;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор пользователя', AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `categories_products`
--
ALTER TABLE `categories_products`
  ADD CONSTRAINT `categories_products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `categories_products_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group_user`
--
ALTER TABLE `group_user`
  ADD CONSTRAINT `group_user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
