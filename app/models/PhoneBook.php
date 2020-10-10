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
        $return = $this->db->getArray($query, $params);
        //debug($return);
        return $return;
    }
}
