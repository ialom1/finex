<?php
class Account{

  public $acc_name;
  public $acc_num;
  public $acc_pin;
  public $acc_bal;

  private $conn;
  private $accounts_table = "accounts";

  // constructor with $db as database connection

  public function __construct($db){
    $this->conn = $db;
  }

  // read products
  function read(){

    // select all query
    $query = "SELECT acc_name, acc_num, acc_bal FROM " . $this->accounts_table
    . " WHERE acc_name = :accName";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->acc_name = htmlspecialchars(strip_tags($this->acc_name));

    // bind new values
    $stmt->bindParam(':accName', $this->acc_name);

    // execute query
    $stmt->execute();

    return $stmt;
  }
}
?>
