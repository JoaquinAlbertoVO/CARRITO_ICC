<?php
namespace App\Core;

class Controller {
    // Método para cargar una vista
    public function view($view, $data = []) {
        // Extraer los datos para que estén disponibles en la vista
        extract($data);
        
        $viewFile = 'app/Views/' . $view . '.php';
        if (file_exists($viewFile)) {
            // El layout puede incluir este $viewFile en su contenido
            ob_start();
            require_once $viewFile;
            $content = ob_get_clean();
            
            // Cargar el layout principal que envolverá el $content
            if (file_exists('app/Views/layouts/main.php')) {
                require_once 'app/Views/layouts/main.php';
            } else {
                echo $content;
            }
        } else {
            die("Vista no existe: " . $viewFile);
        }
    }
}
