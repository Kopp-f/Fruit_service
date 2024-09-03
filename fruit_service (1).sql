-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 03-09-2024 a las 20:40:30
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
-- Base de datos: `fruit_service`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `abrir_caja`
--

CREATE TABLE `abrir_caja` (
  `id_abrir` int(150) NOT NULL,
  `fecha` date NOT NULL,
  `encargado` text NOT NULL,
  `valor_apertura` int(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `abrir_caja`
--

INSERT INTO `abrir_caja` (`id_abrir`, `fecha`, `encargado`, `valor_apertura`) VALUES
(44, '2024-08-21', 'Fabian', 10000),
(45, '2024-08-21', 'Fabian', 100),
(46, '2024-08-21', 'Fabian', 10000),
(47, '2024-08-21', 'Fabian', 10000),
(48, '2024-08-21', 'Fabian', 10000),
(49, '2024-08-22', 'Fabian', 10000),
(50, '2024-08-22', 'Fabian', 1999),
(51, '2024-08-27', 'Fabian', 10000),
(52, '2024-09-01', 'Fabian', 0),
(53, '2024-09-02', 'fabian', 1000),
(54, '2024-09-02', 'fabian', 1000),
(55, '2024-09-02', 'Fabian', 200000),
(56, '2024-09-02', 'fabian', 200000),
(57, '2024-09-03', 'Fabian', 1000000),
(58, '2024-09-03', 'Fabian', 145000),
(59, '2024-09-03', 'Fabian', 1111);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(50) NOT NULL,
  `id_abrir` int(150) NOT NULL,
  `Fecha` date NOT NULL,
  `encargado` text NOT NULL,
  `valor_apertura` int(150) NOT NULL,
  `Ingresos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `id_abrir`, `Fecha`, `encargado`, `valor_apertura`, `Ingresos`) VALUES
(26, 47, '2024-08-21', 'Fabian', 10000, 59000),
(27, 52, '2024-09-01', 'Fabian', 0, 0),
(28, 53, '2024-09-02', 'fabian', 1000, -1000),
(29, 54, '2024-09-02', 'fabian', 1000, -1000),
(30, 55, '2024-09-02', 'Fabian', 200000, 50700),
(31, 56, '2024-09-02', 'fabian', 200000, -200000),
(32, 56, '2024-09-02', 'fabian', 200000, -124200),
(33, 57, '2024-09-03', 'Fabian', 1000000, -1000000),
(34, 57, '2024-09-03', 'Fabian', 1000000, -1000000),
(35, 58, '2024-09-03', 'Fabian', 145000, -145000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos`
--

CREATE TABLE `pedidos` (
  `id` int(50) NOT NULL,
  `id_pedido` int(11) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `hora` time NOT NULL,
  `total` int(11) NOT NULL,
  `cantidad` int(150) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_enc`
--

CREATE TABLE `pedidos_enc` (
  `id_pedido` int(11) NOT NULL,
  `hora` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  `total` int(150) NOT NULL,
  `estado` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id_producto` int(11) NOT NULL,
  `Nombre_del_producto` text NOT NULL,
  `descripcion` text NOT NULL,
  `Precio` int(11) NOT NULL,
  `Imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id_producto`, `Nombre_del_producto`, `descripcion`, `Precio`, `Imagen`) VALUES
(1, 'ensalada especial', 'Mezcla de fruta, bañada con crema de leche, cubierta con queso y dos sabores de helado de tu preferencia\r\n', 11000, '../Imagenes_Productos/1.png'),
(2, 'ensalada pequeña', 'Mezcla de fruta, bañada con crema\r\nde leche, cubierta con queso y un\r\nsabores de helado de tu preferencia', 9500, '../Imagenes_Productos/2.png'),
(3, 'Malteada Capuchino', 'Helado de capuchino,arequipe,chips de chocolate y barquillo', 11800, '../Imagenes_Productos/3.png'),
(4, 'Salpicón Pequeño', 'Delicioso salpicón de frutas con jugo de naranja', 2500, '../Imagenes_Productos/4.png'),
(5, 'Gusano', 'Tres bolas de helado de tu preferencia', 12000, '../Imagenes_Productos/5.png'),
(8, 'Waffle especial', 'Waffle con dos bolas de helado', 16000, '../Imagenes_Productos/8.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `id_cargo` int(50) NOT NULL,
  `Nombre` text NOT NULL,
  `Telefono` bigint(20) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Contraseña` varchar(150) NOT NULL,
  `imagen` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `id_cargo`, `Nombre`, `Telefono`, `Correo`, `Contraseña`, `imagen`) VALUES
(7, 1, 'Fabian', 3133859654, 'fabiankpp3@gmail.com', '8a7296a1a0fca94c0111ca0ed7a249f9bd78e0e61609b44a076e989b6507c5bed17c3b864f46bb1cdc436db26ec6c6e82d4cc1ca60ee96a974a4c0656e8ef664', 'Imagen_usuario/usuario.png'),
(9, 0, 'kopp', 3133859654, 'fabiankpp3@gmail.com', '8a7296a1a0fca94c0111ca0ed7a249f9bd78e0e61609b44a076e989b6507c5bed17c3b864f46bb1cdc436db26ec6c6e82d4cc1ca60ee96a974a4c0656e8ef664', 'Imagen_usuario/usuario.png'),
(11, 1, 'Hayder', 3123021995, 'hayder87@gmail.com', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', 'Imagen_usuario/usuario.png'),
(12, 1, 'dayanna', 31333331331, 'dayyad@gamil.com', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', 'Imagen_usuario/usuario.png');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `abrir_caja`
--
ALTER TABLE `abrir_caja`
  ADD PRIMARY KEY (`id_abrir`);

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_abrir` (`id_abrir`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_producto` (`id_producto`),
  ADD KEY `id_pedido` (`id_pedido`);

--
-- Indices de la tabla `pedidos_enc`
--
ALTER TABLE `pedidos_enc`
  ADD PRIMARY KEY (`id_pedido`);

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id_producto`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abrir_caja`
--
ALTER TABLE `abrir_caja`
  MODIFY `id_abrir` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `pedidos_enc`
--
ALTER TABLE `pedidos_enc`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `caja_ibfk_1` FOREIGN KEY (`id_abrir`) REFERENCES `abrir_caja` (`id_abrir`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id_producto`),
  ADD CONSTRAINT `pedidos_ibfk_2` FOREIGN KEY (`id_pedido`) REFERENCES `pedidos_enc` (`id_pedido`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
