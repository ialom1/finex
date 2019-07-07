<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/product.php';

// get database connection
$database = new Database('citiSupplyDb');
$db = $database->getConnection();

// prepare product object
$product = new Product($db);

// set ID property of record to read
$product->id = isset($_GET['id']) ? $_GET['id'] : die();
$product->prd_qty = isset($_GET['qty']) ? $_GET['qty'] : die();

// update the product
if($product->update()){

  // set response code - 200 ok
  http_response_code(200);

  // tell the user
  echo json_encode(array("message" => "success", "price" => $product->prd_price));
}
// if unable to update the product, tell the user
else{

  // set response code - 503 service unavailable
  http_response_code(200);

  // tell the user
  echo json_encode(array("message" => "failed"));
}
?>
