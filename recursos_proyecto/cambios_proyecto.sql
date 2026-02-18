-- 1. Eliminamos las tablas viejas (el orden es importante por las relaciones)
DROP TABLE IF EXISTS `feedback`;
DROP TABLE IF EXISTS `clase`;
DROP TABLE IF EXISTS `horario`;

-- 2. Creamos la nueva tabla GRUPO (La oferta del mes del profesor)
CREATE TABLE `grupo` (
  `id_grupo` int(11) NOT NULL AUTO_INCREMENT,
  `id_docente` int(11) NOT NULL,
  `nivel` enum('Primaria','Secundaria','Bachillerato') NOT NULL,
  `mes_anio` date NOT NULL COMMENT 'Se guarda el día 1 del mes, ej: 2026-03-01',
  `precio` decimal(10,2) NOT NULL,
  `estado` enum('abierto','cerrado') DEFAULT 'abierto',
  PRIMARY KEY (`id_grupo`),
  UNIQUE KEY `unique_grupo_mes` (`id_docente`, `nivel`, `mes_anio`),
  CONSTRAINT `grupo_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 3. Creamos la tabla INSCRIPCIÓN (Los alumnos que se apuntan)
CREATE TABLE `inscripcion` (
  `id_inscripcion` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `fecha_inscripcion` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_inscripcion`),
  UNIQUE KEY `unique_inscripcion` (`id_grupo`, `id_alumno`),
  CONSTRAINT `inscripcion_ibfk_1` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE CASCADE,
  CONSTRAINT `inscripcion_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 4. Recreamos la tabla FEEDBACK adaptada a los grupos
CREATE TABLE `feedback` (
  `id_feedback` int(11) NOT NULL AUTO_INCREMENT,
  `id_grupo` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `calificacion` tinyint(4) NOT NULL CHECK (`calificacion` >= 1 and `calificacion` <= 5),
  `fecha` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id_feedback`),
  UNIQUE KEY `unique_feedback` (`id_grupo`, `id_alumno`),
  CONSTRAINT `fk_feedback_grupo` FOREIGN KEY (`id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE CASCADE,
  CONSTRAINT `fk_feedback_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;