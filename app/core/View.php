<?php
namespace core;

class View
{
    public $route;
    public $user;
    public $path;


    public function __construct($route, $user)
    {
        $this->route = $route;
        $this->user = $user;
        $this->path = $route['controller'] . '/' . $route['action'];
    }


    /**
     * Генерация страницы
     */
    public function render($title = 'PhoneBook', $vars = [])
    {
        // Load vars //
        extract($vars);
        // Render view //
        $path = dirname(__DIR__, 2) . '/templates/views/' . $this->path . '.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require dirname(__DIR__, 2) . '/templates/index.php';
        }
        else {
            View::errorCode('Не найден вид: ' . $path, 404, $title);
        }
    }


    /**
     * Страница ошибок
     */
    public static function errorCode($message = '', $code = 404, $title = '')
    {
        http_response_code($code);
        $content = '<center><p><b><h3>Ошибка ' . $code . '<br>' . $message . '</h3></b></p></center>';
        require dirname(__DIR__, 2) . '/templates/index.php';
        exit;
    }


    /**
     * Редирект
     */
    public static function redirect($url)
    {
        header('location: ' . $url);
    }
}
