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

          if(!is_null($page->name))
            $this->view('pages/edit', array('app' => $app, 'user' => $user, 'page' => $page));
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

  /**
   * Site analytics endpoint.
   */
  public function analytics($app = null)
  {
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

          if(!is_null($media->filename))
            $this->view('media/edit', array('app' => $app, 'user' => $user, 'media' => $media));
          else
            $this->view('error/404', array('app' => $app, 'user' => $user, 'media' => $media));
          break;

        case 'new':
            $this->view('media/new', array('app' => $app, 'user' => $user));
          break;

        default:
          $media = Media::get($this->db);
          $this->view('media/index', array('app' => $app, 'user' => $user, 'media' => $media));
          break;
      }
    }
    else
    {
      $this->view('error/403');
    }
  }

}

?>
