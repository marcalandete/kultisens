-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2019 a las 19:38:32
-- Versión del servidor: 10.1.38-MariaDB
-- Versión de PHP: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `proyecto_grupo03`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eventos`
--

CREATE TABLE `eventos` (
  `idUsuario` int(10) NOT NULL,
  `idEvento` int(10) NOT NULL,
  `inicioEvento` datetime DEFAULT NULL,
  `finalEvento` datetime DEFAULT NULL,
  `tituloEvento` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `eventos`
--

INSERT INTO `eventos` (`idUsuario`, `idEvento`, `inicioEvento`, `finalEvento`, `tituloEvento`) VALUES
(1, 1, '2019-05-02 12:00:00', '2019-05-02 14:00:00', 'Regar tomates'),
(1, 2, '2019-05-17 08:00:00', '2019-05-18 11:00:00', 'Un 10 para el grupo 3'),
(1, 3, '2019-05-27 18:00:00', '2019-05-29 14:00:00', 'Suspender al grupo 6'),
(1, 5, '2019-05-25 17:00:00', '2019-05-25 20:00:00', 'prueba');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `notificaciones`
--

CREATE TABLE `notificaciones` (
  `idNotificacion` int(11) NOT NULL,
  `idUsuario` int(11) NOT NULL,
  `Titulo` varchar(40) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `Descripción` text COLLATE utf8_spanish_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `notificaciones`
--

INSERT INTO `notificaciones` (`idNotificacion`, `idUsuario`, `Titulo`, `tipo`, `Descripción`) VALUES
(31, 2, '¡Regar!', 'alerta_humedad', 'Ha bajado la humedad de la tierra por debajo del 30%, Tengo que regar'),
(32, 2, '¡No regar!', 'alerta_salinidad', 'La salinidad de los pozos ha sobrepasado el 35%, no regar con el agua del pozo.');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `parcelas`
--

CREATE TABLE `parcelas` (
  `idParcelas` int(50) UNSIGNED NOT NULL,
  `posiciones` int(50) UNSIGNED NOT NULL,
  `nombreParcela` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `color` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `cultivo` varchar(20) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `parcelas`
--

INSERT INTO `parcelas` (`idParcelas`, `posiciones`, `nombreParcela`, `color`, `cultivo`) VALUES
(1, 1, 'lechuginos', '#9a59d5', 'lechugos'),
(2, 2, 'naranjos', '#ff8c00', 'naranjas'),
(3, 3, 'tomateras', '#b22222', 'tomates');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posiciones`
--

CREATE TABLE `posiciones` (
  `idPosicion` int(11) NOT NULL,
  `idPos` int(50) UNSIGNED NOT NULL,
  `latitud` double NOT NULL,
  `longitud` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `posiciones`
--

INSERT INTO `posiciones` (`idPosicion`, `idPos`, `latitud`, `longitud`) VALUES
(14, 1, 38.934681833784, -0.18945912198797),
(15, 1, 38.934381392862, -0.18784979658119),
(16, 1, 38.933822235542, -0.18824676350903),
(17, 1, 38.933263073813, -0.18840769604356),
(18, 1, 38.933711655403, -0.18930623606502),
(19, 1, 38.933709568983, -0.18968979195574),
(20, 1, 38.934014185569, -0.18983463124562),
(21, 2, 38.935470260555, -0.18914262131193),
(22, 2, 38.935713710648, -0.18906751946247),
(23, 2, 38.935484435214, -0.18761376217162),
(24, 2, 38.934644473542, -0.18776933029267),
(25, 2, 38.934865334193, -0.18894413785301),
(26, 2, 38.93494355343, -0.18933842257411),
(27, 3, 39.157525276857, -0.24943551021715),
(28, 3, 39.157025079459, -0.24858793219278),
(29, 3, 39.156543768518, -0.24922093352836),
(30, 3, 39.15704177756, -0.24988612135576);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `relaciones`
--

CREATE TABLE `relaciones` (
  `idRelacion` int(11) NOT NULL,
  `idUsuario` int(10) NOT NULL,
  `idParcela` int(50) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `relaciones`
--

INSERT INTO `relaciones` (`idRelacion`, `idUsuario`, `idParcela`) VALUES
(1, 4, 3),
(2, 1, 1),
(3, 1, 2),
(9, 2, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sensores`
--

CREATE TABLE `sensores` (
  `idMedicion` int(11) NOT NULL,
  `idSonda` int(11) NOT NULL,
  `dateTime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `temperatura` double NOT NULL,
  `humedad` tinyint(4) NOT NULL,
  `presion` double NOT NULL,
  `iluminacion` tinyint(4) NOT NULL,
  `salinidad` tinyint(4) NOT NULL,
  `acelerometro` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sensores`
--

INSERT INTO `sensores` (`idMedicion`, `idSonda`, `dateTime`, `temperatura`, `humedad`, `presion`, `iluminacion`, `salinidad`, `acelerometro`) VALUES
(1, 1, '2019-03-26 00:00:00', 10.3, 48, 1010.74, 6, 25, 0),
(2, 2, '2019-03-26 00:00:00', 9.8, 50, 1008.44, 7, 26, 0),
(3, 3, '2019-03-26 00:00:00', 10.9, 52, 1009.02, 7, 26, 0),
(4, 4, '2019-03-26 00:00:00', 5, 60, 1018.44, 0, 24, 0),
(5, 1, '2019-03-26 00:30:00', 9.8, 49, 1010.74, 6, 24, 0),
(6, 2, '2019-03-26 00:30:00', 9.4, 50, 1009.76, 8, 25, 0),
(7, 3, '2019-03-26 00:30:00', 10, 51, 1009.85, 8, 24, 0),
(8, 4, '2019-03-26 00:30:00', 4.6, 62, 1017.44, 2, 23, 0),
(9, 1, '2019-03-26 01:00:00', 9.4, 53, 1007.85, 8, 23, 0),
(10, 2, '2019-03-26 01:00:00', 9.3, 54, 1008.88, 7, 25, 0),
(11, 3, '2019-03-26 01:00:00', 9.3, 55, 1007.99, 8, 24, 0),
(12, 4, '2019-03-26 01:00:00', 4.1, 64, 1016.84, 1, 21, 0),
(17, 1, '2019-03-26 01:30:00', 9.6, 53, 1008.07, 9, 23, 0),
(18, 2, '2019-03-26 01:30:00', 8.7, 54, 1005.2, 10, 22, 0),
(19, 3, '2019-03-26 01:30:00', 8.2, 53, 1007.2, 10, 24, 0),
(20, 4, '2019-03-26 01:30:00', 4, 64, 1017.03, 3, 22, 0),
(21, 1, '2019-03-26 02:00:00', 8.8, 55, 1007.51, 9, 26, 0),
(22, 2, '2019-03-26 02:00:00', 7.1, 60, 1008.44, 8, 23, 0),
(23, 3, '2019-03-26 02:00:00', 7.5, 59, 1006.64, 8, 22, 0),
(24, 4, '2019-03-26 02:00:00', 3.8, 69, 1019.58, 1, 20, 0),
(25, 1, '2019-03-26 02:30:00', 8.1, 57, 1006.52, 7, 23, 0),
(26, 2, '2019-03-26 02:30:00', 7, 62, 1007.99, 7, 25, 0),
(27, 3, '2019-03-26 02:30:00', 7.1, 61, 1006.5, 6, 24, 0),
(28, 4, '2019-03-26 02:30:00', 3.7, 72, 1020.11, 3, 21, 0),
(29, 1, '2019-03-26 03:00:00', 7.3, 62, 1007.3, 9, 22, 0),
(30, 2, '2019-03-26 03:00:00', 7, 64, 1006.99, 8, 23, 0),
(31, 3, '2019-03-26 03:00:00', 6.7, 63, 1005.5, 7, 23, 0),
(32, 4, '2019-03-26 03:00:00', 3.2, 71, 1021.11, 2, 22, 0),
(33, 1, '2019-03-26 03:30:00', 7.2, 64, 1006.23, 10, 23, 0),
(34, 2, '2019-03-26 03:30:00', 6.8, 63, 1007.52, 9, 22, 0),
(35, 3, '2019-03-26 03:30:00', 7.1, 62, 1007.5, 8, 23, 0),
(36, 4, '2019-03-26 03:30:00', 3.7, 70, 1019.11, 4, 22, 0),
(38, 1, '2019-03-26 04:00:00', 6.9, 62, 1007.51, 8, 24, 0),
(39, 2, '2019-03-26 04:00:00', 6.6, 60, 1008.44, 8, 23, 0),
(40, 3, '2019-03-26 04:00:00', 7.1, 59, 1006.5, 10, 24, 0),
(41, 4, '2019-03-26 04:00:00', 3.8, 72, 1019.58, 3, 21, 0),
(42, 1, '2019-03-26 04:30:00', 7.3, 62, 1007.3, 9, 22, 0),
(43, 2, '2019-03-26 04:30:00', 7.9, 60, 1008.85, 11, 23, 0),
(44, 3, '2019-03-26 04:30:00', 8, 60, 1009.54, 10, 21, 0),
(45, 4, '2019-03-26 04:30:00', 4, 69, 1017.23, 6, 23, 0),
(46, 1, '2019-03-26 05:00:00', 9.3, 54, 1009.02, 12, 22, 0),
(47, 2, '2019-03-26 05:00:00', 9.1, 59, 1010.45, 11, 20, 0),
(48, 3, '2019-03-26 05:00:00', 9.2, 59, 1008.52, 12, 22, 0),
(49, 4, '2019-03-26 05:00:00', 5, 68, 1019.23, 6, 22, 0),
(50, 1, '2019-03-26 05:30:00', 10.3, 59, 1009.85, 17, 23, 0),
(51, 2, '2019-03-26 05:30:00', 9.4, 58, 1008.44, 16, 21, 0),
(52, 3, '2019-03-26 05:30:00', 8.5, 59, 1006.5, 18, 21, 0),
(53, 4, '2019-03-26 05:30:00', 6.2, 65, 1020.12, 9, 22, 0),
(54, 1, '2019-03-26 06:00:00', 12.3, 54, 1009.85, 27, 21, 0),
(55, 2, '2019-03-26 06:00:00', 10.5, 56, 1010.45, 25, 23, 0),
(56, 3, '2019-03-26 06:00:00', 9.2, 57, 1008.52, 25, 23, 0),
(57, 4, '2019-03-26 06:00:00', 7, 63, 1019.58, 20, 20, 0),
(58, 1, '2019-03-26 06:30:00', 12.1, 56, 1007.3, 42, 23, 0),
(59, 2, '2019-03-26 06:30:00', 11.5, 56, 1008.85, 48, 23, 0),
(60, 3, '2019-03-26 06:30:00', 11, 56, 1008.23, 45, 22, 0),
(61, 4, '2019-03-26 06:30:00', 6.8, 60, 1018.98, 32, 35, 0),
(62, 1, '2019-03-26 07:00:00', 13.1, 55, 1009.56, 60, 21, 0),
(63, 2, '2019-03-26 07:00:00', 12.1, 54, 1006.23, 62, 21, 0),
(64, 3, '2019-03-26 07:00:00', 11.9, 54, 1010.23, 64, 21, 0),
(65, 4, '2019-03-26 07:00:00', 7.5, 59, 1020.23, 54, 22, 0),
(66, 1, '2019-03-26 07:30:00', 13.3, 54, 1008.4, 69, 23, 0),
(67, 2, '2019-03-26 07:30:00', 12.5, 52, 1008.98, 68, 23, 0),
(68, 3, '2019-03-26 07:30:00', 12.3, 52, 1007.45, 70, 24, 0),
(69, 4, '2019-03-26 07:30:00', 8, 58, 1018.25, 62, 23, 0),
(70, 1, '2019-03-26 08:00:00', 14.3, 53, 1009.56, 76, 22, 0),
(71, 2, '2019-03-26 08:00:00', 13, 13, 1009.35, 79, 22, 0),
(72, 3, '2019-03-26 08:00:00', 12.6, 50, 1010.32, 78, 23, 0),
(73, 4, '2019-03-26 08:00:00', 8.5, 57, 1017.23, 70, 21, 0),
(74, 1, '2019-03-26 08:30:00', 14.8, 51, 1008.32, 82, 23, 0),
(75, 2, '2019-03-26 08:30:00', 13.5, 51, 1010.23, 86, 23, 0),
(76, 3, '2019-03-26 08:30:00', 13.1, 51, 1010.32, 85, 22, 0),
(77, 4, '2019-03-26 08:30:00', 9, 56, 1018.52, 78, 22, 0),
(78, 1, '2019-03-26 09:00:00', 15.1, 50, 1010.32, 85, 21, 0),
(79, 2, '2019-03-26 09:00:00', 14.1, 49, 1008.75, 88, 21, 0),
(80, 3, '2019-03-26 09:00:00', 13.5, 49, 1008.21, 88, 21, 0),
(81, 4, '2019-03-26 09:00:00', 9.4, 55, 1019.32, 83, 21, 0),
(82, 1, '2019-03-26 09:30:00', 15.2, 49, 1009.23, 89, 22, 0),
(83, 2, '2019-03-26 09:30:00', 14.4, 48, 1009.56, 90, 23, 0),
(84, 3, '2019-03-26 09:30:00', 13.9, 48, 1007.56, 90, 22, 0),
(85, 4, '2019-03-26 09:30:00', 9.6, 54, 1018.55, 88, 21, 0),
(86, 1, '2019-03-26 10:00:00', 15.4, 47, 1008.65, 90, 23, 0),
(87, 2, '2019-03-26 10:00:00', 14.7, 47, 1007.23, 91, 21, 0),
(88, 3, '2019-03-26 10:00:00', 14.3, 47, 1009.65, 91, 21, 0),
(89, 4, '2019-03-26 10:00:00', 10, 53, 1019.32, 90, 22, 0),
(90, 1, '2019-03-26 10:30:00', 15.7, 47, 1009.32, 92, 21, 0),
(91, 2, '2019-03-26 10:30:00', 15.1, 46, 1009.34, 92, 23, 0),
(92, 3, '2019-03-26 10:30:00', 14.8, 46, 1007.89, 92, 21, 0),
(93, 4, '2019-03-26 10:30:00', 11.1, 47, 1010.23, 92, 21, 0),
(94, 1, '2019-03-26 11:00:00', 16.2, 46, 1009.23, 93, 22, 0),
(95, 2, '2019-03-26 11:00:00', 15.6, 45, 1008.78, 92, 22, 0),
(96, 3, '2019-03-26 11:00:00', 15.3, 47, 1009.45, 92, 23, 0),
(97, 4, '2019-03-26 11:00:00', 12, 47, 1008.23, 91, 22, 0),
(98, 1, '2019-03-26 11:30:00', 16.8, 45, 1007.59, 93, 21, 0),
(99, 2, '2019-03-26 11:30:00', 16, 45, 1007.56, 93, 23, 0),
(100, 3, '2019-03-26 11:30:00', 15.8, 45, 1006.23, 93, 23, 0),
(101, 4, '2019-03-26 11:30:00', 12.3, 46, 1019.31, 94, 23, 0),
(102, 1, '2019-03-26 12:00:00', 17, 44, 1009.32, 94, 23, 0),
(103, 2, '2019-03-26 12:00:00', 16.5, 44, 1009.45, 94, 21, 0),
(104, 3, '2019-03-26 12:00:00', 16.4, 44, 1008.24, 94, 21, 0),
(105, 4, '2019-03-26 12:00:00', 13, 44, 1016.36, 95, 23, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sondas`
--

CREATE TABLE `sondas` (
  `id` int(20) UNSIGNED NOT NULL,
  `parcela` int(50) UNSIGNED NOT NULL,
  `nombreSonda` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `longitud` double NOT NULL,
  `latitud` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `sondas`
--

INSERT INTO `sondas` (`id`, `parcela`, `nombreSonda`, `longitud`, `latitud`) VALUES
(1, 3, 'tomates_1', -0.2492589, 39.1571112),
(2, 3, 'tomates_2', -0.2496269, 39.1575246),
(3, 3, 'tomates_3', -0.2487369, 39.1574035),
(4, 2, 'naranjos', -0.1885407, 38.9355897);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(10) NOT NULL,
  `nombre` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `apellido1` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `apellido2` varchar(20) COLLATE utf8_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE utf8_spanish_ci NOT NULL,
  `contrasenya` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `localidad` varchar(20) COLLATE utf8_spanish_ci NOT NULL,
  `tipo` int(1) NOT NULL,
  `imagenPerfil` varchar(500) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido1`, `apellido2`, `email`, `contrasenya`, `localidad`, `tipo`, `imagenPerfil`) VALUES
(1, 'Pepe', 'Mira', 'Calabacín', 'pepe@gmail.com', 'Pepe', 'Beniarjó', 0, ''),
(2, 'Laura', 'NAN', NULL, 'NAN@gmail.com', 'Laura', 'Cullera', 0, ''),
(3, 'José', 'Santos', 'García', 'jose@admin.com', 'administrador', 'Alzira', 1, ''),
(4, 'Laura', 'Melero', 'Garrigós', 'lauramelerogarrigos@gmail.com', 'invisible2561', 'Cullera', 0, '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD PRIMARY KEY (`idEvento`),
  ADD KEY `idUsuario` (`idUsuario`);

--
-- Indices de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  ADD PRIMARY KEY (`idNotificacion`);

--
-- Indices de la tabla `parcelas`
--
ALTER TABLE `parcelas`
  ADD PRIMARY KEY (`idParcelas`),
  ADD KEY `idPosiciones` (`posiciones`);

--
-- Indices de la tabla `posiciones`
--
ALTER TABLE `posiciones`
  ADD PRIMARY KEY (`idPosicion`),
  ADD KEY `idPosiciones` (`idPos`);

--
-- Indices de la tabla `relaciones`
--
ALTER TABLE `relaciones`
  ADD PRIMARY KEY (`idRelacion`),
  ADD KEY `idUser` (`idUsuario`),
  ADD KEY `idParcela` (`idParcela`);

--
-- Indices de la tabla `sensores`
--
ALTER TABLE `sensores`
  ADD PRIMARY KEY (`idMedicion`),
  ADD KEY `idSonda` (`idSonda`) USING BTREE;

--
-- Indices de la tabla `sondas`
--
ALTER TABLE `sondas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parcela` (`parcela`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `eventos`
--
ALTER TABLE `eventos`
  MODIFY `idEvento` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `notificaciones`
--
ALTER TABLE `notificaciones`
  MODIFY `idNotificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT de la tabla `parcelas`
--
ALTER TABLE `parcelas`
  MODIFY `idParcelas` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `posiciones`
--
ALTER TABLE `posiciones`
  MODIFY `idPosicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `relaciones`
--
ALTER TABLE `relaciones`
  MODIFY `idRelacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `sensores`
--
ALTER TABLE `sensores`
  MODIFY `idMedicion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT de la tabla `sondas`
--
ALTER TABLE `sondas`
  MODIFY `id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `eventos`
--
ALTER TABLE `eventos`
  ADD CONSTRAINT `eventos_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`);

--
-- Filtros para la tabla `posiciones`
--
ALTER TABLE `posiciones`
  ADD CONSTRAINT `posiciones_ibfk_1` FOREIGN KEY (`idPos`) REFERENCES `parcelas` (`posiciones`) ON DELETE CASCADE;

--
-- Filtros para la tabla `relaciones`
--
ALTER TABLE `relaciones`
  ADD CONSTRAINT `parcela` FOREIGN KEY (`idParcela`) REFERENCES `parcelas` (`idParcelas`) ON DELETE CASCADE,
  ADD CONSTRAINT `relaciones_ibfk_1` FOREIGN KEY (`idUsuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sondas`
--
ALTER TABLE `sondas`
  ADD CONSTRAINT `parcelas` FOREIGN KEY (`parcela`) REFERENCES `parcelas` (`idParcelas`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
