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
   */
  public function select($table, $columns, $options=array())
  {
    $sql = "SELECT";

    # Check for distinct option
    if(array_key_exists("-d", $options) || array_key_exists("DISTINCT", $options))
      $sql .= " DISTINCT";



    // echo $sql;
    echo 'Select method called but not yet implemented.';
  } // end select(string, string, string)

  /**
   * Inserts data into the database.
   */
  public function insert($table, $columns = array(), $values = array(), $filter)
  {
    $sql = "INSERT INTO {$table}";
    $param_type_list = "";

    if(!empty($columns))
    {
      $cols = implode(", ", $columns);
      $sql .= " ({$cols})";

      # Since we have columns we must ensure that
      # column array and values array are of equal size.
      if(count($columns) != count($values))
        return QUERY_STMT_PARAM_ERR;
    }

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

    echo $param_type_list . "<br>" . $sql;
    //
    // # Prepare and bind statement
    // $stmt = $this->conn->prepare($sql);
    // $stmt->bind()
    echo '<br>Insert method called but not yet implemented.';
  } // end insert()

  /**
   *
   */
  public function update()
  {
    echo 'Update method called but not yet implemented.';
  } // end update()

  public function delete()
  {
    echo 'Delete method called but not yet implemented.';
  } // end delete()

} // end Database

?>
