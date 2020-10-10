<?php
namespace core;

use core\View;
use lib\Authorize;

abstract class Controller
{
    protected $config;
    //----------------------------------------------------------------------//
    //                             Конструктор                              //
    //----------------------------------------------------------------------//
    // public function __construct($route, $user, $config) {
    // 	$this->user = $user;
    // 	$this->view = new View($route, $user, $config);
    // 	$this->model = $this->loadModel($route['controller']);
    // }
    public function __construct($route, $config) {
        $this->config = $config;
        $this->view = new View($route, $config);
        $this->model = $this->loadModel($route['controller']);
    }

    //----------------------------------------------------------------------//
    //                           Загрузка модели                            //
    //----------------------------------------------------------------------//
    public function loadModel($name) {
        $path = 'models\\' . ucfirst($name);
        if (class_exists($path)) {
            return new $path;
        }
    }
}
