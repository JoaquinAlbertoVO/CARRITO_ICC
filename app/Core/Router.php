<?php
namespace App\Core;

class Router {
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Controlador por defecto o de la URL
        if (isset($url[0]) && $url[0] != '') {
            $controllerName = ucfirst($url[0]) . 'Controller';
            if (file_exists('app/Controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            } else {
                // TODO: 404
                die("Error 404: Controlador no encontrado");
            }
        }

        $controllerClass = "\\App\\Controllers\\" . $this->controller;
        
        if(class_exists($controllerClass)) {
            $this->controller = new $controllerClass;
        } else {
            die("Error 404: Clase de Controlador no encontrada");
        }

        // Método
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        // Parámetros
        $this->params = $url ? array_values($url) : [];

        // Llamar al controlador
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return [];
    }
}
