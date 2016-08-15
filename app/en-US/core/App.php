<?php

class App
{
  protected $controller = 'home';
  protected $method = 'index';

  protected $params = array();

  public $db;
  // protected $conn;

  public function __construct()
  {
    global $db_host, $db_user, $db_pass, $db_name, $locale;

    # Make a new connection to the database
    $this->db = new Database($db_host, $db_user, $db_pass, $db_name);
    // $this->db = new DbContext;
    // $this->conn = $this->db->conn;

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
   * Handles redirection
   * [Deprecated] - Use Controller::redirect($url) instead.
   */
  public static function redirect($path)
  {
    header("Location: {$path}");
  }
}

?>
