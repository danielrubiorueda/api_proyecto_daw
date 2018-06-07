/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE TABLE IF NOT EXISTS `alumnos` (
  `id_alumno` int(11) NOT NULL AUTO_INCREMENT,
  `id_strava` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  PRIMARY KEY (`id_alumno`),
  UNIQUE KEY `id_strava` (`id_strava`),
  KEY `id_curso` (`id_curso`),
  CONSTRAINT `FK_alumnos_cursos` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT IGNORE INTO `alumnos` (`id_alumno`, `id_strava`, `id_curso`) VALUES
	(1, 31364834, 1);
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `causas` (
  `id_causa` int(11) NOT NULL AUTO_INCREMENT,
  `www_causa` varchar(200) NOT NULL,
  `causa` varchar(100) NOT NULL,
  `descripcion_causa` varchar(800) NOT NULL,
  `img_causa` varchar(200) NOT NULL,
  PRIMARY KEY (`id_causa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `causas` DISABLE KEYS */;
INSERT IGNORE INTO `causas` (`id_causa`, `www_causa`, `causa`, `descripcion_causa`, `img_causa`) VALUES
	(1, 'web', 'causa', 'descripcion', 'imagen');
/*!40000 ALTER TABLE `causas` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `centros` (
  `id_centro` int(11) NOT NULL AUTO_INCREMENT,
  `centro` varchar(50) NOT NULL,
  `localidad` varchar(50) NOT NULL,
  `provincia` varchar(50) NOT NULL,
  PRIMARY KEY (`id_centro`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `centros` DISABLE KEYS */;
INSERT IGNORE INTO `centros` (`id_centro`, `centro`, `localidad`, `provincia`) VALUES
	(1, 'IES Mar de Alboran', 'Estepona', 'Málaga');
/*!40000 ALTER TABLE `centros` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `contribuciones` (
  `id_contribucion` int(11) NOT NULL AUTO_INCREMENT,
  `id_strava` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `contribucion` decimal(6,2) NOT NULL,
  `fecha_contribucion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_contribucion`),
  KEY `id_proyecto` (`id_proyecto`),
  KEY `id_strava` (`id_strava`),
  CONSTRAINT `FK_contribuciones_alumnos` FOREIGN KEY (`id_strava`) REFERENCES `alumnos` (`id_strava`) ON UPDATE CASCADE,
  CONSTRAINT `FK_contribuciones_proyectos` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`)
) ENGINE=InnoDB AUTO_INCREMENT=179 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `contribuciones` DISABLE KEYS */;
INSERT IGNORE INTO `contribuciones` (`id_contribucion`, `id_strava`, `id_proyecto`, `contribucion`, `fecha_contribucion`) VALUES
	(172, 31364834, 1, 0.00, '2018-06-06 13:14:10');
INSERT IGNORE INTO `contribuciones` (`id_contribucion`, `id_strava`, `id_proyecto`, `contribucion`, `fecha_contribucion`) VALUES
	(173, 31364834, 2, 0.00, '2018-06-06 13:14:10');
INSERT IGNORE INTO `contribuciones` (`id_contribucion`, `id_strava`, `id_proyecto`, `contribucion`, `fecha_contribucion`) VALUES
	(174, 31364834, 3, 0.00, '2018-06-06 13:14:10');
INSERT IGNORE INTO `contribuciones` (`id_contribucion`, `id_strava`, `id_proyecto`, `contribucion`, `fecha_contribucion`) VALUES
	(175, 31364834, 4, 0.00, '2018-06-06 13:14:10');
INSERT IGNORE INTO `contribuciones` (`id_contribucion`, `id_strava`, `id_proyecto`, `contribucion`, `fecha_contribucion`) VALUES
	(176, 31364834, 5, 0.00, '2018-06-06 13:14:10');
INSERT IGNORE INTO `contribuciones` (`id_contribucion`, `id_strava`, `id_proyecto`, `contribucion`, `fecha_contribucion`) VALUES
	(177, 31364834, 6, 0.00, '2018-06-06 13:14:10');
INSERT IGNORE INTO `contribuciones` (`id_contribucion`, `id_strava`, `id_proyecto`, `contribucion`, `fecha_contribucion`) VALUES
	(178, 31364834, 6, 0.00, '2018-06-06 13:14:10');
/*!40000 ALTER TABLE `contribuciones` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `cursos` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `id_centro` int(11) NOT NULL,
  `curso` varchar(50) NOT NULL,
  `nivel` enum('Primaria','ESO','Bachiller','FP') NOT NULL,
  PRIMARY KEY (`id_curso`),
  KEY `FK_cursos_centros` (`id_centro`),
  CONSTRAINT `FK_cursos_centros` FOREIGN KEY (`id_centro`) REFERENCES `centros` (`id_centro`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT IGNORE INTO `cursos` (`id_curso`, `id_centro`, `curso`, `nivel`) VALUES
	(1, 1, '1a', 'ESO');
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `empresas` (
  `id_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `www_empresa` varchar(200) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `descripcion_empresa` varchar(500) NOT NULL,
  `img_empresa` varchar(200) NOT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT IGNORE INTO `empresas` (`id_empresa`, `www_empresa`, `empresa`, `descripcion_empresa`, `img_empresa`) VALUES
	(1, 'web', 'empresa', 'descripcion', 'imagen');
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `mensajes` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `org` tinytext NOT NULL,
  `msg` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  PRIMARY KEY (`id_mensaje`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `mensajes` DISABLE KEYS */;
INSERT IGNORE INTO `mensajes` (`id_mensaje`, `fecha`, `org`, `msg`, `email`) VALUES
	(4, '2018-06-05 13:55:21', 'Contakt', 'Quiero participar como empresa y donar 10000€', 'hola@contakt.com');
/*!40000 ALTER TABLE `mensajes` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `proyectos` (
  `id_proyecto` int(11) NOT NULL AUTO_INCREMENT,
  `id_causa` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `proyecto` varchar(100) NOT NULL,
  `hashtag_proyecto` varchar(20) NOT NULL,
  `img_proyecto` varchar(200) NOT NULL,
  `descripcion_proyecto` varchar(800) NOT NULL,
  `objetivo` int(11) NOT NULL,
  `donacion` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  PRIMARY KEY (`id_proyecto`),
  UNIQUE KEY `hashtag_proyecto` (`hashtag_proyecto`),
  KEY `id_empresa` (`id_empresa`),
  KEY `id_causa` (`id_causa`),
  CONSTRAINT `FK_proyectos_causas` FOREIGN KEY (`id_causa`) REFERENCES `causas` (`id_causa`),
  CONSTRAINT `FK_proyectos_empresas` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `hashtag_proyecto`, `img_proyecto`, `descripcion_proyecto`, `objetivo`, `donacion`, `fecha_inicio`, `fecha_fin`) VALUES
	(1, 1, 1, 'Helados para los peques', 'pequesconhelados', 'x1.jpg', 'Vamos a repartir helados para los peques que no se lo pueden permitir', 1100, 1000, '2018-01-01', '2018-06-30');
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `hashtag_proyecto`, `img_proyecto`, `descripcion_proyecto`, `objetivo`, `donacion`, `fecha_inicio`, `fecha_fin`) VALUES
	(2, 1, 1, 'Helados para los mayores', 'mayoresconhelados', 'x2.jpg', 'Vamos a repartir helados para los mayores que no se lo pueden permitir', 1000, 1000, '2018-01-01', '2018-06-30');
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `hashtag_proyecto`, `img_proyecto`, `descripcion_proyecto`, `objetivo`, `donacion`, `fecha_inicio`, `fecha_fin`) VALUES
	(3, 1, 1, 'Globos para todas', 'globosparatodas', 'x3.jpg', 'Vamos a repartir globos para todo el mundo que esté triste', 2000, 1000, '2018-01-01', '2018-06-19');
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `hashtag_proyecto`, `img_proyecto`, `descripcion_proyecto`, `objetivo`, `donacion`, `fecha_inicio`, `fecha_fin`) VALUES
	(4, 1, 1, 'Helados para los peques', 'pequesconhelados2', 'x1.jpg', 'Vamos a repartir helados para los peques que no se lo pueden permitir', 1000, 2000, '2018-01-01', '2018-06-30');
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `hashtag_proyecto`, `img_proyecto`, `descripcion_proyecto`, `objetivo`, `donacion`, `fecha_inicio`, `fecha_fin`) VALUES
	(5, 1, 1, 'Helados para los mayores', 'mayoresconhelados2', 'x2.jpg', 'Vamos a repartir helados para los mayores que no se lo pueden permitir', 1000, 2000, '2018-01-01', '2018-06-30');
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `hashtag_proyecto`, `img_proyecto`, `descripcion_proyecto`, `objetivo`, `donacion`, `fecha_inicio`, `fecha_fin`) VALUES
	(6, 1, 1, 'Globos para todos', 'globosparatodos2', 'x3.jpg', 'Vamos a repartir globos para todo el mundo que esté triste', 1000, 3000, '2018-01-01', '2018-06-30');
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
