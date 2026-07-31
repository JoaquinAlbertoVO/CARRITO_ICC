<?php
namespace App\Helpers;

class Security {
    /**
     * Escapes HTML characters to prevent XSS.
     * @param string|null $string
     * @return string
     */
    public static function esc($string) {
        if ($string === null) return '';
        return htmlspecialchars($string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

// Helper function global para facilitar su uso en vistas
if (!function_exists('esc')) {
    function esc($string) {
        return \App\Helpers\Security::esc($string);
    }
}
