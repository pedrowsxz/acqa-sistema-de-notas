<?php

namespace Core;

class Router {
    private $routes = [];

    public function get($uri, $handler) {
        $this->routes['GET'][$uri] = $handler;
    }

    public function post($uri, $handler) {
        $this->routes['POST'][$uri] = $handler;
    }

    public function run() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rtrim(str_replace('/seu_projeto/public', '', $uri), '/');

        if (isset($this->routes[$method][$uri])) {
            [$class, $methodName] = $this->routes[$method][$uri];
            call_user_func([new $class, $methodName]);
        } else {
            http_response_code(404);
            echo "404 - Página não encontrada";
        }
    }
}