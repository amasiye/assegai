<?php
define('CATEGORY_TABLE', 'assg_categories');

/**
 * This class provides a structured representation of all Categories.
 * It defines methods that allow access to these categories allowing
 * for easier translation between category names and ids.
 */
class Category
{
  private $id;
  private $name;
  private $info;
  private $db;

  /**
   * Constructs a category of given name.
   * @param {Database} $db The database containing the category data.
   * @param {string} $name The name of the category.
   */
  function __construct($db, $name)
  {
    $this->db = $db;
    # Check if this category is already in the database
    if(!empty($result = $db->select('assg_categories', null, array('where' => "category_name='{$name}'"))[0]))
    {
      # If found bind data
      $this->id = $result['category_id'];
      $this->name = $result['category_name'];
      $this->info = $result['category_info'];
    }
    else
    {
      # If not found then create a new category and bind the data.
      $this->create($db, $name);
      $new_result = $db->select('assg_categories', null, array('where' => "category_name='{$name}'"))[0];
      $this->id = $new_result['category_id'];
      $this->name = $new_result['category_name'];
      $this->info = $new_result['category_info'];
    }
  } // end __construct()

  /**
   * Returns the id of the category.
   * @return {int} Returns QUERY_EXEC_OK upon successful update or
   * QUERY_EXEC_ERR on failure.
   */
  public function get_id($name = '')
  {
    return $this->id;
  } // end get_id()

  /**
   * Returns the name of the category.
   * @return {int} Returns QUERY_EXEC_OK upon successful update or
   * QUERY_EXEC_ERR on failure.
   */
  public function get_name()
  {
    return $this->name;
  } // end get_name();

  /**
   * Returns the category's info.
   * @return {int} Returns QUERY_EXEC_OK upon successful update or
   * QUERY_EXEC_ERR on failure.
   */
  public function get_info()
  {
    return $this->info;
  } // end get_info()

  /**
   * Updates the name of the category.
   * @param {sting} $name The new category name.
   * @return {int} Returns QUERY_EXEC_OK upon successful update or
   * QUERY_EXEC_ERR on failure.
   */
  public function set_name($name)
  {
    return $this->db->update(
                      'assg_categories',
                      array('category_name'),
                      array($name),
                      array('where' => "category_id={$this->category_id}")
                    );
  } // end set_name();

  /**
   * Updates the category's information column.
   * @param {sting} $info The new category information.
   * @return {int} Returns QUERY_EXEC_OK upon successful update or
   * QUERY_EXEC_ERR on failure.
   */
  public function set_info($info)
  {
    return $this->db->update(
                                'assg_categories',
                                array('category_info'),
                                array($info),
                                array('where' => "category_id={$this->get_id()}")
                              );
  } // end set_info()

  /**
   * Creates a new category.
   * @param {Database} $db The database containing the category data.
   * @param {string} $name The name of the category.
   * @param {string} $info The info about the category.
   * @return {string} Returns true upon successful creatino or false otherwise.
   */
  private function create($db, $name, $info = "")
  {
    return $db->insert(
                        CATEGORY_TABLE,
                        array('category_name', 'category_info'),
                        array($name, $info)
                      );
  } // end create()

  /**
   * Deletes the category of given name from the database.
   * @param {Database} $db The database containing the category data.
   * @param {string} $name The name of the category.
   * @return {string} Returns true upon successful deletion or false otherwise.
   */
  public static function delete($db, $name)
  {
    return $db->delete(
                        CATEGORY_TABLE,
                        array("where" => "category_name='{$name}'")
                      );
  } // end delete();

  /**
   * Returns the id of the category of given name.
   * @param {Database} $db The database containing the category data.
   * @param {string} $name The name of the category.
   * @return {int} Returns a int representing the id of the category or
   * QUERY_EXEC_ERR on failure.
   */
  public static function id($db, $name)
  {
    return $db->select(CATEGORY_TABLE, array('category_id'), array('where' => "category_name='{$name}'"))[0]['category_id'];
  } // end id()

  /**
   * Returns the name of the category of given id.
   * @param {Database} $db The database containing the category data.
   * @param {int} $id The id of the category.
   * @return {string} Returns a string representing the name of the category or
   * QUERY_EXEC_ERR on failure.
   */
  public static function name($db, $id)
  {
    return $db->select(CATEGORY_TABLE, array('category_name'), array('where' => "category_id={$id}"))[0]['category_name'];
  } // end name()
} // end Category


?>
