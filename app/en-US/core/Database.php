<?php

/**
 * The database wrapper class. It contains methods to
 * quickly perform database operations. It also acts as
 * a layer of security using its sanitization methods to
 * ensure that data is properly escaped before storage
 * and data being extracted is appropriately unescaped.
 *
 * @version 1.0.0
 * @since 1.0.0
 *
 * @package Assegai
 */
class Database
{
  private $conn;
  private $mysqli;
  private $host;
  private $user;
  private $password;
  private $name;

  public $execution_errors = array();

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
   * Performs a query on the database.
   * @param {string} $query The query string. Data inside the query should be properly escaped.
   * @param {int} $result_mode Either the constant MYSQLI_USE_RESULT or
   * MYSQLI_STORE_RESULT depending on the desired behavior. By default,
   * MYSQLI_STORE_RESULT is used.
   */
  public function query($query, $result_mode = MYSQLI_STORE_RESULT)
  {
    $conn = $this->conn;
    return $conn->query($query, $result_mode);
  } // end query()

  /**
   * Selects data from the database.
   * @param $table String name of the table to make the selection from.
   * @param $columns String A comma seperated list of column names to select.
   * @param $filters array An array of filters for the selection.
   * @return {array} An associative array of the selected data or an int
   * representing a status error.
   */
  public function select($table, $columns = null, $filters=array())
  {
    # Cache connection
    $conn = $this->conn;

    # Prepare SQL Query statement
    $sql = "SELECT";
    # Check for distinct option
    $distinct_is_set = false;
    if(array_key_exists("distinct", $filters))
    {
      $sql .= " DISTINCT";
      $distinct_is_set = true;
    }

    # Check for distinct option
    if(array_key_exists("-d", $filters) && $distinct_is_set == true)
      $sql .= " DISTINCT";

    # Append column names to $sql if any at all are found.
    if(empty($columns) || is_null($columns))
    {
      $sql .= " *";
    }
    else
    {
      $sql .= " " . implode(", ", $columns);
    }

    # Append table name
    $sql .= " FROM {$table}";

    # Append any filters e.g LIMIT
    $where_is_set = false;
    if(array_key_exists("where", $filters))
    {
      $sql .= " WHERE " . $filters['where'];
      $where_is_set = true;
    }

    # Handle where filter
    if(array_key_exists("-w", $filters) && $where_is_set == false)
      $sql .= " WHERE " . $filters['-w'];

    # Handle like filter
    if(array_key_exists("like", $filters))
      $sql .= " LIKE '" . $filters['like'] . "'";

    # Handle join filter
    if(array_key_exists("join", $filters))
      $sql .= " JOIN " . $filters['join'];

    # Handle order filter
    if(array_key_exists("order", $filters))
      $sql .= " ORDER BY " . $filters['order'];

    # Handle limit filter
    if(array_key_exists("limit", $filters))
      $sql .= " LIMIT " . $filters['limit'];

    # Handle offset filter
    if(array_key_exists("offset", $filters))
      $sql .= " OFFSET " . $filters['offset'];

    // echo $sql;
    # Run the query and report if something goes wrong
    if(!$result = $conn->query($sql))
    {
      // return array($conn->error_list);
      return QUERY_EXEC_ERR;
    }

    # Fetch the selected rows and return them in an array
    $rows = array();
    while($row = $result->fetch_assoc())
    {
      foreach ($row as $key => $value)
      {
        $row[$key] = $this->desanitize($value);
      }
      array_push($rows, $row);
    }

    # If nothing was found insert a null character so that
    # an empty array is never returned.
    if(empty($rows))
    {
      array_push($rows, null);
      if(array_key_exists("count", $filters) || in_array("count", $filters))
        return 0;
    }

    if(array_key_exists("count", $filters) || in_array("count", $filters))
      return count($rows);

    return $rows;
  } // end select()

  /**
   * Inserts new records in a table..
   * @param {string} $table The name of the table.
   * @param {array} $columns The list of column names to be inserted.
   * @param {array} $values The list of values to be inserted into the corresponding values.
   * @return {int} An integer corresponding to a status code.
   */
  public function insert($table, $columns = array(), $values = array(), $sanitize = true)
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
      if($sanitize == false)
      {
        # Enclose strings in single quotes
        if(gettype($values[$x]) == 'string')
          $sql .= "'" . $values[$x] . "'";
        else
          $sql .= $values[$x];
      }
      else
      {
        # Enclose strings in single quotes
        if(gettype($values[$x]) == 'string')
          $sql .= "'" . $this->sanitize($values[$x]) . "'";
        else
          $sql .= $this->sanitize($values[$x]);
      }

      # Add comma after each value except for last
      if($x < (count($values) - 1)) $sql .= ", ";
    }
    $sql .= ")";

    $insertion_result = "";

    # Execute SQL query and report any errors.
    if($conn->query($sql) === TRUE)
    {
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
   * @param {array} $values The list of new values to update the corresponding
   * columns with.
   * @param $filters array An array of filters for the update.
   * @return {integer} Returns QUERY_EXEC_OK upon successful update or
   * QUERY_EXEC_ERR on failure.
   */
  public function update($table, $columns = array(), $values = array(), $filters = array())
  {
    $conn = $this->conn;

    # Prepare SQL string
    $sql = "UPDATE {$table}";

    # Check for columns otherwise return error
    if(empty($columns) || is_null($columns))
      return QUERY_STMT_PARAM_ERR;

    # Check for values othewise return error
    if(empty($values) || is_null($values))
      return QUERY_STMT_PARAM_ERR;

    $sql .= " SET";

    # Append columns and value to SQL string
    for($x = 0; $x < count($columns); $x++)
    {
      if(array_key_exists("santize", $filters) && $filters['sanitize'] == false)
      {
        if($x == 0)
          $sql .= " {$columns[$x]}='{$values[$x]}'";
        else
          $sql .= ",{$columns[$x]}='{$values[$x]}'";
      }
      else
      {
        if($x == 0)
          $sql .= " $columns[$x]='" . $this->sanitize($values[$x]) . "'";
        else
          $sql .= ",$columns[$x]='" . $this->sanitize($values[$x]) . "'";
      }
    }

    if(isset($filters) && !is_null($filters))
    {
      $where_flag = false;

      # Check if WHERE clause exists
      if(array_key_exists("-w", $filters))
      {
        $sql .= " WHERE " . $filters['-w'];
        $where_flag = true;
      }

      if(array_key_exists("where", $filters) && $where_flag == false)
      {
        $sql .= " WHERE " . $filters['where'];
        $where_flag = true;
      }

      # If the where flag is not set check for unlock flag
      if($where_flag == false && (!array_key_exists('unlock', $filters) && !in_array('unlock', $filters)))
        /* Return to prevent all specified columns in table from being overwritten */
        return UPDATE_ERR_ILLEGAL;
    }
    else
    {

    }

    # Run the query and report if something goes wrong
    if(!$conn->query($sql))
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
    $where_flag = false;

    # Check user credentials

    # Prepare SQL statement
    $sql = "DELETE FROM {$table}";

    # Check for WHERE clause
    if(is_null($filters) && !isset($filters))
    {
      return DELETE_ERR;
    }

    if(array_key_exists('where', $filters))
    {
      $where_flag = true;
      $sql .= " WHERE {$filters['where']}";
    }

    if(array_key_exists('-w', $filters) && !$where_flag)
    {
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
