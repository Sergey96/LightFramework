-- phpMyAdmin SQL Dump
-- version 4.5.3.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июн 24 2018 г., 01:15
-- Версия сервера: 5.7.10
-- Версия PHP: 7.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `light`
--

-- --------------------------------------------------------

--
-- Структура таблицы `access_roles`
--

CREATE TABLE `access_roles` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `access_roles`
--

TRUNCATE TABLE `access_roles`;
--
-- Дамп данных таблицы `access_roles`
--

INSERT INTO `access_roles` (`id`, `name`) VALUES
(1, 'admin'),
(4, 'dev');

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` text NOT NULL,
  `created` datetime NOT NULL,
  `description` text NOT NULL,
  `content` text NOT NULL,
  `owner` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `articles`
--

TRUNCATE TABLE `articles`;
--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `title`, `created`, `description`, `content`, `owner`) VALUES
(1, 'О кафедре «Программное обеспечение вычислительной техники и автоматизированных систем»', '2018-05-31 05:23:26', '<img class="first-img" src="/img/articles/fkfn-dekan-sin.png"><p>Кафедра «Программное обеспечение вычислительной техники и автоматизированных систем» была создана в 1989 году по инициативе ректора Хабаровского государственного технического университета профессора Булгакова В.К. В этом же году был произведен первый набор студентов на одноименную специальность.</p>', '<img class="first-img" src="/img/articles/fkfn-dekan-sin.png">\r\n	<p>Кафедра «Программное обеспечение вычислительной техники и автоматизированных систем» была создана в 1989 году по инициативе ректора Хабаровского государственного технического университета профессора Булгакова В.К. В этом же году был произведен первый набор студентов на одноименную специальность.</p>\r\n	<p>Учебно-лабораторная база обеспечивает проведение учебных занятий по всем дисциплинам учебного плана кафедры и самостоятельную работу студентов, требующую применения ВТ. В настоящее время для проведения учебных занятий, научно-исследовательской деятельности студентов и дипломного проектирования используется 2 компьютерных класса кафедры на 30 рабочих мест. Общее количество часов машинного времени, используемого в учебном процессе для специальности «ПО ВТ и АС», составляет более 3000 часов в год. Две аудитории кафедры были оборудованы мультимедиа-проектором. Оборудование используется для проведения занятий и научных семинаров. Кафедра располагает 1 сервером ЛВС ТОГУ с выходом в Internet.</p>\r\n	<img class="right" src="/img/articles/photo1.jpg__150x154_q85_crop_upscale.jpg">\r\n	\r\n	<p>На кафедре открыта аспирантура по специальностям 05.13.16 «Применение вычислительной техники, математического моделирования и математических методов в научных исследованиях» и 01.01.07 «Вычислительная математика». Научное руководство осуществляют доктора наук Булгаков В.К., Намм Р.В., Быковский В.А. Последняя на сегодняшний день защита состоялась 27 апреля 2011 г., соискатель - выпускник ТОГУ Ткаченко А.С.</p>\r\n	<p>Кафедра ведет научное сотрудничество с ВЦ и ИПМ ДВО РАН, Чангвонским Национальным университетом (Республика Корея). В подготовке высококвалифицированных научных кадров принимает активное участие директор ХО ИМ ДВО РАН член-корреспондент РАН, д.ф.-м.н., профессор Быковский В.А.</p>\r\n	<img src="/img/articles/photo2.jpg__150x129_q85_crop_upscale.jpg">\r\n	<p>До набора 2011/2012 учебного года подготовка студентов на кафедре велась:</p>\r\n	<ul>\r\n		<li>по специальности 230105.65 Программное обеспечение вычислительной техники и автоматизированных систем, квалификация «дипломированный специалист»</li>\r\n		<li>по направлению 230100.62 Информатика и вычислительная техника, квалификация (степень) «бакалавр»</li>\r\n		<li>по направлению 230100.68 Информатика и вычислительная техника, квалификация (степень) «магистр»</li>\r\n		<li></li>\r\n	</ul>\r\n	<p>С набора 2011/2012 учебного года направление подготовки кафедры 231000 Программная инженерия:</p>\r\n	<ul>\r\n		<li>квалификация (степень) Бакалавр</li>\r\n		<li>квалификация (степень) Магистр</li>\r\n	</ul>\r\n	<p>По окончании обучения выпускнику присваивается специальное звание «бакалавр-инженер», «магистр-инженер».</p>', 'admin'),
(4, 'Международное сотрудничество', '2018-05-31 05:23:26', 'Одной из важнейших задач российского образования на современном этапе является подготовка высококвалифицированных специалистов для национальной экономики и интеграция российских вузов в мировую систему образования.\r\n\r\nС 1989 года в ТОГУ взят курс на развитие международного сотрудничества, и в настоящий момент установлены долговременные международные образовательные и научные связи более чем с 130 зарубежными партнерами из 15 стран мира. Наибольшее число контактов приходится на ближнее зарубежье Дальнего Востока России – страны Азиатско-Тихоокеанского региона.', '<div class="text-plugin">\r\n<p><a style="float: right; margin-left: 10px;" rel="lytebox[]" href="/media/filer_public/2013/05/30/ic.jpg"><img alt="" src="/media/filer_public_thumbnails/filer_public/2013/05/30/ic.jpg__240x180_q85_crop_upscale.jpg"></a></p>\r\n\r\n<p>Одной из важнейших задач российского образования на современном этапе является подготовка высококвалифицированных специалистов для национальной экономики и интеграция российских вузов в мировую систему образования.</p>\r\n\r\n<p>С 1989 года в ТОГУ взят курс на развитие международного сотрудничества, и в настоящий момент установлены долговременные международные образовательные и научные связи более чем с 130 <a href="http://pnu.edu.ru/ru/ic/institutions/">зарубежными партнерами</a> из 15 стран мира. Наибольшее число контактов приходится на ближнее зарубежье Дальнего Востока России – страны Азиатско-Тихоокеанского региона. В соответствии с долгосрочными программами сотрудничества университет осуществляет мероприятия по академическому и студенческому обмену, совместные научно-исследовательские, инновационно-технологические, образовательные, культурные и деловые проекты, обучает иностранных студентов и аспирантов в своих стенах и направляет российских студентов на учебу за рубежом.</p>\r\n\r\n<p>ТОГУ является одним из организаторов и активным участником проведения международных форумов ректоров вузов Дальнего Востока и Сибири Российской Федерации и Северо-Восточных провинций Китайской Народной Республики. В марте 2011 года ТОГУ стал членом элитной международной организации – Ассоциации технических университетов России и Китая (ASRTU), в которую входят 30 вузов.</p>\r\n\r\n<p>В ТОГУ ежегодно обучаются более 800 иностранных студентов, большинство из которых составляют граждане КНР; кроме того, в ТОГУ обучаются граждане Республики Корея, КНДР, Японии.</p>\r\n\r\n<p>ТОГУ активно развивает внешнеэкономическую деятельность, содействующую развитию проектов международного сотрудничества. За 2015 год Тихоокеанский государственный университет посетили 21 делегация.</p>\r\n\r\n<p>Среди них особо выделяются:</p>\r\n\r\n<ul>\r\n	<li>делегации префектуры Хоккайдо (Япония)</li>\r\n	<li>делегация Грифитского университета  (Австралия)</li>\r\n	<li>делегация Университета Канто Гакуин (Япония)</li>\r\n	<li>делегация Харбинского политехнического института (КНР)</li>\r\n	<li>делегация МТЦ LG (КНР)</li>\r\n	<li>делегация университета Гачхон (Южная Корея)</li>\r\n</ul>\r\n\r\n<p>Университет прошел сертификацию по международному стандарту ISO 9001:2008 в сфере предоставления образовательных услуг.</p>\r\n\r\n<p><a href="http://pnu.edu.ru/ru/ic/id/">Управление международной деятельности</a> Тихоокеанского государственного университета действует в целях повышения эффективности международного сотрудничества для обеспечения конкурентоспособности на рынке образовательных услуг, роста международного авторитета ТОГУ как высокопрофессионального учебного и научного центра.</p>\r\n\r\n<p>В рамках концепции развития ТОГУ деятельность Управления направлена на:</p>\r\n\r\n<ul>\r\n	<li>повышение и укрепление репутации университета на международной арене;</li>\r\n	<li>достижение международного уровня конкурентоспособности результатов учебной и научно-исследовательской деятельности;</li>\r\n	<li>увеличение количества и повышение эффективности международных договоров и соглашений на обучение студентов;</li>\r\n	<li>привлечение средств от международной деятельности в бюджет университета.</li>\r\n</ul>\r\n\r\n<p>Для достижения вышеуказанных целей Управлением решаются следующие задачи:</p>\r\n\r\n<ul>\r\n	<li>реализация политики университета в области международной деятельности, обеспечивающей необходимые условия для формирования имиджа ТОГУ в сфере образовательной и научно-технической деятельности на уровне зарубежных учебных заведений высшего профессионального образования;</li>\r\n	<li>организация и контроль выполнения федеральных и межвузовских международных программ, реализуемых в университете;</li>\r\n	<li>разработка и реализация в рамках своей компетенции международных образовательных и научно-технических программ.</li>\r\n	<li>разработка и реализация политики университета, направленной на расширение международной деятельности университета, повышение эффективности её функционирования;</li>\r\n	<li>развитие системы дополнительного профессионального образования и услуг для иностранных граждан, сторонних организаций и населения;</li>\r\n	<li>развитие международного и межрегионального сотрудничества в целях содействия интеграции университета в мировое образовательное пространство.</li>\r\n</ul>\r\n\r\n<p><strong>Контактная информация</strong></p>\r\n\r\n<p>E-mail: <a href="mailto:intdep@pnu.edu.ru">study@pnu.edu.ru</a><br>\r\nТелефон: (4212) 72-07-12<br>\r\nФакс: (4212) 72-07-12<br>\r\nАдрес: 680035, Россия, г. Хабаровск, ул. Тихоокеанская, 136, ауд. 237ц.</p>\r\n\r\n<div style="display: none;">\r\n<h2>Зарубежные партнеры ТОГУ</h2>\r\n\r\n<ul>\r\n	<li><a href="http://pnu.edu.ru/ru/ic/institutions/">Организации и учреждения</a></li>\r\n	<li><a href="http://pnu.edu.ru/ru/ic/agreements/">Реестр соглашений ТОГУ с зарубежными партнерами</a></li>\r\n	<li><a href="http://pnu.edu.ru/ru/ic/participation/">Участие ТОГУ в международных ассоциациях</a></li>\r\n</ul>\r\n</div>\r\n\r\n</div>', 'adminss');

-- --------------------------------------------------------

--
-- Структура таблицы `assign_roles`
--

CREATE TABLE `assign_roles` (
  `id` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_role` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `assign_roles`
--

TRUNCATE TABLE `assign_roles`;
--
-- Дамп данных таблицы `assign_roles`
--

INSERT INTO `assign_roles` (`id`, `id_user`, `id_role`) VALUES
(1, 1, 1),
(3, 1, 1),
(4, 1, 4);

-- --------------------------------------------------------

--
-- Структура таблицы `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `sender` text NOT NULL,
  `sender_email` text,
  `theme` text NOT NULL,
  `content` text NOT NULL,
  `created` datetime NOT NULL,
  `readed` int(11) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `feedback`
--

TRUNCATE TABLE `feedback`;
--
-- Дамп данных таблицы `feedback`
--

INSERT INTO `feedback` (`id`, `sender`, `sender_email`, `theme`, `content`, `created`, `readed`) VALUES
(1, 'Ceргей', 'sergey___96@mail.ru', 'Все сломалось', 'Не работает страница ошибки', '2018-06-04 07:03:50', NULL),
(2, 'Ceргей', 'sergey___96@mail.ru', 'Все сломалось', 'Ничего не работает', '2018-06-04 07:05:12', NULL);

-- --------------------------------------------------------
-- --------------------------------------------------------

--
-- Структура таблицы `schedule`
--

CREATE TABLE `schedule` (
  `id` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `number_work` int(11) NOT NULL,
  `type_week` text NOT NULL,
  `number_day` int(11) NOT NULL,
  `sub_group` int(11) NOT NULL,
  `type_work` text NOT NULL,
  `title_work` text NOT NULL,
  `room` text NOT NULL,
  `id_teacher` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `schedule`
--

TRUNCATE TABLE `schedule`;
--
-- Дамп данных таблицы `schedule`
--

INSERT INTO `schedule` (`id`, `id_group`, `number_work`, `type_week`, `number_day`, `sub_group`, `type_work`, `title_work`, `room`, `id_teacher`) VALUES
(1, 1, 1, 'ч', 1, 1, 'лб', 'Распределенные системы обработки информации', '327п', 1),
(2, 1, 1, 'ч', 1, 2, 'лб', 'Технология командной разработки ПО', '330п', 2),
(3, 1, 1, 'з', 1, 1, 'лб', 'Технология командной разработки ПО', '330п', 2),
(4, 1, 1, 'з', 1, 2, 'лб', 'Распределенные системы обработки информации', '330п', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `sidebar_section`
--

CREATE TABLE `sidebar_section` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `sidebar_section`
--

TRUNCATE TABLE `sidebar_section`;
--
-- Дамп данных таблицы `sidebar_section`
--

INSERT INTO `sidebar_section` (`id`, `name`) VALUES
(1, 'Главная'),
(2, 'Расписание'),
(4, 'Кафедра'),
(5, 'Обратная связь');

-- --------------------------------------------------------

--
-- Структура таблицы `sidebar_submenu`
--

CREATE TABLE `sidebar_submenu` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `link` text NOT NULL,
  `id_section` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `sidebar_submenu`
--

TRUNCATE TABLE `sidebar_submenu`;
--
-- Дамп данных таблицы `sidebar_submenu`
--

INSERT INTO `sidebar_submenu` (`id`, `name`, `link`, `id_section`) VALUES
(1, 'Главная', '/home/index/', 1),
(2, 'По группам', '/rasp/groups', 2),
(6, 'ПОВТиАС', '/article/view?id=1', 4),
(7, 'Обратная связь', '/feedback/create', 5);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `token` text NOT NULL,
  `created` datetime NOT NULL,
  `avatar` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Очистить таблицу перед добавлением данных `users`
--

TRUNCATE TABLE `users`;
--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `password`, `token`, `created`, `avatar`) VALUES
(1, 'admin', '$2y$10$9m0dp2U2zd.lsmk9lm0kbeWc7V9qQ0IDTQvaLiW0tCbNKtwrWj5Re', '73a8c30d6ddef2296ec06c46e80f8a08', '2018-05-31 05:23:26', '/img/avatars/face.png'),
(3, 'moder', '123456', '', '2018-05-31 05:23:26', '/img/avatars/face2.png'),
(13, 'user', '$2y$10$3jwye7rQI2wSyc9QNVOJduNaDOt.2vaiEBzaw5xazvF81QtP9irQS', '074334b763e91908dcee9ab6e2d7ba73', '2018-05-31 05:23:26', '/img/avatars/face1.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `access_roles`
--
ALTER TABLE `access_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQUE` (`name`(25)) USING BTREE;

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `assign_roles`
--
ALTER TABLE `assign_roles`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `films`
--
ALTER TABLE `films`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sidebar_section`
--
ALTER TABLE `sidebar_section`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `sidebar_submenu`
--
ALTER TABLE `sidebar_submenu`
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
-- AUTO_INCREMENT для таблицы `access_roles`
--
ALTER TABLE `access_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT для таблицы `assign_roles`
--
ALTER TABLE `assign_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT для таблицы `films`
--
ALTER TABLE `films`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `schedule`
--
ALTER TABLE `schedule`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT для таблицы `sidebar_section`
--
ALTER TABLE `sidebar_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT для таблицы `sidebar_submenu`
--
ALTER TABLE `sidebar_submenu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
