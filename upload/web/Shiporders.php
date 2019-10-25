<?php 

class Shiporders {
 
    // database connection and table name
    private $conn;
    private $table_name = "shiporders";
 
    // object properties
    public $orderid;
    public $orderperson;
    public $name;
    public $address;
    public $city;
    public $country;
    public $title;
    public $note;
    public $quantity;
    public $price;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}
?>