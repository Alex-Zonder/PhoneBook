<?php
namespace models;

use core\Model;

class PhoneBook extends Model
{
    function getPhones(int $ownerId = 0)
    {
        $query = 'SELECT * from phone_book where owner_id = :owner_id';
        $params = ['owner_id' => $ownerId];
        $result = $this->db->getArray($query, $params);

        return $result;
    }

    function countPhones(int $ownerId = 0)
    {
        $query = 'SELECT count(*) from phone_book where owner_id = :owner_id';
        $params = ['owner_id' => $ownerId];
        $result = $this->db->getArray($query, $params);

        return $result[0]["count(*)"];
    }

    function deletePhone(int $id)
    {
        $query = 'DELETE from phone_book where id = :id';
        $params = ['id' => $id];
        $this->db->query($query, $params);
    }

    function updatePhone(object $phone)
    {
        $query = "UPDATE phone_book SET name = :name, last_name = :last_name, email = :email, phone = :phone where id = :id";
        $params = [
            'name' => $phone->name,
            'last_name' => $phone->last_name,
            'email' => $phone->email,
            'phone' => $phone->phone,
            'id' => $phone->id
        ];
        $this->db->query($query, $params);
    }

    function createPhone(object $phone, int $owner_id)
    {
        $query = 'INSERT INTO phone_book (owner_id, name, last_name, email, phone) VALUES (:owner_id, :name, :last_name, :email, :phone)';
        $params = [
            'owner_id' => $owner_id,
            'name' => isset($phone->name) ? $phone->name : null,
            'last_name' => isset($phone->last_name) ? $phone->last_name : null,
            'email' => isset($phone->email) ? $phone->email : null,
            'phone' => isset($phone->phone) ? $phone->phone : null,
        ];
        $this->db->query($query, $params);
    }
}
