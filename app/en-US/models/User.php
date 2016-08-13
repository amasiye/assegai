<?php

class User
{
  public $id;
  public $login;
  public $username;
  public $password;
  public $salt;
  public $joined;
  public $group;
  public $primary_email;
  public $emails;         // An associative array of email addresses
  public $address;
  public $phones;         // An associative array of phone numbers
  public $preferences;

  private $db;

  function __counstruct()
  {

  } // end __construct()

  /**
   * Logs a user into the system given login, password and an optional salt.
   * @param $login String The login/username.
   * @param $password String The user password.
   * @param $salt String [Optional] Salt key.
   * @return int
   */
  public static function login($login, $password, $salt=)
  {

  } // end static function login()

  /*
   * Logs the user out of the system.
   */
  public static function logout()
  {
    return true;
  } // end static function  logout()

  /**
   * Creates a new user given detailed information.
   * @param $details Array An associative array of user information.
   * @return int True upon successful user registration, false otherwise.
   */
  public static function register($details)
  {
    return 0;
  } // end static function register($details)
}

?>
