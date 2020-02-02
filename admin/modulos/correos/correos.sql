-- phpMyAdmin SQL Dump
-- version 4.4.3
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 18-10-2017 a las 22:23:30
-- Versión del servidor: 5.6.24
-- Versión de PHP: 5.5.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `theta`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `correos`
--

CREATE TABLE IF NOT EXISTS `correos` (
  `id` int(11) NOT NULL,
  `titulo` varchar(100) DEFAULT NULL,
  `remitente` varchar(100) DEFAULT NULL,
  `asunto` varchar(100) DEFAULT NULL,
  `cuerpo` text
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `correos`
--

INSERT INTO `correos` (`id`, `titulo`, `remitente`, `asunto`, `cuerpo`) VALUES
(1, 'Inscripci&oacute;n', 'MundoTH', 'Su registro en ThetaHealing', '<h1>Bienvenido %userName%</h1>\r\n<p>Te recordamos que te inscribiste al curso</p>\r\n<p><strong>%curso%</strong></p>\r\n<p>Tu n&uacute;mero de estudiante es: %idEstudiante%</p>\r\n<p>Para completar tu registro es necesario realizar tu pago</p>\r\n<p>Para pagar con tarjeta de cr&eacute;dito o d&eacute;bito v&iacute;a PayPal, entra aqu&iacute;:</p>\r\n<p>%botonPago%</p>\r\n<p>o deposita directamente en esta cuenta:</p>\r\n<p>Banco: BBVA Bancomer<br />Cuenta: 4555 1030 0112 7227<br />Nombre: Daniela C. Valdatti A.</p>\r\n<p>Una vez realizado tu pago es necesario reportarlo a: <a href="mailto:contacto@mundoth.com">contacto@mundoth.com</a> (no nos hacemos responsables de pagos no reportados).</p>\r\n<p>Recuerda conservar tu recibo original, ya que deber&aacute;s presentarlo en la entrada.</p>\r\n<div class="text-center" style="text-align: center;"><br /><br /><img src="http://efra.biz/desarrollo/-vianna/img/design/logo-mundo.png" /><br /><a href="http://www.mundoth.com/">www.mundoth.com</a><br /><a href="mailto:contacto@mundoth.com">contacto@mundoth.com</a><br />OFICINA: +52 (33) 15896232<br />WHATSAPP: (+521) 3319260529</div>'),
(2, 'Asiento seleccionado', 'MundoTH', 'Asiento seleccionado', '<h1>Apreciable %userName%</h1>\r\n<p>Te recordamos que te incribiste al curso</p>\r\n<p><strong>%curso%<br /></strong></p>\r\n<p>N&uacute;mero de estudiante es: %idEstudiante%</p>\r\n<p><strong>Asiento: %asiento%</strong></p>\r\n<p>Recuerda conservar tu recibo de pago original, ya que deber&aacute;s presentarlo en la entrada.</p>\r\n<p style="text-align: center;"><br /><img src="http://efra.biz/desarrollo/-vianna/img/design/logo-mundo.png" /><br /><a href="http://www.mundoth.com/">www.mundoth.com</a><br /><a href="mailto:contacto@mundoth.com">contacto@mundoth.com</a><br />OFICINA: +52 (33) 15896232<br />WHATSAPP: (+521) 3319260529</p>'),
(3, 'Notificaci&oacute;n desde admin', 'MundoTH', 'Pago confirmado y asiento asignado', '<h1>Bienvenido %userName%</h1>\r\n<p>Su pago ha sido registrado.</p>\r\n<p>Recuerde que el d&iacute;a del evento deber&aacute; presentar su recibo de pago original o impreso para ingresar al curso.<br /> Si lo hizo via paypal, el propietario de la tarjeta de cr&eacute;dito deber&aacute; imprimir el pago y escribir con tinta "Reconozco el presente pago" acompa&ntilde;ado de su firma y presentar identificaci&oacute;n.</p>\r\n<p class="text-sm">Los datos de su registro son:</p>\r\n<p><strong>%curso%</strong></p>\r\n<p><strong>Asiento: %asiento%</strong></p>\r\n<p><strong>N&uacute;mero de estudiante: %idEstudiante%</strong></p>\r\n<p style="text-align: center;"><strong><br /><img src="http://efra.biz/desarrollo/-vianna/img/design/logo-mundo.png" /><br /><a href="http://www.mundoth.com/">www.mundoth.com</a><br /><a href="mailto:contacto@mundoth.com">contacto@mundoth.com</a><br />OFICINA: +52 (33) 15896232<br />WHATSAPP: (+521) 3319260529</strong></p>');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `correos`
--
ALTER TABLE `correos`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `correos`
--
ALTER TABLE `correos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


INSERT INTO `traduccion` (`variable`, `en`, `ja`, `ru`, `pt`, `it`, `es`) VALUES ('chino', 'chino', 'chino', 'chino', 'chino', 'chino', 'chino');