<?php
namespace lib;

class Validator
{
    public static function checkEmail(string $email): bool
    {
        if (!preg_match("#^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$#", $email)) {
            return false;
        }
        return true;
    }

    public static function checkPhone(string $phone): bool
    {
        if (!preg_match("#^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){10,14}(\s*)?$#", $phone)) {
            return false;
        }
        return true;
    }

    // Check login (до 16 символов, буквы и цифры)
    public static function checkLogin(string $login): bool
    {
        if (!preg_match('#^[-A-Za-z0-9]{4,16}$#', $login)) {
            return false;
        }
        return true;
    }

    // Check password (до 16 символов, буквы, цифры, спецсимволы)
    public static function checkPassword(string $password): bool
    {
        if (!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%_-])[0-9A-Za-z!@#$%_-]{6,16}$/', $password)) {
            return false;
        }
        return true;
    }
}
