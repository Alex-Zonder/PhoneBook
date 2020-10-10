<?php
namespace lib;

use lib\DB\DbPdo;

use models\Users;

class Authorize
{
    private $usersModel;
    private $user = null;

    public function __construct()
    {
        $this->usersModel = new Users();

        // If POST authorize //
        if (!empty($_POST) && isset($_POST['login']) && isset($_POST['password'])) {
            $this->login($_POST['login'], $_POST['password']);
        }
        // If GET authorize //
        // else if (isset($_GET['login']) && isset($_GET['password'])) {
        //     $this->login($_GET['login'], $_GET['password']);
        // }
        // If SESSION or COOKIE authorize //
        else {
            $this->checkSession();
        }

        // dd($this->user);
    }


    public function getUser(): ?array
    {
        if (!isset($this->user) || !isset($this->user['login']))
            return null;
        return $this->user;
    }


    public static function logout() {
        // Destroy Session //
        $_SESSION = [];
        session_destroy();
        // Destroy Cookie //
        self::unsetCookie('name');
        self::unsetCookie('SESSID');
    }


    private function login($login, $password) {
        $this->user = $this->usersModel->authUser($login, $password);
        // If user is //
        if ($this->user) {
            $this->createSession();
        }
    }


    private function createSession()
    {
        // Create session //
        $_SESSION['login'] = $this->user['login'];
    }


    private function checkSession ()
    {
        // By Session //
        if (isset($_SESSION['login'])) {
            $this->user = $this->usersModel->getUserByLoginOrEmail($_SESSION['login']);
        }
    }


    /**
     * Cookie
     */
    private function setCookie ($key, $val)
    {
        $y2k = time() + (86400 * 60);
        setcookie($key, $val, $y2k, "/");
    }
    public static function unsetCookie ($key)
    {
        unset($_COOKIE[$key]);
        setcookie($key, null, -1, '/');
    }
}
