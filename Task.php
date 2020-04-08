<?php

class Task
{
  /**
  * @var int
  */
  public $id = null;
  /**
  * @var string
  */
  public $description = null;
  /**
  * @var string
  */
  public $status = null;
  /**
  * @var int
  */
  public $list_id = null;
  /**
  * @var int
  */
  public $duration = null;
  /**
  *
  *
  * @param assoc
  */

public function __construct($data=array()){
  if (isset($data['id'])) $this->id = (int) $data['id'];
  if (isset($data['description'])) $this->description = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['description']);
  if (isset($data['status'])) $this->status = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['status']);
  if (isset($data['list_id'])) $this->list_id = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['list_id']);
    if (isset($data['duration'])) $this->list_id = preg_replace("/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['duration']);
}

public function storeFormValues($params){
  $this->__construct($params);
}

public static function getList( $numRows=1000000, $order=" ASC" ) {
  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM tasks
          ORDER BY " . $conn->quote($order) . " LIMIT :numRows";

  $st = $conn->prepare( $sql );
  $st->bindValue( ":numRows", $numRows, PDO::PARAM_INT );
  $st->execute();
  $list = array();

  while ( $row = $st->fetch() ) {
    $task = new Task( $row );
    $list[] = $task;
  }


  $conn = null;
  return ( array ( "results" => $list ) );
}

public static function getById( $list_id ) {
  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $sql = "SELECT * FROM tasks WHERE list_id = :list_id";
  $st = $conn->prepare( $sql );
  $st->bindValue( ":list_id", $list_id, PDO::PARAM_INT );
  $st->execute();
  $row = $st->fetch();
  $conn = null;
  if ( $row ) return new Task( $row );
}

public function storeTask(){

if(!is_null($this->id)) trigger_error("Task::insert(): Attempt to insert a Task object that already has its ID property set (to $this->id).", E_USER_ERROR);

$conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
$sql = "INSERT INTO tasks (description, duration, status, list_id) VALUES(:description, :duration, :status, :list_id)";
$st = $conn->prepare($sql);
$st->bindValue(":description", $this->name, PDO::PARAM_STR);
$st->bindValue(":duration", $this->name, PDO::PARAM_STR);
$st->bindValue(":status", $this->name, PDO::PARAM_STR);
$st->bindValue(":list_id", $this->name, PDO::PARAM_STR);
$st->execute();
$this->id = $conn->lastInsertId();
$conn = null;
}

public function update() {

  if ( is_null( $this->id ) ) trigger_error ( "Task::update(): Attempt to update a Task object that does not have its ID property set.", E_USER_ERROR );

  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $sql = "UPDATE lists SET name=:name WHERE id = :id";
      $st = $conn->prepare ( $sql );
  $st->bindValue( ":name", $this->name, PDO::PARAM_INT );
  $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
  $st->execute();
  $conn = null;
}

public function delete() {


  if ( is_null( $this->id ) ) trigger_error ( "Task::delete(): Attempt to delete a Task object that does not have its ID property set.", E_USER_ERROR );

  $conn = new PDO( DB_DSN, DB_USERNAME, DB_PASSWORD );
  $st = $conn->prepare ( "DELETE FROM tasks WHERE id = :id LIMIT 1" );
  $st->bindValue( ":id", $this->id, PDO::PARAM_INT );
  $st->execute();
  $conn = null;
}
}
