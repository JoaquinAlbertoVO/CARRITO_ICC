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
    const OFERTAS = [
        'sistema-ia' => [
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
