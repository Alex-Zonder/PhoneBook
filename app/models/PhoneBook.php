<?php
namespace models;

use core\Model;

class PhoneBook extends Model
{
    function getPhones(int $ownerId = 0)
    {
        // Data Base //
        $query = 'SELECT * from phone_book where owner_id = :owner_id';
        $params = ['owner_id' => $ownerId];
        $result = $this->db->getArray($query, $params);

        return $result;
    }

    function countPhones(int $ownerId = 0)
    {
        // Data Base //
        $query = 'SELECT count(*) from phone_book where owner_id = :owner_id';
        $params = ['owner_id' => $ownerId];
        $result = $this->db->getArray($query, $params);

        return $result[0]["count(*)"];
    }
}