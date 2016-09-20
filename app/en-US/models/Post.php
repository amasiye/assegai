<?php

/**
 * The base class of all post model. Handles business logic
 * and abstracts the persistent storage classe(s) and models.
 */
class Post
{
  public $id;
  public $name;
  public $author;
  public $editors;
  public $created;
  public $modified;
  public $content;
  public $type;
  public $tags;
  public $meta;

  protected $db;
  protected $fetched_data;

  function __construct($db, $id)
  {
    $this->db = $db;
    $result = $db->select('assg_posts', null, array("where" => "post_id='$id'"))[0];

    $this->id = $result['post_id'];
    $name = $result['post_name'];
    $author = $result['post_author'];
    $editors = $result['post_editors'];
    $created = $result['post_created'];
    $modified = $result['post_modified'];
    $content = $result['post_content'];
    $type = $result['post_type'];
    $tags = $result['post_tags'];
    $meta = $result['post_meta'];
  } // __construct()

  /**
   * Updates the post without publishing.
   */
  public function save_draft($data = array())
  {
    return false;
  } // end save_draft()

  /**
   * Saves the draft and writes the changes to file.
   */
  public function publish()
  {
    # Save the draft
    $this->save_draft();

    # Do publishing

  } // end publish()

  /**
   * Deletes a post.
   * @param {Database} $db The database containing the post.
   * @param {int} $id The post id.
   * @return {int} Returns a status id of QUERY_EXEC_OK if successful or some
   * other error status code if failed.
   */
  public static function delete($db, $id)
  {
    return $db->delete('assg_posts', array("where" => "post_id='{$id}'"));
  } // end delete()

  /**
   * Returns an array of video posts given the specified filters.
   * @param {Database} $db The database to make the pull from.
   * @param {array} $filters [Optional] The filters to apply to the pulled data.
   * @return {array} Returns an array of posts.
   */
  public static function pull($db, $filters = null)
  {
    $columns = null;
    $where = "";
    $like = "";
    $distinct = "";

    if(empty($filters) || is_null($filters))
      return $db->select('assg_posts', null, array('where' => "post_type='{$this->type}'"));

    if(array_key_exists('columns', $filters))
      $columns = $filters['columns'];

    return $db->select('assg_posts', $columns, $filters);
  } // end pull()

  /**
   * Inserts a new post into the Database.
   * @param {Dataabse} $db The databases to make the push to.
   * @param {array} $data The new post's data as an associative array.
   * @return {boolean} Returns true if push was successful, otherwise returns false.
   */
  public static function push($db, $data = array())
  {
    $columns = array();
    $values = array();

    if(!empty($data) && !is_null($data))
    {
      foreach ($data as $col => $val)
      {
        array_push($columns, $col);
        array_push($values, $val);
      }

      if($db->insert('assg_posts', $columns, $values) == QUERY_STMT_OK)
        return true;
    }
    return false;
  } // end pull()
}


?>
