<?php
namespace App\Helpers;

/**
 * Links de pago de Hotmart por curso, para ofrecerlos como alternativa en el checkout
 * (sobre todo a compradores fuera de Peru, que ahi tienen mas metodos locales segun
 * su pais que con PayPal solo - OXXO, Mercado Pago, PSE, Nequi, etc.).
 *
 * Cuando se cree un producto nuevo en Hotmart, agregar su fila aqui (nombre del curso
 * tal cual esta en la tabla `cursos` => link "Pagina de Pago" de Links de divulgacion).
 */
class HotmartLinks {
    const LINKS = [
        'Variadores de Frecuencia' => 'https://pay.hotmart.com/I107372800G',
        'Terminaciones Termocontraibles' => 'https://pay.hotmart.com/K107652172W',
        'Empalmes Termocontraibles' => 'https://pay.hotmart.com/U107652234V',
        'Especializacion en Electricidad Industrial' => 'https://pay.hotmart.com/G107652272C',
        'Banco de Condensadores' => 'https://pay.hotmart.com/X107652292F',
        'Analizador de Redes' => 'https://pay.hotmart.com/P107652336M',
        'Mantenimiento de Subestaciones Electricas' => 'https://pay.hotmart.com/R107652397E',
    ];

    /**
     * Busca el link de Hotmart para un curso por nombre aproximado - mismo criterio
     * de matching (primeros 15 caracteres) que ya usa api/webhook-hotmart.php, para
     * que un curso que matchea en el webhook tambien matchee aqui.
     */
    public static function buscarPorNombre($nombreCurso) {
        if (empty($nombreCurso)) {
            return null;
        }
        $nombreCurso = trim($nombreCurso);

        // 1. Match exacto primero
        foreach (self::LINKS as $curso => $link) {
            if (strcasecmp($curso, $nombreCurso) === 0) {
                return $link;
            }
        }

        // 2. Match aproximado (primeros 15 caracteres de uno aparecen en el otro)
        foreach (self::LINKS as $curso => $link) {
            if (stripos($nombreCurso, substr($curso, 0, 15)) !== false
                || stripos($curso, substr($nombreCurso, 0, 15)) !== false) {
                return $link;
            }
        }

        return null;
    }
}
