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
                '1. Bases y memoria del proyecto' => [
                    'Memoria descriptiva del proyecto eléctrico',
                    'Bases y criterios de diseño eléctrico',
                    'Descripción del sistema de utilización',
                ],
                '2. Cálculos eléctricos' => [
                    'Cálculo de máxima demanda y cuadro de cargas',
                    'Cálculo de caída de tensión',
                    'Selección y cálculo de conductores',
                    'Cálculo y selección de protecciones',
                    'Cálculo del sistema de puesta a tierra',
                    'Cálculo luminotécnico (nivel de lux)',
                    'Distribución de tableros (general y de distribución)',
                    'Cálculo de canalizaciones (tuberías/bandejas)',
                ],
                '3. Planos y esquemas' => [
                    'Estructura del diagrama unifilar',
                    'Cuadro de cargas (tabla lista)',
                    'Leyenda y simbología del plano',
                ],
                '4. Especificaciones y presupuesto' => [
                    'Especificaciones técnicas de materiales y equipos',
                    'Metrado de materiales eléctricos',
                    'Análisis de precios unitarios y presupuesto',
                    'Cronograma de ejecución',
                ],
                '5. Cierre y conformidad' => [
                    'Protocolo de pruebas y puesta en servicio',
                    'Panel fotográfico e informe de conformidad',
                    'Requisitos y solicitud del trámite',
                    'Índice y checklist del expediente eléctrico',
                ],
                '6. Revisión de documentos' => [
                    'Revisión de documentos del proyecto',
                ],
                '7. Bonus incluido' => [
                    'Asesor de Proyectos Eléctricos (Prompt Maestro)',
                ],
            ],
        ],
    ];

    /**
     * Devuelve el HTML de "Temas Principales" de la oferta, o null si la clave no existe.
     */
    public static function temasHtml($clave) {
        if (!isset(self::OFERTAS[$clave])) {
            return null;
        }
        $html = '';
        foreach (self::OFERTAS[$clave]['temas'] as $seccion => $items) {
            $html .= '<p style="margin: 14px 0 6px;"><strong>' . htmlspecialchars($seccion) . '</strong></p>';
            $html .= '<ul style="list-style: none; padding: 0;">';
            foreach ($items as $item) {
                $html .= '<li>' . htmlspecialchars($item) . '</li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }
}
