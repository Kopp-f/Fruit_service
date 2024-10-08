-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 14-08-2024 a las 16:12:44
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
-- Estructura de tabla para la tabla `caja`
--

CREATE TABLE `caja` (
  `id` int(50) NOT NULL,
  `Fecha` date NOT NULL,
  `encargado` text NOT NULL,
  `Ingresos` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `caja`
--

INSERT INTO `caja` (`id`, `Fecha`, `encargado`, `Ingresos`) VALUES
(9, '2024-08-13', 'fabian', 10000),
(10, '2024-08-14', 'Hayder', 2000);

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
(6, 'jugo en agua', 'bebida refrescante natural', 4600, '../Imagenes_Productos/6.png'),
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
(7, 1, 'Fabian', 3133859654, 'fabiankpp3@gmail.com', '8a7296a1a0fca94c0111ca0ed7a249f9bd78e0e61609b44a076e989b6507c5bed17c3b864f46bb1cdc436db26ec6c6e82d4cc1ca60ee96a974a4c0656e8ef664', ''),
(9, 0, 'kopp', 3133859654, 'fabiankpp3@gmail.com', '8a7296a1a0fca94c0111ca0ed7a249f9bd78e0e61609b44a076e989b6507c5bed17c3b864f46bb1cdc436db26ec6c6e82d4cc1ca60ee96a974a4c0656e8ef664', '');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja`
--
ALTER TABLE `caja`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT de la tabla `pedidos_enc`
--
ALTER TABLE `pedidos_enc`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

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
