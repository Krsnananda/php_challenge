<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// inclui banco de dados e arquivos de objetos
include_once '../config/database.php';
include_once '../objects/product.php';
 
// instancia banco de dados e objeto 
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$people = new People($db);
$shiporders = new Shiporders($db);

// query products
$stmt = $people->$shiporders->read();
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $shiporders_arr=array();
    $shiporders_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    //site exemplo
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $product_item=array(
            "id" => $orderid,
            "order" => $orderperson,
            "name" => $name,
            "city" => $city,
            "country" => $country,
            "title" => $title,
            "note" => $note,
            "quantity" => $quantity,
            "description" => html_entity_decode($description),
            "price" => $price
           
        );
 
        array_push($shiporders_arr["records"], $product_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show products data in json format
    echo json_encode($shiporders);
    
}

// read products
function read(){
 
    // select all query
    $query = "SELECT
                p.person as orderperson, p.orderid, p.name, p.description, p.price, p.orderid, p.created
            FROM
                " . $this->table_name . " p
                LEFT JOIN
                    categories o
                        ON p.category_id = c.id
            ORDER BY
                p.created DESC";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // execute query
    $stmt->execute();
 
    return $stmt;
} 
 
