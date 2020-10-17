<?php
namespace models;

use core\Model;

class Users extends Model
{
    function authUser(string $login, string $password): ?array
    {
        $query = 'SELECT * FROM users WHERE login = :login or email = :login';
        $params = ['login' => $login];
        $result = $this->db->getArray($query, $params);

        if (!isset($result[0]) || !password_verify($password, $result[0]['password'])) {
            return null;
        }

        return $result[0];
    }


    function getUserByLoginOrEmail(string $login): ?array
    {
        $query = 'SELECT * FROM users WHERE login = :login OR email = :login';
        $params = ['login' => $login];
        $result = $this->db->getArray($query, $params);

        return isset($result[0]) ? $result[0] : null;
    }


    function getUserByLogin(string $login): ?array
    {
        $query = 'SELECT * FROM users WHERE login = :login';
        $params = ['login' => $login];
        $result = $this->db->getArray($query, $params);

        return isset($result[0]) ? $result[0] : null;
    }


    function getUserByEmail(string $email): ?array
    {
        $query = 'SELECT * FROM users WHERE email = :email';
        $params = ['email' => $email];
        $result = $this->db->getArray($query, $params);

        return isset($result[0]) ? $result[0] : null;
    }


    function addUser(string $login, string $email, string $password)
    {
        $query = 'INSERT INTO users (login, email, password)
                    VALUES (:login, :email, :password)';
        $params = [
            'login' => $login,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        $this->db->query($query, $params);
    }
}
