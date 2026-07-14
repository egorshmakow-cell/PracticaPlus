-- phpMyAdmin SQL Dump
-- version 5.1.1deb5ubuntu1
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июл 14 2026 г., 20:59
-- Версия сервера: 8.0.46-0ubuntu0.22.04.2
-- Версия PHP: 8.1.2-1ubuntu2.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `practica`
--

-- --------------------------------------------------------

--
-- Структура таблицы `auth_assignment`
--

CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `user_id` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `created_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item`
--

CREATE TABLE `auth_item` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `type` smallint NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `rule_name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Дамп данных таблицы `auth_item`
--

INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
('admin', 1, 'Управление данными', NULL, NULL, 1778242333, 1778242333),
('updatePost', 2, 'Дфвдзыфд', NULL, NULL, 1777632528, 1777632528);

-- --------------------------------------------------------

--
-- Структура таблицы `auth_item_child`
--

CREATE TABLE `auth_item_child` (
  `parent` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `child` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `auth_rule`
--

CREATE TABLE `auth_rule` (
  `name` varchar(64) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `data` blob,
  `created_at` int DEFAULT NULL,
  `updated_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `diary_entries`
--

CREATE TABLE `diary_entries` (
  `id` int NOT NULL,
  `assignment_id` int NOT NULL,
  `date` date NOT NULL,
  `content` text NOT NULL,
  `hours` int NOT NULL,
  `supervisor_comment` text NOT NULL,
  `grade` int NOT NULL,
  `is_locked` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `diary_entries`
--

INSERT INTO `diary_entries` (`id`, `assignment_id`, `date`, `content`, `hours`, `supervisor_comment`, `grade`, `is_locked`, `created_at`, `updated_at`) VALUES
(1, 1, '2026-06-20', 'Выполнил подготовительный этап проекта', 3, 'Хорошо', 4, 1, '2026-06-20 03:23:56', '2026-06-20 03:32:59'),
(2, 1, '2026-06-20', 'База данных', 5, 'Молодец', 5, 1, '2026-06-20 03:25:02', '2026-06-20 03:29:33'),
(3, 1, '2026-06-20', 'Бэкенд', 3, 'Молодец', 5, 1, '2026-06-20 03:32:08', '2026-06-20 03:32:41'),
(4, 1, '2026-06-20', 'Фронтенд', 2, 'Молодец', 5, 1, '2026-06-20 03:40:58', '2026-06-20 03:41:36'),
(5, 1, '2026-06-21', 'JavaScript', 3, 'Молодец', 5, 1, '2026-06-21 06:24:19', '2026-06-21 06:24:52'),
(7, 5, '2026-06-21', 'Подготовка рабочего места', 3, 'Замечательно', 5, 1, '2026-06-21 09:54:00', '2026-06-21 10:01:54');

-- --------------------------------------------------------

--
-- Структура таблицы `document_templates`
--

CREATE TABLE `document_templates` (
  `id` int NOT NULL,
  `practice_id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `document_templates`
--

INSERT INTO `document_templates` (`id`, `practice_id`, `name`, `description`, `file_path`, `created_by`, `created_at`) VALUES
(1, 1, 'Аттестационный лист', 'Заполняется студентом и руководителем практики', 'uploads/templates/6a38c46a245ec_Attestatsionny_list.doc', 3, '2026-06-06 14:37:03'),
(2, 2, 'Журнал по практике', 'Заполняется студентом и руководителем практики', 'uploads/templates/6a38c49b8a5e6_Zhurnal_po_praktike__kopia.docx', 3, '2026-06-06 14:37:03'),
(3, 3, 'Отчёт', 'Заполняется студентом', 'uploads/templates/6a38c4c038756_Otchet.docx', 3, '2026-06-06 14:56:03'),
(4, 1, 'Содержание практики', 'Подробное содержание практики', 'uploads/templates/6a38c4ecec21b_Soderzhanie_praktiki.doc', 3, '2026-06-06 14:56:03'),
(5, 1, 'Характеристика', 'Заполняется руководителем', 'uploads/templates/6a38c50fa798f_Kharakteristika.docx', 3, '2026-06-06 14:58:34');

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE `groups` (
  `id` int NOT NULL,
  `group_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `course_year` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `groups`
--

INSERT INTO `groups` (`id`, `group_name`, `course_year`) VALUES
(1, '43', 4),
(2, '35', 3),
(3, '25', 2);

-- --------------------------------------------------------

--
-- Структура таблицы `group_practices`
--

CREATE TABLE `group_practices` (
  `id` int NOT NULL,
  `group_id` int NOT NULL,
  `practice_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `group_practices`
--

INSERT INTO `group_practices` (`id`, `group_id`, `practice_id`) VALUES
(1, 1, 1),
(2, 2, 2);

-- --------------------------------------------------------

--
-- Структура таблицы `migration`
--

CREATE TABLE `migration` (
  `version` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `apply_time` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1775188963),
('m140506_102106_rbac_init', 1777630704),
('m170907_052038_rbac_add_index_on_auth_assignment_user_id', 1777630704),
('m180523_151638_rbac_updates_indexes_without_prefix', 1777630704),
('m200409_110543_rbac_update_mssql_trigger', 1777630704),
('m260403_035429_create_user_table', 1775188967),
('m260403_041200_create_groups_table', 1775190958),
('m260403_043718_create_practices_table', 1775191566),
('m260403_045242_create_reports_table', 1775192679),
('m260403_050615_create_report_feedback_table', 1775196670),
('m260403_061159_create_document_templates_table', 1775196833),
('m260422_055732_create_practice_diary_entries_table', 1776837688),
('m260427_043019_create_students_table', 1777265123),
('m260430_071158_create_notification_table', 1777533929),
('m260430_145113_create_practice_progress_table', 1777561071),
('m260501_101537_init_rbac', 1777631595),
('m260501_103212_create_role_table', 1777631595),
('m260502_030250_create_practice_place_table', 1777692066),
('m260502_080757_create_user_logs_table', 1777710661),
('m260506_043456_create_supervisors_table', 1778042889);

-- --------------------------------------------------------

--
-- Структура таблицы `practices`
--

CREATE TABLE `practices` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `total_hours` int NOT NULL,
  `main_supervisor_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `practices`
--

INSERT INTO `practices` (`id`, `title`, `type`, `description`, `start_date`, `end_date`, `total_hours`, `main_supervisor_id`) VALUES
(1, 'ПМ 09', 'Преддипломная', 'Закрепление и углубление знаний', '2026-06-22', '2026-06-28', 16, 1),
(2, 'УП ПМ 09', 'Учебная', 'Создание сайта', '2026-06-22', '2026-06-28', 3, 1),
(3, 'ПМ 09.01', 'Производственная', 'Создание сайта', '2026-06-22', '2026-06-29', 3, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `reports`
--

CREATE TABLE `reports` (
  `id` int NOT NULL,
  `assignment_id` int NOT NULL,
  `report_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `submission_date` datetime NOT NULL,
  `status` enum('draft','ready') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `document_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade` decimal(3,1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `reports`
--

INSERT INTO `reports` (`id`, `assignment_id`, `report_title`, `submission_date`, `status`, `document_path`, `grade`, `created_at`) VALUES
(6, 1, 'Аттестационный лист', '2026-06-20 21:27:41', 'ready', 'uploads/ready-documents/student_work_rep_6_1782110811.doc', '0.0', '2026-06-20 16:27:41'),
(7, 1, 'Журнал по практике', '2026-06-20 21:34:13', 'ready', 'uploads/reports/6a36c1055699f_Zhurnal_po_praktike__kopia.docx', NULL, '2026-06-20 16:34:13'),
(8, 1, 'Отчёт', '2026-06-20 21:35:36', 'draft', 'uploads/reports/6a36c15827649_Otchet.docx', NULL, '2026-06-20 16:35:36'),
(9, 1, 'Содержание практики', '2026-06-20 21:36:13', 'draft', 'uploads/reports/6a36c17d64324_Soderzhanie_praktiki.doc', NULL, '2026-06-20 16:36:13');

-- --------------------------------------------------------

--
-- Структура таблицы `report_feedback`
--

CREATE TABLE `report_feedback` (
  `id` int NOT NULL,
  `report_id` int NOT NULL,
  `reviewer_id` int NOT NULL,
  `comment` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `feedback_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('submitted','reviewed','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `group_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `students`
--

INSERT INTO `students` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(3, 4, 2),
(4, 5, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `student_assignments`
--

CREATE TABLE `student_assignments` (
  `id` int NOT NULL,
  `student_id` int NOT NULL,
  `group_id` int NOT NULL,
  `practice_id` int NOT NULL,
  `supervisor_id` int NOT NULL,
  `completed_hours` int NOT NULL,
  `final_grade` decimal(3,1) NOT NULL,
  `status` enum('draft','under_review','completed') NOT NULL DEFAULT 'draft'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `student_assignments`
--

INSERT INTO `student_assignments` (`id`, `student_id`, `group_id`, `practice_id`, `supervisor_id`, `completed_hours`, `final_grade`, `status`) VALUES
(1, 1, 1, 1, 1, 16, '4.8', 'completed'),
(2, 3, 2, 2, 1, 0, '0.0', 'completed'),
(5, 4, 3, 2, 1, 3, '0.0', 'draft');

-- --------------------------------------------------------

--
-- Структура таблицы `student_documents`
--

CREATE TABLE `student_documents` (
  `id` int NOT NULL,
  `template_id` int NOT NULL,
  `assignment_id` int NOT NULL,
  `student_content` text,
  `status` enum('draft','submitted','rejected','approved') NOT NULL DEFAULT 'draft',
  `comment` text,
  `document_path` varchar(255) NOT NULL,
  `draft_path` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `student_documents`
--

INSERT INTO `student_documents` (`id`, `template_id`, `assignment_id`, `student_content`, `status`, `comment`, `document_path`, `draft_path`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Вся аттестация', 'approved', NULL, 'uploads/ready-documents/Attestatsionny_list.doc', 'uploads/draft/Attestatsionny_list.doc', '2026-06-18 19:00:00', '2026-06-18 19:00:00'),
(2, 2, 1, 'Все записи в журнале', 'draft', '', 'uploads/ready-documents/6a365c6b1a50b_Zhurnal_po_praktike__kopia.docx', 'uploads/draft/6a365c6b1a581_Zhurnal_po_praktike__kopia.docx', '2026-06-19 19:00:00', '2026-06-19 19:00:00');

-- --------------------------------------------------------

--
-- Структура таблицы `supervisors`
--

CREATE TABLE `supervisors` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `department` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `supervisors`
--

INSERT INTO `supervisors` (`id`, `user_id`, `phone`, `department`) VALUES
(1, 2, '+7(920)182-02-39', 'ГБПОУ \"Курганский педагогический колледж\"'),
(2, 6, '+7(930)183-32-91', 'ГБПОУ \"Курганский педагогический колледж\"');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `patronymic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('student','supervisor','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'student',
  `is_blocked` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `name`, `surname`, `patronymic`, `username`, `password`, `role`, `is_blocked`) VALUES
(1, 'Егор', 'Шмаков', 'Евгеньевич', 'egorka', '$2y$13$WbDOV5eoLXAI8ax6.WWjRu0MH.bhcrTQ2V31U3UPUQzLO/tHnhEeW', 'student', 0),
(2, 'Петр', 'Корюкин', 'Валентинович', 'peters', '$2y$13$KPoGd27oGYFrVHraCH/t/uZBL.FZl6tmlaUXjnGMYsgpUPANjhhmi', 'supervisor', 0),
(3, 'Роман', 'Вартанов', 'Зиновьевич', 'romance', '$2y$10$pJxHNRTTNpaPkuFyjE/Z9OtN.qT2fBVeBXXIE4lRM6lbjjH/6RgtS', 'admin', 0),
(4, 'Полина', 'Гусева', 'Олеговна', 'polinka', '$2y$13$f2Kn07Hi4vsljOXPu3pUmuzocUTBL02W1tzIWVBv6o0UAgQuBwjfC', 'student', 0),
(5, 'Иван', 'Петров', 'Сергеевич', 'Ivanko', '$2y$13$Ng8XC.E9BxO0FuO0bLNRwOBjwAc4sOeNiCNRtcuP.JywHqJUVahWW', 'student', 0),
(6, 'Григорий', 'Сидоров', 'Николаевич', 'Gregory', '$2y$13$N/QNa0253z7pmlYbsewgy.c.UKtyo/xbwtW6LULhAdmk0OU/0d3Bq', 'supervisor', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD PRIMARY KEY (`item_name`,`user_id`),
  ADD KEY `idx-auth_assignment-user_id` (`user_id`);

--
-- Индексы таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD PRIMARY KEY (`name`),
  ADD KEY `rule_name` (`rule_name`),
  ADD KEY `idx-auth_item-type` (`type`);

--
-- Индексы таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD PRIMARY KEY (`parent`,`child`),
  ADD KEY `child` (`child`);

--
-- Индексы таблицы `auth_rule`
--
ALTER TABLE `auth_rule`
  ADD PRIMARY KEY (`name`);

--
-- Индексы таблицы `diary_entries`
--
ALTER TABLE `diary_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Индексы таблицы `document_templates`
--
ALTER TABLE `document_templates`
  ADD PRIMARY KEY (`id`),
  ADD KEY `practice_id` (`practice_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Индексы таблицы `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `group_practices`
--
ALTER TABLE `group_practices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `practice_id` (`practice_id`);

--
-- Индексы таблицы `migration`
--
ALTER TABLE `migration`
  ADD PRIMARY KEY (`version`);

--
-- Индексы таблицы `practices`
--
ALTER TABLE `practices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `main_supervisor_id` (`main_supervisor_id`);

--
-- Индексы таблицы `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_reports_assignment` (`assignment_id`);

--
-- Индексы таблицы `report_feedback`
--
ALTER TABLE `report_feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_rf_report` (`report_id`),
  ADD KEY `fk_rf_reviewer` (`reviewer_id`);

--
-- Индексы таблицы `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Индексы таблицы `student_assignments`
--
ALTER TABLE `student_assignments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `group_id` (`group_id`),
  ADD KEY `practice_id` (`practice_id`),
  ADD KEY `supervisor_id` (`supervisor_id`);

--
-- Индексы таблицы `student_documents`
--
ALTER TABLE `student_documents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `template_id` (`template_id`),
  ADD KEY `assignment_id` (`assignment_id`);

--
-- Индексы таблицы `supervisors`
--
ALTER TABLE `supervisors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `diary_entries`
--
ALTER TABLE `diary_entries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `document_templates`
--
ALTER TABLE `document_templates`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT для таблицы `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `group_practices`
--
ALTER TABLE `group_practices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `practices`
--
ALTER TABLE `practices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `reports`
--
ALTER TABLE `reports`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `report_feedback`
--
ALTER TABLE `report_feedback`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `student_assignments`
--
ALTER TABLE `student_assignments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `student_documents`
--
ALTER TABLE `student_documents`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `supervisors`
--
ALTER TABLE `supervisors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `auth_assignment`
--
ALTER TABLE `auth_assignment`
  ADD CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item`
--
ALTER TABLE `auth_item`
  ADD CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `auth_item_child`
--
ALTER TABLE `auth_item_child`
  ADD CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `diary_entries`
--
ALTER TABLE `diary_entries`
  ADD CONSTRAINT `diary_entries_ibfk_1` FOREIGN KEY (`assignment_id`) REFERENCES `student_assignments` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `document_templates`
--
ALTER TABLE `document_templates`
  ADD CONSTRAINT `document_templates_ibfk_1` FOREIGN KEY (`practice_id`) REFERENCES `practices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `document_templates_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `user` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `group_practices`
--
ALTER TABLE `group_practices`
  ADD CONSTRAINT `group_practices_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `group_practices_ibfk_2` FOREIGN KEY (`practice_id`) REFERENCES `practices` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `practices`
--
ALTER TABLE `practices`
  ADD CONSTRAINT `practices_ibfk_1` FOREIGN KEY (`main_supervisor_id`) REFERENCES `supervisors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `reports`
--
ALTER TABLE `reports`
  ADD CONSTRAINT `fk_reports_assignment` FOREIGN KEY (`assignment_id`) REFERENCES `student_assignments` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `report_feedback`
--
ALTER TABLE `report_feedback`
  ADD CONSTRAINT `fk_rf_report` FOREIGN KEY (`report_id`) REFERENCES `reports` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_rf_reviewer` FOREIGN KEY (`reviewer_id`) REFERENCES `supervisors` (`user_id`) ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `students_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `students_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `student_assignments`
--
ALTER TABLE `student_assignments`
  ADD CONSTRAINT `student_assignments_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_assignments_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_assignments_ibfk_3` FOREIGN KEY (`practice_id`) REFERENCES `practices` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_assignments_ibfk_4` FOREIGN KEY (`supervisor_id`) REFERENCES `supervisors` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `student_documents`
--
ALTER TABLE `student_documents`
  ADD CONSTRAINT `student_documents_ibfk_1` FOREIGN KEY (`template_id`) REFERENCES `document_templates` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  ADD CONSTRAINT `student_documents_ibfk_2` FOREIGN KEY (`assignment_id`) REFERENCES `student_assignments` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT;

--
-- Ограничения внешнего ключа таблицы `supervisors`
--
ALTER TABLE `supervisors`
  ADD CONSTRAINT `supervisors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
