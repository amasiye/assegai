<?php

/**
 * The database wrapper class. It contains methods to
 * quickly perform database operations.
 */
class Database
{
  private $conn;
  private $mysqli;
  private $host;
  private $user;
  private $password;
  private $name;

  public $instance;

  /**
   * Constructs a Database object.
   */
  function __construct($db_host, $db_user, $db_pass, $db_name)
  {
    $this->host = $db_host;
    $this->user = $db_user;
    $this->password = $db_pass;
    $this->name = $db_name;

    $this->mysqli =
      new mysqli($this->host, $this->user, $this->password, $this->name);

    $this->conn = $this->mysqli;

    # Create singleton
    $instance = $this;
  } // end __construct()

  /**
   * Selects data from the database.
   * @param $table String name of the table to make the selection from.
   * @param $columns String A comma seperated list of column names to select.
   * @param $options array An array of options for the selection.
   */
  public function select($table, $columns, $options=array())
  {
    $sql = "SELECT";

    # Check for distinct option
    if(array_key_exists("-d", $options) || array_key_exists("DISTINCT", $options))
      $sql .= " DISTINCT";



    echo $sql;
  } // end select(string, string, string)

  /**
   * Inserts data into the database.
   */
  public function insert($table, $columns, $values, $filter)
  {

  } // end insert()

  /**
   *
   */
  public function update()
  {

  } // end update()

  public function delete()
  {

  } // end delete()

} // end Database

?>
