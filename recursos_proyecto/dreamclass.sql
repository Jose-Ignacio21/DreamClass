-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 06-02-2026 a las 19:18:12
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `dreamclass`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alumno`
--

CREATE TABLE `alumno` (
  `id_alumno` int(11) NOT NULL,
  `nivel` varchar(50) DEFAULT NULL,
  `intereses` text DEFAULT NULL,
  `meta_aprendizaje` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `alumno`
--

INSERT INTO `alumno` (`id_alumno`, `nivel`, `intereses`, `meta_aprendizaje`) VALUES
(16, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivotarea`
--

CREATE TABLE `archivotarea` (
  `id_archivo` int(11) NOT NULL,
  `id_tarea` int(11) NOT NULL,
  `ruta_archivo` varchar(255) NOT NULL,
  `tipo` varchar(50) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clase`
--

CREATE TABLE `clase` (
  `id_clase` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL,
  `estado` enum('pendiente','realizada','cancelada') DEFAULT 'pendiente',
  `enlace_video` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clase`
--

INSERT INTO `clase` (`id_clase`, `id_docente`, `id_alumno`, `fecha`, `hora_inicio`, `hora_fin`, `estado`, `enlace_video`) VALUES
(11, 17, 16, '2026-02-02', '16:30:00', '16:40:00', 'cancelada', NULL),
(15, 17, 16, '2026-02-02', '16:31:00', '16:38:00', 'cancelada', NULL),
(18, 17, 16, '2026-02-02', '17:00:00', '17:05:00', 'pendiente', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente`
--

CREATE TABLE `docente` (
  `id_docente` int(11) NOT NULL,
  `especialidad` varchar(100) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `precio_hora` decimal(6,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `docente`
--

INSERT INTO `docente` (`id_docente`, `especialidad`, `descripcion`, `precio_hora`) VALUES
(17, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `feedback`
--

CREATE TABLE `feedback` (
  `id_feedback` int(11) NOT NULL,
  `id_clase` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `comentario` text DEFAULT NULL,
  `calificacion` tinyint(4) NOT NULL CHECK (`calificacion` >= 1 and `calificacion` <= 5),
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `horario`
--

CREATE TABLE `horario` (
  `id_horario` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `dia_semana` tinyint(4) NOT NULL CHECK (`dia_semana` >= 1 and `dia_semana` <= 7),
  `hora_inicio` time NOT NULL,
  `hora_fin` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `horario`
--

INSERT INTO `horario` (`id_horario`, `id_docente`, `dia_semana`, `hora_inicio`, `hora_fin`) VALUES
(7, 17, 6, '16:30:00', '17:30:00'),
(8, 17, 1, '16:30:00', '17:30:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mensaje`
--

CREATE TABLE `mensaje` (
  `id_mensaje` int(11) NOT NULL,
  `id_remitente` int(11) NOT NULL,
  `id_destinatario` int(11) NOT NULL,
  `contenido` text NOT NULL,
  `fecha_hora` datetime DEFAULT current_timestamp(),
  `leido` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `mensaje`
--

INSERT INTO `mensaje` (`id_mensaje`, `id_remitente`, `id_destinatario`, `contenido`, `fecha_hora`, `leido`) VALUES
(10, 16, 17, 's', '2026-02-01 17:30:25', 1),
(11, 16, 17, 'hola docente', '2026-02-01 17:30:53', 1),
(12, 17, 16, 'hola alumno', '2026-02-01 17:31:19', 1),
(13, 16, 17, 'hola', '2026-02-02 09:04:33', 1),
(14, 17, 16, 'hola', '2026-02-02 10:16:14', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tarea`
--

CREATE TABLE `tarea` (
  `id_tarea` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `id_alumno` int(11) NOT NULL,
  `titulo` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `fecha_asignacion` datetime DEFAULT current_timestamp(),
  `completada` tinyint(1) DEFAULT 0,
  `fecha_completada` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `contrasenia` varchar(255) NOT NULL,
  `rol` enum('docente','alumno','admin') NOT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp(),
  `foto_perfil` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `nombre`, `email`, `contrasenia`, `rol`, `fecha_registro`, `foto_perfil`) VALUES
(16, 'Prueba Alumno', 'jose.garcia.cruz@ieslaarboleda.es', '$2y$10$eVkhraMurf7AqLCwySUwJuAsKVT3dYESLTxedOe4ZNlszZtn..h4a', 'alumno', '2026-02-01 15:30:12', NULL),
(17, 'Prueba Docente', 'j.ignaciocruz2110@gmail.com', '$2y$10$3PFJBCYucVCoW6vvMeFYC.dMf6f0dICjfqp/qVfMW3LIaxUPfl1y6', 'docente', '2026-02-01 15:32:44', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD PRIMARY KEY (`id_alumno`);

--
-- Indices de la tabla `archivotarea`
--
ALTER TABLE `archivotarea`
  ADD PRIMARY KEY (`id_archivo`),
  ADD KEY `id_tarea` (`id_tarea`);

--
-- Indices de la tabla `clase`
--
ALTER TABLE `clase`
  ADD PRIMARY KEY (`id_clase`),
  ADD UNIQUE KEY `unique_clase` (`id_docente`,`fecha`,`hora_inicio`),
  ADD KEY `id_alumno` (`id_alumno`);

--
-- Indices de la tabla `docente`
--
ALTER TABLE `docente`
  ADD PRIMARY KEY (`id_docente`);

--
-- Indices de la tabla `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id_feedback`),
  ADD UNIQUE KEY `id_clase` (`id_clase`),
  ADD KEY `fk_feedback_alumno` (`id_alumno`);

--
-- Indices de la tabla `horario`
--
ALTER TABLE `horario`
  ADD PRIMARY KEY (`id_horario`),
  ADD KEY `id_docente` (`id_docente`);

--
-- Indices de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD PRIMARY KEY (`id_mensaje`),
  ADD KEY `id_remitente` (`id_remitente`),
  ADD KEY `id_destinatario` (`id_destinatario`);

--
-- Indices de la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `id_docente` (`id_docente`),
  ADD KEY `id_alumno` (`id_alumno`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivotarea`
--
ALTER TABLE `archivotarea`
  MODIFY `id_archivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `clase`
--
ALTER TABLE `clase`
  MODIFY `id_clase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de la tabla `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id_feedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `horario`
--
ALTER TABLE `horario`
  MODIFY `id_horario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `mensaje`
--
ALTER TABLE `mensaje`
  MODIFY `id_mensaje` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `tarea`
--
ALTER TABLE `tarea`
  MODIFY `id_tarea` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `alumno`
--
ALTER TABLE `alumno`
  ADD CONSTRAINT `alumno_ibfk_1` FOREIGN KEY (`id_alumno`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `archivotarea`
--
ALTER TABLE `archivotarea`
  ADD CONSTRAINT `archivotarea_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tarea` (`id_tarea`) ON DELETE CASCADE;

--
-- Filtros para la tabla `clase`
--
ALTER TABLE `clase`
  ADD CONSTRAINT `clase_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`),
  ADD CONSTRAINT `clase_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`);

--
-- Filtros para la tabla `docente`
--
ALTER TABLE `docente`
  ADD CONSTRAINT `docente_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE;

--
-- Filtros para la tabla `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`id_clase`) REFERENCES `clase` (`id_clase`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_feedback_alumno` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`);

--
-- Filtros para la tabla `horario`
--
ALTER TABLE `horario`
  ADD CONSTRAINT `horario_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE CASCADE;

--
-- Filtros para la tabla `mensaje`
--
ALTER TABLE `mensaje`
  ADD CONSTRAINT `mensaje_ibfk_1` FOREIGN KEY (`id_remitente`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `mensaje_ibfk_2` FOREIGN KEY (`id_destinatario`) REFERENCES `usuario` (`id_usuario`);

--
-- Filtros para la tabla `tarea`
--
ALTER TABLE `tarea`
  ADD CONSTRAINT `tarea_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`),
  ADD CONSTRAINT `tarea_ibfk_2` FOREIGN KEY (`id_alumno`) REFERENCES `alumno` (`id_alumno`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
