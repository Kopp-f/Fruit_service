-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 10-10-2024 a las 23:05:27
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
(59, '2024-09-03', 'Fabian', 1111),
(60, '2024-09-03', 'Fabian', 1000000),
(61, '2024-09-03', 'fabian', 1500000),
(62, '2024-09-04', 'Fabian', 100000),
(63, '2024-09-04', 'fabian', 0),
(64, '2024-09-05', 'kopp', 100000),
(65, '2024-10-01', 'kopp', 1000000),
(66, '2024-10-02', 'kopp', 2222),
(67, '2024-10-02', 'Fabian', 3444),
(68, '2024-10-02', 'kopp', 100000),
(69, '2024-10-02', 'kopp', 10000),
(70, '2024-10-07', 'kopp', 0),
(71, '2024-10-07', 'kopp', 0),
(72, '2024-10-07', 'Fabian', 0),
(73, '2024-10-08', 'Fabian', 0),
(74, '2024-10-08', 'kopp', 10000),
(75, '2024-10-08', 'kopp', 0),
(76, '2024-10-08', 'kopp', 1000000),
(77, '2024-10-09', 'kopp', 200000),
(78, '2024-10-10', 'kopp', 100000),
(79, '2024-10-10', 'kopp', 100000);

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
(44, 76, '2024-10-08', 'kopp', 1000000, -856000),
(45, 77, '2024-10-09', 'kopp', 200000, -115000),
(46, 78, '2024-10-10', 'kopp', 100000, -18500),
(47, 79, '2024-10-10', 'kopp', 100000, 2147383647),
(48, 79, '2024-10-10', 'kopp', 100000, -100000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cargo`
--

CREATE TABLE `cargo` (
  `id` int(50) NOT NULL,
  `Descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `cargo`
--

INSERT INTO `cargo` (`id`, `Descripcion`) VALUES
(1, 'Administrador'),
(2, 'Cajero'),
(3, 'Mesero');

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

--
-- Disparadores `pedidos`
--
DELIMITER $$
CREATE TRIGGER `after_insert_pedido` AFTER INSERT ON `pedidos` FOR EACH ROW BEGIN
    UPDATE pedidos_enc 
    SET hora = NEW.hora 
    WHERE id_pedido = NEW.id_pedido;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedidos_enc`
--

CREATE TABLE `pedidos_enc` (
  `id_pedido` int(11) NOT NULL,
  `hora` time NOT NULL,
  `total` int(150) NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `transferencia` tinyint(1) NOT NULL
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
(1, 'ensalada especial', 'Mezcla de fruta, bañada con crema de leche, cubierta con queso y dos sabores de helado de tu preferencia\r\n', 11000, 'Imagenes_Productos/1.png'),
(2, 'ensalada pequeña', 'Mezcla de fruta, bañada con crema\r\nde leche, cubierta con queso y un\r\nsabores de helado de tu preferencia', 9500, 'Imagenes_Productos/2.png'),
(3, 'Malteada Capuchino', 'Helado de capuchino,arequipe,chips de chocolate y barquillo', 11800, 'Imagenes_Productos/3.png'),
(4, 'Salpicón Pequeño', 'Delicioso salpicón de frutas con jugo de naranja', 2500, 'Imagenes_Productos/4.png'),
(5, 'Gusano', 'Tres bolas de helado de tu preferencia', 12000, 'Imagenes_Productos/5.png'),
(8, 'Waffle especial', 'Waffle con dos bolas de helado', 16000, 'Imagenes_Productos/8.png'),
(14, 'Malteda mix', 'tres bolas de helado con decoracion', 10000, 'Imagenes_Productos/14.png'),
(19, 'limonada de mango ', 'agua con limon y azucar', 6000, 'Imagenes_Productos/19.png');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `Nombre` text NOT NULL,
  `Telefono` bigint(20) NOT NULL,
  `Correo` varchar(50) NOT NULL,
  `Contraseña` varchar(150) NOT NULL,
  `imagen` text NOT NULL,
  `cargo_id` int(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id_usuario`, `Nombre`, `Telefono`, `Correo`, `Contraseña`, `imagen`, `cargo_id`) VALUES
(14, 'kopp', 31333331331, 'fabiankpp3@gmail.com', '8a7296a1a0fca94c0111ca0ed7a249f9bd78e0e61609b44a076e989b6507c5bed17c3b864f46bb1cdc436db26ec6c6e82d4cc1ca60ee96a974a4c0656e8ef664', 'Imagen_usuario/kopp.png', 2),
(18, 'Fabian', 3133859654, 'fabiankpp3@gmail.com', '8a7296a1a0fca94c0111ca0ed7a249f9bd78e0e61609b44a076e989b6507c5bed17c3b864f46bb1cdc436db26ec6c6e82d4cc1ca60ee96a974a4c0656e8ef664', 'Imagen_usuario/Fabian.jpg', 3),
(19, 'andres', 3133859654, 'FABIANKPP3@GMAIL.COM', '8a7296a1a0fca94c0111ca0ed7a249f9bd78e0e61609b44a076e989b6507c5bed17c3b864f46bb1cdc436db26ec6c6e82d4cc1ca60ee96a974a4c0656e8ef664', 'Imagen_usuario/usuario.png', 1),
(21, 'robertooo', 3208908754, 'andress040406@gmail.com', 'ba3253876aed6bc22d4a6ff53d8406c6ad864195ed144ab5c87621b6c233b548baeae6956df346ec8c17f5ea10f35ee3cbc514797ed7ddd3145464e2a0bab413', 'Imagen_usuario/robertooo.png', 1),
(22, 'Hayder', 3123021995, 'hayderpalacios87@gmail.com', '3c9909afec25354d551dae21590bb26e38d53f2173b8d3dc3eee4c047e7ab1c1eb8b85103e3be7ba613b31bb5c9c36214dc9f14a42fd7a2fdb84856bca5c44c2', 'Imagen_usuario/usuario.png', 3);

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
-- Indices de la tabla `cargo`
--
ALTER TABLE `cargo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hora` (`hora`),
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
  ADD PRIMARY KEY (`id_usuario`),
  ADD KEY `cargo_id` (`cargo_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `abrir_caja`
--
ALTER TABLE `abrir_caja`
  MODIFY `id_abrir` int(150) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT de la tabla `caja`
--
ALTER TABLE `caja`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT de la tabla `cargo`
--
ALTER TABLE `cargo`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `pedidos`
--
ALTER TABLE `pedidos`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT de la tabla `pedidos_enc`
--
ALTER TABLE `pedidos_enc`
  MODIFY `id_pedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id_producto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`cargo_id`) REFERENCES `cargo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
