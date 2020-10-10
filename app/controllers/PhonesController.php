<?php
namespace controllers;

use core\Controller;

use lib\DB\DbPdo;

class PhonesController extends Controller
{
    /**
     * Телефонная книга
     */
    function indexAction ()
    {
        //   Work with view params   //
        //$this->view->path = 'account/login';
        //$this->view->redirect('/');

        //   Work with model   //
        $phoneBook = $this->loadModel('PhoneBook');
        $phones = $phoneBook->getPhones($this->user['id']);

        $this->view->render('Моя телефонная книга', ["phones" => $phones]);
    }
}
