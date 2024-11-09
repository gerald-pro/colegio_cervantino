-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-11-2024 a las 20:18:40
-- Versión del servidor: 10.4.28-MariaDB
-- Versión de PHP: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `db_colegio`
--

-- --------------------------------------------------------

CREATE TABLE `gestion_academica` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `anio` int NOT NULL,
  `fecha_inicio_registro` date NOT NULL,
  `fecha_cierre_registro` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `gestion_academica` (`id`, `anio`, `fecha_inicio_registro`, `fecha_cierre_registro`) VALUES 
(1, 2024, '2024-01-01', '2024-03-31'),
(2, 2023, '2023-01-01', '2023-03-31'),
(3, 2025, '2025-01-01', '2025-03-31');
--
-- Estructura de tabla para la tabla `apoderado`
--

CREATE TABLE `apoderado` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellido` varchar(20) NOT NULL,
  `direccion` varchar(50) NOT NULL,
  `telefono` varchar(15) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `apoderado`
--

INSERT INTO `apoderado` (`id`, `nombre`, `apellido`, `direccion`, `telefono`, `id_usuario`) VALUES
(5, 'karen', 'saucedo', 'radial 10', '68127026', 4),
(14, 'carmen', 'sanchez', 'la villa', '77886756', 4),
(18, 'Pablo', 'Roca', 'la villa', '77867676', 4),
(19, 'Fernando', 'Zabala', 'el plan 3000', '77677656', 4),
(20, 'Ernesto', 'Vaca', 'el plan 3000', '76767666777', 4),
(21, 'José ', 'Fernández', 'el plan 3000', '77565657', 4),
(22, 'Ana ', 'García', 'La Campana', '77656535', 4),
(23, 'Andrés ', 'Rodríguez', 'la villa', '6656457', 4),
(24, 'carlos', 'flores', 'el plan 3000', '56484965', 4),
(25, 'Ingrid', 'Zabala', 'el plan 3000', '43438988', 4),
(26, 'Mario', 'Montaño', 'el plan 3000', '34534545', 4),
(28, 'alex', 'ornelas', 'el plan 3000', '4434344', 4),
(29, 'simon', 'daza', 'el plan 3000', '4544545', 4),
(32, 'Juan ', 'Cespedes', 'el plan 3000', '67676767', 4),
(33, 'Lidia', 'Paz', 'el plan 3000', '775656545', 4),
(34, 'Laura', 'Ramirez', 'el plan 3000', '77788666', 4),
(35, 'juan', 'perez', 'el plan 3000', '7767755', 4),
(36, 'Sergio', 'Gutierrez', 'La Campana', '7756564', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `curso` varchar(20) NOT NULL,
  `paralelo` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id`, `curso`, `paralelo`) VALUES
(8, '3', 'B'),
(9, '4', 'C'),
(13, '5', 'a'),
(14, '4', 'b'),
(16, '6', 'C'),
(17, '2', 'B'),
(18, '1', 'A'),
(19, '3', 'B'),
(20, '4', 'A');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_cuotas`
--

CREATE TABLE `detalle_cuotas` (
  `id` int(11) NOT NULL,
  `gestion` int(50) NOT NULL,
  `monto` decimal(50,0) NOT NULL,
  `n_cuotas` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_cuotas`
--

INSERT INTO `detalle_cuotas` (`id`, `gestion`, `monto`, `n_cuotas`) VALUES
(5, 2024, 340, '10'),
(11, 2024, 200, '5'),
(12, 2024, 240, '6'),
(22, 2024, 340, '10'),
(24, 2024, 340, '10'),
(25, 2024, 340, '10'),
(26, 2024, 200, '5'),
(27, 2024, 120, '3'),
(28, 2024, 340, '10'),
(30, 2024, 340, '10'),
(31, 2024, 340, '10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle_n_cuotas`
--

CREATE TABLE `detalle_n_cuotas` (
  `id` int(11) NOT NULL,
  `gestion` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `detalle_n_cuotas`
--

INSERT INTO `detalle_n_cuotas` (`id`, `gestion`) VALUES
(1, '2015'),
(2, '2016'),
(3, '2017'),
(4, '2018'),
(5, '2019'),
(6, '2020'),
(7, '2021'),
(8, '2022'),
(9, '2023'),
(10, '2024');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `estudiante`
--

CREATE TABLE `estudiante` (
  `id` int(11) NOT NULL,
  `nombre` varchar(20) NOT NULL,
  `apellidos` varchar(40) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `fechanac` date NOT NULL,
  `correo` varchar(50) NOT NULL,
  `telefono` varchar(50) NOT NULL,
  `fecharegistro` date NOT NULL,
  `fechaact` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_curso` int(11) NOT NULL,
  `id_apoderado` int(11) NOT NULL,
  `id_gestion_academica` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `estudiante`
--

INSERT INTO `estudiante` (`id`, `nombre`, `apellidos`, `direccion`, `fechanac`, `correo`, `telefono`, `fecharegistro`, `fechaact`, `id_curso`, `id_apoderado`, `id_gestion_academica`) VALUES
(33, 'Marcos', 'Saucedo', 'El plan 3000', '2014-06-15', 'marcos@gmail.com', '77676659', '2024-08-11', '2024-10-12 23:52:21', 13, 5, 1),
(34, 'Angel', 'Sanchez', 'El plan 3000', '2015-03-18', 'angel@gmail.com', '77656555', '2024-08-11', '2024-08-11 20:43:06', 14, 14, 1),
(39, 'Sebastian', 'Roca', 'la villa', '2015-05-06', 'sebastian@gmail.com', '7756566', '2024-08-11', '2024-08-11 22:52:39', 14, 18, 1),
(40, 'David', 'Zabala', 'El plan 3000', '2014-09-20', 'david@gmail.com', '765656577', '2024-08-11', '2024-10-12 22:32:56', 13, 19, 1),
(41, 'Thiago', 'Vaca', 'El plan 3000', '2016-08-04', 'thiago@gmail.com', '7677566', '2024-08-11', '2024-08-11 23:14:26', 8, 20, 1),
(44, 'Valeria ', ' Fernández', 'El plan 3000', '2016-06-11', 'valeria@gmail.com', '76764534', '2024-08-27', '2024-08-28 02:33:27', 14, 21, 1),
(45, 'Sofia', ' García', 'La Campana', '2015-05-06', 'sofia@gmail.com', '76754534', '2024-08-27', '2024-08-28 02:35:27', 13, 22, 1),
(46, 'Daniela', ' Rodríguez', 'la villa', '2014-10-12', 'daniela@gmail.com', '77565643', '2024-08-27', '2024-08-28 02:36:57', 13, 23, 1),
(47, 'juan', 'flores', 'El plan 3000', '2015-07-18', 'juan@gmail.com', '5656566', '2024-10-12', '2024-10-12 19:19:10', 14, 24, 1),
(48, 'sara', 'zabala', 'El plan 3000', '2016-07-30', 'sara@gmail.com', '45454644', '2024-10-12', '2024-10-12 21:10:41', 18, 25, 1),
(49, 'valentina', 'montaño', 'El plan 3000', '2015-02-08', 'valentinas@gmail.com', '4545455', '2024-10-12', '2024-10-12 22:08:31', 16, 26, 1),
(50, 'ronald', 'ornelas', 'El plan 3000', '2016-09-06', 'ronald@gmail.com', '2323233', '2024-10-12', '2024-10-12 22:45:28', 13, 28, 1),
(51, 'camila', 'daza', 'El plan 3000', '2015-06-14', 'camila@gmail.com', '545555', '2024-10-12', '2024-10-13 00:42:13', 16, 29, 1),
(54, 'Jessica', 'Cespedes', 'El plan 3000', '2015-04-03', 'jessica@gmail.com', '88766656', '2024-10-24', '2024-10-24 04:30:52', 16, 32, 1),
(55, 'Anthony', 'Paz', 'El plan 3000', '2015-10-07', 'anthony@gmail.com', '77565666', '2024-11-05', '2024-11-05 14:47:22', 13, 33, 1),
(56, 'Ricardo', 'Ramirez', 'El plan 3000', '2015-07-18', 'ricardo@gmail.com', '776765', '2024-11-06', '2024-11-06 13:57:34', 16, 34, 1),
(57, 'luis', 'Perez', 'El plan 3000', '2015-06-11', 'luis@gmail.com', '777675', '2024-11-06', '2024-11-08 15:16:21', 13, 35, 1),
(58, 'Verónica', 'Gutierrez', 'La Campana', '2016-09-16', 'veronica@gmail.com', '76754531', '2024-11-07', '2024-11-08 03:10:04', 16, 36, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int(11) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `hora` datetime NOT NULL,
  `monto` decimal(11,0) NOT NULL,
  `n_cuotas` varchar(50) NOT NULL,
  `id_estudiante` int(11) NOT NULL,
  `id_apoderado` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_detalle_cuotas` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pagos`
--

INSERT INTO `pagos` (`id`, `fecha`, `hora`, `monto`, `n_cuotas`, `id_estudiante`, `id_apoderado`, `id_curso`, `id_detalle_cuotas`, `id_usuario`) VALUES
(59, '2024-08-11 20:41:32', '2024-08-11 16:41:32', 340, '10', 33, 5, 13, 5, 4),
(60, '2024-08-11 20:43:31', '2024-08-11 16:43:31', 340, '10', 34, 14, 14, 5, 4),
(65, '2024-08-11 22:52:56', '2024-08-11 18:52:56', 340, '10', 39, 18, 14, 5, 4),
(66, '2024-08-11 22:55:41', '2024-08-11 18:55:41', 340, '10', 40, 19, 13, 5, 4),
(67, '2024-08-11 23:14:43', '2024-08-11 19:14:43', 340, '10', 41, 20, 8, 24, 4),
(69, '2024-08-28 14:43:33', '2024-08-28 10:43:33', 340, '10', 44, 21, 14, 5, 4),
(70, '2024-08-28 14:46:54', '2024-08-28 10:46:54', 200, '5', 46, 23, 13, 11, 4),
(71, '2024-10-12 19:19:27', '2024-10-12 15:19:27', 340, '10', 47, 24, 14, 5, 4),
(72, '2024-10-12 19:21:37', '2024-10-12 15:21:37', 200, '5', 46, 23, 13, 11, 4),
(73, '2024-10-12 22:03:04', '2024-10-12 18:03:04', 200, '5', 45, 22, 13, 11, 4),
(74, '2024-10-12 22:14:44', '2024-10-12 18:14:44', 340, '10', 49, 26, 16, 22, 4),
(75, '2024-10-13 00:25:03', '2024-10-12 20:25:03', 340, '10', 50, 28, 13, 5, 4),
(76, '2024-10-13 00:42:41', '2024-10-12 20:42:41', 340, '10', 51, 29, 16, 5, 4),
(78, '2024-10-24 04:32:09', '2024-10-24 00:32:09', 340, '10', 54, 32, 16, 5, 4),
(79, '2024-11-05 14:48:04', '2024-11-05 10:48:04', 340, '10', 55, 33, 13, 22, 4),
(80, '2024-11-06 13:58:08', '2024-11-06 09:58:08', 200, '5', 56, 34, 16, 11, 4),
(81, '2024-11-06 13:58:31', '2024-11-06 09:58:31', 200, '5', 56, 34, 16, 26, 4),
(82, '2024-11-06 14:34:59', '2024-11-06 10:34:59', 340, '10', 57, 35, 13, 5, 4),
(83, '2024-11-08 03:10:37', '2024-11-07 23:10:37', 340, '10', 58, 36, 16, 5, 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `correo` varchar(50) NOT NULL,
  `password` varchar(300) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `correo`, `password`, `fecha`) VALUES
(2, 'luis', 'luis@gmail.commm', '', '2024-05-17'),
(3, 'jose', 'jose@gmail.com', '12347f', '2024-05-25'),
(4, 'admin', 'admin@gmail.com', '12345', '2024-11-08'),
(5, 'marcos', 'marcos@gmail.com', '75432', '2024-05-27'),
(6, 'angel', 'angel@gmail.com', '123456e', '2024-05-28'),
(7, 'andres', 'andres@gmail.com', '33397', '2024-05-29'),
(8, 'luisa', 'luisa@gmail.com', '54321', '2024-05-30'),
(14, 'Gerald', 'gerald@gmail.com', '', '2024-07-12');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `apoderado`
--
ALTER TABLE `apoderado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_cuotas`
--
ALTER TABLE `detalle_cuotas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle_n_cuotas`
--
ALTER TABLE `detalle_n_cuotas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_apoderado` (`id_apoderado`),
  ADD KEY `id_gestion_academica` (`id_gestion_academica`);


--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_estudiante` (`id_estudiante`),
  ADD KEY `id_apoderado` (`id_apoderado`),
  ADD KEY `id_curso` (`id_curso`),
  ADD KEY `id_detalle_cuotas` (`id_detalle_cuotas`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `apoderado`
--
ALTER TABLE `apoderado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `detalle_cuotas`
--
ALTER TABLE `detalle_cuotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `detalle_n_cuotas`
--
ALTER TABLE `detalle_n_cuotas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `estudiante`
--
ALTER TABLE `estudiante`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `apoderado`
--
ALTER TABLE `apoderado`
  ADD CONSTRAINT `apoderado_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `estudiante`
--
ALTER TABLE `estudiante`
  ADD CONSTRAINT `estudiante_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estudiante_ibfk_2` FOREIGN KEY (`id_apoderado`) REFERENCES `apoderado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `estudiante_ibfk_3` FOREIGN KEY (`id_gestion_academica`) REFERENCES `gestion_academica` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pagos_ibfk_2` FOREIGN KEY (`id_apoderado`) REFERENCES `apoderado` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pagos_ibfk_3` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pagos_ibfk_4` FOREIGN KEY (`id_detalle_cuotas`) REFERENCES `detalle_cuotas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pagos_ibfk_5` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
