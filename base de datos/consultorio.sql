-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-01-2016 a las 16:57:42
-- Versión del servidor: 5.6.26
-- Versión de PHP: 5.5.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `consultorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `caja_tmp`
--

CREATE TABLE IF NOT EXISTS `caja_tmp` (
  `id` int(11) NOT NULL,
  `paciente` varchar(255) NOT NULL,
  `ref` varchar(255) NOT NULL,
  `cant` varchar(255) NOT NULL,
  `usu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cajero`
--

CREATE TABLE IF NOT EXISTS `cajero` (
  `usu` varchar(255) NOT NULL,
  `consultorio` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cajero`
--

INSERT INTO `cajero` (`usu`, `consultorio`) VALUES
('11223344', '1'),
('112233447', '1'),
('123456789', '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas_medicas`
--

CREATE TABLE IF NOT EXISTS `citas_medicas` (
  `id` int(11) NOT NULL,
  `id_paciente` varchar(255) NOT NULL,
  `id_medico` varchar(15) NOT NULL,
  `consultorio` varchar(255) NOT NULL,
  `fechai` date NOT NULL,
  `observaciones` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `horario` varchar(25) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultas_medicas`
--

CREATE TABLE IF NOT EXISTS `consultas_medicas` (
  `id` int(11) NOT NULL,
  `id_paciente` varchar(15) NOT NULL,
  `id_medico` varchar(15) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `sintomas` text NOT NULL,
  `diagnostico` text NOT NULL,
  `tratamiento` text NOT NULL,
  `reseta` text NOT NULL,
  `observaciones` text NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `consultorios`
--

CREATE TABLE IF NOT EXISTS `consultorios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `encargado` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `consultorios`
--

INSERT INTO `consultorios` (`id`, `nombre`, `direccion`, `telefono`, `encargado`, `estado`) VALUES
(1, 'Medicina General', 'Sn Salvador, 4° norte barrio Centro', '(789)797-9797', 'Juan Perdomo', 's'),
(2, 'Medicenter', 'San Miguel ', '(678)687-6786', 'Juan Muñoz', 's'),
(3, 'Consultorio de Prueba', 'Prueba', '(839)103-8018', 'Juan Prez', 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

CREATE TABLE IF NOT EXISTS `departamentos` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`id`, `nombre`, `estado`) VALUES
(1, 'Usulutan', 's'),
(2, 'San Miguel', 's'),
(3, 'La Union', 's'),
(4, 'Morazan', 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detalle`
--

CREATE TABLE IF NOT EXISTS `detalle` (
  `id` int(255) NOT NULL,
  `factura` varchar(255) NOT NULL,
  `codigo` varchar(255) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `importe` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `consultorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `empresa`
--

CREATE TABLE IF NOT EXISTS `empresa` (
  `id` int(255) NOT NULL,
  `empresa` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `nit` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `pais` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `ciudad` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fax` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `web` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `moneda` varchar(22) COLLATE utf8_spanish_ci NOT NULL,
  `anno` varchar(255) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `empresa`
--

INSERT INTO `empresa` (`id`, `empresa`, `nit`, `direccion`, `pais`, `ciudad`, `tel`, `fax`, `web`, `correo`, `fecha`, `moneda`, `anno`) VALUES
(1, 'CONSULTORIO MEDICO ORIENTAL', '123111-4565-455', '2a. Calle ote. y 4a. Avenida sur, costado Sur del paruque San Miguelito, Usulutan', 'EL SALVADOR', 'SAN MIGUEL', '6657-5743', '2663-4422', 'www.guanaquitosoft.com', 'guanaquitosoft@gmail.com', '2015-02-16', '$', '2014');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `id` int(11) NOT NULL,
  `factura` varchar(255) NOT NULL,
  `valor` varchar(255) NOT NULL,
  `fecha` date NOT NULL,
  `estado` varchar(255) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `usu` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

CREATE TABLE IF NOT EXISTS `municipios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `departamento` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pacientes`
--

CREATE TABLE IF NOT EXISTS `pacientes` (
  `id` int(11) NOT NULL,
  `documento` varchar(25) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `direccion` varchar(255) NOT NULL,
  `departamento` varchar(255) NOT NULL,
  `municipio` varchar(255) NOT NULL,
  `telefono` varchar(255) NOT NULL,
  `edad` varchar(255) NOT NULL,
  `sexo` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `estado` varchar(250) NOT NULL,
  `sangre` varchar(255) NOT NULL,
  `vih` varchar(255) NOT NULL,
  `peso` varchar(255) NOT NULL,
  `talla` varchar(255) NOT NULL,
  `alergia` text NOT NULL,
  `medicamento` text NOT NULL,
  `enfermedad` text NOT NULL,
  `consultorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos`
--

CREATE TABLE IF NOT EXISTS `permisos` (
  `id` int(11) NOT NULL,
  `permiso` varchar(255) NOT NULL,
  `usu` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisos`
--

INSERT INTO `permisos` (`id`, `permiso`, `usu`, `estado`) VALUES
(1, 'Admin', '11223344', 's'),
(40, '1', '112233447', 's'),
(41, '2', '112233447', 's'),
(42, '3', '112233447', 's'),
(43, '4', '112233447', 'n'),
(44, '5', '112233447', 'n'),
(45, '1', '123456789', 's'),
(46, '2', '123456789', 's'),
(47, '3', '123456789', 's'),
(48, '4', '123456789', 's'),
(49, '5', '123456789', 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `permisos_tmp`
--

CREATE TABLE IF NOT EXISTS `permisos_tmp` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `permisos_tmp`
--

INSERT INTO `permisos_tmp` (`id`, `nombre`) VALUES
(1, 'Crear Pacientes'),
(2, 'Crear Citas'),
(3, 'Crear consultas'),
(4, 'Crear Usuarios'),
(5, 'Caja');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE IF NOT EXISTS `persona` (
  `id` int(11) NOT NULL,
  `doc` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `nom` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `sexo` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `dir` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `cargo` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `estado` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `doc`, `nom`, `tel`, `sexo`, `dir`, `cargo`, `estado`) VALUES
(1, '11223344', 'admin', '83723829', 'm', 'col. las pruebas', '', 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `resumen`
--

CREATE TABLE IF NOT EXISTS `resumen` (
  `id` int(11) NOT NULL,
  `paciente` varchar(255) NOT NULL,
  `concepto` varchar(250) NOT NULL,
  `factura` varchar(255) NOT NULL,
  `clase` varchar(250) NOT NULL,
  `valor` varchar(250) NOT NULL,
  `tipo` varchar(250) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `status` varchar(255) NOT NULL,
  `usu` varchar(250) NOT NULL,
  `consultorio` int(11) NOT NULL,
  `estado` varchar(250) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `resumen`
--

INSERT INTO `resumen` (`id`, `paciente`, `concepto`, `factura`, `clase`, `valor`, `tipo`, `fecha`, `hora`, `status`, `usu`, `consultorio`, `estado`) VALUES
(1, '29', 'Operacion al Contado', '100000001', 'CONSULTA', '15', 'CONSULTA', '2015-06-06', '20:59:42', 'CANCELADO', '11223344', 1, 's'),
(2, '31', 'Operacion al Contado', '100000002', 'CONSULTA', '15', 'CONSULTA', '2015-06-06', '21:00:00', 'CANCELADO', '11223344', 1, 's'),
(3, '31', 'Operacion al Contado', '100000003', 'CONSULTA', '15', 'CONSULTA', '2015-06-06', '21:02:21', 'CANCELADO', '11223344', 1, 's'),
(4, '29', 'Operacion al Contado', '100000004', 'CONSULTA', '15', 'CONSULTA', '2015-06-06', '21:09:40', 'CANCELADO', '11223344', 1, 's'),
(5, '27', 'Operacion al Contado', '100000005', 'CONSULTA', '15', 'CONSULTA', '2015-06-06', '22:54:52', 'CANCELADO', '11223344', 1, 's'),
(6, '33', 'Operacion al Contado', '100000006', 'CONSULTA', '15', 'CONSULTA', '2015-06-06', '23:13:34', 'CANCELADO', '112233445', 2, 's'),
(7, '34', 'Operacion al Contado', '100000007', 'CONSULTA', '15', 'CONSULTA', '2015-06-06', '23:13:48', 'CANCELADO', '112233445', 2, 's'),
(8, '33', 'Operacion al Contado', '100000008', 'CONSULTA', '15', 'CONSULTA', '2015-06-07', '11:30:33', 'CANCELADO', '112233445', 2, 's'),
(9, '34', 'Operacion al Contado', '100000009', 'CONSULTA', '15', 'CONSULTA', '2015-06-07', '11:32:33', 'CANCELADO', '112233445', 2, 's'),
(10, '33', 'Operacion al Contado', '100000010', 'CONSULTA', '15', 'CONSULTA', '2015-06-07', '19:20:05', 'CANCELADO', '112233445', 2, 's'),
(11, '35', 'Operacion al Contado', '100000011', 'CONSULTA', '15', 'CONSULTA', '2015-06-07', '20:28:38', 'CANCELADO', '112233445', 2, 's'),
(12, '23', 'Operacion al Contado', '100000012', 'CONSULTA', '15', 'CONSULTA', '2015-06-07', '20:31:21', 'CANCELADO', '11223344', 1, 's'),
(13, '24', 'Operacion al Contado', '100000013', 'CONSULTA', '15', 'CONSULTA', '2015-06-07', '20:32:09', 'CANCELADO', '11223344', 1, 's'),
(14, '26', 'Operacion al Contado', '100000014', 'CONSULTA', '15', 'CONSULTA', '2015-06-07', '20:32:37', 'CANCELADO', '11223344', 1, 's'),
(15, '29', 'Operacion al Contado', '100000015', 'CONSULTA', '15', 'CONSULTA', '2015-06-07', '20:41:24', 'CANCELADO', '11223344', 1, 's'),
(16, '27', 'Operacion al Contado', '100000016', 'CONSULTA', '15', 'CONSULTA', '2015-06-08', '09:07:44', 'CANCELADO', '11223344', 1, 's'),
(17, '29', 'Operacion al Contado', '100000017', 'CONSULTA', '15', 'CONSULTA', '2015-06-08', '09:09:39', 'CANCELADO', '11223344', 1, 's'),
(18, '31', 'Operacion al Contado', '100000018', 'CONSULTA', '15', 'CONSULTA', '2015-06-08', '09:11:10', 'CANCELADO', '11223344', 1, 's'),
(19, '25', 'Operacion al Contado', '100000019', 'CONSULTA', '15', 'CONSULTA', '2015-06-08', '09:20:33', 'CANCELADO', '11223344', 1, 's'),
(20, '28', 'Operacion al Contado', '100000020', 'CONSULTA', '15', 'CONSULTA', '2015-06-08', '09:21:27', 'CANCELADO', '11223344', 1, 's'),
(21, '27', 'Operacion al Contado', '100000021', 'CONSULTA', '15', 'CONSULTA', '2015-06-08', '11:12:48', 'CANCELADO', '11223344', 1, 's'),
(22, '33', 'Operacion al Contado', '100000022', 'CONSULTA', '15', 'CONSULTA', '2015-06-08', '13:00:30', 'CANCELADO', '112233445', 2, 's'),
(23, '31', 'Operacion al Contado', '100000023', 'CONSULTA', '15', 'CONSULTA', '2015-06-09', '17:03:44', 'CANCELADO', '11223344', 1, 's');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_permisos`
--

CREATE TABLE IF NOT EXISTS `tipo_permisos` (
  `id` int(11) NOT NULL,
  `permiso` varchar(255) NOT NULL,
  `tipo` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_permisos`
--

INSERT INTO `tipo_permisos` (`id`, `permiso`, `tipo`, `estado`) VALUES
(1, '1', '1', 's'),
(2, '2', '1', 's'),
(3, '3', '1', 's'),
(4, '4', '1', 'n'),
(5, '5', '1', 'n');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE IF NOT EXISTS `tipo_usuario` (
  `id` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `nombre`) VALUES
(1, 'Medico'),
(2, 'Secretaria');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `username`
--

CREATE TABLE IF NOT EXISTS `username` (
  `id` int(11) NOT NULL,
  `usu` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `con` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `cargo` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `correo` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `fecha` date NOT NULL,
  `tipo` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Volcado de datos para la tabla `username`
--

INSERT INTO `username` (`id`, `usu`, `con`, `cargo`, `correo`, `fecha`, `tipo`) VALUES
(21, '11223344', 'admin', '', 'admin@hotmail.com', '1986-12-01', 'Admin'),
(47, '112233447', '112233447', '', 'notiene@hotmail.com', '2015-06-12', '1'),
(51, '123456789', '123456789', '', 'prueba@hotmail.com', '2015-06-12', 'Admin');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `caja_tmp`
--
ALTER TABLE `caja_tmp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `consultas_medicas`
--
ALTER TABLE `consultas_medicas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indices de la tabla `consultorios`
--
ALTER TABLE `consultorios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `detalle`
--
ALTER TABLE `detalle`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `factura`
--
ALTER TABLE `factura`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `municipios`
--
ALTER TABLE `municipios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos`
--
ALTER TABLE `permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `permisos_tmp`
--
ALTER TABLE `permisos_tmp`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `resumen`
--
ALTER TABLE `resumen`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_permisos`
--
ALTER TABLE `tipo_permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `username`
--
ALTER TABLE `username`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `caja_tmp`
--
ALTER TABLE `caja_tmp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `citas_medicas`
--
ALTER TABLE `citas_medicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `consultas_medicas`
--
ALTER TABLE `consultas_medicas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `consultorios`
--
ALTER TABLE `consultorios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT de la tabla `departamentos`
--
ALTER TABLE `departamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT de la tabla `detalle`
--
ALTER TABLE `detalle`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `factura`
--
ALTER TABLE `factura`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `municipios`
--
ALTER TABLE `municipios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `pacientes`
--
ALTER TABLE `pacientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT de la tabla `permisos`
--
ALTER TABLE `permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=50;
--
-- AUTO_INCREMENT de la tabla `permisos_tmp`
--
ALTER TABLE `permisos_tmp`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT de la tabla `resumen`
--
ALTER TABLE `resumen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT de la tabla `tipo_permisos`
--
ALTER TABLE `tipo_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT de la tabla `username`
--
ALTER TABLE `username`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=52;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
