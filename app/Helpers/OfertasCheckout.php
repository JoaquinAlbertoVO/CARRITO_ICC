<?php
namespace App\Helpers;

/**
 * Ofertas del checkout con contenido propio (?oferta=clave en la URL).
 *
 * Sirven para armar links promocionales cuyo "Temas Principales" es distinto al que
 * tiene el curso en la tabla `cursos`, sin tocar la BD ni la pagina publica del curso:
 * solo cambia lo que ve quien entra con ese link.
 */
class OfertasCheckout {
    /**
     * Ofertas de Hotmart de prueba (?hm=clave): fuerzan el recuadro de Hotmart con ese link
     * para probar un pago real de punta a punta dentro del iframe con muy poca plata.
     * Borrar la oferta en Hotmart (y esta fila) cuando termine la prueba: quien tenga el
     * link podria comprar el curso a ese precio.
     */
    const HOTMART_PRUEBAS = [
        's4' => 'https://pay.hotmart.com/G107652272C?off=m34xui0w', // Especializacion, S/ 4
    ];

    const OFERTAS = [
        'sistema-ia' => [
            // Ofertas de Hotmart del mismo producto ("Especializacion en Electricidad Industrial
            // con IA") segun la moneda del link: PEN = S/ 69.90, USD = US$ 19.90 exacto. Solo los
            // visitantes de fuera de Peru ven Hotmart (pestaña "Otros metodos", junto a PayPal
            // directo); en Peru se sigue viendo Yape/Plin + PayPal.
            // El webhook sigue matriculando por el nombre del producto.
            'hotmart' => [
                'PEN' => 'https://pay.hotmart.com/G107652272C?off=ius4rna9',
                'USD' => 'https://pay.hotmart.com/G107652272C?off=ndvqfw67',
            ],
            // ---- Pagina de checkout v2 (?diseno=2) ----
            // Nombre real del curso en la BD (lo usan el pago y la matricula).
            'curso' => 'Especializacion en Electricidad Industrial',
            'horas' => 30,
            'inicio' => '2026-10-20',
            'video' => '632hOVAUEhE', // video promocional actual del curso (YouTube): "Electricidad Industrial con IA"
            // Texto de gancho armado a partir del temario: que lo revise el jefe.
            'subtitulo' => 'Conviertete en un especialista en instalaciones eléctricas de principio a fin, con IA como asistente: cálculos, planos, especificaciones, presupuesto y expediente del proyecto.',
            'docente' => [
                'nombre' => 'Ricardo Cardenas',
                'cargo' => 'Docente del curso', // pendiente: una linea de credenciales reales
                'foto' => 'assets/images/docentes/ricardo-cardenas.jpg',
            ],
            // Clases en vivo por Zoom: todas de 7 a 9 p. m. (hora de Peru/Colombia/Ecuador/Panama); si queda vacia no se muestra.
            'hora' => '7:00 p. m. a 9:00 p. m.',
            'hora_corta' => '7:00 a 9:00 p. m.', // version corta para las fichas del calendario
            'sesiones' => ['2026-10-20', '2026-10-22', '2026-10-27', '2026-10-29', '2026-11-03', '2026-11-05', '2026-11-11', '2026-11-13', '2026-11-18'],
            // Precio por etapa (fechas en hora de Lima; 'hasta' inclusive). El precio REGULAR de
            // referencia es el de la ultima etapa, que es el que de verdad se cobra despues.
            // Los USD de las etapas 1 y 3 son propuestos (misma razon ~3.5 que 69.90 -> 19.90).
            // 'hotmart' = oferta de Hotmart con ese mismo precio; sin oferta no se muestra Hotmart.
            'etapas' => [
                ['nombre' => 'Preventa 1', 'hasta' => '2026-09-30', 'pen' => 39.90, 'usd' => 11.90, 'hotmart' => []],
                ['nombre' => 'Preventa 2', 'hasta' => '2026-10-15', 'pen' => 69.90, 'usd' => 19.90, 'hotmart' => [
                    'PEN' => 'https://pay.hotmart.com/G107652272C?off=ius4rna9',
                    'USD' => 'https://pay.hotmart.com/G107652272C?off=ndvqfw67',
                ]],
                ['nombre' => 'Precio regular', 'hasta' => null, 'pen' => 150.00, 'usd' => 42.90, 'hotmart' => []],
            ],
            // Titulo visible (la parte en amarillo va aparte). El nombre real del curso sigue
            // siendo el de la URL (?curso=), que es el que usan el pago y la matricula.
            'titulo' => ['Especializacion en Electricidad Industrial', 'más IA'],
            'duracion' => '30 horas académicas',
            'quitar_beneficios' => ['Acceso al aula virtual por tiempo limitado'],
            // Archivos de assets/images/testimonios/ que esta oferta no muestra (el collage grande ya no va).
            'testimonios_ocultos' => ['01-alumnos-dicen.jpg'],
            // Capturas de chat de alumnos (recortadas al encabezado y al mensaje), en este orden.
            // El 'alt' repite el mensaje porque el texto va dentro de la imagen.
            'chats' => [
                ['archivo' => 'assets/images/testimonios-chat/chat-rk.webp', 'alt' => 'Mensaje de un alumno: "Buen curso, aprendí bastante sobre instalaciones, seguridad y el uso correcto de los equipos. Espero poder participar en otro."'],
                ['archivo' => 'assets/images/testimonios-chat/chat-jh.webp', 'alt' => 'Mensaje de un alumno: "Me gustó bastante la capacitación de electricidad industrial. Aprendí cosas que no conocía y ahora entiendo mejor cómo funcionan los circuitos."'],
                ['archivo' => 'assets/images/testimonios-chat/chat-ed.webp', 'alt' => 'Mensaje de un alumno: "Gracias por la capacitación. Estuvo muy interesante y bien organizada. Me gustaría llevar otro curso de mantenimiento eléctrico. ¡Saludos!"'],
                ['archivo' => 'assets/images/testimonios-chat/chat-el.webp', 'alt' => 'Mensaje de un alumno: "Excelente capacitación, se entendió todo con claridad y hubo buena atención. Muchas gracias por la oportunidad."'],
            ],
            // 'etiqueta corta' => 'nombre completo del tema' (la etiqueta se ve; el nombre completo
            // queda como tooltip). Las etiquetas quitan lo que el titulo de la seccion ya dice.
            // Los 7 modulos reales del curso (flyer "Aprende Electricidad Industrial desde 0").
            // El modulo 7 (IA) ademas tiene su propia seccion grande justo despues de este temario
            // (ver 'extra' mas abajo), con el detalle completo de esa parte del flyer.
            'temas' => [
                'Fundamentos de electricidad industrial' => [
                    'Fundamentos y cálculos' => 'Fundamentos y cálculos',
                ],
                'Lectura de planos eléctricos' => [
                    'Lectura de planos eléctricos' => 'Lectura de planos eléctricos',
                ],
                'Equipos de medición' => [
                    'Revelador de tensión' => 'Revelador de tensión',
                    'Megóhmetro' => 'Megóhmetro',
                    'Pinza amperimétrica' => 'Pinza amperimétrica',
                    'Cámara termográfica' => 'Cámara termográfica',
                    'Analizador de redes' => 'Analizador de redes',
                ],
                'Protecciones eléctricas' => [
                    'Interruptor termomagnético' => 'Interruptor termomagnético',
                    'Diferencial' => 'Diferencial',
                    'Relé térmico' => 'Relé térmico',
                    'Guardamotor' => 'Guardamotor',
                ],
                'Motores trifásicos' => [
                    'Conexionado' => 'Conexionado',
                    'Selección' => 'Selección',
                    'Mantenimiento' => 'Mantenimiento',
                ],
                'Transformadores eléctricos' => [
                    'Conexionado' => 'Conexionado',
                    'Selección' => 'Selección',
                    'Mantenimiento' => 'Mantenimiento',
                ],
                // El modulo 7 (IA) no lleva tarjeta aqui: es innecesario repetirlo, ya que
                // justo debajo esta su propia seccion grande con el detalle completo ('extra').
            ],
            // Acordeon propio, debajo de "Temas Principales": el detalle completo del Modulo 7
            // (flyer "Sistema IA para Proyectos e Instalaciones Electricas" de TodoLab)
            'extra' => [
                'titulo' => 'Módulo 07 · IA para sistemas eléctricos',
                'intro' => 'El módulo 7 te da un asistente de IA listo para usar (funciona con ChatGPT, Gemini o Claude): el Prompt Maestro, que te acompaña en cada etapa de tu proyecto eléctrico.',
                'items' => [
                    'Redactar la memoria descriptiva y las bases de diseño',
                    'Ordenar tus cálculos: máxima demanda, caída de tensión, conductores, protecciones y puesta a tierra',
                    'Estructurar el diagrama unifilar y el cuadro de cargas',
                    'Armar especificaciones, metrado y presupuesto',
                    'Preparar protocolos, informe de conformidad y checklist del expediente',
                    'Revisar los documentos de tu proyecto antes de presentarlos',
                ],
                'bonus' => 'Asesor de Proyectos Eléctricos (Prompt Maestro)',
            ],
        ],
    ];

    /**
     * HTML de "Temas Principales" de la oferta (o null si la clave no existe): cada seccion
     * es un titulo con numero y sus temas en un solo parrafo separado por puntos, para que
     * el temario completo ocupe mucho menos alto que una lista vertical.
     */
    public static function temasHtml($clave) {
        if (!isset(self::OFERTAS[$clave])) {
            return null;
        }
        $badge = 'display:inline-flex; align-items:center; justify-content:center; width:22px; height:22px; '
               . 'border-radius:50%; background:#2563eb; color:#fff; font-size:0.75rem; font-weight:700; flex:none;';
        $html = '';
        $n = 0;
        foreach (self::OFERTAS[$clave]['temas'] as $seccion => $items) {
            $n++;
            $html .= '<div style="margin:0 0 10px;">'
                   . '<div style="display:flex; align-items:center; gap:8px; margin-bottom:2px;">'
                   . '<span style="' . $badge . '">' . $n . '</span>'
                   . '<strong style="color:#0f172a;">' . htmlspecialchars($seccion) . '</strong></div>'
                   . '<p style="margin:0 0 0 30px; line-height:1.55; font-size:0.85rem; color:#334155;">';
            $partes = [];
            foreach ($items as $corto => $completo) {
                $partes[] = '<span title="' . htmlspecialchars($completo) . '">' . htmlspecialchars($corto) . '</span>';
            }
            $html .= implode(' <span style="color:#3b82f6; font-weight:700;">·</span> ', $partes) . '</p></div>';
        }
        return $html;
    }

    /**
     * Ajustes del curso para esta oferta sobre lo que viene de la BD: duracion en el resumen,
     * beneficios que se quitan y titulo con la parte destacada en amarillo (`titulo_html`).
     * Devuelve $curso (array de la tabla cursos) modificado; la BD no se toca.
     */
    public static function ajustarCurso($clave, array $curso) {
        $o = self::OFERTAS[$clave] ?? null;
        if (!$o) {
            return $curso;
        }
        if (!empty($o['duracion']) && !empty($curso['resumen'])) {
            $curso['resumen'] = preg_replace(
                '/(Duración:<\/strong>\s*)[^<]*/u',
                '${1}' . $o['duracion'],
                $curso['resumen']
            );
        }
        if (!empty($o['quitar_beneficios']) && !empty($curso['beneficios'])) {
            foreach ($o['quitar_beneficios'] as $texto) {
                $curso['beneficios'] = preg_replace(
                    '/<li>\s*' . preg_quote($texto, '/') . '\s*<\/li>\s*/iu',
                    '',
                    $curso['beneficios']
                );
            }
        }
        if (!empty($o['titulo'])) {
            $curso['titulo_html'] = htmlspecialchars($o['titulo'][0])
                . ' <span style="color:#facc15;">' . htmlspecialchars($o['titulo'][1]) . '</span>';
        }
        return $curso;
    }

    /**
     * Configuracion completa de una oferta, o null si no existe.
     */
    public static function config($clave) {
        return self::OFERTAS[$clave] ?? null;
    }

    /**
     * Indice de la etapa de precio vigente hoy (hora de Lima). Una etapa sin 'hasta' no vence.
     */
    public static function etapaActual($clave, \DateTime $ahora = null) {
        $tz = new \DateTimeZone('America/Lima');
        $ahora = $ahora ?: new \DateTime('now', $tz);
        $etapas = self::OFERTAS[$clave]['etapas'] ?? [];
        foreach ($etapas as $i => $e) {
            if (empty($e['hasta'])) {
                return $i;
            }
            if ($ahora <= new \DateTime($e['hasta'] . ' 23:59:59', $tz)) {
                return $i;
            }
        }
        return max(0, count($etapas) - 1);
    }

    /**
     * Fecha en espanol: "martes 20 de octubre" (o "20 de octubre" sin dia de la semana).
     */
    public static function fechaLarga($ymd, $conDia = true) {
        $meses = ['enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        $dias = [1 => 'lunes', 2 => 'martes', 3 => 'miércoles', 4 => 'jueves', 5 => 'viernes', 6 => 'sábado', 7 => 'domingo'];
        $t = strtotime($ymd . ' 12:00:00');
        $txt = (int)date('j', $t) . ' de ' . $meses[(int)date('n', $t) - 1];
        return $conDia ? $dias[(int)date('N', $t)] . ' ' . $txt : $txt;
    }

    /**
     * Link de la oferta de Hotmart con el precio promocional en esa moneda, o null si no tiene.
     */
    public static function hotmartLink($clave, $moneda) {
        return self::OFERTAS[$clave]['hotmart'][strtoupper($moneda)] ?? null;
    }

    /**
     * Acordeon extra de la oferta ['titulo' => ..., 'html' => ...], o null si no tiene.
     */
    public static function extraAcordeon($clave) {
        $e = self::OFERTAS[$clave]['extra'] ?? null;
        if (!$e) {
            return null;
        }
        $html = '<p style="line-height:1.5; margin-bottom:10px;">' . htmlspecialchars($e['intro']) . '</p>'
              . '<ul style="list-style:none; padding:0;">';
        foreach ($e['items'] as $item) {
            $html .= '<li>' . htmlspecialchars($item) . '</li>';
        }
        $html .= '</ul>'
               . '<div style="background:#fefce8; border:1px solid #fde68a; border-radius:8px; padding:10px 12px; font-size:0.85rem; color:#713f12;">'
               . '<strong>🎁 Bonus incluido:</strong> ' . htmlspecialchars($e['bonus']) . '</div>';
        return ['titulo' => $e['titulo'], 'html' => $html];
    }
}
