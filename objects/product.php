<?php
class Product{

  public $id;
  public $prd_name;
  public $prd_price;
  public $prd_qty;
  public $txnRef;

  private $availableQty = 0;
  private $updatedQty = 0;
  private $conn;
  private $table_name = "products";

  // constructor with $db as database connection

  public function __construct($db){
    $this->conn = $db;
  }

  // read products
  function read(){

    // select all query
    $query = "SELECT * FROM "
    . $this->table_name
    . " WHERE id ='" .$this->id ."'";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  // update product
  function update(){
    $query = "SELECT * FROM "
    . $this->table_name
    . " WHERE id ='" .$this->id ."'";

    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    $num = $stmt->rowCount();

    if($num > 0){

      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $this->prd_price = $row['prd_price'];
        $this->availableQty = $row['prd_qty'];
      }

      if($this->availableQty >= $this->prd_qty){
        $this->updatedQty = $this->availableQty - $this->prd_qty;

        $query = "UPDATE " . $this->table_name
        . " SET prd_qty = :updatedQty WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->updatedQty = htmlspecialchars(strip_tags($this->updatedQty));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $stmt->bindParam(':updatedQty', $this->updatedQty);
        $stmt->bindParam(':id', $this->id);

        if($stmt->execute()){
          return true;
        }
      }
    }
    return false;

  }
}
?>
