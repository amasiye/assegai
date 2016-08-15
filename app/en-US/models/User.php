<?php
/**
 * @version 1.0.0
 * @since 1.0.0
 *
 * @package Assegai
 */
class User
{
  public $id = -1;
  public $login;
  public $username = 'User';
  public $password;
  public $salt;
  public $joined;
  public $group;
  public $primary_email;
  public $emails;         // An associative array of email addresses
  public $address;
  public $phones;         // An associative array of phone numbers
  public $preferences;
  public $display_name = 'Default User.';

  private $db;

  function __counstruct()
  {
  } // end __construct()

  /**
   * Logs a user into the system given login, password and an optional salt.
   * @param {String} $login The login/username.
   * @param {String} $password The user password.
   * @param {String} $salt [Optional] Salt key.
   * @return {int} Loging status or error code.
   */
  public static function login($login, $password)
  {

  } // end static function login()

  /*
   * Logs the user out of the system.
   */
  public static function logout()
  {
    return true;
  } // end logout()

  /**
   * Creates a new user given detailed information.
   * @param $details Array An associative array of user information.
   * @return int True upon successful user registration, false otherwise.
   */
  public static function register($details)
  {
    return 0;
  } // end static function register($details)

  public static function is_logged_in()
  {
      if
      (
        isset($_SESSION[SITE_PREFIX . 'username']) &&
        !empty($_SESSION[SITE_PREFIX . 'username'])
      )
      return true;

    return false;
  } // end is_logged_in()
}

?>
