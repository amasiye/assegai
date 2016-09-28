<?php

/**
 * This class provides a structured representation of the Site settings data.
 * It provides methods for retrieving and updating various site settings.
 */
class Settings
{
  /**
   * Returns the name of the site.
   * @param {Database} $db The database containing site settings data.
   * @return {string} Returns the name of the site.
   */
  public static function get_site_name($db)
  {
    $option = new Option($db, Option::get_id($db, 'site_name'));
    return $option->value();
  } // end get_site_name()

  /**
   * An alias of get_site_name.
   */
  public static function get_site_title($db)
  {
    return Settings::get_site_name($db);
  } // end get_site_title();

}


?>
