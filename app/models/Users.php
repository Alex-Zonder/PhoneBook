<?php
namespace models;

use core\Model;

class Users extends Model
{
    function authUser(string $login, string $password): ?array
    {
        // Data Base //
        $query = 'SELECT * from users where password = :password and (login = :login or email = :login)';
        $params = ['login' => $login, 'password' => md5($password)];
        $result = $this->db->getArray($query, $params);

        return isset($result[0]) ? $result[0] : null;
    }



    function getUserByLoginOrEmail(string $login): ?array
    {
        // Data Base //
        $query = 'SELECT * from users where login = :login or email = :login';
        $params = ['login' => $login];
        $result = $this->db->getArray($query, $params);

        return isset($result[0]) ? $result[0] : null;
    }
}
