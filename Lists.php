<?php

class Lists
{
  /**
  * @var int
  */
  public $id = null;
  /**
  * @var string
  */
  public $name = null;
  /**
  *
  *
  * @param assoc
  */

public function __construct($data=array()){
  if (isset($data['id'])) $this->id = (int) $data['id'];
  if (isset($data['name'])) $this->name = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['name']);
}

public function storeFormValues($params){
  $this->__construct($params);
}

//Get all lists
public static function getList( $numRows=1000000, $order="name ASC" ) {
  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM lists
          ORDER BY " . $conn->quote($order) . " LIMIT :numRows";

  $st = $conn->prepare( $sql );
  $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
  $st->execute();
  $list = array();

  while ( $row = $st->fetch() ) {
    $listOne = new Lists( $row );
    $list[] = $listOne;
  }

  $sql = "SELECT FOUND_ROWS() AS totallists";
  $totallists = $conn->query( $sql )->fetch();
  $conn = null;
  return ( array ( "results" => $list, "totallists" => $totallists[0] ) );
}

//Get list associated with the given id
public static function getById( $id ) {
  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $sql = "SELECT * FROM lists WHERE id = :id";
  $st = $conn->prepare( $sql );
  $st->bindValue( ":id", $id, PDO::PARAM_INT );
  $st->execute();
  $row = $st->fetch();
  $conn = null;
  if ( $row ) return new Lists( $row );
}


//Create list with the name the user enters
public function storeList(){

if(!is_null($this->id)) trigger_error("List::insert(): Attempt to insert a List object that already has its ID property set (to $this->id).", E_USER_ERROR);

$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
$sql = "INSERT INTO lists (name) VALUES(:name)";
$st = $conn->prepare($sql);
$st->bindValue(":name", $this->name, PDO::PARAM_STR);
$st->execute();
$this->id = $conn->lastInsertId();
$conn = null;
}

//Update list iwht user submitted name
public function update() {

  if ( is_null( $this->id ) ) trigger_error ( "List::update(): Attempt to update a List object that does not have its ID property set.", E_USER_ERROR );

  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $sql = "UPDATE lists SET name=:name WHERE id = :id";
      $st = $conn->prepare ( $sql );
  $st->bindValue( ":name", $this->name, PDO::PARAM_INT );
  $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
  $st->execute();
  $conn = null;
}
//Delete list associated with the given id
public static function delete($id) {


  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $st = $conn->prepare ( "DELETE FROM lists WHERE id = :id LIMIT 1" );
  $st->bindValue( ":id", $id, PDO::PARAM_INT );
  $st->execute();
  $conn = null;
}
}
