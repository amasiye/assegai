<?php

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

  public function user($endpoint = '')
  {

    switch($endpoint)
    {
        case 'login':
          $this->view('user/login', array('db'=> $this->db));
          break;
    }

  } // end

  public function auth($login, $password)
  {
    echo Hash::hash_password($login, $password);
  }
}

?>
