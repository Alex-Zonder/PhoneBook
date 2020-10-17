<?php
namespace controllers;

use core\Controller;
use models\Users;
use lib\Validator;

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
        // Ragistration //
        if (isset($_POST['login'])) {
            //   Validation   //
            // Check login
            if (!Validator::checkLogin($_POST['login'])) {
                $errors[] = "Лгоин: длинна должна быть 4 - 16 символов.";
            }
            // Check email
            if (!Validator::checkEmail($_POST['email'])) {
                $errors[] = "Почта: не верный формат.";
            }
            // Check password
            if (!Validator::checkPassword($_POST['password'])) {
                $errors[] = 'Пароль: 6 - 16 символов; должен содеражать: 1 заглавную, 1 цифру, один символ (!@#$%_-).';
            }
            // Check passwords //
            if ($_POST['password'] != $_POST['password2']) {
                $errors[] = 'Пароли не совпадают.';
            }

            // Проверка существующих login & email //
            if (count($errors) == 0) {
                $userModel = new Users();
                // Check login //
                if ($userModel->getUserByLogin($_POST['login']) !== null)
                    $errors[] = "Лгоин ".$_POST['login']." уже зарегистрирован.";
                // Check email //
                if ($userModel->getUserByEmail($_POST['email']) !== null)
                    $errors[] = "Почта ".$_POST['email']." уже зарегистрирована.";
            }

            // Adding user to DB //
            if (count($errors) == 0) {
                $userModel->addUser($_POST['login'], $_POST['email'], $_POST['password']);
                $this->view->redirect('/');
            }
        }

        $this->view->render('Регистрация', ['errors' => $errors]);
    }
}
