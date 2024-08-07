-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         8.0.30 - MySQL Community Server - GPL
-- SO del servidor:              Win64
-- HeidiSQL Versión:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Volcando estructura de base de datos para hotel
CREATE DATABASE IF NOT EXISTS `hotel` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `hotel`;

-- Volcando estructura para tabla hotel.cabanas
CREATE TABLE IF NOT EXISTS `cabanas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo_cabana` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `cabanas_id_tipo_cabana_foreign` (`id_tipo_cabana`),
  CONSTRAINT `cabanas_id_tipo_cabana_foreign` FOREIGN KEY (`id_tipo_cabana`) REFERENCES `tipo_cabanas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.cabanas: ~8 rows (aproximadamente)
INSERT INTO `cabanas` (`id`, `id_tipo_cabana`, `created_at`, `updated_at`) VALUES
	(1, 1, '2024-05-02 05:48:28', '2024-05-02 05:48:28'),
	(2, 1, '2024-05-02 05:48:33', '2024-05-02 05:48:33'),
	(3, 1, '2024-05-02 05:48:39', '2024-05-02 05:48:39'),
	(4, 1, '2024-05-02 05:48:45', '2024-05-02 05:48:45'),
	(5, 2, '2024-05-02 05:49:24', '2024-05-02 05:49:24'),
	(6, 2, '2024-05-02 05:49:30', '2024-05-02 05:49:30'),
	(7, 2, '2024-05-02 05:49:44', '2024-05-02 05:49:44'),
	(8, 3, '2024-05-02 05:50:00', '2024-05-02 05:50:00');

-- Volcando estructura para tabla hotel.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.failed_jobs: ~0 rows (aproximadamente)

-- Volcando estructura para tabla hotel.imagen_cabanas
CREATE TABLE IF NOT EXISTS `imagen_cabanas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo_cabana` bigint unsigned NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_imagen` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imagen_cabanas_id_tipo_cabana_foreign` (`id_tipo_cabana`),
  CONSTRAINT `imagen_cabanas_id_tipo_cabana_foreign` FOREIGN KEY (`id_tipo_cabana`) REFERENCES `tipo_cabanas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.imagen_cabanas: ~19 rows (aproximadamente)
INSERT INTO `imagen_cabanas` (`id`, `id_tipo_cabana`, `url`, `nombre_imagen`, `created_at`, `updated_at`) VALUES
	(1, 1, 'WLoQAOYiJPSBy1iP2eAnwgnL430cG2SsSCtrQ6oB.png', 'africana1.png', '2024-05-02 07:12:53', '2024-05-02 07:12:53'),
	(2, 1, 'XH2BCm7N15uAdfMqfPoovnzrFDVO1pPmFYVVVck6.png', 'africana2.png', '2024-05-02 07:13:02', '2024-05-02 07:13:02'),
	(3, 1, 'bLCIshlQl1WZNK5kS6rNV2ToESaq1IJf3QLQG5yk.png', 'africana3.png', '2024-05-02 07:13:11', '2024-05-02 07:13:11'),
	(4, 1, 'ALx5icEQiYkGxMYjOPBTAPvXqwordn4QkkobNOxM.png', 'africana4.png', '2024-05-02 07:13:21', '2024-05-02 07:13:21'),
	(5, 1, 'FSxHbxWP4XlghdqpFkhaLPQXVuIwBMvk4LrNxKpj.png', 'africana5.png', '2024-05-02 07:13:30', '2024-05-02 07:13:30'),
	(6, 1, 'NGjeojhc6CUsEs8eYr8r5JyJiIhVr9P079MjINnn.png', 'africana6.png', '2024-05-02 07:13:38', '2024-05-02 07:13:38'),
	(7, 2, 'cULhQwJeYrRCT7V2CwXO4DfkZSLaGdWtP634KecP.png', 'amazonica1.png', '2024-05-02 07:14:18', '2024-05-02 07:14:18'),
	(8, 2, 'isL4czyeh8EIaSQ8RaZNQ0p0zLtbZXfFrWLXZmne.png', 'amazonica2.png', '2024-05-02 07:14:28', '2024-05-02 07:14:28'),
	(9, 2, 'lmlfeLiSjNDtJFnrBriYygSCqwGXDjpXFS0X8RgE.png', 'amazonica3.png', '2024-05-02 07:14:40', '2024-05-02 07:14:40'),
	(10, 2, 'aKCw3uHmUjSdOLenXdQyLw74IUDz9XVgJ3moHhQO.png', 'amazonica4.png', '2024-05-02 07:14:48', '2024-05-02 07:14:48'),
	(11, 2, 'k5OU8ZxUrdPSUMFEy2DSemKTyHms5SQeVXIZXjLq.png', 'amazonica5.png', '2024-05-02 07:14:58', '2024-05-02 07:14:58'),
	(12, 2, 'odSVxC8axvnfPqTO4By20uhzd50qGKTRq2fBURwW.png', 'amazonica6.png', '2024-05-02 07:15:07', '2024-05-02 07:15:07'),
	(13, 3, 'UWQzJpcXHpLBsAHKIByRoOrYdSwm5YfD7Z5Z7Pjv.png', 'hawaiana1.png', '2024-05-02 07:15:33', '2024-05-02 07:15:33'),
	(14, 3, '7taHw8ojXtOlxUfT6CTU1EB83QAy7i7KC6SPvzcU.png', 'hawaiana2.png', '2024-05-02 07:15:45', '2024-05-02 07:15:45'),
	(15, 3, 'V4C580lh70ZtkGb3o5P1YP2u2XyzVhwSr5f3fVTk.png', 'hawaiana3.png', '2024-05-02 07:16:05', '2024-05-02 07:16:05'),
	(16, 3, 'jn6hVm4pGCRaH7z4ZqMIGM4ikrY2eglNoLJRKcVr.png', 'hawaiana4.png', '2024-05-02 07:16:25', '2024-05-02 07:16:25'),
	(17, 3, 'hvrweNdsWBLlY20AKgj6diY22amXcNyH7CllUD6s.png', 'hawaiana5.png', '2024-05-02 07:16:33', '2024-05-02 07:16:33'),
	(18, 3, 'zTIK2mU3tbPdceQHU55ZKzDuZ6iCscCxSDDnhjer.png', 'hawaiana6.png', '2024-05-02 07:16:48', '2024-05-02 07:16:48'),
	(19, 3, '1ONlYB5ejmoh31cBuGRkqtYK5FNrASgN3S1OYzfJ.png', 'hawaiana7.png', '2024-05-02 07:16:57', '2024-05-02 07:16:57');

-- Volcando estructura para tabla hotel.imagen_salons
CREATE TABLE IF NOT EXISTS `imagen_salons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_salon` bigint unsigned NOT NULL,
  `url` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nombre_imagen` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `imagen_salons_id_salon_foreign` (`id_salon`),
  CONSTRAINT `imagen_salons_id_salon_foreign` FOREIGN KEY (`id_salon`) REFERENCES `salons` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.imagen_salons: ~12 rows (aproximadamente)
INSERT INTO `imagen_salons` (`id`, `id_salon`, `url`, `nombre_imagen`, `created_at`, `updated_at`) VALUES
	(1, 1, 'CQZ3LSolHIyVgkkUlx8Z9lTfD7KNOqWhLHCyBzXi.png', 'tundra1.png', '2024-05-02 07:46:38', '2024-05-02 07:46:38'),
	(2, 1, 'Qfd0imQwfUxUM69tNOCslac2VbZRr66nF8ERdKhP.png', 'tundra2.png', '2024-05-02 07:46:45', '2024-05-02 07:46:45'),
	(3, 1, 'Pw0A1vHilDnM15ZXr46iPeGHres4hV58SkoAxYS5.png', 'tundra3.png', '2024-05-02 07:46:52', '2024-05-02 07:46:52'),
	(4, 2, '8aW8XU5L2Y3X07yDESpfe2EgIdOgGpAZ5xFmJX8A.png', 'arabia1.png', '2024-05-02 07:47:04', '2024-05-02 07:47:04'),
	(5, 2, '1QNtXEgnX7SXhgRvLLkJZqiBITURa472EwY6YPGb.png', 'arabia2.png', '2024-05-02 07:47:12', '2024-05-02 07:47:12'),
	(6, 2, 'e8vF98ZQ1m5HVThjtOjlK1TkEWnJUmAoEB35GcpI.png', 'arabia3.png', '2024-05-02 07:47:20', '2024-05-02 07:47:20'),
	(7, 3, 'HfaTpRgNM93Q5wkq6i4TJhZWMAdgYRXopoTsDtpP.png', 'egipto1.png', '2024-05-02 07:47:34', '2024-05-02 07:47:34'),
	(8, 3, 'aylHkxN36H3GchC5WdQNTQ6bKlmBrIzHpSraPEeV.png', 'egipto2.png', '2024-05-02 07:47:44', '2024-05-02 07:47:44'),
	(9, 3, 's5rCmThhTxAoKscg0XdIxhAbnLN4oDMxIkisvvQt.png', 'egipto3.png', '2024-05-02 07:47:55', '2024-05-02 07:47:55'),
	(10, 4, 'hB8tBnC9NHkD3zpCx4tgvhY54AIwq4sccwIGRiiM.png', 'niagara1.png', '2024-05-02 07:53:21', '2024-05-02 07:53:21'),
	(11, 4, 'HyS5ZiiHLikK4vicEojmrDlZlUPsuyQsO06xCw2N.png', 'niagara2.png', '2024-05-02 07:53:30', '2024-05-02 07:53:30'),
	(12, 4, 'zxUznojZ9ttjyJ6ACG4LvM8kQ4P57o38AbcPtJoN.png', 'niagara3.png', '2024-05-02 07:53:42', '2024-05-02 07:53:42');

-- Volcando estructura para tabla hotel.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.migrations: ~0 rows (aproximadamente)
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_000000_create_users_table', 1),
	(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
	(3, '2014_10_12_100000_create_password_resets_table', 1),
	(4, '2019_08_19_000000_create_failed_jobs_table', 1),
	(5, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(6, '2024_04_12_142445_create_tipo_cabanas_table', 1),
	(7, '2024_04_12_142511_create_cabanas_table', 1),
	(8, '2024_04_12_142614_create_reserva_cabanas_table', 1),
	(9, '2024_04_12_142631_create_imagen_cabanas_table', 1),
	(10, '2024_04_12_142650_create_salons_table', 1),
	(11, '2024_04_12_142828_create_imagen_salons_table', 1),
	(12, '2024_04_12_142843_create_reserva_salons_table', 1),
	(13, '2024_04_18_091032_create_resenas_table', 1),
	(14, '2024_04_19_075456_create_ofertas_table', 1);

-- Volcando estructura para tabla hotel.ofertas
CREATE TABLE IF NOT EXISTS `ofertas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_tipo_cabana` bigint unsigned NOT NULL,
  `descuento` int unsigned NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ofertas_id_tipo_cabana_foreign` (`id_tipo_cabana`),
  CONSTRAINT `ofertas_id_tipo_cabana_foreign` FOREIGN KEY (`id_tipo_cabana`) REFERENCES `tipo_cabanas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.ofertas: ~5 rows (aproximadamente)
INSERT INTO `ofertas` (`id`, `id_tipo_cabana`, `descuento`, `fecha_inicio`, `fecha_fin`, `created_at`, `updated_at`) VALUES
	(1, 1, 30, '2024-07-15', '2024-07-21', '2024-05-02 07:19:09', '2024-05-02 07:19:09'),
	(2, 1, 25, '2024-08-01', '2024-08-04', '2024-05-02 07:20:01', '2024-05-02 07:20:01'),
	(3, 2, 45, '2024-07-23', '2024-07-27', '2024-05-02 07:23:50', '2024-05-02 07:23:50'),
	(4, 2, 20, '2024-08-20', '2024-08-24', '2024-05-02 07:24:28', '2024-05-02 07:24:28'),
	(5, 3, 35, '2024-07-16', '2024-07-20', '2024-05-02 07:25:06', '2024-05-02 07:25:06');

-- Volcando estructura para tabla hotel.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.password_resets: ~0 rows (aproximadamente)

-- Volcando estructura para tabla hotel.password_reset_tokens
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.password_reset_tokens: ~0 rows (aproximadamente)
INSERT INTO `password_reset_tokens` (`email`, `token`, `created_at`) VALUES
	('jgonros27@gmail.com', '$2y$12$fUdPn3NsX1p4thwb.spgIubGcoCYIpFTQMsfFY4x/so3O0ruZ7MJq', '2024-05-13 10:01:04');

-- Volcando estructura para tabla hotel.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.personal_access_tokens: ~0 rows (aproximadamente)

-- Volcando estructura para tabla hotel.resenas
CREATE TABLE IF NOT EXISTS `resenas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint unsigned NOT NULL,
  `comentario` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `puntuacion` int unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `resenas_id_usuario_foreign` (`id_usuario`),
  CONSTRAINT `resenas_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.resenas: ~9 rows (aproximadamente)
INSERT INTO `resenas` (`id`, `id_usuario`, `comentario`, `puntuacion`, `created_at`, `updated_at`) VALUES
	(1, 2, 'Me ha gustado mucho este hotel, volvería a repetir sin duda alguna. Es una autentica maravilla, desde el trato del personal hasta el paisaje que ofrece, pasando por las calidades de sus habitaciones. Un 10!!', 5, '2024-05-02 07:56:24', '2024-05-02 07:56:24'),
	(2, 3, 'Espectacular hotel con bonitas vistas para disfrutar en pareja', 5, '2024-05-17 09:30:34', '2024-05-17 09:30:34'),
	(3, 3, 'Me encanta', 5, '2024-05-17 09:43:58', '2024-05-17 09:43:58'),
	(4, 3, 'Volveria a repetir', 5, '2024-05-17 09:53:32', '2024-05-17 09:53:32'),
	(5, 3, 'Mejoraría la comida, por lo demás genial', 4, '2024-05-17 09:59:02', '2024-05-17 09:59:02'),
	(6, 3, 'me encantaria volver a ir', 5, '2024-05-17 10:10:27', '2024-05-17 10:10:27'),
	(7, 3, 'Lo adoro', 5, '2024-05-17 10:11:16', '2024-05-17 10:11:16'),
	(8, 3, 'Muy bien', 5, '2024-05-20 06:07:29', '2024-05-20 06:07:29'),
	(9, 3, 'Me ha parecido muy bien el hotel', 4, '2024-05-20 07:34:40', '2024-05-20 07:34:40'),
	(10, 5, 'Nice room!', 5, '2024-05-20 14:33:54', '2024-05-20 14:33:54'),
	(11, 5, 'Lugar confortable para disfrutar en familia', 5, '2024-05-20 14:34:41', '2024-05-20 14:34:41');

-- Volcando estructura para tabla hotel.reserva_cabanas
CREATE TABLE IF NOT EXISTS `reserva_cabanas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint unsigned NOT NULL,
  `id_cabana` bigint unsigned NOT NULL,
  `fecha_entrada` date NOT NULL,
  `fecha_salida` date NOT NULL,
  `n_huespedes` int unsigned NOT NULL DEFAULT '1',
  `precio_habitacion` double NOT NULL,
  `precio_total` double NOT NULL,
  `descuento` double NOT NULL,
  `media_pension` double NOT NULL,
  `precio_final` double NOT NULL,
  `id_pago` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reserva_cabanas_id_usuario_foreign` (`id_usuario`),
  KEY `reserva_cabanas_id_cabana_foreign` (`id_cabana`),
  CONSTRAINT `reserva_cabanas_id_cabana_foreign` FOREIGN KEY (`id_cabana`) REFERENCES `cabanas` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reserva_cabanas_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.reserva_cabanas: ~10 rows (aproximadamente)
INSERT INTO `reserva_cabanas` (`id`, `id_usuario`, `id_cabana`, `fecha_entrada`, `fecha_salida`, `n_huespedes`, `precio_habitacion`, `precio_total`, `descuento`, `media_pension`, `precio_final`, `id_pago`, `created_at`, `updated_at`) VALUES
	(43, 3, 3, '2024-05-22', '2024-05-23', 2, 80, 80, 0, 0, 80, 'ch_3PGH3IP1krnOqKI009TTURUU', '2024-05-14 06:49:42', '2024-05-14 06:49:42'),
	(44, 3, 3, '2024-05-22', '2024-05-23', 2, 80, 80, 0, 0, 80, 'ch_3PGH8vP1krnOqKI00Y8SikNg', '2024-05-14 06:55:31', '2024-05-14 06:55:31'),
	(45, 3, 4, '2024-05-22', '2024-05-23', 2, 80, 80, 0, 0, 80, 'ch_3PGHQhP1krnOqKI013ih2K2E', '2024-05-14 07:13:53', '2024-05-14 07:13:53'),
	(46, 3, 5, '2024-05-01', '2024-05-02', 2, 100, 100, 0, 0, 100, '', '2024-05-14 07:27:26', '2024-05-14 07:27:26'),
	(47, 3, 1, '2024-05-24', '2024-05-25', 2, 80, 80, 0, 60, 140, 'ch_3PHL3OP1krnOqKI01QmZtOIt', '2024-05-17 05:18:11', '2024-05-17 05:18:11'),
	(48, 3, 1, '2024-05-29', '2024-06-05', 2, 80, 560, 0, 420, 980, 'ch_3PHMKTP1krnOqKI01FDTkpZf', '2024-05-17 06:39:55', '2024-05-17 06:39:55'),
	(49, 3, 5, '2024-05-31', '2024-06-01', 2, 100, 100, 0, 0, 100, 'ch_3PHPr3P1krnOqKI00IKNFH1s', '2024-05-17 10:25:46', '2024-05-17 10:25:46'),
	(50, 3, 1, '2024-06-11', '2024-06-12', 1, 80, 80, 0, 30, 110, 'ch_3PIRS7P1krnOqKI01tFqnmwt', '2024-05-20 06:20:18', '2024-05-20 06:20:18'),
	(51, 3, 1, '2024-06-19', '2024-06-20', 1, 80, 80, 0, 30, 110, 'ch_3PIRc8P1krnOqKI007Gwd0pb', '2024-05-20 06:30:39', '2024-05-20 06:30:39'),
	(56, 5, 5, '2024-08-01', '2024-08-04', 1, 100, 300, 0, 0, 300, 'ch_3PIZ4kP1krnOqKI01EW9G7XO', '2024-05-20 14:28:41', '2024-05-20 14:28:41'),
	(58, 5, 5, '2024-08-05', '2024-08-08', 2, 100, 300, 0, 240, 540, '', '2024-05-20 15:19:42', '2024-05-20 15:19:42'),
	(59, 3, 1, '2024-08-01', '2024-08-04', 2, 80, 240, 60, 180, 360, 'ch_3PIaRcP1krnOqKI00c6HIBCW', '2024-05-20 15:56:23', '2024-05-20 15:56:23'),
	(60, 7, 1, '2024-08-08', '2024-08-15', 1, 80, 560, 0, 0, 560, 'ch_3PlCpeP1krnOqKI01trHFiBK', '2024-08-07 14:35:26', '2024-08-07 14:35:26');

-- Volcando estructura para tabla hotel.reserva_salons
CREATE TABLE IF NOT EXISTS `reserva_salons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` bigint unsigned NOT NULL,
  `id_salon` bigint unsigned NOT NULL,
  `fecha_evento` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `tipo_evento` enum('cumpleaños','boda','bautizo','comunion','evento_empresarial','otros') COLLATE utf8mb4_unicode_ci NOT NULL,
  `mensaje` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_final` double NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `reserva_salons_id_usuario_foreign` (`id_usuario`),
  KEY `reserva_salons_id_salon_foreign` (`id_salon`),
  CONSTRAINT `reserva_salons_id_salon_foreign` FOREIGN KEY (`id_salon`) REFERENCES `salons` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reserva_salons_id_usuario_foreign` FOREIGN KEY (`id_usuario`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.reserva_salons: ~2 rows (aproximadamente)
INSERT INTO `reserva_salons` (`id`, `id_usuario`, `id_salon`, `fecha_evento`, `hora_inicio`, `hora_fin`, `tipo_evento`, `mensaje`, `precio_final`, `created_at`, `updated_at`) VALUES
	(5, 5, 2, '2024-05-15', '12:00:00', '22:00:00', 'boda', 'QUIERO UN COCKTAIL DE INVITADOS', 350, '2024-05-20 14:21:34', '2024-05-20 14:21:34'),
	(7, 5, 3, '2024-08-05', '12:00:00', '22:00:00', 'bautizo', '0', 400, '2024-05-20 15:27:49', '2024-05-22 07:21:17'),
	(8, 3, 1, '2024-05-21', '14:57:00', '21:57:00', 'cumpleaños', 'Cumpleaños feliz', 210, '2024-05-20 15:57:52', '2024-05-20 15:57:52');

-- Volcando estructura para tabla hotel.salons
CREATE TABLE IF NOT EXISTS `salons` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_hora` double unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.salons: ~4 rows (aproximadamente)
INSERT INTO `salons` (`id`, `nombre`, `descripcion`, `precio_hora`, `created_at`, `updated_at`) VALUES
	(1, 'Tundra', 'Agua mineral de bienvenida, atril, tarimas, audiovisuales, catering, decoración, material de escritura, megafonía, montaje a elección del cliente, pantallas y conexión WIFI gratuita.', 30, '2024-05-02 07:28:45', '2024-05-02 07:28:45'),
	(2, 'Arabia', 'Agua mineral de bienvenida, atril, tarimas, audiovisuales, catering, decoración, material de escritura, megafonía, montaje a elección del cliente, pantallas y conexión WIFI gratuita.  Además cuenta con un espacio de desconexión, donde se realizan los coffees si hubieran. También disponen de una barrade bebidas con servicio de camareros.', 35, '2024-05-02 07:29:39', '2024-05-02 07:29:39'),
	(3, 'Egipto', 'Agua mineral de bienvenida, atril, tarimas, audiovisuales, catering, decoración, material de escritura, megafonía, montaje a elección del cliente, pantallas y conexión WIFI gratuita.', 40, '2024-05-02 07:30:10', '2024-05-02 07:30:10'),
	(4, 'Jardín Niágara', 'Es el lugar perfecto donde celebrar un evento personal.  Puedes pedir precio incluso para organizar el acto de una boda civil.  En éste se ncluye el montaje, la decoración del altar y la del  resto del entorno.  450 m2 de pura magia harán que tu evento sea lo más especial que desees.  ​Montajes:  ​Banquete  hasta 125 pax  ​cóctel  hasta 200 pax', 60, '2024-05-02 07:38:03', '2024-05-02 07:38:03');

-- Volcando estructura para tabla hotel.tipo_cabanas
CREATE TABLE IF NOT EXISTS `tipo_cabanas` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio` double unsigned NOT NULL,
  `capacidad` int unsigned NOT NULL,
  `servicios` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_media_pension` double unsigned NOT NULL,
  `dias_cancelacion` int NOT NULL DEFAULT '14',
  `especificaciones` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.tipo_cabanas: ~3 rows (aproximadamente)
INSERT INTO `tipo_cabanas` (`id`, `nombre`, `precio`, `capacidad`, `servicios`, `precio_media_pension`, `dias_cancelacion`, `especificaciones`, `created_at`, `updated_at`) VALUES
	(1, 'Africana', 80, 3, 'Ropa de cama, toallas, productos de aseo personal (gel, champú, pastilla de jabón).;bañera y/o ducha;teléfono;caja fuerte;minibar;aire acondicionado y calefacción;WIFI', 30, 7, 'Perfecta cabaña para disfrutar en pareja o en familia, con parking gratuito, una cama de matrimonio y una cama single. Perfectas vistas a la naturaleza. Disfruta de un espectáculo de luces bajo las estrellas por la noche.', '2024-05-02 05:36:40', '2024-05-02 05:36:40'),
	(2, 'Amazónica', 100, 4, 'Ropa de cama, toallas, productos de aseo personal (gel, champú, pastilla de jabón).;bañera y/o ducha;teléfono;televisión;caja fuerte;minibar;aire acondicionado y calefacción;WIFI;Room service incluido', 40, 7, 'La cabaña está diseñada con materiales naturales y sostenibles, fusionando perfectamente con su entorno selvático. Grandes ventanales ofrecen vistas panorámicas de la densa vegetación y permiten la entrada de luz natural. \r\nLa Cabaña Amazónica ofrece a sus huéspedes una experiencia de lujo en un entorno natural incomparable, donde pueden reconectarse con la naturaleza mientras disfrutan de todas las comodidades y servicios de primera clase.', '2024-05-02 05:42:07', '2024-05-02 05:42:07'),
	(3, 'Hawaiana', 150, 4, 'Ropa de cama, toallas, productos de aseo personal (gel, champú, pastilla de jabón).;ducha, jacuzzi;teléfono;televisión;caja fuerte;minibar;cafetera y tetera;aire acondicionado y calefacción;WIFI;Room service incluido', 30, 7, 'Diseñada para ofrecer a los huéspedes una experiencia de lujo inspirada en el exótico encanto de Hawai. Con su propio jacuzzi privado y una decoración que evoca la esencia de las islas, esta cabaña ofrece un oasis de relajación y elegancia para aquellos que buscan una escapada inolvidable.\r\nLa cabaña Hawaiana ofrece a sus huéspedes una experiencia de lujo y relajación en un entorno tropical cautivador, donde pueden disfrutar de la comodidad y la privacidad de su propio oasis hawaiano sin salir del hotel.', '2024-05-02 05:48:03', '2024-05-02 05:48:03');

-- Volcando estructura para tabla hotel.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla hotel.users: ~5 rows (aproximadamente)
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `admin`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'admin@admin.com', '2024-05-13 05:29:42', '$2y$12$BZZUS5rcUB5D8XNMnk9Bq.XZynOsS8g8828qqwhAjlZ22WKYe802y', 1, 'X1DSbzAtrrwBxTdLgaO4jmxbk2fcO6Ak0WceTNngRrR0MIe9acRYta0F5Nln', '2024-05-13 05:29:43', '2024-05-13 05:29:43'),
	(2, 'juan', 'juangonzalez@email.com', '2024-05-13 05:29:43', '$2y$12$PvZwaDtud8JRATa4rBxKQeVgM5iE5LdcmSo3tmcEC0veA9f8a9ey.', 0, 'Um5L4jQiSH', '2024-05-13 05:29:43', '2024-05-13 05:29:43'),
	(3, 'Juan Francisco González Rosal', 'jgonros27@gmail.com', NULL, '$2y$12$o053Ea6ky4z/JL10hfIOW.7knvMkZhyMuih11U2C8WtjCM/y.gNtS', 0, '4nfzTTBBhv6kXUkSS4H8iJfKjUfTvTvtyaIeFs86kEh0mngyXH1t5L8IrM73', '2024-05-13 05:33:01', '2024-05-13 09:56:34'),
	(5, 'Irene Gámez', 'igamnav99@gmail.com', NULL, '$2y$12$grd7vHisWW4u9AkKu0kunOBB4i9Bom9kTjPISNKyLdOp8L0ncRn2a', 0, NULL, '2024-05-20 14:18:47', '2024-05-20 14:18:47'),
	(7, 'ana', 'juaneaea27@gmail.com', NULL, '$2y$12$P0WhDM5WBIRH4RaCLe9iJeEnBCTFOY00NPNKCL6/i5Nws5I/1Vli6', 0, NULL, '2024-08-07 14:19:44', '2024-08-07 14:19:44');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
