<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/product.php';

// instantiate database and product object
$database = new Database('citiSupplyDb');
$db = $database->getConnection();

// initialize object
$product = new Product($db);


$product->id = isset($_GET['id']) ? $_GET['id'] : die();

// query products
$stmt = $product->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

  // products array
  $products_arr=array();
  $products_arr["records"]=array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    extract($row);
    // extract row
    // this will make $row['name'] to
    // just $name only

    $product_item=array(
      "id" => $id,
      "name" => $prd_name,
      "price" => $prd_price,
      "qty" => $prd_qty
    );

    array_push($products_arr["records"], $product_item);
  }

  // set response code - 200 OK
  http_response_code(200);

  // show products data in json format
  echo json_encode($products_arr);
} else {

  // set response code - 404 Not found
  http_response_code(200);

  // tell the user no products found
  echo json_encode(
    array("message" => "No products found.")
  );
}

?>
