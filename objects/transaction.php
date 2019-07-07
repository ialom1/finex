<?php
class Transaction{

  public $txn_id;
  public $txn_ref;
  public $acc_from;
  public $acc_to;
  public $acc_pin;
  public $amt;

  private $conn;
  private $accounts_table = "accounts";
  private $transactions_table = 'transactions';

  // constructor with $db as database connection

  public function __construct($db){
    $this->conn = $db;
  }

  function verify(){
    $this->txn_ref = htmlspecialchars(strip_tags($this->txn_ref));
    $this->acc_from = htmlspecialchars(strip_tags($this->acc_from));
    $this->acc_to = htmlspecialchars(strip_tags($this->acc_to));

    $query = "SELECT * FROM " .$this->transactions_table
    ." WHERE txn_ref = :txnRef";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':txnRef', $this->txn_ref);
    $stmt->execute();

    if($stmt->rowCount() == 1) {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if(($row['acc_from'] == $this->acc_from) && ($row['acc_to'] == $this->acc_to)){
        return true;
      }
    }
    return false;
  }

  // update product
  function update(){

    // sanitize
    $this->txn_id = htmlspecialchars(strip_tags($this->txn_id));
    $this->txn_ref = htmlspecialchars(strip_tags($this->txn_ref));
    $this->acc_from = htmlspecialchars(strip_tags($this->acc_from));
    $this->acc_to = htmlspecialchars(strip_tags($this->acc_to));
    $this->amt = htmlspecialchars(strip_tags($this->amt));

    $query0 = "SELECT * FROM " .$this->accounts_table
    ." WHERE acc_num = :fromAcc AND acc_pin = :accPin";

    $stmt0 = $this->conn->prepare($query0);
    $stmt0->bindParam(':fromAcc', $this->acc_from);
    $stmt0->bindParam(':accPin', $this->acc_pin);

    $query00 = "SELECT * FROM " .$this->accounts_table
    ." WHERE acc_num = :toAcc";

    $stmt00 = $this->conn->prepare($query00);
    $stmt00->bindParam(':toAcc', $this->acc_to);

    $stmt0->execute();
    $stmt00->execute();


    if($stmt0->rowCount() == 1 && $stmt00->rowCount() == 1) {
      $row = $stmt0->fetch(PDO::FETCH_ASSOC);
      if($row['acc_bal'] < $this->amt){
        return false;
      }
      else{
        $query = "INSERT INTO " .$this->transactions_table
        ." SET txn_id = :id, acc_from = :fromAcc, acc_to = :toAcc, amt = :amt, txn_ref = :ref";

        $stmt = $this->conn->prepare($query);

        // bind new values
        $stmt->bindParam(':id', $this->txn_id);
        $stmt->bindParam(':fromAcc', $this->acc_from);
        $stmt->bindParam(':toAcc', $this->acc_to);
        $stmt->bindParam(':amt', $this->amt);
        $stmt->bindParam(':ref', $this->txn_ref);


        if($stmt->execute()){
          $query1 = "UPDATE " .$this->accounts_table
          ." SET acc_bal = (acc_bal + :crBal) WHERE acc_num = :crAcc";
          $stmt1 = $this->conn->prepare($query1);
          $stmt1->bindParam(':crBal', $this->amt);
          $stmt1->bindParam(':crAcc', $this->acc_to);

          $query2 = "UPDATE " .$this->accounts_table
          ." SET acc_bal = (acc_bal - :deBal) WHERE acc_num = :deAcc";
          $stmt2 = $this->conn->prepare($query2);
          $stmt2->bindParam(':deBal', $this->amt);
          $stmt2->bindParam(':deAcc', $this->acc_from);

          if($stmt1->execute() && $stmt2->execute()){
            return true;
          }

        }
      }
    }

    return false;

  }
}
?>
