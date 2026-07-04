USE icccom_icc;

CREATE TABLE IF NOT EXISTS `plataforma` (
  `id_pla` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pass` varchar(50) NOT NULL,
  `rol` int(11) NOT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_pla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `plataforma` (`name`, `last_name`, `user`, `pass`, `rol`, `estatus`) 
VALUES ('Administrador', 'Local', 'admin', 'admin', 1, 1)
ON DUPLICATE KEY UPDATE `pass`='admin';

CREATE TABLE IF NOT EXISTS `cursos` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_curso` varchar(150) NOT NULL,
  `descripcion` text,
  `horas_academicas` int(11) NOT NULL DEFAULT 20,
  `fecha_emision` date NOT NULL,
  `foto` varchar(255) DEFAULT 'default.png',
  `categoria` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `usuario` (
  `iduser` int(11) NOT NULL AUTO_INCREMENT,
  `id_pla` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `dni` varchar(20) DEFAULT NULL,
  `n_operacion` varchar(50) DEFAULT NULL,
  `m_pagado` decimal(10,2) DEFAULT NULL,
  `encargado` varchar(100) DEFAULT NULL,
  `banco` varchar(50) DEFAULT NULL,
  `fecha_deposito` date DEFAULT NULL,
  `usuario` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `boucher` varchar(255) DEFAULT NULL,
  `estatus` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`iduser`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `inscrito` (
  `id_inscrito` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `plc` int(1) DEFAULT 1,
  `e_basica` int(1) DEFAULT 1,
  `s_p_tierra` int(1) DEFAULT 1,
  `m_electrico` int(1) DEFAULT 1,
  `banco_c` int(1) DEFAULT 1,
  `a_facturas_t_e` int(1) DEFAULT 1,
  `g_seguridad_t` int(1) DEFAULT 1,
  `r_mercado_e` int(1) DEFAULT 1,
  `a_redes` int(1) DEFAULT 1,
  `riesgo_e` int(1) DEFAULT 1,
  `t_altura` int(1) DEFAULT 1,
  `e_motores_e` int(1) DEFAULT 1,
  `s_p_t_antiguo` int(1) DEFAULT 1,
  `costo_p` int(1) DEFAULT 1,
  `idtermo` int(1) DEFAULT 1,
  `id_residencial` int(1) DEFAULT 1,
  `id_medicion` int(1) DEFAULT 1,
  `m_t_electricos` int(1) DEFAULT 1,
  `redes_electricas` int(1) DEFAULT 1,
  `t_caliente` int(1) DEFAULT 1,
  PRIMARY KEY (`id_inscrito`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `usuario_cursos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
