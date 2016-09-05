<?php

/**
 * The database wrapper class. It contains methods to
 * quickly perform database operations. It also acts as
 * a layer of security using its sanitization methods to
 * ensure that data is properly escaped before storage
 * and data being extracted is appropriately unescaped.
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
    # Bind parameters to properties
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
   * @param $filters array An array of filters for the selection.
   * @return {array} An associative array of the selected data or an int
   * representing a status error.
   */
  public function select($table, $columns, $filters=array())
  {
    # Cache connection
    $conn = $this->conn;

    # Prepare SQL Query statement
    $sql = "SELECT";

    # Check for distinct option
    if(array_key_exists("-d", $filters))
      $sql .= " DISTINCT";

    # Append column names to $sql if any at all are found.
    if(empty($columns) || is_null($columns))
    {
      $sql .= ' *';
    }
    else
    {
      $sql .= " " . implode(", ", $columns);
    }

    # Append table name
    $sql .= " FROM {$table}";

    # Append any filters e.g LIMIT
    if(array_key_exists("-w", $filters))
      $sql .= " WHERE " . $filters['-w'];

    // echo $sql;
    # Run the query and report if something goes wrong
    if(!$result = $conn->query($sql))
    {
      return QUERY_EXEC_ERR;
    }

    # Fetch the selected rows and return them in an array
    $rows = array();
    while($row = $result->fetch_assoc())
    {
      array_push($rows, $row);
    }

    # If nothing was found insert a null character so that
    # an empty array is never returned.
    if(empty($rows))
      array_push($rows, null);

    return $rows;
  } // end select(string, string, string)

  /**
   * Inserts data into the database.
   * @param {string} $table The name of the table to be inserted.
   * @param {array} $column The list of columns to be inserted.
   * @param {array} $values The list of new values to update the corresponding columns with.
   * @return {int} An integer corresponding to the status code.
   */
  public function insert($table, $columns = array(), $values = array())
  {
    # Cache connection
    $conn = $this->conn;

    # Prepare SQL query statement
    $sql = "INSERT INTO {$table}";
    $param_type_list = "";

    # If columns are specified add them to sql query string
    if(!empty($columns) && !is_null($columns))
    {
      $cols = implode(", ", $columns);
      $sql .= " ({$cols})";

      # Since we have columns we must ensure that
      # column array and values array are of equal size.
      if(count($columns) != count($values))
        return QUERY_STMT_PARAM_ERR;
    }

    # Sanitize and append values to SQL query string
    $sql .= " VALUES (";
    for ($x = 0; $x < count($values); $x++)
    {
      # Enclose strings in single quotes
      if(gettype($values[$x]) == 'string')
        $sql .= "'" . sanitize($values[$x]) . "'";
      else
        $sql .= sanitize($values[$x]);

      # Add comma after each value except for last
      if($x < (count($values) - 1)) $sql .= ", ";
    }
    $sql .= ")";

    $insertion_result = "";

    # Execute SQL query and report any errors.
    if($conn->query($sql) === TRUE)
    {
      // echo "Successfully inserted new data into {$table}.";
      $insertion_result = QUERY_STMT_OK;
    }
    else
    {
      $insertion_result = QUERY_STMT_ERR;
      Debug::log_to_file("Error: " . $sql . PHP_EOL . $conn->error);
    }

    return $insertion_result;
  } // end insert()

  /**
   * Updates a table in the database.
   * @param {string} $table The name of the table to be updated.
   * @param {array} $column The list of columns to be updated.
   * @param {array} $values The list of new values to update the corresponding columns with.
   * @param $filters array An array of filters for the update.
   * @return {int} An int representing the operation status.
   */
  public function update($table, $columns = array(), $values = array(), $filters = array())
  {
    $conn = $this->conn;

    # Prepare SQL string
    $sql = "UPDATE {$table}";

    # Check for columns otherwise return error
    if(!isset($columns) || is_null($columns))
      return QUERY_STMT_PARAM_ERR;

    # Check for values othewise return error
    if(!isset($values) || is_null($values))
    return QUERY_STMT_PARAM_ERR;

    $sql .= " SET";

    # Append columns and value to SQL string
    for($x = 0; $x < count($columns); $x++)
      $sql .= " $columns[$x]='$values[$x]'";

    if(isset($filters) && !is_null($filters))
    {
      # Check if WHERE clause exists
      if(array_key_exists("-w", $filters))
      $sql .= " WHERE " . $filters['-w'];
    }

    # Run the query and report if something goes wrong
    if(!$result = $conn->query($sql))
    {
      return QUERY_EXEC_ERR;
    }

    return QUERY_EXEC_OK;
  } // end update()

  /**
   * Deletes a record from given table.
   * @param {string} $table The name of the table.
   * @param $filters array An array of filters for the deletion.
   * @return {array} An associative array of the selected data or an int
   * representing a status error.
   */
  public function delete($table, $filters)
  {
    $conn = $this->conn;

    # Check user credentials

    # Prepare SQL statement
    $sql = "DELETE FROM {$table}";

    # Check for WHERE clause
    if(!is_null($filters) && isset($filters))
    {
      if(array_key_exists('-w', $filters))
        $sql .= " WHERE {$filters['-w']}";
    }

    # Execute SQL query
    if($conn->query($sql) !== TRUE)
    {
      return QUERY_EXEC_ERR;
    }

    return QUERY_EXEC_OK;
  } // end delete()

  /**
   * Deletes a table from the database.
   * @param {string} $table The name of the table to destroy.
   * @return {int} An integer representing the status after the operation.
   */
  public function drop($table)
  {
    $sql = "DROP TABLE {$table}";

    return QUERY_EXEC_OK;
  } // end destroy_table

  /**
   * Deletes the data in a table and leaves the table itself.
   * @param {string} $table The name of the table to be truncated.
   * @return {int} An integer representing the status after the operation.
   */
  public function truncate($table)
  {
    $sql = "TRUNCATE TABLE {$table}";

    return QUERY_EXEC_OK;
  } // end truncate($table)

  /**
   * Sanitizes the given text for safe database storage.
   * @param {string} $txt The text to be sanitized.
   * @return {string} The sanitized string.
   */
  private function sanitize($txt)
  {
    return htmlentities(htmlspecialchars($txt), ENT_QUOTES);
  } // end sanitize($txt)

  /**
   * Reverse string sanitization for given text.
   * @param {string} $txt The text to be desanitized.
   * @return {string} The desanitized string.
   */
  private function desanitize($txt)
  {
    return htmlspecialchars_decode(html_entity_decode($txt));
  } // end desanitize($txt)

} // end Database

?>
