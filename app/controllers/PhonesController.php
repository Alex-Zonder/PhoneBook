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
        $phoneBook = $this->loadModel('PhoneBook');
        $phones = $phoneBook->getPhones(1);

        $this->view->render('Моя записная книжка', ["phones" => $phones]);
    }
}
