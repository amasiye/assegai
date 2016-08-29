<?php

/**
 * Model class for user Groups.
 */
class Group
{

  /**
   * @param {Database} $db The database connection object.
   * @param {string} $group_name The name of the group.
   * @return {int} The group id or -1 upon failure
   */
  public static function get_group_id($db, $group_name = 'User')
  {
    # Check if Admin was passed instead of Administrator
    if($group_name == 'Admin')
      $group_name = 'Administrator';

    # Get group details
    $result = $db->select('assg_groups', null, array("-w" => "group_name='{$group_name}'"))[0];

    # Return group id if one is found
    if(!is_null($result) )
      return $result['group_id'];

    # Return false upon failure
    return -1;
  } // end static function get()

} // end  Group

?>
