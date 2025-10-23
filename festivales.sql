-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-10-2025 a las 03:47:55
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
-- Base de datos: `festivales`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `artistas`
--

CREATE TABLE `artistas` (
  `id` int(11) NOT NULL,
  `nombres` varchar(150) NOT NULL,
  `apellidos` varchar(150) NOT NULL,
  `genero` varchar(100) NOT NULL,
  `ciudad_natal` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `artistas`
--

INSERT INTO `artistas` (`id`, `nombres`, `apellidos`, `genero`, `ciudad_natal`, `created_at`) VALUES
(1, 'df', 'sdfs', 'sdfsd', 'sdfs', '2025-10-22 00:41:52'),
(2, 'df', 'sdfs', 'sdfsd', 'sdfs', '2025-10-22 00:42:25'),
(3, 'dfafa', 'adfadf', 'adf', 'adfad', '2025-10-22 00:46:16'),
(4, 'Maluma', 'guerra', 'femenino', 'Bogota', '2025-10-22 13:30:38');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compras`
--

CREATE TABLE `compras` (
  `id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `numero_documento` int(11) NOT NULL,
  `evento_id` int(11) NOT NULL,
  `localidad_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL CHECK (`cantidad` <= 10),
  `valor_total` decimal(10,2) NOT NULL,
  `metodo_pago` varchar(20) NOT NULL,
  `estado` enum('exitosa','pendiente','cancelada') DEFAULT 'exitosa',
  `fecha_compra` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE `departamentos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre`) VALUES
(1, 'Antioquia'),
(2, 'Atlantico');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `evento_artista`
--

CREATE TABLE `evento_artista` (
  `event_id` int(11) NOT NULL,
  `artista_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `descripcion` text NOT NULL,
  `municipio_id` int(11) DEFAULT NULL,
  `fecha_inicio` datetime NOT NULL,
  `fecha_fin` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `events`
--

INSERT INTO `events` (`id`, `nombre`, `descripcion`, `municipio_id`, `fecha_inicio`, `fecha_fin`, `created_at`, `foto`) VALUES
(5, 'Protector solar', 'qeadf', 2, '2025-10-14 18:31:00', '2025-10-07 18:31:00', '2025-10-22 23:31:09', 'uploads/1761175869_monumento-ventana-del-mundo-barraquilla-600nw-2355880593 (1).webp'),
(6, 'cafe especial', 'asdasd', 1, '2025-10-27 22:31:00', '2025-10-15 18:35:00', '2025-10-22 23:31:37', 'uploads/1761175897_images.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `localidades`
--

CREATE TABLE `localidades` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `capacidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `localidades`
--

INSERT INTO `localidades` (`id`, `codigo`, `nombre`, `capacidad`) VALUES
(1, '2', 'asd', 500),
(3, '1 ', 'expofuturo', 1000),
(8, '3', 'alegra', 700),
(9, '12312', 'panorama', 6),
(11, '7', 'panorama', 100),
(12, '5', 'plaza', 400),
(13, '4', 'plaza', 400);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE `municipios` (
  `id` int(11) NOT NULL,
  `departamento_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`id`, `departamento_id`, `nombre`) VALUES
(1, 1, 'Medellin'),
(2, 2, 'Barranquilla');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  `localidad_id` int(11) NOT NULL,
  `precio` decimal(10,2) NOT NULL CHECK (`precio` > 0),
  `cantidad` int(11) NOT NULL CHECK (`cantidad` >= 0),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `tipo_ticket` enum('VIP','general','preferencial') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` text DEFAULT NULL,
  `apellidos` text DEFAULT NULL,
  `tipo_documento` enum('TI','CC','Cédula de extranjeria') DEFAULT NULL,
  `numero_documento` int(11) DEFAULT NULL,
  `telefono` int(10) DEFAULT NULL,
  `email` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `contrasena` text DEFAULT NULL,
  `rol` enum('admin','usuario') NOT NULL DEFAULT 'usuario'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellidos`, `tipo_documento`, `numero_documento`, `telefono`, `email`, `foto`, `contrasena`, `rol`) VALUES
(1, 'Laura', 'Admin', 'CC', 1234567890, 2147483647, 'admin@festivales.com', NULL, 'admin', 'admin'),
(3, 'laura', 'morales', 'CC', 123456789, 2147483647, 'laugamer334@gmail.com', NULL, '$2y$10$nsBnlsv5Q3uj27P5DxF5A.wR5ha4VLPAwkG679hIdxBaQgBStgoC2', 'usuario'),
(4, 'Yeral', 'Bravo', 'CC', 12342454, 13214134, 'yeraldinbravo65@gmail.com', 'perfil_4_descarga.png', '$2y$10$18dla5SZY7wMQq3CdDhwpuWETI5QmU8vm1sTFMXb59EvCe0eD6hme', 'usuario'),
(8, 'Administrador', 'Principal', '', 123455, 2147483647, 'admin@tudominio.com', NULL, '8ebae87018453330d0425db8c1b03191fd4e0c4aff6b81cc000a20266e9316ff', 'admin'),
(9, 'Laura', 'Morales', 'CC', 1044606536, 301770740, 'laugamer334@gmail.com', NULL, '$2y$10$QZ784ZfJllDe6Br0A8XLveQRjgpFSzNUtJXge7P92LjwJCKBY21zu', 'admin'),
(10, 'Yeral', 'Bravo', 'CC', 123456789, 2147483647, 'yeral@example.com', NULL, '$2y$10$8Wq0EcDO1RAiuwgCoCSJIe8iGgrZG0dOlDwcWKJEstLg5I/ocWSim', 'admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `artistas`
--
ALTER TABLE `artistas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `compras`
--
ALTER TABLE `compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`),
  ADD KEY `evento_id` (`evento_id`),
  ADD KEY `localidad_id` (`localidad_id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `evento_artista`
--
ALTER TABLE `evento_artista`
  ADD PRIMARY KEY (`event_id`,`artista_id`),
  ADD KEY `artista_id` (`artista_id`);

--
-- Indices de la tabla `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `municipio_id` (`municipio_id`);

--
-- Indices de la tabla `localidades`
--
ALTER TABLE `localidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departamento_id` (`departamento_id`);

--
-- Indices de la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_id` (`event_id`),
  ADD KEY `localidad_id` (`localidad_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `artistas`
--
ALTER TABLE `artistas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `compras`
--
ALTER TABLE `compras`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `localidades`
--
ALTER TABLE `localidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `compras`
--
ALTER TABLE `compras`
  ADD CONSTRAINT `compras_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `compras_ibfk_2` FOREIGN KEY (`evento_id`) REFERENCES `events` (`id`),
  ADD CONSTRAINT `compras_ibfk_3` FOREIGN KEY (`localidad_id`) REFERENCES `localidades` (`id`);

--
-- Filtros para la tabla `evento_artista`
--
ALTER TABLE `evento_artista`
  ADD CONSTRAINT `evento_artista_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `evento_artista_ibfk_2` FOREIGN KEY (`artista_id`) REFERENCES `artistas` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Filtros para la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD CONSTRAINT `municipios_ibfk_1` FOREIGN KEY (`departamento_id`) REFERENCES `departamentos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`localidad_id`) REFERENCES `localidades` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
