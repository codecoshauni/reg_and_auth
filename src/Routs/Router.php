<?php

namespace App\Routs;

use App\Model\Validator;
use App\Model\XmlGateway;

class Router
{

    private $routes;
    private $users;
    private $validator;

    public function __construct(XmlGateway $users, Validator $validator)
    {
        $this->users = $users;
        $this->validator = $validator;
    }

    public function run()
    {
        $this->routes = require_once('routes.php');
        $path = $this->getUrlPath();
        $controllerName = $this->getControllerName($path);

        if (!isset($controllerName)) {
            header("HTTP/1.0 404");
            die();
        }

        $controller = new $controllerName($this->users, $this->validator);
        $controller->run();
    }

    private function getUrlPath()
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return '/' . ltrim(preg_replace('/^\\/index\\.php/', '', $path), '/');
    }

    private function getControllerName(string $path)
    {
        foreach ($this->routes as $route => $controllerName) {
            if ($path === $route) {
                return $controllerName;
            }
        }
    }
}
