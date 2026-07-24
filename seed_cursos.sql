INSERT INTO `cursos` (`nombre_curso`, `descripcion`, `horas_academicas`, `fecha_emision`, `foto`, `categoria`, `estado`, `precio`, `docente`, `lecciones`) VALUES
('Diseño de Subestaciones Eléctricas', 'Aprende todo sobre el diseño y montaje de subestaciones eléctricas de alta y media tensión.', 40, '2024-01-10', 'default.png', 'Especialización', 1, 150.00, 'Ing. Carlos Méndez', 10),
('Mantenimiento de Motores Industriales', 'Curso práctico de mantenimiento preventivo y correctivo para motores eléctricos.', 25, '2024-02-15', 'default.png', 'Técnico', 1, 90.00, 'Ing. Luis Fernández', 6),
('Sistemas de Energías Renovables', 'Implementación de sistemas fotovoltaicos y eólicos para el hogar y la industria.', 30, '2024-03-01', 'default.png', 'Diplomado', 1, 120.00, 'Dra. Ana Gómez', 8);

INSERT INTO `usuario_cursos` (`id_usuario`, `id_curso`) VALUES
(1, 1),
(1, 2),
(1, 3);

INSERT INTO `usuario_certificados` (`id_usuario`, `id_curso`, `archivo_pdf`, `fecha_subida`) VALUES
(1, 1, 'certificado_demo.pdf', '2024-04-10 10:00:00');
