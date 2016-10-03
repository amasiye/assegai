<?php

/**
 * This class provides a structured representation of the Assegai
 * application class.
 */
class App
{
  protected $instance;
  protected $controller = 'home';
  protected $method = 'index';
  protected $params = array();

  private $api_key = API_KEY;
  private $api_key_id = ID_API_KEY;

  public $version = APP_VER;

  public function __construct()
  {
    global $locale;

    $url = $this->parse_url();

    if(file_exists('app/' . $locale . '/controllers/' . $url[0] . '.php'))
    {
      $this->controller = $url[0];
      unset($url[0]);
    }

    require_once 'app/' . $locale . '/controllers/' . $this->controller . '.php';

    # Instantiate our controller object and reassign controller var accordingly
    $this->controller = new $this->controller;

    if(isset($url[1]))
    {
      if(method_exists($this->controller, $url[1]))
      {
        $this->method = $url[1];
        unset($url[1]);
      }
    }

    # If the url isn't empty assign values else assign empty array
    $this->params = $url ? array_values($url) : array();

    # Cache instance of app for easier use within controller functions
    $this->params['app'] = $this;

    call_user_func_array(array($this->controller, $this->method), $this->params);

  } // end __construct()

  /**
   * Breaks up url into an array of tokens.
   */
  public function parse_url()
  {
    if(isset($_GET['url']))
    {
      return $url = explode(
                            '/',
                            filter_var(
                                        rtrim($_GET['url'], '/'),
                                        FILTER_SANITIZE_URL
                                      )
                            );
    }
  } // end parse_url()

  /**
   * Return the website app's api_key
   * @return {string} The hashed string representing the web app's api_key.
   */
  public function get_api_key()
  {
    return $this->api_key;
  } // end get_api_key()

  /**
   * Return the website app's api_key
   * @return {string} The hashed string representing the web app's api_key.
   */
  public function get_api_key_id()
  {
    return $this->api_key_id;
  } // end get_api_key_id()

  /**
   * Sets the api_key of the website to the given hashed string.
   * @param {Database} $db The Database where the key will be registered.
   * @param {string} $key The new api key string.
   * @return {boolean} True if successful, false otherwise.
   */
  public function set_api_key($db, $key)
  {
    # Update the api key in the database
    if($db->update('assg_api_key', array('key_hash'), array($key), array('-w' => "key_author='website'")) == QUERY_EXEC_OK)
    {
      # Update the api key in the Config file
      // if()
      return true;
    }

    return false;
  } // end set_api_key()

  public static function get_api_key_author($db, $key)
  {
    $row = $db->select('assg_api_keys', array('key_author'), array('where' => "key_hash='{$key}'"))[0];

    return $row['key_author'];
  } // end get_api_key_author()

  /**
   * Generates a hash key of given length.
   * @param {string} $length The length of the random string that should be returned in bytes.
   * @return {string} Returns a randomnly generated key.
   */
  public static function generate_key($length)
  {

    $key = md5(uniqid());
    $key_length = strlen($key);

    # Pad key if it is shorter than required length
    if($key_length < $length)
    {
      # Calculate the pad length
      $pad_length = $length - $key_length;
      $pad_str = "";

      # Determine whether multiple md5 strings
      # needed be created.
      if($pad_length <= 64)
      {
        $pad_str = md5(uniqid());
      }
      else
      {
        $reps = $pad_length % 64;
        for($x = 0; $x < $reps; $x++)
          $pad_str .= md5(uniqid());
      }

      $key = str_pad($key, $length, $pad_str);
    }

    # Truncate key if it's longer than required length
    if($key_length > $length)
    {
      $key = substr($key, 0, $length);
    }

    return $key;
  } // end generate_key()

  /**
   * Verifies whether a given key is acceptable..
   * @param {Database} $db The database containing the list of acceptable api keys.
   * @param {string} $key The key to be checked for validity.
   * @return {boolean} True if the given is valid/acceptable, false otherwise.
   */
  public static function is_valid_api_key($db = null, $key = '')
  {
    $result = false;

    if(!is_null($db) && strcmp(get_class($db), 'Database') == 0)
    {
      # Grab all the accceptable keys
      $acceptable = $db->select('assg_api_keys', array('key_hash'));

      foreach($acceptable as $row)
      {
        if(strcmp($row['key_hash'], $key) == 0)
          $result = true;
      }
    }

    return $result;
  } // end is_valid_key()

  /**
   * Handles redirection
   * [Deprecated] - Use Controller::redirect($url) instead.
   */
  public static function redirect($path)
  {
    header("Location: {$path}");
  } // end redirect($path)

  /**
   * Returns the site description.
   * @return {string} The site description.
   */
  public static function get_site_description($db)
  {
    return $db->select('assg_options', array('option_value'), array('where' => "option_name='site_description'"))[0]['option_value'];
  } // end get_site_description()

  public static function get_ui_component($db, $user, $component, $data = array())
  {
    $html = "<div class='page-header'><h3><span class='glyphicon glyphicon-dashboard'></span> Dashboard</h3>
      <div class='list-group'>
      <a href='admin/analytics/' class='list-group-item'>Site Analytics</a>
      <a href='admin/media/' class='list-group-item'>Media Library<span class='badge'>" . Media::total($db) . "</span></a>
      <a href='admin/contacts/' class='list-group-item'>Contacts</a>
      <a href='admin/mail/' class='list-group-item'>Mail</a>
      <a href='admin/users/' class='list-group-item'>Users</a>
      <a href='admin/profile/' class='list-group-item'>Profile</a>
      <a href='admin/settings/' class='list-group-item'>Settings</a>
      </div>
      </div>";

    switch ($component)
    {
      case 'nav-dashboard':
        break;

      case 'nav-pages':
        if($user->has_permission('read', 'pages'))
        {
          $html = "<div class='page-header'><h3>Pages</h3></div>";
        }
        break;

      case 'nav-pages/edit':
        if($user->has_permission('edit', 'pages'))
        {
          $html = "<div class='page-header'>
                    <ul class='nav nav-tabs'>
                      <li class='active'><a href='#' data-target='#menu-elements'>Elements</a></li>
                      <li><a href='#' data-target='#menu-widgets'>Widgets</a></li>
                    </ul>
                  </div>
                  <div id='menu-elements' class='col-md-12'>
                    Elements
                  </div>
                  <div id='menu-widgets' class='col-md-12 hidden'>
                    Widgets
                  </div>
                  <script>
                  </script>";
          $elements = Element::get($db);
        }
        break;

      case 'nav-layouts':
        if($user->has_permission('read', 'layouts'))
        {
          $html = "<div class='page-header'><h3>Layouts</h3></div>
                  <div class='list-group'>";
          foreach ($data['layouts'] as $layout)
          {
            $html .= "<a class='list-group-item' href='admin/layouts/edit/{$layout->id}'>
                      {$layout->title}
                      </a>";
          }
          $html .= "<a class='list-group-item text-center' title='Add Layout' href='admin/layouts/new/'>
                      <span class='glyphicon glyphicon-plus'></span>
                    </a>
                    </div>";
        }
        break;
      case 'nav-layouts/edit':
        if($user->has_permission('edit', 'layouts'))
        {
          $html = "<div class='page-header'>
                    <ul class='nav nav-tabs'>
                      <li class='active'><a href='#' data-target='#menu-elements'>Elements</a></li>
                      <li><a href='#' data-target='#menu-widgets'>Widgets</a></li>
                    </ul>
                  </div>
                  <div id='menu-elements' class='col-md-12 element-list-group'>
                    <div class='element-list-group-item text-center pull-left' draggable='true' ondragstart='drag(event)' data-element-type='title'><span class='glyphicon'>T</span><br>Title</div>
                    <div class='element-list-group-item text-center pull-left' draggable='true' ondragstart='drag(event)' data-element-type='text'><span class='glyphicon glyphicon-align-left  '></span><br>Text</div>
                    <div class='element-list-group-item text-center pull-left' draggable='true' ondragstart='drag(event)' data-element-type='image'><span class='glyphicon glyphicon-picture'></span><br>Image</div>
                    <div class='element-list-group-item text-center pull-left' draggable='true' ondragstart='drag(event)' data-element-type='gallery'><span class='glyphicon glyphicon-th-large'></span><br>Gallery</div>
                  </div>
                  <div id='menu-widgets' class='col-md-12 element-list-group hidden'>
                    <div class='element-list-group-item text-center pull-left'>Widget 1</div>
                    <div class='element-list-group-item text-center pull-left'>Widget 2</div>
                    <div class='element-list-group-item text-center pull-left'>Widget 3</div>
                    <div class='element-list-group-item text-center pull-left'>Widget 4</div>
                  </div>
                  <script>
                  </script>";
          $elements = Element::get($db);
        }
        break;

      default:
        break;
    }
    return $html;
  } // end get_ui_component()

}

?>
