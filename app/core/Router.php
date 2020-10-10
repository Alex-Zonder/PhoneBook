<?php
namespace core;

use core\View;
use lib\Authorize;

class Router
{
    protected $config;
    protected $user;
    protected $url;
    protected $routes = [];
    protected $params = [];



    public function __construct()
    {
        //   Load Config   //
        $this->config = require dirname(__DIR__, 2).'/config/app.php';
        //   Authorization   //
        $auth = new Authorize();
        $this->user = $auth->getUser();
        //   Load Routes   //
        $this->url = trim($_SERVER['REQUEST_URI'], '/');
        $routes = require dirname(__DIR__, 2) . '/config/routes.php';
        foreach ($routes as $key => $value) {
            $key = '#^' . $key . '$#';
            $this->routes[$key] = $value;
        }
    }



    /*
     * Проверка пути
     */
    public function match()
    {
        foreach ($this->routes as $route => $params) {
            if (preg_match($route, $this->url)) {
                $this->params = $params;
                return true;
            }
        }
        return false;
    }



    /*
     * Старт
     */
    public function run()
    {
        if ($this->match()) {
            // Check authorized user //
            if ($this->url != 'register' && (!isset($this->user) || !isset($this->user['login']))) {
                $this->params['controller'] = 'main';
                $this->params['action'] = 'login';
            }

            // Load controller //
            $path = 'controllers\\' . ucfirst($this->params['controller']) . 'Controller';
            if (class_exists($path)) {
                $action = $this->params['action'].'Action';
                if (method_exists($path, $action)) {
                    $controller = new $path($this->params, $this->config, $this->user);
                    $controller->$action();
                }
                else View::errorCode('Не найден экшн: ' . $action, 404, $this->config['title']);
            }
            else View::errorCode('Не найден контроллер: ' . $path, 404, $this->config['title']);
        }
        else View::errorCode('Маршрут не найден: ' . $this->url, 404, $this->config['title']);
    }
}
