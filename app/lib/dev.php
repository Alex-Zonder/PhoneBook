<?php
// Включаем отображение ошибок //
ini_set('display_errors', 1);
error_reporting(E_ALL);

$debugMode = true;

// Переводим объекты в текст //
function dd($str) {
	echo '<pre>';
	var_dump($str);
	echo '</pre>';
}
