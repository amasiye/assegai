<?php

/**
 * Model class for user Groups.
 */
class Group
{

  /**
   * @param {Database} $db The database connection object.
   * @param {string} $group_name The name of the group.
   * @return {int} The group id or QUERY_EXEC_ERR upon failure.
   */
  public static function get_group_id($db, $group_name = 'User')
  {
    # Check if Admin was passed instead of Administrator
    if($group_name == 'Admin')
      $group_name = 'Administrator';

    # Get group details
    $result = $db->select('assg_groups', null, array("-w" => "group_name='{$group_name}'"))[0];

    # Return group id if one is found
    if(!is_null($result))
      return $result['group_id'];

    # Return false upon failure
    return QUERY_EXEC_ERR;
  } // end static function get_group_id()

  /**
   * Returns the name of a group given its group id.
   * @param {Database} $db The databse containing the group.
   * @param {int} $group_id The id of the group.
   * @return {string} The name of the group or QUERY_EXEC_ERR upon failure.
   */
  public static function get_group_name($db, $group_id)
  {
    # Get group details by group_id
    $result = $db->select('assg_groups', array('group_name'), array("-w" => "group_id='{$group_id}'"))[0];

    # Find and return group name
    if(!is_null($result))
      return $result['group_name'];

    return QUERY_EXEC_ERR;
  } // end get_group_name()

  /**
   * Returns an associative array of all group data from the given database.
   * @return {array} An associative array of all group data of given database or
   * QUERY_EXEC_ERR upon failure.
   */
  public static function get_groups($db)
  {
    # Get group details
    $result = $db->select('assg_groups', null);

    if(!is_null($result))
    {
      return $result;
    }

    return QUERY_EXEC_ERR;
  } // end static function get_groups()

} // end  Group

?>
