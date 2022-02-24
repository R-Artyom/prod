-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 24 2022 г., 06:54
-- Версия сервера: 5.7.29
-- Версия PHP: 7.4.5

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
-- Структура таблицы `colors`
--

CREATE TABLE `colors` (
  `id` int(11) NOT NULL COMMENT 'Уникальный идентификатор цвета',
  `name` varchar(255) NOT NULL COMMENT 'Название цвета',
  `description` varchar(255) NOT NULL COMMENT 'Описание цвета'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `colors`
--

INSERT INTO `colors` (`id`, `name`, `description`) VALUES
(1, 'red', 'Красный'),
(2, 'orange', 'Оранжевый'),
(3, 'yellow', 'Желтый'),
(4, 'green', 'Зеленый'),
(5, 'lightblue', 'Голубой'),
(6, 'blue', 'Синий'),
(7, 'purple', 'Фиолетовый');

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
-- Структура таблицы `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL COMMENT 'Уникальный идентификатор сообщения',
  `title` varchar(255) NOT NULL COMMENT 'Заголовок сообщения',
  `text` text NOT NULL COMMENT 'Текст сообщения',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания сообщения',
  `created_by` int(11) NOT NULL COMMENT 'Идентификатор пользователя-отправителя сообщения',
  `user_id_to` int(11) NOT NULL COMMENT 'Идентификатор пользователя-получателя сообщения',
  `section_id` int(11) NOT NULL COMMENT 'Идентификатор раздела',
  `read` tinyint(4) NOT NULL DEFAULT '0' COMMENT 'Флаг - сообщение прочитано / не прочитано'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `messages`
--

INSERT INTO `messages` (`id`, `title`, `text`, `created_at`, `created_by`, `user_id_to`, `section_id`, `read`) VALUES
(1, 'Протокол', 'Надо изменить п.1.23', '2021-06-04 07:27:25', 3, 1, 1, 1),
(2, 'Замена DD3', 'Прошу провести испытания', '2021-06-05 20:28:02', 6, 1, 1, 1),
(3, 'Замена микросхемы DD2', 'Изменился поставщик', '2021-06-05 20:29:34', 6, 1, 1, 0),
(4, 'Рэндом', 'Равным образом консультация с широким активом требуют определения и уточнения модели развития. Товарищи! постоянное информационно-пропагандистское обеспечение нашей деятельности позволяет выполнять важные задания по разработке модели развития. Идейные соображения высшего порядка, а также дальнейшее развитие различных форм деятельности позволяет оценить значение новых предложений.\r\nЗначимость этих проблем настолько очевидна, что консультация с широким активом играет важную роль в формировании новых предложений. . Равным образом рамки и место обучения кадров влечет за собой процесс внедрения и модернизации системы обучения кадров, соответствует насущным потребностям.\r\nРазнообразный и богатый опыт консультация с широким активом обеспечивает широкому кругу. Идейные соображения высшего порядка, а также укрепление и развитие структуры играет важную роль в формировании существенных финансовых и административных условий.', '2021-06-06 20:44:22', 2, 1, 2, 1),
(5, 'Эльдорадо дарит подарки', 'Скидка 99,9%', '2021-06-11 12:09:33', 4, 6, 3, 0),
(6, 'Подарок от Колорадо', 'Скидки 1 %', '2021-06-12 21:24:50', 7, 6, 3, 0),
(7, 'Срочно!', 'Свяжись со мной!!!', '2021-06-13 13:05:24', 7, 2, 2, 0),
(8, 'Подарки от пятёрочки', 'Скидки 55% на всё', '2021-06-13 18:45:05', 1, 4, 2, 1),
(9, 'Сигнализация', 'Поставь объект на охрану', '2021-06-15 13:13:57', 6, 4, 2, 1),
(10, 'Всё', 'Или не всё', '2021-06-15 15:14:47', 1, 7, 1, 1),
(11, 'Всё еще?', 'Или уже нет', '2021-06-16 18:09:14', 1, 7, 3, 0),
(12, 'Или уже нет!', 'Всё еще?', '2021-06-16 18:10:11', 1, 7, 3, 0),
(13, 'Почти', 'Всё', '2021-06-19 13:55:25', 7, 2, 6, 0);

-- --------------------------------------------------------

--
-- Структура таблицы `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL COMMENT 'Уникальный идентификатор раздела',
  `parent_id` int(11) NOT NULL COMMENT 'Уникальный идентификатор родительского раздела',
  `name` varchar(255) NOT NULL COMMENT 'Название раздела',
  `color_id` int(11) NOT NULL COMMENT 'Идентификатор цвета раздела',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата и время создания раздела',
  `created_by` int(11) NOT NULL COMMENT 'Идентификатор пользователя, создавшего раздел'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `sections`
--

INSERT INTO `sections` (`id`, `parent_id`, `name`, `color_id`, `created_at`, `created_by`) VALUES
(1, 0, 'Основные', 6, '2021-06-05 15:45:46', 3),
(2, 0, 'Оповещения', 4, '2021-06-05 16:31:46', 5),
(3, 0, 'Спам', 1, '2021-06-05 16:32:09', 1),
(4, 1, 'По работе', 2, '2021-06-19 13:44:15', 1),
(5, 1, 'Личные', 3, '2021-06-19 13:45:59', 2),
(6, 2, 'Форумы', 5, '2021-06-19 13:52:52', 3),
(7, 2, 'Магазины', 7, '2021-06-19 13:53:39', 4),
(8, 2, 'Подписки', 4, '2021-06-19 13:54:06', 5);

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
-- Индексы таблицы `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`);

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
-- Индексы таблицы `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `messages_ibfk_1` (`user_id_to`),
  ADD KEY `messages_ibfk_2` (`created_by`),
  ADD KEY `messages_ibfk_3` (`section_id`);

--
-- Индексы таблицы `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `sections_ibfk_1` (`color_id`),
  ADD KEY `sections_ibfk_2` (`created_by`),
  ADD KEY `parent_id` (`parent_id`);

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
-- AUTO_INCREMENT для таблицы `colors`
--
ALTER TABLE `colors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор цвета', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор группы', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор сообщения', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор раздела', AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Уникальный идентификатор пользователя', AUTO_INCREMENT=8;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `group_user`
--
ALTER TABLE `group_user`
  ADD CONSTRAINT `group_user_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `group_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id_to`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `messages_ibfk_3` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `sections`
--
ALTER TABLE `sections`
  ADD CONSTRAINT `sections_ibfk_1` FOREIGN KEY (`color_id`) REFERENCES `colors` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sections_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
