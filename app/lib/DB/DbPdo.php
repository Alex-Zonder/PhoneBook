<?php
namespace lib\DB;

use PDO;

class DbPdo
{
	protected $db;


    public function __construct($database = false) {
        $config = require dirname(__DIR__, 3) . '/config/db.php';
        $config['database'] = $database == true ? $database : $config['database'];
        try {
            $this->db = new PDO(
                $config['driver'] . ':host=' . $config['host'] . ':' . $config['port'] . ';dbname=' . $config['database'],
                $config['user'],
                $config['password'],
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (\Exception $e) {
            echo "Error!: " . $e->getMessage() . "<br/>";
        }
    }


    public function query($query, $params = []) {
        try {
            $prepare = $this->db->prepare($query);
            if (!empty($params))
                foreach ($params as $key => $value)
                    $prepare->bindValue(':' . $key, $value);
            $prepare->execute();
        }
        catch (\Exception $e) {
            echo "Error!: " . $e->getMessage() . "<br/>";
        }
        return $prepare;
    }


    public function getArray($query, $params = []) {
        return $this->query($query, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}
