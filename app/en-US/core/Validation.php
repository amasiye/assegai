<?php
define('INDEX_REGEX_WORD', 0);
define('INDEX_REGEX_DIGIT', 1);
define('INDEX_REGEX_NON_WORD', 2);
define('INDEX_REGEX_NON_DIGIT', 3);
define('INDEX_REGEX_PASSWORD', 4);

/**
 * The validation class contains methods for
 * validating all kinds of data including regex patterns.
 */
class Validation
{

  /**
   * @param {string} $text The input string.
   * @param {string} $pattern The pattern to search for, as a string.
   */
  public static function validate($text, $pattern)
  {
    $is_valid = false;

    # Perform regular expression test
    if(preg_match(get_regex_pattern($pattern), $text))
      $is_valid = true;

    return $is_valid;
  }

  /**
   * Checks whehter a given password is valid.
   * @param {string} $password The input password to be validated.
   * @prara {string} $pattern [Optional] The pattern to search for, as a string.
   */
  public static function validate_password($password, $pattern = INDEX_REGEX_PASSWORD)
  {
    return validate($password, $pattern);
  } // end validate_password()

  /**
   * Returns a predefined regular expression pattern of given name
   * @param {string} $name The name of the regex pattern to retrieve
   * @return {string} The requested regex pattern or false if the
   * pattern name is undefined.
   */
  public static function get_regex_pattern($name)
  {
    switch($name)
    {

      case INDEX_REGEX_WORD:
        $result = $pattern = '/^[\w]$/';
        break;

      case INDEX_REGEX_DIGIT:
        $result = $pattern = '/^[\d]$/';
        break;

      default:
        $result = false;

    }

    # Return false if an invalide name is supplied
    return $result;
  } // end get_regex_pattern()
}


?>
