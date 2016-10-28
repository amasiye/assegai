<?php
/**
 * This class provides a structured representation of Option data from the
 * assegai database. It provides methods for retrieving and/or manipulating
 * options data from the database.
 */
class Option
{
  private $id;
  private $name;
  private $value;
  private $autoload;
  private $db;

  function __construct($db, $id)
  {
    $this->db = $db;
    $result = $db->select(OPTIONS_TABLE, null, array('where' => "option_id={$id}"))[0];
    $this->id = $result['option_id'];
    $this->name = $result['option_name'];
    $this->value = $result['option_value'];
    $this->autoload = $result['option_autoload'];
  } // end __construct()

  /**
   * Returns the id of the option.
   * @return {integer} Returns the id of the option.
   */
  public function id()
  {
    return $this->id;
  } // end get_id()

 /**
  * Gets or sets the name of the an option.
  * @param {string} $new_name The new name of the option.
  * @return {string} Returns the name of the option or its new name if new name
  * is specified.
  */
  public function name($new_name = '')
  {
    if(
        !empty($new_name) &&
        (
          $this->db->update(
                              OPTIONS_TABLE,
                              array('option_name'),
                              array($new_name),
                              array('where' => "option_id={$this->option_id}")
                            )
        )
      )
      return $new_name;

    return $this->name;
  } // end name()

  /**
   * Gets or sets the value of the an option.
   * @param {string} $new_value The new value of the option.
   * @return {string} Returns the value of the option or its new name if new name
   * is specified.
   */
  public function value($new_value = '')
  {
    if(
        !empty($new_value) &&
        (
          $this->db->update(
                              OPTIONS_TABLE,
                              array('option_value'),
                              array($new_value),
                              array('where' => "option_id={$this->id}")
                            )
        )
      )
      return $new_value;

    return $this->value;
  } // end value()

  /**
   * Gets or sets whether the option will be autoloaded.
   * @param {string} $new_autoload The new value of the option.
   * @return {string} Returns the value of autoloaded property of the option.
   */
  public function autoload($new_autoload)
  {
    if(
        !empty($new_value) &&
        (
          $this->db->update(
                              OPTIONS_TABLE,
                              array('option_value'),
                              array($new_value),
                              array('where' => "option_id={$this->id}")
                            )
        )
      )
      return $new_value;

    return $this->value;
  } // end autoload

  /**
   * Creates an option of given name from the given database.
   * @param {Database} $db The database containing the options data.
   * @param {string} $name The name of the option to be created.
   * @param {string} $autoload [Optional] Autoload this option: yes or no.
   * @return {integer} Returns QUERY_EXEC_OK upon success or
   * QUERY_EXEC_ERR on failure.
   */
  public static function create($db, $name, $value, $autoload = 'yes')
  {
    return $db->insert(
                        OPTIONS_TABLE,
                        array(
                              'option_name',
                              'option_value',
                              'option_autoload'
                            ),
                        array(
                              $name,
                              $value,
                              $autoload
                            )
                      );
  } // end create()

  /**
   * Deletes an option of given name from the given database.
   * @param {Database} $db The database containing the options data.
   * @param {string} $name The name of the option to be deleted.
   * @param {integer} Returns QUERY_EXEC_OK upon success or QUERY_EXEC_ERR on failure.
   */
  public static function delete($db, $name)
  {
    return $db->delete(OPTIONS_TABLE, array('where' => "option_name='{$name}'"));
  } // end delet()

  /**
   * Returns the id of an option of given name from the database.
   * @param {name} $name The name of the option.
   * @return {integer} Returns the id of the option of given name or null
   * QUERY_EXEC_ERR on failure.
   */
  public static function get_option_id($db, $name)
  {
    return (int)$db->select(OPTIONS_TABLE, array('option_id'), array('where' => "option_name='{$name}'"))[0]['option_id'];
  } // end get_option_id()

  /**
   * An alias of get_option_id.
   */
  public static function get_id($db, $name)
  {
    return intval(Option::get_option_id($db, $name));
  } // end get_id()

}


?>
