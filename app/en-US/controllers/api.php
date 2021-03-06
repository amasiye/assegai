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
  public function user($verb = '')
  {
    switch($verb)
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

        case 'update':
          # Check for api key
          if(isset($_POST[ID_API_KEY]) && !empty($_POST[ID_API_KEY]))
          {
            # Validate api key
            if(App::is_valid_api_key($this->db, $_POST[ID_API_KEY]))
            {
              # Specify which columns are being updated
              if
              (
                  isset($_POST['login']) &&
                  !empty($_POST['login']) &&
                  !is_null($_POST['login']) &&
                  User::login_name_exists($this->db, $_POST['login'])
              )
              {
                if($this->validate_text($_POST['login'], REGEX_USERNAME, 4))
                {
                  $user = new User(array('login' => $_POST['login'], 'db' => $this->db));
                  $results = array('success' => true, 'errorMessage' => null);

                  # Create a columns and values array
                  $meta = $user->meta;
                  $columns = array();
                  $values = array();

                  $results['login'] = array('success' => true, 'value' => $_POST['login']);
                  array_push($columns, 'login');
                  array_push($values, $_POST['login']);

                  /*
                  Note - Each field is checked individually so that only
                  specified fields are updated.
                  */

                  # User Name
                  if(
                      isset($_POST['username']) &&
                      !empty($_POST['username']) &&
                      $this->validate_text($_POST['username'])
                    )
                  {
                    $results['username'] = array('success' => true, 'value' => $_POST['username']);
                    array_push($columns, 'username');
                    array_push($values, $_POST['username']);
                  }

                  # Group Name
                  if(
                      isset($_POST['groupName']) &&
                      !empty($_POST['groupName']) &&
                      $this->validate_text($_POST['groupName'])
                    )
                  {
                    if($this->db->select('assg_users', null, array('where' => "user_login='{$_POST['login']}'"))[0]['user_group'] > 1)
                    {
                      $results['groupName'] = array('success' => true, 'value' => $_POST['groupName']);
                      array_push($columns, 'group');
                      array_push($values, Group::get_group_id($this->db, $_POST['groupName']));
                    }
                    else
                    {
                      $results['groupName'] = array('success' => false, 'value' => null, 'error' => 1, );
                    }
                  }

                  # Primary Email
                  if(
                      isset($_POST['primaryEmail']) &&
                      !empty($_POST['primaryEmail']) &&
                      $this->validate_text($_POST['primaryEmail'])
                    )
                  {
                    $results['primaryEmail'] = array('success' => true, 'value' => $_POST['primaryEmail']);
                    $meta['primary_email'] = $_POST['primaryEmail'];
                  }

                  # Emails
                  if(
                      isset($_POST['emails']) &&
                      !empty($_POST['emails']) &&
                      $this->validate_text($_POST['emails'])
                    )
                  {
                    $results['emails'] = array('success' => true, 'value' => $_POST['emails']);
                    $meta['emails'] = $_POST['emails'];
                  }

                  # Address
                  if(
                      isset($_POST['address']) &&
                      !empty($_POST['address']) &&
                      $this->validate_text($_POST['address'])
                    )
                  {
                    $results['address'] = array('success' => true, 'value' => $_POST['address']);
                    $meta['address'] = $_POST['address'];
                  }

                  # Phones
                  if(
                      isset($_POST['phones']) &&
                      !empty($_POST['phones']) &&
                      $this->validate_text($_POST['phones'])
                    )
                  {
                    $results['phones'] = array('success' => true, 'value' => $_POST['phones']);
                    $meta['phones'] = $_POST['phones'];
                  }

                  # Preferences
                  if(
                      isset($_POST['preferences']) &&
                      !empty($_POST['preferences']) &&
                      $this->validate_text($_POST['preferences'])
                    )
                  {
                    $results['preferences'] = array('success' => true, 'value' => $_POST['preferences']);
                    $meta['preferences'] = $_POST['preferences'];
                  }

                  # Display Name
                  if(
                      isset($_POST['displayName']) &&
                      !empty($_POST['displayName']) &&
                      $this->validate_text($_POST['displayName'])
                    )
                  {
                    $results['displayName'] = array('success' => true, 'value' => $_POST['displayName']);
                    $meta['display_name'] = $_POST['displayName'];
                  }

                  if(!empty($meta) && !is_null($meta))
                  {
                    array_push($columns, 'meta');
                    array_push($values, json_encode($meta));
                  }

                  # Perform the update
                  if(!$user->update($columns, $values))
                  {
                    $results['success'] = false;
                    foreach($columns as $col)
                    {
                      $results[$col]['success'] = false;
                      $results[$col]['value'] = null;
                    }
                    $results['errorMessage'] = "<strong>Error {$user->error}:</strong> Update failed.";
                  }
                  # Now you can update user details
                  //   $results['username'] = false;
                  echo json_encode($results);
                  // echo $user->update(array('login'), array($_POST['login']));
                }
                else
                {
                  echo json_encode(array('success' => false, 'errorMessage' => "<strong>Error " . UPDATE_ERR_LOGIN . ":</strong> Invalid login name."));
                }
              }
              else
              {
                echo json_encode(array('success' => false, 'errorMessage' => "<strong>Error " . UPDATE_ERR_LOGIN . ":</strong> Invalid login name."));
              }
            }
            else
            {
              echo json_encode(array('success' => false, 'errorMessage' => "<strong>Error " . API_REQUEST_ERR_INVALID_KEY . ":</strong> Invalid api key."));
            }
          }
          else
          {
            echo json_encode(array('success' => false, 'errorMessage' => "<strong>Error " . API_REQUEST_ERR_MISSING_KEY . ":</strong> Missing api key."));
          }
          break;

        case 'upload':
          $this->view('user/upload');
          break;
    }

  } // end user()

  /**
   * Post endpoint. Handles all requests for pages such as
   * creation, deletion, editing etc...
   */
  public function post($verb = '', $data = array())
  {
    global $db;

    switch ($verb)
    {
      case 'trash':
        if(isset($_POST['itemIDs']) && !empty($_POST['itemIDs']))
        {
          $filters = array();
          $data = $_POST['itemIDs'];

          if(streq($data, 'all'))
          {
            $result = $db->update(POSTS_TABLE, array('post_trashed'), array(1), array('verbose' => true));
            $message = 'All items trashed.';

            if(streq(gettype($result), 'integer'))
            {
              $message = 'Database request error.';
              echo json_encode(array('success' => false, 'status' => API_REQUEST_ERR, 'message' => $message));
            }

            if($result['affected_rows'] == 0) $message = 'No changes made.';

            echo json_encode(array('success' => true, 'status' => API_REQUEST_OK, 'message' => $message));
            break;
          }

          if(intval($data) > 0)
          {
            $ids = explode(",", $_POST['itemIDs']);
            $id_string = '';

            for($x = 0; $x < count($ids); $x++)
            {
              $id_string .= ($x == 0)? "post_id={$ids[$x]}": " OR post_id={$ids[$x]}";
            }
            $filters['where'] = $id_string;
            $filters['verbose'] = true;
          }

          $result = $db->update(POSTS_TABLE, array('post_trashed'), array(1), $filters);

          if(streq(gettype($result), 'integer'))
          {
            echo json_encode(array('success' => false, 'status' => $result, 'message' => "Database request error."));
            break;
          }

          $affected_rows = $result['affected_rows'];
          $message = ($affected_rows > 1)? "{$affected_rows} items trashed." : "1 item trashed.";
          if($affected_rows == 0) $message = 'No changes made';

          echo json_encode(array('success' => true, 'status' => API_REQUEST_OK, 'message' => $message, 'changes' => $result['affected_rows']));
        }
        else
        {
          echo json_encode(array('success' => false, 'status' => API_REQUEST_ERR, 'message' =>"Bad Request data."));
        }
        break;

      case 'restore':
        if(isset($_POST['itemIDs']) && !empty($_POST['itemIDs']))
        {

          $filters = array();
          $data = $_POST['itemIDs'];

          if(streq($data, 'all'))
          {
            $result = $db->update(POSTS_TABLE, array('post_trashed'), array(0), array('verbose' => true));
            $message = 'All items restored.';

            if(streq(gettype($result), 'integer'))
            {
              $message = 'Database request error.';
              echo json_encode(array('success' => false, 'status' => API_REQUEST_ERR, 'message' => $message));
            }

            if($result['affected_rows'] == 0) $message = 'No changes made.';

            echo json_encode(array('success' => true, 'status' => API_REQUEST_OK, 'message' => $message));
            break;
          }

          # Handle 1 or more restoration
          if(intval($data) > 0)
          {
            $ids = explode(',', $data);
            $id_string = '';

            for($x = 0; $x < count($ids); $x++)
            {
              $id_string .= ($x == 0)? "post_id={$ids[$x]}": " OR post_id={$ids[$x]}";
            }
            $filters['where'] = $id_string;
            $filters['verbose'] = true;
          }

          $result = $db->update(POSTS_TABLE, array('post_trashed'), array(0), $filters);

          # Handle errors
          if(streq(gettype($result), 'integer'))
          {
            echo json_encode(array('success' => false, 'status' => $result, 'message' => "Database request error."));
            break;
          }

          $message = (count($ids) > 1)? "Items restored." : "Item restored.";

          if($result['affected_rows'] == 0) $message = 'No changes made.';

          echo json_encode(array('success' => true, 'status' => API_REQUEST_OK, 'message' => $message));
          break;
        }
        else
        {
          // if(empty($verb) || empty($data) || streq(gettype($data), 'object'))
          // {
          // }
          echo json_encode(array('success' => false, 'status' => API_REQUEST_ERR, 'message' =>"Database Request error."));
        }
        break;

      case 'delete':
        if(isset($_POST['itemIDs']) && !empty($_POST['itemIDs']))
        {
          $filters = array();
          $data = $_POST['itemIDs'];

          if(streq($data, 'all'))
          {
            $result = $db->delete(POSTS_TABLE, array('where' => "post_trashed=1", 'verbose' => true));
            $message = 'All items deleted.';

            if(streq(gettype($result), 'integer'))
            {
              $message = 'Database request error.';
              echo json_encode(array('success' => false, 'status' => API_REQUEST_ERR, 'message' => $message));
            }
            // if($result['affected_rows'] == 0) $message = 'No changes made.';

            echo json_encode(array('success' => true, 'status' => API_REQUEST_OK, 'message' => $message));
            // echo json_encode(array('success' => false, 'status' => API_REQUEST_ERR, 'messasge' => 'Database request error.'));
            break;
          }

          if(intval($data) > 0)
          {
            $ids = explode(',', $data);
            $id_string = '';

            for($x = 0; $x < count($ids); $x++)
            {
              $id_string .= ($x == 0)? "post_id={$ids[$x]}": " OR post_id={$ids[$x]}";
            }
            $filters['where'] = $id_string;
            $filters['verbose'] = true;
          }
          // var_dump($filters); exit;

          $result = $db->delete(POSTS_TABLE, $filters);

          # Handle errors
          if(streq(gettype($result), 'integer'))
          {
            echo json_encode(array('success' => false, 'status' => $result, 'message' => "Database request error."));
            break;
          }
          $message = (count($ids) > 1)? "Items deleted." : "Item deleted.";

          echo json_encode(array('success' => true, 'status' => API_REQUEST_OK, 'message' => $message));
        }
        else
        {
          echo json_encode(array('success' => false, 'status' => API_REQUEST_ERR, 'message' =>"Database Request error. No items selected."));
        }
        break;

      default:
        break;
    }
  }

  public function auth($login, $password)
  {
    $result = array('success' => true, 'status' => AUTH_OK, 'message' => 'Autherization granted.');
    if(!User::login_name_exists($this->db, $login))
    {
      $result['status'] = AUTH_ERR_CRED;
      $result['message'] = "User {$login} not found.";
      echo json_encode($result);
      return;
    }

    if(!User::auth($this->db, $login, $password))
    {
      $result['status'] = AUTH_ERR_CRED;
      $result['message'] = "Incorrect username or password.";
      echo json_encode($result);
      return;
    }

    // echo Hash::hash_password($login, $password);
    echo json_encode($result);
  } // end auth()

}

?>
