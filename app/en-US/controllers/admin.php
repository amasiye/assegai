<?php
/**
 * The main controller for site administration and management requests.
 *
 * @since 0.0.1
 * @version 0.0.1
 *
 * @package Assegai
 */
class Admin extends Controller
{
  /**
   * The default endpoint, i.e the dashboard
   * @param {string} $params The user name to assign for this session
   */
  public function index($params = '')
  {
    global $app;

    if(User::is_logged_in())
    {
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db));
      $recent_posts = $this->db->select(
                                        'assg_posts',
                                        null,
                                        array(
                                                'order' => 'post_modified DESC',
                                                'limit' => 10
                                              )
                                        );
      $this->view(
                    'dashboard/index',
                    array(
                            'app' => $app,
                            'user' => $user,
                            'recent_posts' => $recent_posts,
                            'totals' => Post::get_totals($this->db)
                          )
                  );
    }
    else
    {
      $user = $this->model('User', array('login' => 'Admin', 'db' => $this->db));
      $this->view('login/index', array('app' => $app, 'user' => $user));
    }
  } // end index()

  /**
   * Displays user profile information.
   * @param {array} $params The parameter list.
   */
  public function profile($app = '')
  {
    if(User::is_logged_in())
    {
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db, 'app' => $app));
      $this->view('user/profile', array('app' => $app, 'user' => $user));
    }
    else
    {
      # Error - Unauthorised
      $this->view('error/401');
    }
  } // end profile()

  public function pages($action = '', $id = -1, $app = null)
  {
    if(User::is_logged_in())
    {
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db, 'app' => $app));
      switch ($action)
      {
        case 'edit':
          $page = new Post($this->db, $id, 'page');
          $task_bar_options = array('save' => true, 'publish' => true, 'view_mode' => true);

          if(!is_null($page->name))
            $this->view(
                        'pages/edit',
                         array(
                                'app' => $app,
                                'user' => $user,
                                'page' => $page,
                                'task_bar_options' => $task_bar_options
                              )
                        );
          else
            $this->view('error/404', array('message' => 'Page lookup error possibly due to an invalid page id.'));
          break;

        default:
          $this->view('pages/index', array('app' => $app, 'user' => $user));
          break;
      }
    }
    else
    {
        $this->view('error/403');
    }
  } // end pages()

  public function layouts($action = '', $id = -1, $app = null)
  {
    $db = $this->db;
    if(User::is_logged_in())
    {
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db, 'app' => $app));
      switch ($action)
      {
        case 'edit':
          $layout = new Post($this->db, $id, 'layout');
          $task_bar_options = array('save' => true, 'publish' => true, 'view_mode' => true);

          if(!is_null($layout->name))
            $this->view(
                        'layouts/edit',
                        array(
                              'app' => $app,
                              'user' => $user,
                              'layout' => $layout,
                              'task_bar_options' => $task_bar_options
                            )
                        );
          else
            $this->view('error/404', array('message' => 'Page lookup error possibly due to an invalid page id.'));
          break;

        default:
          $result = $db->select('assg_posts', null, array('where' => "post_type='layout'"));
          $layouts = array();
          foreach ($result as $row)
          {
            array_push($layouts, new Layout($db, $row['post_id']));
          }
          $this->view('layouts/index', array('app' => $app, 'user' => $user, 'layouts' => $layouts));
          break;
      }
    }
    else
    {
        $this->view('error/403');
    }
  } // end layouts()

  /**
   * Site analytics endpoint.
   */
  public function analytics($action = '', $id = -1, $app = null)
  {
    # Validate parameters
    if(is_null($app))
      $app = $id;
    else
      $id = (int)$id;

    if(User::is_logged_in())
    {
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db, 'app' => $app));
      $this->view('dashboard/analytics', array('app' => $app, 'user' => $user));
    }
    else
    {
      $this->view('error/403');
    }
  } // end analytics()

  /**
   * Media endpoint
   */
  public function media($action = '', $id = -1, $app = null)
  {
    # Validate parameters
    if(is_null($app))
      $app = $id;
    else
      $id = (int)$id;

    if(User::is_logged_in())
    {
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db, 'app' => $app));

      switch ($action)
      {
        case 'edit':
          # Note the [0] at end: we only want the first returned row.
          $media = Media::get($this->db, array('where' => "post_id={$id}"))[0];
          $task_bar_options = array('save' => true, 'publish' => true, 'view_mode' => false);

          if(!is_null($media->filename))
            $this->view(
                        'media/edit',
                        array(
                              'app' => $app,
                              'user' => $user,
                              'media' => $media,
                              'task_bar_options' => $task_bar_options
                            )
                        );
          else
            $this->view('error/404', array('app' => $app, 'user' => $user, 'media' => $media));
          break;

        case 'new':
          $task_bar_options = array('save' => true);
          $this->view(
                      'media/new',
                      array(
                            'app' => $app,
                            'user' => $user,
                            'task_bar_options' => $task_bar_options
                          )
                      );
          break;

        default:
          $media = Media::get($this->db);
          $client_side_controllers = ['media', 'display-options'];

          $this->view(
                      'media/index', array(
                                            'app' => $app,
                                            'user' => $user,
                                            'media' => $media,
                                            'client_side_controllers' => $client_side_controllers
                                          )
                      );
          break;
      }
    }
    else
    {
      $this->view('error/403');
    }
  } // end media()

  public function settings($action = '', $id = -1, $app = null)
  {
    # Validate parameters
    if(is_null($app))     // i.e app is not 3rd parameter
    {
      if($id == -1)       // i.e app is not 2nd parameter
        $app = $action;   // therefore app is the first parameter
      else
        $app = $id;
    }
    else
      $id = (int)$id;

    # Check if user is logged in
    if(User::is_logged_in())
    {
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db, 'app' => $app));
      $task_bar_options = array('save' => true);

      $this->view(
                  'dashboard/settings',
                  array(
                        'app' => $app,
                        'user' => $user,
                        'settings' => null,
                        'task_bar_options' => $task_bar_options
                      )
                );
    }
    else
    {
      $this->view('error/403');
    }
  } // end settings()

  /**
   * Trash bin controller.
   */
  public function trash($action = '', $id = -1, $app = null)
  {
    # Validate parameters
    if(is_null($app))     // i.e app is not 3rd parameter
    {
      if($id == -1)       // i.e app is not 2nd parameter
        $app = $action;   // therefore app is the first parameter
      else
        $app = $id;
    }
    else
      $id = (int)$id;

    if(User::is_logged_in())
    {
      $user = $this->model('User', array('login' => $_SESSION[SESSION_USER], 'db' => $this->db, 'app' => $app));
      $trash_posts = Post::get($this->db, array('where' => "post_trashed=1"));
      // var_dump($trash_posts); exit;
      $trash = array();
      if(!empty($trash_posts[0]))
      {
        foreach ($trash_posts as $tp)
        {
          $t = new Post($this->db, $tp['post_id']);
          array_push($trash, $t);
        }
      }
      $client_side_controllers = ['trash', 'display-options'];

      $this->view(
                  'dashboard/trash',
                  array(
                        'user' => $user,
                        'trash' => $trash,
                        'client_side_controllers' => $client_side_controllers
                      )
                );
    }
  } // end trash()

} // end admin

?>
