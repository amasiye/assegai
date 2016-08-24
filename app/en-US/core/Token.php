<?php

/**
 * Token class provides helpful functionality for token generation
 */
class Token
{
  /**
   * Generates a hashed string token.
   */
  public static function generate()
  {
    return Session::put(TOKEN_NAME, md5(uniqid()));
  } // end generate()
} // end Token


?>
