<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/account.php';

// instantiate database and product object
$database = new Database('citiBankDb');
$db = $database->getConnection();

// initialize object
$account = new Account($db);

// set ID property of record to read
$account->acc_name = isset($_GET['acName']) ? $_GET['acName'] : die();
//$account->acc_pin = isset($_GET['acPin']) ? $_GET['acPin'] : die();

// query products
$stmt = $account->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

  // products array
  $result_ara=array();
  $result_ara["records"]=array();

  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){

    extract($row);
    // extract row
    // this will make $row['name'] to
    // just $name only

    $result_item=array(
      "acc_name" => $acc_name,
      "acc_num" => $acc_num,
      "acc_bal" => $acc_bal
    );

    array_push($result_ara["records"], $result_item);
  }

  // set response code - 200 OK
  http_response_code(200);

  // show products data in json format
  echo json_encode($result_ara);

} else {

  // set response code - 404 Not found
  http_response_code(200);

  // tell the user no products found
  echo json_encode(
    array("message" => "No account found for " .$account->acc_name)
  );
}

?>
