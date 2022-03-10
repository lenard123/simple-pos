<?php

require_once __DIR__.'/../_init.php';

class Order
{
    public $id;
    public $created_at;

    public function __construct($order)
    {
        $this->id = $order['id'];
        $this->created_at = $order['created_at'];
    }

    public static function create()
    {
        global $connection;

        $sql_command = 'INSERT INTO orders VALUES ()';
        $stmt = $connection->prepare($sql_command);
        $stmt->execute();

        return static::getLastRecord();
    }


    public static function getLastRecord()
    {
        global $connection;

        $stmt = $connection->prepare('SELECT * FROM `orders` ORDER BY id DESC limit 1;');
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $result = $stmt->fetchAll();

        if (count($result) >= 1) {
            return new Order($result[0]);
        }

        return null;
    }
}