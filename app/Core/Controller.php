<?php
namespace App\Core;

class Controller {
    // Método para cargar una vista
    public function view($view, $data = [], $layout = 'layouts/main') {
        // Extraer los datos para que estén disponibles en la vista
        extract($data);
        
        $viewFile = 'app/Views/' . $view . '.php';
        if (file_exists($viewFile)) {
            // El layout puede incluir este $viewFile en su contenido
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
            
            // Cargar el layout principal que envolverá el $content
            // Si el layout es false, significa que no queremos layout (ej. peticiones AJAX, o el login que ya tiene su propio HTML completo)
            if ($layout !== false && file_exists('app/Views/' . $layout . '.php')) {
                require_once 'app/Views/' . $layout . '.php';
            } else {
                echo $content;
            }
        } else {
            die("Vista no existe: " . $viewFile);
        }
    }
}
