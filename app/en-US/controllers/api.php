<<?php

/**
 * This controller handles all web service requests and provides an extensive
 * and robust api.
 *
 * @since 0.0.1
 * @version 0.0.1
 *
 * @package Assegai
 */
class Api extends Controller
{
  function index()
  {

  }

  public function auth($login, $password)
  {
    echo Hash::hash_password($login, $password);
  }
}

?>
