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

    // echo $db_host . " " . $db_user . " " . $db_pass . " " . $db_name;

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
   * @return {array} An associative array of the selected data or an int
   * representing a status error.
   */
  public function select($table, $columns, $options=array())
  {
    # Cache connection
    $conn = $this->conn;

    # Prepare SQL Query statement
    $sql = "SELECT";

    # Check for distinct option
    if(array_key_exists("-d", $options))
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
    if(array_key_exists("-w", $options))
      $sql .= " WHERE " . $options['-w'];

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

    if(empty($rows))
      array_push($rows, null);

    return $rows;
  } // end select(string, string, string)

  /**
   * Inserts data into the database.
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

    # For the time being we will use the straight forward
    # MySQLi query method. Eventually prepared statements must
    # used as they are more secure and are more effecient when
    # executing the same statement with high frequencey

    /*
    $num_values = count($values);
    $values_token = '?';
    if($num_values > 1)
      for ($i=0; $i < $num_values; $i++)
      {
        # Get value type and add it to parameter_type argument string
        $param_type_list .= substr(gettype($values[$i]), 0, 1);

        # If the index is 0, skip this iteration since we already
        # have a '?' for index 0.
        if($i > 0)
          $values_token .= ', ?';
      }

    $sql .= " VALUES ({$values_token})";

    # Prepare and bind statement
    $stmt = $this->conn->prepare($sql);
    echo $param_type_list . "<br>" . $sql;
    $stmt->bind()
    */

    // $sql .= " VALUES (" . implode(", ", $values) . ")";
    $sql .= " VALUES (";
    for ($x = 0; $x < count($values); $x++)
    {
      # Enclose strings in single quotes
      if(gettype($values[$x]) == 'string')
        $sql .= "'" . $values[$x] . "'";
      else
        $sql .= $values[$x];

      # Add comma after each value except for last
      if($x < (count($values) - 1)) $sql .= ", ";
    }
    $sql .= ")";

    $insertion_result = "";

    // if($conn->query($sql) === TRUE)
    // {
    //   // echo "Successfully inserted new data into {$table}.";
    //   $insertion_result = QUERY_STMT_OK;
    // }
    // else
    // {
    //   $insertion_result = QUERY_STMT_ERR;
    //   Debug::log_to_file("Error: " . $sql . PHP_EOL . $conn->error);
    // }

    echo $sql;

    return $insertion_result;
  } // end insert()

  /**
   * Updates a table in the database.
   */
  public function update()
  {
    echo 'Update method called but not yet implemented.';
  } // end update()

  /**
   * Deletes a record from given table.
   * @param {string} $table The name of the table.
   * @param {string} $fileter The filter data i.e options.
   */
  public function delete($table, $filter)
  {
    echo 'Delete method called but not yet implemented.';
  } // end delete()

} // end Database

?>
