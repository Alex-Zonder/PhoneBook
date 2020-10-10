<?php
// Возращаем файлы напрямую //
if (preg_match('/\.(?:js|css|png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"]))
	return false;


//   Включаем работу с ошибками   //
require dirname(__DIR__) . '/app/lib/dev.php';


//   Автозагрузка файлов с классом   //
spl_autoload_register(function($class) {
	$path = dirname(__DIR__) . '/app/' . str_replace('\\', '/', $class) . '.php';
	if (file_exists($path))
		require $path;
	// Debug if no file //
	else if (isset($debugMode))
		echo 'No file with class: ' . $path;
});


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
