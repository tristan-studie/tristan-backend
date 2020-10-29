<?php
require( "config.php" );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";

//depending on the action given, call a function
switch ( $action ) {
  case 'newList':
    newList();
    break;
  case 'editList':
    editList();
    break;
  case 'deleteList':
    deleteList();
    break;
  case 'newTask':
    newTask();
    break;
  case 'editTask':
    editTask();
    break;
  case 'deleteTask':
    deleteTask();
    break;
  default:
    listLists();
}
//to create a new list
function newList() {

  $results = array();
  $results['pageTitle'] = "New List";
  $results['formAction'] = "newList";

  if ( isset( $_POST['saveChanges'] ) ) {

    $list = new Lists;
    $list->storeFormValues( $_POST );
    $list->storeList();

    header( "Location: index.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    header( "Location: index.php" );
  } else {

    $results['list'] = new Lists;

    require( TEMPLATE_PATH . "/editList.php" );
  }
}
//To create a new task
function newTask() {

  $results = array();
  $results['pageTitle'] = "New Task";
  $results['formAction'] = "newTask";

  if ( isset( $_POST['saveChanges'] ) ) {

    $list = new Task;
    $list->storeFormValues( $_POST );
    $list->storeTask();

    header( "Location: index.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    header( "Location: index.php" );
  } else {

    $results['list'] = new Task;


    $statusResults = Status::getStatus();
    $results['status'] = $statusResults['results'];
    require( TEMPLATE_PATH . "/editTask.php" );
  }
}
//Edit a list
function editList() {

  $results = array();
  $results['pageTitle'] = "Edit List";
  $results['formAction'] = "editList";

  if ( isset( $_POST['saveChanges'] ) ) {

    if ( !$list = Lists::getById( (int)$_POST['listId'] ) ) {
      header( "Location: index.php?error=listNotFound" );
      return;
    }

    $list->storeFormValues( $_POST );
        $list->update();
        header( "Location: index.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {


    header( "Location: index.php" );
  } else {

    $results['list'] = Lists::getById( (int)$_GET['listId'] );
    require( TEMPLATE_PATH . "/editList.php" );
  }

}
//Edit a task
function editTask() {

  $results = array();
  $results['pageTitle'] = "Edit Task";
  $results['formAction'] = "editTask";

  if ( isset( $_POST['saveChanges'] ) ) {

    if ( !$list = Task::getById( (int)$_POST['taskId'] ) ) {
      header( "Location: index.php?error=taskNotFound" );
      return;
    }

    $list->storeFormValues( $_POST );
        $list->update();
        header( "Location: index.php?status=changesSaved" );

  } elseif ( isset( $_POST['cancel'] ) ) {


    header( "Location: index.php" );
  } else {

    $results['list'] = Task::getById( (int)$_GET['taskId'] );

        $statusResults = Status::getStatus();
        $results['status'] = $statusResults['results'];

    require( TEMPLATE_PATH . "/editTask.php" );
  }

}
//Delete a list
function deleteList() {

  $results = array();
  $results['pageTitle'] = "Delete List";
  $results['formAction'] = "deleteList";

  if ( isset( $_POST['deleteList'] ) ) {

    Lists::delete($_POST['listId']);

    header( "Location: index.php?status=listDeleted" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    header( "Location: index.php" );
  } else {


    require( TEMPLATE_PATH . "/editList.php" );
  }
}
//Delete a task
function deleteTask() {

  $results = array();
  $results['pageTitle'] = "Delete Task";
  $results['formAction'] = "deleteTask";

  if ( isset( $_POST['deleteTask'] ) ) {

    Task::delete($_POST['taskId']);

    header( "Location: index.php?status=taskDeleted" );

  } elseif ( isset( $_POST['cancel'] ) ) {

    header( "Location: index.php" );
  } else {


    require( TEMPLATE_PATH . "/editTask.php" );
  }
}
//List all lists
function listLists() {
  $results = array();
  $data = Lists::getList(100);
  $results['lists'] = $data['results'];
  $statusResults = Status::getStatus();
  $results['status'] = $statusResults['results'];

  $results['pageTitle'] = "All Lists";

  if ( isset( $_GET['error'] ) ) {
    if ( $_GET['error'] == "listNotFound" ) $results['errorMessage'] = "Error: List not found.";
  }

  if ( isset( $_GET['status'] ) ) {
    if ( $_GET['status'] == "changesSaved" ) $results['statusMessage'] = "Your changes have been saved.";
    if ( $_GET['status'] == "listDeleted" ) $results['statusMessage'] = "List deleted.";
  }

  require( TEMPLATE_PATH . "/listLists.php" );
}


?>
