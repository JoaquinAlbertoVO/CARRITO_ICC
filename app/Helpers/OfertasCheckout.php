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
            'temas' => [
                'Bases y memoria del proyecto' => [
                    'Memoria descriptiva del proyecto eléctrico',
                    'Bases y criterios de diseño eléctrico',
                    'Descripción del sistema de utilización',
                ],
                'Cálculos eléctricos' => [
                    'Cálculo de máxima demanda y cuadro de cargas',
                    'Cálculo de caída de tensión',
                    'Selección y cálculo de conductores',
                    'Cálculo y selección de protecciones',
                    'Cálculo del sistema de puesta a tierra',
                    'Cálculo luminotécnico (nivel de lux)',
                    'Distribución de tableros (general y de distribución)',
                    'Cálculo de canalizaciones (tuberías/bandejas)',
                ],
                'Planos y esquemas' => [
                    'Estructura del diagrama unifilar',
                    'Cuadro de cargas (tabla lista)',
                    'Leyenda y simbología del plano',
                ],
                'Especificaciones y presupuesto' => [
                    'Especificaciones técnicas de materiales y equipos',
                    'Metrado de materiales eléctricos',
                    'Análisis de precios unitarios y presupuesto',
                    'Cronograma de ejecución',
                ],
                'Cierre y conformidad' => [
                    'Protocolo de pruebas y puesta en servicio',
                    'Panel fotográfico e informe de conformidad',
                    'Requisitos y solicitud del trámite',
                    'Índice y checklist del expediente eléctrico',
                ],
                'Revisión de documentos' => [
                    'Revisión de documentos del proyecto',
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
     * es un titulo con numero y sus temas como etiquetas, para que el temario completo
     * ocupe la mitad de alto que una lista vertical.
     */
    public static function temasHtml($clave) {
        if (!isset(self::OFERTAS[$clave])) {
            return null;
        }
        $pill = 'display:inline-block; background:#eff6ff; border:1px solid #dbeafe; color:#1e3a5f; '
              . 'border-radius:999px; padding:3px 10px; margin:3px 4px 3px 0; font-size:0.8rem; line-height:1.35;';
        $badge = 'display:inline-flex; align-items:center; justify-content:center; width:22px; height:22px; '
               . 'border-radius:50%; background:#2563eb; color:#fff; font-size:0.75rem; font-weight:700; flex:none;';
        $html = '';
        $n = 0;
        foreach (self::OFERTAS[$clave]['temas'] as $seccion => $items) {
            $n++;
            $html .= '<div style="margin:0 0 12px;">'
                   . '<div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">'
                   . '<span style="' . $badge . '">' . $n . '</span>'
                   . '<strong style="color:#0f172a;">' . htmlspecialchars($seccion) . '</strong></div><div>';
            foreach ($items as $item) {
                $html .= '<span style="' . $pill . '">' . htmlspecialchars($item) . '</span>';
            }
            $html .= '</div></div>';
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
