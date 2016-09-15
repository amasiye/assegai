<?php

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
    $instance = $this;

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
    array_push($this->params, array('app' => $instance));

    call_user_func_array(array($this->controller, $this->method), $this->params);

  } // end __construct()

  /**
   * Breaks up url into an array of tokens
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
  }

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
}

?>
