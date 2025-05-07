-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 07-05-2025 a las 23:38:35
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
(35, 'RUC', '20601929563', '', '', 'CORP ERA-TEG EMPRESA INDIVIDUAL DE RESPONSABILIDAD LIMITADA - CORP ERA-TEG E.I.R.L.', 'CAL. REAL DE MINAS MZA. T LOTE. 13 CERCADO CHAUPIMARCA PASCO PASCO CHAUPIMARCA', '', '', '2025-05-05 19:21:29');

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
  `observaciones` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `internamientos`
--

INSERT INTO `internamientos` (`id`, `correlativo`, `cliente_id`, `fecha_ingreso`, `estado_general`, `observaciones`) VALUES
(2, 'CGS-00001', 34, '2025-05-05 19:28:39', 'Recibido', 'Cliente trajo varios equipos con fallas diversas.');

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
(4, 'Dell');

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
-- Indices de la tabla `internamientos`
--
ALTER TABLE `internamientos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `correlativo` (`correlativo`),
  ADD KEY `cliente_id` (`cliente_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `equipos_internamiento`
--
ALTER TABLE `equipos_internamiento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `internamientos`
--
ALTER TABLE `internamientos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
-- Filtros para la tabla `internamientos`
--
ALTER TABLE `internamientos`
  ADD CONSTRAINT `internamientos_ibfk_1` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
