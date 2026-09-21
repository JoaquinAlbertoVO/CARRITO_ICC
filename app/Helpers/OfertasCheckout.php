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
            // Titulo visible (la parte en amarillo va aparte). El nombre real del curso sigue
            // siendo el de la URL (?curso=), que es el que usan el pago y la matricula.
            'titulo' => ['Especializacion en Electricidad Industrial', 'más IA'],
            'duracion' => '30 horas académicas',
            'quitar_beneficios' => ['Acceso al aula virtual por tiempo limitado'],
            // 'etiqueta corta' => 'nombre completo del tema' (la etiqueta se ve; el nombre completo
            // queda como tooltip). Las etiquetas quitan lo que el titulo de la seccion ya dice.
            'temas' => [
                'Bases y memoria del proyecto' => [
                    'Memoria descriptiva' => 'Memoria descriptiva del proyecto eléctrico',
                    'Bases y criterios de diseño' => 'Bases y criterios de diseño eléctrico',
                    'Sistema de utilización' => 'Descripción del sistema de utilización',
                ],
                'Cálculos eléctricos' => [
                    'Máxima demanda y cuadro de cargas' => 'Cálculo de máxima demanda y cuadro de cargas',
                    'Caída de tensión' => 'Cálculo de caída de tensión',
                    'Conductores' => 'Selección y cálculo de conductores',
                    'Protecciones' => 'Cálculo y selección de protecciones',
                    'Puesta a tierra' => 'Cálculo del sistema de puesta a tierra',
                    'Luminotécnico (lux)' => 'Cálculo luminotécnico (nivel de lux)',
                    'Tableros (general y distribución)' => 'Distribución de tableros (general y de distribución)',
                    'Canalizaciones (tuberías/bandejas)' => 'Cálculo de canalizaciones (tuberías/bandejas)',
                ],
                'Planos y esquemas' => [
                    'Diagrama unifilar' => 'Estructura del diagrama unifilar',
                    'Cuadro de cargas' => 'Cuadro de cargas (tabla lista)',
                    'Leyenda y simbología' => 'Leyenda y simbología del plano',
                ],
                'Especificaciones y presupuesto' => [
                    'Especificaciones técnicas' => 'Especificaciones técnicas de materiales y equipos',
                    'Metrado de materiales' => 'Metrado de materiales eléctricos',
                    'Precios unitarios y presupuesto' => 'Análisis de precios unitarios y presupuesto',
                    'Cronograma de ejecución' => 'Cronograma de ejecución',
                ],
                'Cierre y conformidad' => [
                    'Pruebas y puesta en servicio' => 'Protocolo de pruebas y puesta en servicio',
                    'Panel fotográfico e informe de conformidad' => 'Panel fotográfico e informe de conformidad',
                    'Requisitos y solicitud del trámite' => 'Requisitos y solicitud del trámite',
                    'Índice y checklist del expediente' => 'Índice y checklist del expediente eléctrico',
                ],
                'Revisión de documentos' => [
                    'Revisión de documentos del proyecto' => 'Revisión de documentos del proyecto',
                ],
            ],
            // Acordeon propio, debajo de "Temas Principales"
            'extra' => [
                'titulo' => 'Lo que aprenderemos con la IA',
                'intro' => 'Además del temario, te llevas un asistente de IA listo para usar: el Prompt Maestro, que te acompaña en cada etapa de tu proyecto eléctrico.',
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
