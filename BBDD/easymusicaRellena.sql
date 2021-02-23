-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 23-02-2021 a las 21:59:03
-- Versión del servidor: 10.4.17-MariaDB
-- Versión de PHP: 8.0.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `easymusica`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `alta`
--

CREATE DATABASE IF NOT EXISTS easymusica;
USE easymusica;

CREATE TABLE `alta` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `fechaRegistro` varchar(10) NOT NULL,
  `hora` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `alta`
--

INSERT INTO `alta` (`id`, `email`, `nombre`, `apellidos`, `fechaRegistro`, `hora`) VALUES
(1, 'registro1@gmail.com', 'registro', 'uno perez', '2021-02-23', '20:53:49'),
(2, 'registro2@gmail.com', 'registro dos', 'perez', '2021-02-23', '20:55:01'),
(3, 'registro3@gmail.com', 'registro tres', 'perez', '2021-02-23', '20:55:44'),
(4, 'registro4@gmail.com', 'registro cuatro', 'perez', '2021-02-23', '20:56:09'),
(5, 'registro5@gmail.com', 'registro cinco', 'perez', '2021-02-23', '20:56:58');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `baja`
--

CREATE TABLE `baja` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `fechaRegistro` varchar(10) NOT NULL,
  `fechaBaja` varchar(10) NOT NULL,
  `hora` varchar(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `baja`
--

INSERT INTO `baja` (`id`, `email`, `nombre`, `apellidos`, `direccion`, `fechaRegistro`, `fechaBaja`, `hora`) VALUES
(1, 'registro3@gmail.com', 'registro tres', 'perez', 'calle de la amargura 3', '2021-02-23', '2021/02/23', '20:59:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `carrito_usuario`
--

CREATE TABLE `carrito_usuario` (
  `xUsuario` int(11) NOT NULL,
  `xProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `carrito_usuario`
--

INSERT INTO `carrito_usuario` (`xUsuario`, `xProducto`, `cantidad`) VALUES
(1, 1, 1),
(1, 2, 1),
(1, 4, 1),
(1, 5, 6),
(2, 3, 1),
(2, 10, 1),
(2, 15, 1),
(4, 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`id`, `nombre`) VALUES
(2, 'Bajos'),
(1, 'Guitarras'),
(3, 'instrumentos acústico'),
(4, 'instrumentos eléctricos'),
(7, 'otros'),
(5, 'ukeleles');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `descripcion` text NOT NULL,
  `precio` decimal(7,2) NOT NULL,
  `unidadesDisponibles` int(11) NOT NULL,
  `imagen` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`id`, `nombre`, `descripcion`, `precio`, `unidadesDisponibles`, `imagen`) VALUES
(1, 'guitarra ibanezs', 'guitarra acustica bonita', '199.99', 37, 'guitarra_acustica_fender.jpg'),
(2, 'guitarra cort', 'guitarra electrica bonita', '349.99', 12, 'guitarra_electrica_cort.jpg'),
(3, 'bajo cort', 'bajo acustico bonita', '400.00', 79, 'bajo_acustico_cort.jpg'),
(4, 'bajo fender', 'bajo electrico bonita', '220.00', 6, 'bajo_electrico_fender.jpg'),
(5, 'ukelele', 'ukelele acustico bonito', '400.00', 55, 'ukelele.jpg'),
(6, 'afinador digital', 'Bonito afinador digital, funciona con pilas AAaa', '19.99', 95, 'fotoAfinador.jpg'),
(7, 'Afinador pinza', 'Afinador en forma de pinza. Sirve para afinar cualquier instrumento eléctrico. Carga por USB. Cable no incluido.', '19.99', 119, 'afinador_pinza.JPG'),
(8, 'Bajo fender nate', 'Bonito bajo de 4 cuerdas eléctrico. Perfecto para nivel intermedio', '320.00', 29, 'bajo_fender_nate.JPG'),
(9, 'Bajo Harley Benton', 'Bajo eléctrico Harley Benton perfecto para principiantes.', '89.99', 89, 'bajo_hb.JPG'),
(10, 'Cuerdas ukelele', 'Juego de 4 cuerdas para ukelele de tenor.', '15.99', 99, 'cueras_ukelele.JPG'),
(11, 'Cuerdas guitarra acústica', 'Cuerdas de guitarra acústica, marca: Harley Benton', '15.99', 17, 'cuerdas_acustica_hb.JPG'),
(12, 'Cuerdas bajo eléctrico', 'Cuerdas de titanio para bajo eléctrico. Marca: Harley Benton', '25.89', 20, 'cuerdas_bajo_elec_hb.JPG'),
(13, 'Cuerdas de guitarra eléctrica', 'Cuerdas de guitarra eléctrica marca DAdario. Perfectas para tocar melodías cálidas.', '14.99', 28, 'cuerdas_gelectrica_da.JPG'),
(14, 'Guitarra Fender Stratocaster', 'Mítica guitarra eléctrica. Instrumento franquicia de la casa Fender. Incluye funda de regalo.', '2500.00', 88, 'fender_stratocaster.jpg'),
(15, 'Guitarra fender telecaster', 'Guitarra eléctrica de la casa Fender. Perfecta para blues y riffs cañeros. No incluye funda rígida.', '850.00', 50, 'fender_telecaster.jpg'),
(16, 'Guitarra gibson explorer', 'Guitarra eléctrica de con forma de estrella. Muy mítica de los años 70.', '690.00', 65, 'gibson_explorer.jpg'),
(17, 'Guitarra Gibson Les Paul BL', 'Guitarra mítica de la casa Gibson. Color negro azabache. Incluye funda rígida.', '2300.00', 43, 'gibson_lp_negra.jpg'),
(18, 'Guitarra Gibson Les Paul GL', 'Guitarra Gibson Les Paul de color dorado. Mítica guitarra icónica los años 90. Slash hizo de esta guitarra una leyenda. Incluye funda rígida.', '1980.00', 32, 'gibson_lp_dorada.jpg'),
(19, 'Guitarra Gibson SG', 'No hace falta presentación. Angus Young y sus riffs infernales popularizaron esta mítica guitarra. Incluye estuche rígido y juego de cuerdas de repuesto.', '1599.00', 26, 'gibson_sg.jpg'),
(20, 'Guitarra Fender Squier', 'Guitarra básica para iniciarse en el instrumento. Incluye funda no rígida.', '120.00', 99, 'guitarra_fender_squier.jpg'),
(21, 'Guitarra acústica Fender cream', 'Guitarra acústica preciosa. marca Fender.', '120.99', 12, 'acustica_fendercd60.JPG'),
(22, 'Guitarra acústica Harley Bento', 'Guitarra acústica Harley Benton de color azul cromado. Incluye funda no rígida', '123.99', 50, 'hb_azul.JPG'),
(25, 'Guitarra acústica HB BL', 'Guitarra acústica Harley Benton de color negro. Incluye funda no rígida.', '130.99', 123, '1614113650hb_d120.JPG');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto_categoria`
--

CREATE TABLE `producto_categoria` (
  `xProducto` int(11) NOT NULL,
  `xCategoria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `producto_categoria`
--

INSERT INTO `producto_categoria` (`xProducto`, `xCategoria`) VALUES
(2, 1),
(4, 2),
(2, 4),
(4, 4),
(1, 1),
(1, 3),
(6, 7),
(7, 7),
(8, 2),
(8, 4),
(9, 2),
(9, 4),
(10, 7),
(11, 7),
(12, 7),
(13, 7),
(14, 1),
(14, 4),
(15, 1),
(15, 4),
(16, 1),
(16, 4),
(17, 1),
(17, 4),
(18, 1),
(18, 4),
(19, 1),
(19, 4),
(20, 1),
(20, 4),
(21, 1),
(21, 3),
(25, 1),
(25, 3),
(3, 2),
(3, 3),
(5, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(50) NOT NULL,
  `nombre` varchar(30) NOT NULL,
  `apellidos` varchar(30) NOT NULL,
  `direccion` varchar(150) NOT NULL,
  `fechaRegistro` varchar(10) NOT NULL,
  `esAdmin` varchar(2) DEFAULT 'NO',
  `puedeRealizarInformes` varchar(2) DEFAULT 'NO'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `email`, `password`, `nombre`, `apellidos`, `direccion`, `fechaRegistro`, `esAdmin`, `puedeRealizarInformes`) VALUES
(1, 'admin1@admin.es', 'e10adc3949ba59abbe56e057f20f883e', 'Diego', 'Leiva', 'corona verde', '1990/09/16', 'SI', 'SI'),
(2, 'admin2@admin.es', 'e10adc3949ba59abbe56e057f20f883e', 'Daniel', 'Hernandez', 'corona verde', '1990/09/16', 'SI', 'NO'),
(3, 'admin3@admin.es', 'e10adc3949ba59abbe56e057f20f883e', 'Oscar', 'Collado', 'corona verde', '1990/09/16', 'SI', 'NO'),
(4, 'user1@user.es', 'e10adc3949ba59abbe56e057f20f883e', 'Christian', 'Briones', 'corona verde', '1990/09/16', 'NO', 'NO'),
(5, 'user2@user.es', 'e10adc3949ba59abbe56e057f20f883e', 'Pablo', 'Illescas', 'corona verde', '1990/09/16', 'NO', 'NO'),
(6, 'user3@user.es', 'e10adc3949ba59abbe56e057f20f883e', 'Daniel', 'Alvaro', 'corona verde', '1990/09/16', 'NO', 'NO'),
(7, 'user4@user.es', 'e10adc3949ba59abbe56e057f20f883e', 'Adrian', 'Compi', 'corona verde', '1990/09/16', 'NO', 'NO'),
(8, 'user5@user.es', 'e10adc3949ba59abbe56e057f20f883e', 'Maria', 'Pinar', 'corona verde', '1990/09/16', 'NO', 'NO'),
(9, 'user6@user.es', 'e10adc3949ba59abbe56e057f20f883e', 'Alvaro', 'Aparicio8', 'corona verde', '1990/09/16', 'NO', 'NO'),
(10, 'registro1@gmail.com', '651eac6556fe430f05d165d0f9347fbd', 'registro', 'uno perez', 'calle de la felicidad 1', '2021-02-23', 'NO', 'NO'),
(11, 'registro2@gmail.com', '651eac6556fe430f05d165d0f9347fbd', 'registro dos', 'perez', 'calle de la amargura 2', '2021-02-23', 'NO', 'NO'),
(14, 'registro4@gmail.com', '651eac6556fe430f05d165d0f9347fbd', 'registro cuatro', 'perez', 'calle de la amargura 4', '2021-02-23', 'NO', 'NO'),
(15, 'registro5@gmail.com', '651eac6556fe430f05d165d0f9347fbd', 'registro cinco', 'perez', 'calle de la amargura 5', '2021-02-23', 'NO', 'NO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta`
--

CREATE TABLE `venta` (
  `id` varchar(15) NOT NULL,
  `email` varchar(30) NOT NULL,
  `precioTotal` decimal(7,2) NOT NULL,
  `direccionEnvio` varchar(150) NOT NULL,
  `fecha` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `venta`
--

INSERT INTO `venta` (`id`, `email`, `precioTotal`, `direccionEnvio`, `fecha`) VALUES
('1614110262-10', 'registro1@gmail.com', '999.99', 'calle de la felicidad 1', '2021/02/23'),
('1614110324-4', 'user1@user.es', '1200.00', 'corona verde', '2021/02/23'),
('1614110332-4', 'user1@user.es', '199.99', 'corona verde', '2021/02/23'),
('1614110365-1', 'admin1@admin.es', '1229.99', 'corona verde', '2021/02/23'),
('1614110610-2', 'admin2@admin.es', '79.96', 'corona verde', '2021/02/23'),
('1614110701-5', 'user2@user.es', '2099.94', 'corona verde', '2021/02/23'),
('1614113728-1', 'admin1@admin.es', '1129.98', 'corona verde', '2021/02/23'),
('1614113860-10', 'registro1@gmail.com', '263.95', 'calle de la felicidad 1', '2021/02/23'),
('1614113881-10', 'registro1@gmail.com', '783.51', 'calle de la felicidad 1', '2021/02/23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `venta_articulo`
--

CREATE TABLE `venta_articulo` (
  `xVenta` varchar(15) NOT NULL,
  `xProducto` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio` decimal(7,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `venta_articulo`
--

INSERT INTO `venta_articulo` (`xVenta`, `xProducto`, `cantidad`, `precio`) VALUES
('1614110262-10', 1, 1, '199.99'),
('1614110262-10', 3, 2, '400.00'),
('1614110324-4', 3, 3, '400.00'),
('1614110332-4', 1, 1, '199.99'),
('1614110365-1', 2, 1, '349.99'),
('1614110365-1', 4, 4, '220.00'),
('1614110610-2', 6, 4, '19.99'),
('1614110701-5', 2, 6, '349.99'),
('1614113728-1', 3, 1, '400.00'),
('1614113728-1', 6, 1, '19.99'),
('1614113728-1', 7, 1, '19.99'),
('1614113728-1', 16, 1, '690.00'),
('1614113860-10', 1, 1, '199.99'),
('1614113860-10', 11, 4, '15.99'),
('1614113881-10', 11, 49, '15.99');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `alta`
--
ALTER TABLE `alta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `baja`
--
ALTER TABLE `baja`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `carrito_usuario`
--
ALTER TABLE `carrito_usuario`
  ADD PRIMARY KEY (`xUsuario`,`xProducto`),
  ADD KEY `xProducto` (`xProducto`);

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre` (`nombre`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indices de la tabla `venta`
--
ALTER TABLE `venta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `alta`
--
ALTER TABLE `alta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `baja`
--
ALTER TABLE `baja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `carrito_usuario`
--
ALTER TABLE `carrito_usuario`
  ADD CONSTRAINT `carrito_usuario_ibfk_1` FOREIGN KEY (`xUsuario`) REFERENCES `usuario` (`id`),
  ADD CONSTRAINT `carrito_usuario_ibfk_2` FOREIGN KEY (`xProducto`) REFERENCES `producto` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
