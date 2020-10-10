<?php
namespace controllers;

use core\Controller;

use lib\DB\DbPdo;

class PhonesController extends Controller
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

        $db = new DbPdo();
        $phones = $db->getArray('select * from phone_book');

        $this->view->render('Главная страница', ["phones" => $phones]);
    }
}
