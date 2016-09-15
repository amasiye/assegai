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
  } // end static get_groups()

  /**
   * Returns an array of all the group names in the given database.
   * @param {Database} $db The database containing the group names.
   * @return {array} Returns an array of all groups names given database or an empty array.
   */
  public static function get_group_names($db)
  {
    $groups = Group::get_groups($db);
    $group_names = array();

    foreach ($groups as $group)
    {
      array_push($group_names, $group['group_name']);
    }
    return $group_names;
  } // end static get_group_names()

  /**
   * Returns the number of users that belong to a given group.
   * @param {Database} $db The database containing the data.
   * @param {int} $group The group id or name. If an integer is passed, group id
   * is assumed whereas if a string is passed group name is assumed.
   * @return {int} The number of users beloning to the given group.
   */
  public static function get_num_members($db, $group)
  {
    $id = 1;

    if(is_integer($group))
      $id = $group;

    if(is_string($group))
      $id = Group::get_group_id($db, $group);

    return $db->select('assg_users', null, array("where" => "user_group='{$id}'", "count"));
  } // end get_num_members()

} // end  Group

?>
