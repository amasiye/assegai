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
    $prefix = 'site_';
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
        $option = new Option($db, Option::get_id($db, 'default_' . $setting_name));
        return $option->value();
        break;

      default:
        return SETTINGS_REQUEST_ERR;
    }
  } // end get()

  /**
   * Sets the value of the settings of given name.
   * @param {Database} $db The database holding the settings data.
   * @param {string} $setting_name The name of the settings.
   * @param {sring} $value The new value.
   * @return Returns SETTINGS_UPDATE_OK upon success or SETTINGS_UPDATE_ERR
   * on failure.
   */
  public static function set($db, $setting_name, $value)
  {
    $prefix = 'site_';

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
        $option = new Option($db, Option::get_id($db, $prefix . $setting_name));
        if($option->value($value) == $value)
          return SETTINGS_UPDATE_OK;
        break;

      case 'date_format':
      case 'time_format':
      case 'timezone':
        $option = new Option($db, Option::get_id($db, 'default_' . $setting_name));
        if($option->value($value) == $value)
          return SETTINGS_UPDATE_OK;
        break;

      default:
        return SETTINGS_UPDATE_ERR;
    }

    return SETTINGS_UPDATE_ERR;
  } // end set()

  /**
   * Creates a setting of given name from the given database.
   * @param {Database} $db The database containing the settings data.
   * @param {string} $name The name of the setting to be created.
   * @param {string} $autoload [Optional] Autoload this setting: yes or no.
   * @return {integer} Returns QUERY_EXEC_OK upon success or
   * QUERY_EXEC_ERR on failure.
   */
  public static function create($db, $name, $value, $autoload = 'yes')
  {
    return Option::create($db, 'setting_' . $name, $value);
  } // end create()

  /**
   * Deletes an setting of given name from the given database.
   * @param {Database} $db The database containing the settings data.
   * @param {string} $name The name of the setting to be deleted.
   * @param {integer} Returns QUERY_EXEC_OK upon success or QUERY_EXEC_ERR on failure.
   */
  public static function delete($db, $name)
  {
    return Option::delete($db, $name);
  } // end create()

} // end Settings

?>
