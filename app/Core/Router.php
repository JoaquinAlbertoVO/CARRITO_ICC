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
            if ($url[0] === 'admin') {
                if (isset($url[1]) && $url[1] === 'login') {
                    $controllerName = 'AdminAuthController';
                    $this->method = 'login';
                    unset($url[1]);
                } elseif (isset($url[1]) && $url[1] === 'logout') {
                    $controllerName = 'AdminAuthController';
                    $this->method = 'logout';
                    unset($url[1]);
                } else {
                    $controllerName = 'AdminCursosController'; // Por defecto dashboard
                    if (isset($url[1])) {
                        $this->method = $url[1];
                        unset($url[1]);
                    } else {
                        $this->method = 'dashboard';
                    }
                }
                unset($url[0]);
            } else {
                $controllerName = ucfirst($url[0]) . 'Controller';
                unset($url[0]);
            }

            if (file_exists('app/Controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
            } else {
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
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $scriptName = dirname($_SERVER['SCRIPT_NAME']);
        
        if ($scriptName !== '/' && $scriptName !== '\\') {
            if (strpos($uri, $scriptName) === 0) {
                $uri = substr($uri, strlen($scriptName));
            }
        }
        
        $uri = trim($uri, '/');
        
        if (!empty($uri)) {
            return explode('/', filter_var($uri, FILTER_SANITIZE_URL));
        }
        return [];
    }
}
