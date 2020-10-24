<?php
namespace lib\DB;

use PDO;

class DbPdo
{
    private $db;

    private static ?DbPdo $instance = null;

    public static function getInstance(): DbPdo
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    private function __construct($database = false) {
        $config = require dirname(__DIR__, 3) . '/config/db.php';
        $config['database'] = $database !== false ? $database : $config['database'];
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

    private function __clone() {}

    private function __wakeup() {}


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
