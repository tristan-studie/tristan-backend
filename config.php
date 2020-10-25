<?php
ini_set("display_errors", true);
date_default_timezone_set("Europe/Amsterdam");
define("DB_DSN", "mysql:host=localhost; dbname=backend");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "mysql");
define("TEMPLATE_PATH", "templates");
require("Lists.php");
require("Task.php");
require('Status.php');

function handleException( $exception ) {
  echo $exception->getMessage();
  error_log( $exception->getMessage() );
}

set_exception_handler( 'handleException' );
?>
