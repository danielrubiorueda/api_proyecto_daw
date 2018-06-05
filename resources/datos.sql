/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

CREATE TABLE IF NOT EXISTS `alumnos` (
  `id_alumno` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  PRIMARY KEY (`id_alumno`),
  KEY `id_curso` (`id_curso`),
  CONSTRAINT `alumnos_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `cursos` (`id_curso`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
INSERT IGNORE INTO `alumnos` (`id_alumno`, `id_curso`) VALUES
	(31364834, 1);
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `causas` (
  `id_causa` int(11) NOT NULL,
  `www_causa` varchar(200) NOT NULL,
  `causa` varchar(100) NOT NULL,
  `descripcion_causa` varchar(800) NOT NULL,
  `img_causa` varchar(200) NOT NULL,
  PRIMARY KEY (`id_causa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `causas` DISABLE KEYS */;
INSERT IGNORE INTO `causas` (`id_causa`, `www_causa`, `causa`, `descripcion_causa`, `img_causa`) VALUES
	(1, 'www', 'causa', 'descripcion', 'img');
/*!40000 ALTER TABLE `causas` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `contribuciones` (
  `id_contribucion` int(11) NOT NULL AUTO_INCREMENT,
  `id_alumno` int(11) NOT NULL,
  `id_proyecto` int(11) NOT NULL,
  `contribucion` decimal(6,2) NOT NULL,
  `fecha_contribucion` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_contribucion`),
  KEY `id_alumno` (`id_alumno`,`id_proyecto`),
  KEY `id_proyecto` (`id_proyecto`),
  CONSTRAINT `contribuciones_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `alumnos` (`id_alumno`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `contribuciones_ibfk_2` FOREIGN KEY (`id_proyecto`) REFERENCES `proyectos` (`id_proyecto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=155 DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `contribuciones` DISABLE KEYS */;
/*!40000 ALTER TABLE `contribuciones` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `cursos` (
  `id_curso` int(11) NOT NULL,
  `curso` varchar(50) NOT NULL,
  `nivel` varchar(50) NOT NULL,
  `centro` varchar(100) NOT NULL,
  `localidad` varchar(100) NOT NULL,
  `provincia` varchar(100) NOT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
INSERT IGNORE INTO `cursos` (`id_curso`, `curso`, `nivel`, `centro`, `localidad`, `provincia`) VALUES
	(1, 'bch', '1_a', 'IES Mar de Alboran', 'Estepona', 'Málaga');
INSERT IGNORE INTO `cursos` (`id_curso`, `curso`, `nivel`, `centro`, `localidad`, `provincia`) VALUES
	(2, 'bch', '1_b', 'IES Mar de Alboran', 'Estepona', 'Málaga');
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `empresas` (
  `id_empresa` int(11) NOT NULL,
  `www_empresa` varchar(200) NOT NULL,
  `empresa` varchar(100) NOT NULL,
  `descripcion_empresa` varchar(500) NOT NULL,
  `img_empresa` varchar(200) NOT NULL,
  PRIMARY KEY (`id_empresa`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT IGNORE INTO `empresas` (`id_empresa`, `www_empresa`, `empresa`, `descripcion_empresa`, `img_empresa`) VALUES
	(1, 'www', 'empresa', 'descripcion', 'img');
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;

CREATE TABLE IF NOT EXISTS `proyectos` (
  `id_proyecto` int(11) NOT NULL,
  `id_causa` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `proyecto` varchar(100) NOT NULL,
  `descripcion_proyecto` varchar(800) NOT NULL,
  `img_proyecto` varchar(200) NOT NULL,
  `objetivo` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `hashtag_proyecto` varchar(20) NOT NULL,
  `donacion` int(11) NOT NULL,
  PRIMARY KEY (`id_proyecto`),
  UNIQUE KEY `hashtag_proyecto` (`hashtag_proyecto`),
  KEY `id_causa` (`id_causa`,`id_empresa`),
  KEY `id_empresa` (`id_empresa`),
  CONSTRAINT `proyectos_ibfk_1` FOREIGN KEY (`id_causa`) REFERENCES `causas` (`id_causa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `proyectos_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id_empresa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `descripcion_proyecto`, `img_proyecto`, `objetivo`, `fecha_inicio`, `fecha_fin`, `hashtag_proyecto`, `donacion`) VALUES
	(1, 1, 1, 'Helados para los peques', 'Vamos a repartir helados para los peques que no se lo pueden permitir', 'x1.jpg', 1100, '2018-01-01', '2018-06-30', 'pequesconhelados', 1000);
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `descripcion_proyecto`, `img_proyecto`, `objetivo`, `fecha_inicio`, `fecha_fin`, `hashtag_proyecto`, `donacion`) VALUES
	(2, 1, 1, 'Helados para los mayores', 'Vamos a repartir helados para los mayores que no se lo pueden permitir', 'x2.jpg', 1000, '2018-01-01', '2018-06-30', 'mayoresconhelados', 1000);
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `descripcion_proyecto`, `img_proyecto`, `objetivo`, `fecha_inicio`, `fecha_fin`, `hashtag_proyecto`, `donacion`) VALUES
	(3, 1, 1, 'Globos para todos', 'Vamos a repartir globos para todo el mundo que esté triste', 'x3.jpg', 1000, '2018-01-01', '2018-06-30', 'globosparatodos', 1000);
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `descripcion_proyecto`, `img_proyecto`, `objetivo`, `fecha_inicio`, `fecha_fin`, `hashtag_proyecto`, `donacion`) VALUES
	(4, 1, 1, 'Helados para los peques', 'Vamos a repartir helados para los peques que no se lo pueden permitir', 'x1.jpg', 1000, '2018-01-01', '2018-06-30', 'pequesconhelados2', 2000);
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `descripcion_proyecto`, `img_proyecto`, `objetivo`, `fecha_inicio`, `fecha_fin`, `hashtag_proyecto`, `donacion`) VALUES
	(5, 1, 1, 'Helados para los mayores', 'Vamos a repartir helados para los mayores que no se lo pueden permitir', 'x2.jpg', 1000, '2018-01-01', '2018-06-30', 'mayoresconhelados2', 2000);
INSERT IGNORE INTO `proyectos` (`id_proyecto`, `id_causa`, `id_empresa`, `proyecto`, `descripcion_proyecto`, `img_proyecto`, `objetivo`, `fecha_inicio`, `fecha_fin`, `hashtag_proyecto`, `donacion`) VALUES
	(6, 1, 1, 'Globos para todos', 'Vamos a repartir globos para todo el mundo que esté triste', 'x3.jpg', 1000, '2018-01-01', '2018-06-30', 'globosparatodos2', 3000);
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
