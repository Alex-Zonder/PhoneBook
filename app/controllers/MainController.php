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
        // $this->view->path = 'account/login';
        // $this->view->redirect('/');

        //   Work with model   //
        $phoneBook = $this->loadModel('PhoneBook');
        $phonesTotal = $phoneBook->countPhones($this->user['id']);

        $this->view->render('Главная страница', ['phonesTotal' => $phonesTotal]);
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
        $errors = [];
        if (isset($_POST['login'])) {
            // dd($_POST);
            // Check login (до 16 символов, буквы и цифры)
            if (!preg_match('#^' . '.{4,16}' . '$#', $_POST['login'])) $errors[] = "Login error";
            // Check email (до 16 символов, буквы и цифры)
            if (!preg_match('#^' . '.{4,16}' . '$#', $_POST['email'])) $errors[] = "Email error";
            // Check password (до 16 символов, буквы и цифры)
            if (!preg_match('#^' . '.{4,16}' . '$#', $_POST['password'])) $errors[] = "Password error";
        }

        $this->view->render('Регистрация', ['errors' => $errors]);
    }
}
