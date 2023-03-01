-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Мар 01 2023 г., 21:30
-- Версия сервера: 10.4.27-MariaDB
-- Версия PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `php_detail`
--

-- --------------------------------------------------------

--
-- Структура таблицы `brigades`
--

CREATE TABLE `brigades` (
  `id` int(11) NOT NULL,
  `shift` varchar(255) NOT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `brigades`
--

INSERT INTO `brigades` (`id`, `shift`, `notes`) VALUES
(1, 'C 7:00 по 16:00', 'Смена сварщиков 2-й категории'),
(2, 'C 12:00 по 19:00', 'Смена сварщиков 1-й категории'),
(3, 'C 20:00 по 7:00', 'Смена сварщиков 4-й категории'),
(4, 'C 7:00 по 17:00', 'Смена сварщиков 5-й категории'),
(5, 'C 7:00 по 17:00', 'Смена сварщиков 5-й категории'),
(6, 'C 7:00 по 17:00', 'Смена сварщиков 5-й категории'),
(7, 'C 7:00 по 17:00', 'Смена сварщиков 5-й категории'),
(8, 'C 7:00 по 17:00', 'Смена сварщиков 8-й категории'),
(10, 'C 7:00 по 17:00', ''),
(14, 'C 7:00 по 17:00', 'Измененная заметка!2'),
(18, 'C 7:00 по 17:00', 'Бригада 1'),
(19, 'C 7:00 по 17:00', 'Бригада 2');

-- --------------------------------------------------------

--
-- Структура таблицы `details`
--

CREATE TABLE `details` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `quality` tinyint(1) NOT NULL DEFAULT 1,
  `brigade_id` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `worker_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `details`
--

INSERT INTO `details` (`id`, `title`, `date`, `quality`, `brigade_id`, `notes`, `worker_id`) VALUES
(1, 'Кожух №1234-А-Б', '2023-02-09', 1, 1, 'Сделан кожух №1234-А-Б, прошел проверку', 7),
(2, 'Форсунка 2434-44 №1233', '2020-02-10', 0, 2, 'Сделана форсунка 2434-44 №1233', 10),
(3, 'Подножки для кожуха №12232-ОО-BFHG', '2023-02-09', 1, 18, '', 7),
(4, 'Форсунка №2 2434-44 №1233', '2023-03-01', 1, 10, 'Сделана Форсунка №2 2434-44 №1233', 10);

-- --------------------------------------------------------

--
-- Структура таблицы `workers`
--

CREATE TABLE `workers` (
  `id` int(11) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `salary` int(11) NOT NULL,
  `brigade_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `workers`
--

INSERT INTO `workers` (`id`, `surname`, `name`, `lastname`, `position`, `salary`, `brigade_id`) VALUES
(1, 'Петров', 'Петр', 'Иванович', 'Сварщик', 40000, 1),
(2, 'A', 'Владимир', 'Александрович', 'Сварщик', 40000, 1),
(3, 'Порошенко', 'Петр', 'Алексеевич', 'Сварщик', 50000, 2),
(4, 'Тимошенко', 'Иван', 'Максимович', 'Сварщик', 53000, 2),
(5, 'Гурченко', 'Андрей', 'Петрович', 'Сварщик', 32000, 3),
(6, 'Исаев', 'Андрей', 'Владимирович', 'Сварщик', 28000, 3),
(7, 'Лозеев', 'Макар', 'Иванович', 'Мастер', 53000, 0),
(9, 'Петрова', 'Ксения', 'Ивановна', 'Мастер цеха', 50000, 0),
(10, 'Петрова', 'Ирина', 'Ивановна', 'Мастер цеха', 25000, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `brigades`
--
ALTER TABLE `brigades`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `details`
--
ALTER TABLE `details`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `workers`
--
ALTER TABLE `workers`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `brigades`
--
ALTER TABLE `brigades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `details`
--
ALTER TABLE `details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `workers`
--
ALTER TABLE `workers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
