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

  public function notification($endpoint = '', $data = array())
  {
    switch ($endpoint)
    {
      case 'push':
        if(array_key_exists('name', $data) && array_key_exists('content', $data))
        {
          Notification::push($data['name'], $data['content']);
        }
        break;

      case 'pull':
        if(array_key_exists('name', $data))
        {
          Notification::pull($data['name']);
        }
        break;

      default:
        break;
    }
  } // end notification

  /**
   * User controller
   * @param {string} $endpoint
   */
  public function user($endpoint = '')
  {

    switch($endpoint)
    {
        case 'login':
          $this->view('user/login');
          break;

        case 'logout':
          $this->view('user/logout');
          break;

        case 'register':
          if
          (
            isset($_POST['username']) &&
            isset($_POST['password']) &&
            isset($_POST['name']) &&
            isset($_POST['group']) &&
            isset($_POST['primary_email']) &&
            isset($_POST['emails']) &&
            isset($_POST['address']) &&
            isset($_POST['phones']) &&
            isset($_POST['preferences']) &&
            isset($_POST['display_name']) &&
            !empty($_POST['username']) &&
            !empty($_POST['password']) &&
            !empty($_POST['name']) &&
            !empty($_POST['group']) &&
            !empty($_POST['primary_email']) &&
            !empty($_POST['emails']) &&
            !empty($_POST['address']) &&
            !empty($_POST['phones']) &&
            !empty($_POST['preferences']) &&
            !empty($_POST['display_name'])
          )
          {
            # Cache User model.
            $user = $this->model('User', array('login' => 'Admin', 'db' => $this->db));

            # Bind arguments to posted variables.
            $user_login = $_POST['username'];
            $user_password = $_POST['password'];
            $user_name = $_POST['name'];
            $user_group = $_POST['group'];
            $user_meta = json_encode(
                                      array(
                                              'primary_email' => $_POST['primary_email'],
                                              'emails' => $_POST['emails'],
                                              'address' => $_POST['address'],
                                              'phones' => $_POST['phones'],
                                              'preferences' => $_POST['preferences'],
                                              'display_name' => $_POST['display_name']
                                            )
                                    );

            # Check for regiistration permission
            if($user->has_permission("edit","users"))
            {
              User::register($user_login, $user_password, $user_name, $user_group, $user_meta);
            }
            else
            {
              echo "Access denied.";
            }

          }
          break;

        case 'deregister':
          break;
    }

  } // end

  public function auth($login, $password)
  {
    echo Hash::hash_password($login, $password);
  }
}

?>
