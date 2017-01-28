<?php
/**
 * This is the set up file. It is responsible for initializing
 * the app and making sure that all the critical components
 * are set up.
 */
session_start();

# Core classes
require_once "core/Config.php";
require_once "core/App.php";
require_once "core/Controller.php";
require_once "core/Database.php";
require_once "core/Debug.php";
require_once "core/HTML.php";
require_once "core/Session.php";
require_once "core/Token.php";
require_once "core/Utilities.php";
require_once "core/Validation.php";

// Auto load models
spl_autoload_register(function($class) {
  require_once 'models/' . $class . '.php';
});

?>
