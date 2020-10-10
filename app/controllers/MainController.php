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
        // echo "Всего пользователей: " . count($users);

        $usr = $this->loadModel('Users');


        $this->view->render('Главная страница');
    }



    /**
     * Страница авторизации
     */
    function loginAction ()
    {
        $this->view->render('Авторизация');
    }



    /**
     * Страница выхода
     */
    function logoutAction ()
    {
        echo "Logout";
        \lib\Authorize::logout();

        $this->view->redirect('/');
    }



    /**
     * Страница регистрации
     */
    function registerAction ()
    {
        $this->view->render('Регистрация');
    }
}
