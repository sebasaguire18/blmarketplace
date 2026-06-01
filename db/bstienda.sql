-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 21-05-2026 a las 02:58:03
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
-- Base de datos: `bstienda`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `cat_id` varchar(255) NOT NULL COMMENT 'id unico generado internamente con uuid antes de realizar el registro',
  `cat_nombre` varchar(255) NOT NULL COMMENT 'nombre de la categoria',
  `cat_fecha` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'fecha de publicacion',
  `cat_estado` int(255) NOT NULL DEFAULT 1 COMMENT '1: activo; 0: inactivo;'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`cat_id`, `cat_nombre`, `cat_fecha`, `cat_estado`) VALUES
('69fe9657294e4', 'Vehiculos', '2026-05-12 22:51:32', 1),
('64645990cb3d2', 'Hogar', '2026-05-12 22:51:32', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

CREATE TABLE `favoritos` (
  `fav_id` varchar(255) NOT NULL COMMENT 'id unico generado internamente con uuid antes de realizar el registro',
  `fav_id_post` varchar(255) NOT NULL COMMENT 'id del producto favorito',
  `fav_id_usuario` varchar(255) NOT NULL COMMENT 'id del usuario que selecciono el favorito',
  `fav_fecha` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'fecha de la creacion del favorito'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`fav_id`, `fav_id_post`, `fav_id_usuario`, `fav_fecha`) VALUES
('6a0d14075b42d', '6a07f9f28169f', '62223a6e31e99', '2026-05-19 20:53:11'),
('6a0d253468d2b', '6a07f9073768b', '62223a6e31e99', '2026-05-19 22:06:28');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `posts`
--

CREATE TABLE `posts` (
  `post_id` varchar(255) NOT NULL COMMENT 'id unico generado internamente con uuid antes de realizar el registro',
  `post_titulo` varchar(255) NOT NULL COMMENT 'Titulo del post',
  `post_descripcion` varchar(255) NOT NULL COMMENT 'descripcion del post',
  `post_precio` int(255) NOT NULL COMMENT 'precio sin caracteres especiles',
  `post_contacto` int(255) NOT NULL COMMENT 'numero de contacto',
  `post_categoria` varchar(255) NOT NULL COMMENT 'categoria de la publicacion',
  `post_ciudad` varchar(255) NOT NULL COMMENT 'ciudad del post',
  `post_ruta_imagen` varchar(255) NOT NULL COMMENT 'ruta de la imagen data por un uniqid uuid generado internamente antes de guardar el registro',
  `post_ruta_imagen2` varchar(255) DEFAULT NULL COMMENT '	ruta de la imagen data por un uniqid uuid generado internamente antes de guardar el registro',
  `post_ruta_imagen3` varchar(255) DEFAULT NULL COMMENT '	ruta de la imagen data por un uniqid uuid generado internamente antes de guardar el registro',
  `post_id_usuario` varchar(255) NOT NULL COMMENT 'id del usuario que creó el post',
  `post_vistas` int(11) NOT NULL DEFAULT 0,
  `post_fecha` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'fecha de publicacion',
  `post_estado` int(11) NOT NULL DEFAULT 1 COMMENT '1: activo; 0: inactivo; 2: vendido;'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `posts`
--

INSERT INTO `posts` (`post_id`, `post_titulo`, `post_descripcion`, `post_precio`, `post_contacto`, `post_categoria`, `post_ciudad`, `post_ruta_imagen`, `post_ruta_imagen2`, `post_ruta_imagen3`, `post_id_usuario`, `post_vistas`, `post_fecha`, `post_estado`) VALUES
('621bcf3d8f35a', 'diadema auricular', 'jsjsjfdkjflks dsfj sdklf jsdlkds fjsdkl fjsdkf  fsd d fsd fsd lfsldflksdjf sdo fjsdf ', 150000, 2147483647, '64645990cb3d2', 'Armenia Q', '../assets/post/69fe9657294e4-6261fed667f3f-product02.png', NULL, NULL, '62223a6e31e99', 11, '2026-05-08 21:05:11', 1),
('6a03efe7dce55', 'teclado flexible', 'teclado ergonomico, flexible portatil. para llevarlo a cualquier lugar', 35000, 2147483647, '64645990cb3d2', 'Armenia Q', '../assets/post/6a03efe7dc403-6263a7b66a7f6-tecladoFlexible.png', NULL, NULL, '62223a6e31e99', 7, '2026-05-12 22:28:39', 1),
('6a03fb4a6d1f4', 'Computador lenovo series xpro max super sayayin xtz', 'este es un computador ultima generacion xpro max dr xtz con procesador intel igente gatuberante flelixiano 3000', 3500000, 2147483647, '64645990cb3d2', 'Armenia Q', '../assets/post/6a03fb4a6c802-621bcf3d8f35a-product03.png', NULL, NULL, '62223a6e31e99', 4, '2026-05-12 23:17:14', 1),
('6a07f7a522c9d', 'Ipons i12', 'nuevos audifonos', 45000, 2147483647, '64645990cb3d2', 'Pereira R', '../assets/post/6a07f7a521594-62702a8678a97-ipons12.png', NULL, NULL, '62223a6e31e99', 5, '2026-05-15 23:50:45', 1),
('6a07f9073768b', 'Auricular diademas ', 'Auriculares de colores', 55000, 2147483647, '69fe9657294e4', 'Armenia Q', '../assets/post/6a07f907347cd-627027555a5ec-DiademaSony.png', NULL, NULL, '62223a6e31e99', 11, '2026-05-15 23:56:39', 1),
('6a07f9f28169f', 'Bolso molto chic', 'bolsos moltochic', 150000, 323222225, '64645990cb3d2', 'Santa Rosa', '../assets/post/6a07f9f27fb9e-cp-2.jpg', NULL, NULL, '62223a6e31e99', 9, '2026-05-16 00:00:34', 1),
('6a0bde0962237', 'Blusas de colores', 'blusas de colores al por mayor', 90000, 2147483647, '64645990cb3d2', 'Pereira', '../assets/post/6a0bde09606a5-insta-6.jpg', NULL, NULL, '62223a6e31e99', 2, '2026-05-18 22:50:33', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `rol_id` varchar(255) NOT NULL COMMENT 'identificador unico',
  `rol_nombre` varchar(255) NOT NULL COMMENT 'nombre del rol',
  `rol_usuario` varchar(255) NOT NULL COMMENT 'usuario que creo el registro del rol',
  `rol_fecha` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'fecha creacion rol',
  `rol_status` int(50) NOT NULL DEFAULT 1 COMMENT '0:inactivo; 1: Activo	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`rol_id`, `rol_nombre`, `rol_usuario`, `rol_fecha`, `rol_status`) VALUES
('64645990cb1d4', 'Administrador', '62223a6e31e99', '2026-04-29 22:47:46', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `usu_id` varchar(50) NOT NULL COMMENT 'id unico creado internamente',
  `usu_nombre` varchar(255) NOT NULL COMMENT 'nombre del usuario',
  `usu_correo` varchar(255) NOT NULL COMMENT 'correo del usuario para iniciar sesion',
  `usu_contrasena` varchar(255) NOT NULL COMMENT 'contrseña del correo  encriptada para iniciar sesion',
  `usu_rol` varchar(255) NOT NULL COMMENT 'id del rol',
  `usu_fecha_creacion` datetime NOT NULL DEFAULT current_timestamp() COMMENT 'fecha de creacion del registro',
  `usu_estado` int(11) NOT NULL DEFAULT 1 COMMENT '1: activo; 0: inactivo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`usu_id`, `usu_nombre`, `usu_correo`, `usu_contrasena`, `usu_rol`, `usu_fecha_creacion`, `usu_estado`) VALUES
('62223a6e31e99', 'Sebastian Aguirre', 'admin@mail.com', '202cb962ac59075b964b07152d234b70', '64645990cb1d4', '2026-04-29 22:50:58', 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
