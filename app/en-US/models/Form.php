<?php

/**
 * 
 */
class Form
{
  public $id;
  public $name;
  public $action;
  public $method;

  function __construct()
  {

  } // end

  /**
   * Validates the value of input control given type, length, and regex pattern.
   */
  public static function validate_input($type, $value, $pattern, $length, $filter = array())
  {
    $is_valid = false;

    switch($type)
    {
      case 'text':
      case 'password':
      case 'email':
      case 'search':
      case 'url':
        if(strlen($value) >= $length)
          $is_valid = preg_match($pattern, $value);
        break;

      case 'number':
      case 'tel':
        break;
    }

    return $is_valid;
  } // end validate_input()
}


?>
