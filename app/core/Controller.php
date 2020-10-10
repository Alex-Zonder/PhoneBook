<?php
namespace core;

use core\View;
use lib\Authorize;

abstract class Controller
{
    protected $config;
    protected $user;


    public function __construct($route, $config, $user) {
        $this->config = $config;
        $this->user = $user;
        $this->view = new View($route, $user);
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
