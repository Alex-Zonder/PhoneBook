<?php
namespace lib;

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

        // If user is //
        if ($this->user) {
            unset($this->user["password"]);
        }
        // dd($this->user);
    }


    /**
     * Get user
     */
    public function getUser(): ?array
    {
        if (!isset($this->user) || !isset($this->user['login']))
            return null;
        return $this->user;
    }


    /**
     * Login
     */
    private function login($login, $password) {
        $this->user = $this->usersModel->authUser($login, $password);
        // If user is //
        if ($this->user) {
            $this->createSession();
        }
    }


    /**
     * Create session
     */
    private function createSession()
    {
        $_SESSION['login'] = $this->user['login'];
    }


    /**
     * Check session
     */
    private function checkSession ()
    {
        if (isset($_SESSION['login'])) {
            $this->user = $this->usersModel->getUserByLoginOrEmail($_SESSION['login']);
        }
    }


    /**
     * Log out
     */
    public static function logout() {
        // Destroy Session //
        $_SESSION = [];
        session_destroy();
        // Destroy Cookie //
        self::unsetCookie('name');
        self::unsetCookie('SESSID');
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
