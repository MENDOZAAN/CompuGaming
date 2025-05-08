-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 08-05-2025 a las 21:36:55
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
-- Base de datos: `compugaming_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clientes`
--

CREATE TABLE `clientes` (
  `id` int(11) NOT NULL,
  `tipo_doc` enum('DNI','RUC') NOT NULL,
  `dni_ruc` varchar(15) NOT NULL,
  `nombres` varchar(100) DEFAULT NULL,
  `apellidos` varchar(100) DEFAULT NULL,
  `razon_social` varchar(150) DEFAULT NULL,
  `direccion` text DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `fecha_registro` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`id`, `tipo_doc`, `dni_ruc`, `nombres`, `apellidos`, `razon_social`, `direccion`, `telefono`, `correo`, `fecha_registro`) VALUES
(1, 'RUC', '20604235694', '', '', 'COMPU GAMING STORE E.I.R.L.', 'CAL. --- MZA. I LOTE. 38 URB. LA ESTANCIA DE CARABAYLLO LIMA LIMA CARABAYLLO', '', '', '2025-05-04 16:59:07'),
(34, 'DNI', '71250681', 'NICO LIZANDRO', 'MENDOZA ATENCIO', '', '', '979563045', '', '2025-05-05 17:57:15'),
(35, 'RUC', '20601929563', '', '', 'CORP ERA-TEG EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA - CORP ERA-TEG E.I.R.L.', 'CAL. REAL DE MINAS MZA. T LOTE. 13 CERCADO CHAUPIMARCA PASCO PASCO CHAUPIMARCA', '', '', '2025-05-05 19:21:29'),
(36, 'DNI', '04207303', 'JUAN', 'MENDOZA MIRAVAL', '', '', '', '', '2025-05-07 16:58:26'),
(37, 'RUC', '14444', 'jose', 'mesa', '', '', '79797979', '', '2025-05-07 18:08:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `equipos_internamiento`
--

CREATE TABLE `equipos_internamiento` (
  `id` int(11) NOT NULL,
  `internamiento_id` int(11) NOT NULL,
  `tipo_equipo` varchar(100) NOT NULL,
  `marca` varchar(100) DEFAULT NULL,
  `modelo` varchar(100) DEFAULT NULL,
  `nro_serie` varchar(100) DEFAULT NULL,
  `falla_reportada` text DEFAULT NULL,
  `servicio_solicitado` text DEFAULT NULL,
  `accesorios` text DEFAULT NULL,
  `estado_equipo` enum('Recibido','En reparación','Terminado','Entregado') DEFAULT 'Recibido',
  `precio_aprox` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `equipos_internamiento`
--

INSERT INTO `equipos_internamiento` (`id`, `internamiento_id`, `tipo_equipo`, `marca`, `modelo`, `nro_serie`, `falla_reportada`, `servicio_solicitado`, `accesorios`, `estado_equipo`, `precio_aprox`) VALUES
(12, 3, 'Tablet', 'Epson', 'ds', '133', '2', 'Cambio de disco duro de PC', 'd', 'Recibido', 100.00),
(13, 4, 'Laptop', 'HP', 'xd', '12323433553', 'no prende la cosa', 'Cambio de disco duro de PC', 'no tiene', 'Recibido', 0.00),
(14, 5, 'Laptop', 'Epson', 'dfd', 'd', 'd', 'Formateo y reinstalación de sistema operativo', 'd', 'Recibido', 0.00),
(15, 6, 'Monitor', 'Epson', '', '2332', 'mo mrpende', 'Formateo y reinstalación de sistema operativo', 'eww', 'Recibido', 0.00),
(16, 6, 'Teclado', 'Epson', 'dfd', '', '', 'Formateo y reinstalación de sistema operativo', 'trt', 'Recibido', 0.00),
(17, 7, 'Impresora', 'Dells', 'pc1', '2332', 'pc1', 'Cambio de disco duro de PC', 'pc1', 'Recibido', 0.00),
(18, 7, 'Tablet', 'Epson', 'pc1', 'p1221', 'pc1', 'Mantenimiento general de laptop', 'pc1', 'Recibido', 0.00),
(19, 8, 'Laptop', 'Dells', 'hola', 'ds', 'ds', 'Actualización de software', 'd', 'Recibido', 0.00),
(20, 9, 'Monitor', 'Epson', 'hdsdfd', '2313', 'NO PRENDE', 'Cambio de disco duro de PC', '', 'Recibido', 0.00),
(21, 10, 'Monitor', 'Epson', 'xd', 'xd', 'dsd', 'Formateo y reinstalación de sistema operativo', 'dsd', 'Recibido', 0.00);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_tecnico`
--

CREATE TABLE `historial_tecnico` (
  `id` int(11) NOT NULL,
  `internamiento_id` int(11) DEFAULT NULL,
  `tecnico_id` int(11) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `fecha` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagenes_equipo`
--

CREATE TABLE `imagenes_equipo` (
  `id` int(11) NOT NULL,
  `equipo_id` int(11) NOT NULL,
  `ruta_imagen` varchar(255) DEFAULT NULL,
  `fecha_subida` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `internamientos`
--

CREATE TABLE `internamientos` (
  `id` int(11) NOT NULL,
  `correlativo` varchar(20) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `fecha_ingreso` datetime NOT NULL DEFAULT current_timestamp(),
  `estado_general` enum('Recibido','En reparación','Terminado','Entregado') DEFAULT 'Recibido',
  `observaciones` text DEFAULT NULL,
  `tecnico_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `internamientos`
--

INSERT INTO `internamientos` (`id`, `correlativo`, `cliente_id`, `fecha_ingreso`, `estado_general`, `observaciones`, `tecnico_id`) VALUES
(3, 'CGS-00001', 35, '2025-05-07 18:04:14', 'Terminado', 'sd', NULL),
(4, 'CGS-00002', 37, '2025-05-07 18:08:27', 'Recibido', 'no prende', NULL),
(5, 'CGS-00003', 34, '2025-05-07 18:18:02', 'Recibido', 'ds', NULL),
(6, 'CGS-00004', 34, '2025-05-07 18:29:38', 'Recibido', '', NULL),
(7, 'CGS-00005', 35, '2025-05-07 18:32:10', 'Recibido', '1', NULL),
(8, 'CGS-00006', 34, '2025-05-07 18:48:31', 'Recibido', 'dsd', NULL),
(9, 'G-INT-00007', 36, '2025-05-07 18:59:04', 'En reparación', 'FALTA REPUESTPS', 6),
(10, 'G-INT-00008', 1, '2025-05-07 21:05:53', 'En reparación', 'HOLA', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id`, `nombre`) VALUES
(1, 'HP'),
(2, 'Lenovo'),
(3, 'Epson'),
(4, 'Dells');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `descripcion` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `descripcion`) VALUES
(1, 'Limpieza de cabezal de impresora'),
(2, 'Formateo y reinstalación de sistema operativo'),
(3, 'Cambio de disco duro de PC'),
(4, 'Mantenimiento general de laptop'),
(5, 'Actualización de software');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipos_equipo`
--

CREATE TABLE `tipos_equipo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `tipos_equipo`
--

INSERT INTO `tipos_equipo` (`id`, `nombre`) VALUES
(1, 'Laptop'),
(2, 'PC de Escritorio'),
(3, 'Impresora'),
(4, 'Monitor'),
(5, 'Teclado'),
(6, 'Mouse'),
(7, 'Tablet'),
(8, 'Proyector'),
(9, 'Servidor'),
(10, 'Router');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `nombre_usuario` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rol` varchar(50) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp(),
  `estado` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `nombre_usuario`, `password`, `rol`, `fecha_creacion`, `estado`) VALUES
(4, 'Nico Lizandro', 'Mendoza', 'admin', '$2y$10$vcKra/.yCoMwN88xRZFCfuTh2Iq60ooAPG8H5eKsOKc3ejmtrwAtu', 'Admin', '2025-04-29 01:45:58', 1),
(6, 'Marlon', 'Canta', 'user', '$2y$10$xI9TkQEBh4pOIxPoxVVy9eQLoEYl2IP3DpBf/ge6kzT2XXkk0ODfW', 'Usuario', '2025-05-02 14:00:32', 1),
(38, 'admin2', 'admin2', 'admin2', '$2y$10$2CAqIeNw.tMkczwiYlPgwebxxPSKrsGs2evB4FRLLa6US5j714v42', 'Admin', '2025-05-04 19:28:45', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `dni_ruc` (`dni_ruc`);

--
-- Indices de la tabla `equipos_internamiento`
--
ALTER TABLE `equipos_internamiento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internamiento_id` (`internamiento_id`);

--
-- Indices de la tabla `historial_tecnico`
--
ALTER TABLE `historial_tecnico`
  ADD PRIMARY KEY (`id`),
  ADD KEY `internamiento_id` (`internamiento_id`),
  ADD KEY `tecnico_id` (`tecnico_id`);

--
-- Indices de la tabla `imagenes_equipo`
--
ALTER TABLE `imagenes_equipo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipo_id` (`equipo_id`);

--
-- Indices de la tabla `internamientos`
--
ALTER TABLE `internamientos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correlativo` (`correlativo`),
  ADD KEY `cliente_id` (`cliente_id`),
  ADD KEY `fk_tecnico` (`tecnico_id`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipos_equipo`
--
ALTER TABLE `tipos_equipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `equipos_internamiento`
--
ALTER TABLE `equipos_internamiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `historial_tecnico`
--
ALTER TABLE `historial_tecnico`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `imagenes_equipo`
--
ALTER TABLE `imagenes_equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `internamientos`
--
ALTER TABLE `internamientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipos_equipo`
--
ALTER TABLE `tipos_equipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `equipos_internamiento`
--
ALTER TABLE `equipos_internamiento`
  ADD CONSTRAINT `equipos_internamiento_ibfk_1` FOREIGN KEY (`internamiento_id`) REFERENCES `internamientos` (`id`);

--
-- Filtros para la tabla `historial_tecnico`
--
ALTER TABLE `historial_tecnico`
  ADD CONSTRAINT `historial_tecnico_ibfk_1` FOREIGN KEY (`internamiento_id`) REFERENCES `internamientos` (`id`),
  ADD CONSTRAINT `historial_tecnico_ibfk_2` FOREIGN KEY (`tecnico_id`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `imagenes_equipo`
--
ALTER TABLE `imagenes_equipo`
  ADD CONSTRAINT `imagenes_equipo_ibfk_1` FOREIGN KEY (`equipo_id`) REFERENCES `equipos_internamiento` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `internamientos`
--
ALTER TABLE `internamientos`
  ADD CONSTRAINT `fk_tecnico` FOREIGN KEY (`tecnico_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `internamientos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
