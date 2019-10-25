<?php 

class People {
 
    // database connection and table name
    private $conn;
    private $table_name = "people";
 
    // object properties
    public $personid;
    public $personname;
    public $phone;
    
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
}
?>