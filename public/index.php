<?php
//   Включаем работу с ошибками   //
require dirname(__DIR__) . '/app/lib/dev.php';


//   Автозагрузка файлов с классом   //
require dirname(__DIR__) . '/autoload.php';


//   Session   //
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
session_start();


// Time //
date_default_timezone_set('Europe/Moscow');


//   Router   //
use core\Router;
$router = new Router;
$router->run();
