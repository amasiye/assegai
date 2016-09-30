<?php

/**
 * This class provides a structured representation of the Site settings data.
 * It provides methods for retrieving and updating various site settings.
 */
class Settings
{
  /**
   * Returns the value of the setting of given name.
   * @param {Database} $db The database holding the settings data.
   * @param {string} $setting_name The name of the setting.
   * @return {string} Returns teh value of the given setting or
   * SETTINGS_REQUEST_ERR on failure.
   */
  public static function get($db, $setting_name)
  {
    $prefix =
    switch($setting_name)
    {
      case 'name':
      case 'tagline':
      case 'description':
      case 'keywords':
      case 'owner':
      case 'url':
      case 'status':
      case 'cookie_notification':
        $option = new Option($db, Option::get_id($db, 'site_' . $setting_name));
        return $option->value();
        break;

      case 'date_format':
      case 'time_format':
      case 'timezone':
        break;

      default:
        return SETTINGS_REQUEST_ERR;
    }
  } // end get()

  public static function set($db, $name, $value)
  {

  } // end set()

} // end Settings

?>
