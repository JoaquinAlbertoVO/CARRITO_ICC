CREATE TABLE IF NOT EXISTS `cursos` (
  `id_curso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_curso` varchar(150) NOT NULL,
  `descripcion` text,
  `horas_academicas` int(11) NOT NULL DEFAULT 20,
  `fecha_emision` date NOT NULL,
  `foto` varchar(255) DEFAULT 'default.png',
  `categoria` varchar(50) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT 1,
  `precio` decimal(10,2) DEFAULT '89.90',
  `docente` varchar(150) DEFAULT 'Docente',
  `docente_foto` varchar(255) DEFAULT '50x50',
  `lecciones` int(11) DEFAULT 1,
  `requisitos` text,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `curso_videos` (
  `id_video`     int(11) NOT NULL AUTO_INCREMENT,
  `id_curso`     int(11) NOT NULL,
  `modulo`       varchar(100) DEFAULT 'Módulo 1',
  `titulo`       varchar(255) NOT NULL,
  `url_video`    varchar(500) NOT NULL,
  `duracion`     varchar(10) DEFAULT '0:00',
  `descripcion`  text DEFAULT NULL,
  `orden`        int(11) NOT NULL DEFAULT 1,
  `estado`       int(11) NOT NULL DEFAULT 1,
  `fecha_creado` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_video`),
  KEY `idx_id_curso` (`id_curso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
