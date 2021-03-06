-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия сервера:               5.6.26 - MySQL Community Server (GPL)
-- ОС Сервера:                   Win32
-- HeidiSQL Версия:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Дамп структуры для таблица testbeejee.feedback
CREATE TABLE IF NOT EXISTS `feedback` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` varchar(250) DEFAULT '0',
  `img` varchar(50) DEFAULT NULL,
  `user_id` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `changed` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `FK_feedback_user` (`user_id`),
  CONSTRAINT `FK_feedback_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы testbeejee.feedback: ~5 rows (приблизительно)
/*!40000 ALTER TABLE `feedback` DISABLE KEYS */;
INSERT INTO `feedback` (`id`, `text`, `img`, `user_id`, `created_at`, `changed`, `status`) VALUES
	(46, 'test text', '', 36, '2016-10-18 08:46:49', 1, 1);
/*!40000 ALTER TABLE `feedback` ENABLE KEYS */;


-- Дамп структуры для таблица testbeejee.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth_token` varchar(32) NOT NULL DEFAULT '0',
  `auth_token_created_at` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `login` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `name` char(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

-- Дамп данных таблицы testbeejee.user: ~6 rows (приблизительно)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `auth_token`, `auth_token_created_at`, `login`, `password`, `name`, `email`) VALUES
	(1, '1209047b49f6697ae3ac126834ae0e90', '2016-10-20 09:16:58', 'admin', '202cb962ac59075b964b07152d234b70', 'Alex', 'shehovtsov_av@mail.ru'),
	(36, '0', '0000-00-00 00:00:00', '', '', 'Иван', 'ivanov@some.ru');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
