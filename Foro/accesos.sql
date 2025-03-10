-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-03-2025 a las 12:15:09
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
-- Base de datos: `foro`
--
CREATE DATABASE IF NOT EXISTS `foro` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `foro`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentarios`
--

CREATE TABLE `comentarios` (
  `id_comentario` int(11) NOT NULL,
  `comentario` longtext NOT NULL,
  `fecha_comentario` datetime NOT NULL,
  `id_tema` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `comentarios`
--

INSERT INTO `comentarios` (`id_comentario`, `comentario`, `fecha_comentario`, `id_tema`, `id_usuario`) VALUES
(0, 'Es necesario comprender las regulaciones migratorias para hacer una transición legal exitosa a Europa.', '2025-04-20 08:00:00', 47, 2),
(0, '¿Alguien ha tenido experiencia con el proceso de nacionalización en España? Compartan consejos.', '2025-04-21 10:00:00', 48, 3),
(0, 'Las políticas de inmigración están cambiando, por lo que siempre es importante estar actualizado.', '2025-04-22 12:00:00', 50, 4),
(0, '¿Cuáles son las ayudas legales disponibles para inmigrantes indocumentados en España?', '2025-04-23 14:00:00', 46, 5),
(0, 'Es necesario comprender las regulaciones migratorias para hacer una transición legal exitosa a Europa.', '2025-04-20 08:00:00', 47, 2),
(0, '¿Alguien ha tenido experiencia con el proceso de nacionalización en España? Compartan consejos.', '2025-04-21 10:00:00', 48, 3),
(0, 'Las políticas de inmigración están cambiando, por lo que siempre es importante estar actualizado.', '2025-04-22 12:00:00', 50, 4),
(0, '¿Cuáles son las ayudas legales disponibles para inmigrantes indocumentados en España?', '2025-04-23 14:00:00', 46, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `temas`
--

CREATE TABLE `temas` (
  `id_tema` int(11) NOT NULL,
  `tema` varchar(255) NOT NULL,
  `fecha` datetime NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `categoria` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `temas`
--

INSERT INTO `temas` (`id_tema`, `tema`, `fecha`, `id_usuario`, `categoria`) VALUES
(1, '¿Cómo puedo obtener la residencia en España?', '2025-04-15 10:00:00', 3, 'Legalización'),
(2, 'Requisitos para obtener un visado de trabajo en Europa', '2025-04-16 12:00:00', 4, 'Visas'),
(3, 'Proceso de asilo político en Estados Unidos', '2025-04-17 14:00:00', 5, 'Asilo'),
(4, 'Reagrupación familiar en la UE', '2025-04-18 16:00:00', 6, 'Reagrupación Familiar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `usuario` text NOT NULL,
  `pw` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `usuario`, `pw`, `email`) VALUES
(1, 'Carlos', 'abc123', 'carlos@gmail.com'),
(2, 'Ana', 'qwerty', 'ana@yahoo.com'),
(3, 'Sofia', 'password1', 'sofia@hotmail.com'),
(4, 'Juan', '123qwe', 'juan@outlook.com'),
(5, 'Laura', 'mypassword', 'laura@gmail.com'),
(6, 'Ruben', 'ruben2025', 'ruben@ymail.com'),
(7, 'Elena', 'elena1234', 'elena@yahoo.es'),
(8, 'Raul', 'raulfan90', 'raul@aol.com'),
(9, 'Elisa', '123456789', 'elisaitaheredia98@gmail.com');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `temas`
--
ALTER TABLE `temas`
  ADD PRIMARY KEY (`id_tema`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `temas`
--
ALTER TABLE `temas`
  MODIFY `id_tema` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
