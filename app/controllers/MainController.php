<?php
namespace controllers;

use core\Controller;

use lib\DB\DbPdo;

class MainController extends Controller
{
    /**
     * Главная страница
     */
    function indexAction ()
    {
        //   Work with view params   //
        //$this->view->path = 'account/login';
        //$this->view::$layout = 'custom';
        //$this->view->redirect('http://ya.ru');

        //   Work with model   //
        //$news = $this->model->getNews();
        //$this->view->render('Главная страница', ['news'=>$news]);

        // dd($this);
        // dd($this->config['db']);

        $db = new DbPdo();
        $users = $db->getArray('select * from users');
        // foreach ($users as $key => $user) {
        //     echo $user['login'] . '<br>';
        // }
        // echo "Всего пользователей: " . count($users);

        $this->view->render('Главная страница');
    }
}
