<?php
namespace controllers;

use core\Controller;

use models\Users;

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
            // dd($_POST);
            // Validation //
            // Check login (до 16 символов, буквы и цифры)
            if (!preg_match('#^' . "[-A-Za-z0-9]{4,16}" . '$#', $_POST['login']))
                $errors[] = "Лгоин: длинна должна быть 4 - 16 символов.";
            // Check email
            if (!preg_match("#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$#", $_POST['email']))
                $errors[] = "Почта: не верный формат.";
            // Check password (до 16 символов, буквы и цифры)
            if (!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%_-])[0-9A-Za-z!@#$%_-]{6,16}$/', $_POST['password']))
                $errors[] = 'Пароль: 6 - 16 символов; должен содеражать: 1 заглавную, 1 цифру, один символ (!@#$%_-).';
            // Check passwords //
            if ($_POST['password'] != $_POST['password2'])
                $errors[] = 'Пароли не совпадают.';

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
