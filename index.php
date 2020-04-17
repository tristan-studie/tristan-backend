<?php
require( "config.php" );
$action = isset( $_GET['action'] ) ? $_GET['action'] : "";


switch ( $action ) {
  case 'newList':
    newList();
    break;
  case 'editList':
    editList();
    break;
  default:
    listLists();
}

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

function listLists() {
  $results = array();
  $data = Lists::getList(100);
  $results['lists'] = $data['results'];

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
