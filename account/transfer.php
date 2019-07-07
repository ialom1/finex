<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/transaction.php';

// instantiate database and product object
$database = new Database('citiBankDb');
$db = $database->getConnection();

// initialize object
$transaction = new Transaction($db);

// set ID property of record to read
$transaction->acc_from = isset($_POST['acFrom']) ? $_POST['acFrom'] : die();
$transaction->acc_to = isset($_POST['acTo']) ? $_POST['acTo'] : die();
$transaction->amt = isset($_POST['amt']) ? $_POST['amt'] : die();
$transaction->txn_ref = isset($_POST['txnRef']) ? $_POST['txnRef'] : die();
// $transaction->acc_pin = isset($_GET['acPin']) ? $_GET['acPin'] : die();
$transaction->acc_pin = hash('sha256', isset($_POST['acPin']) ? $_POST['acPin'] : die());
$transaction->txn_id = isset($_POST['txnRef']) ? $_POST['txnRef'] : die();

// update the product
if($transaction->update()){

  // set response code - 200 ok
  http_response_code(200);

  // tell the user
  echo json_encode(array("message" => "success", "txid" => $transaction->txn_id));
}
// if unable to update the product, tell the user
else{

  // set response code - 503 service unavailable
  http_response_code(200);

  // tell the user
  echo json_encode(array("message" => "failed", "txid" => $transaction->txn_id));
}

?>
