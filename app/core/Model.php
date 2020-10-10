<?php
namespace core;

use lib\DB\DbPdo;

abstract class Model
{
    public $db;

    public function __construct() {
    	$this->db = new DbPdo();
    }
}
