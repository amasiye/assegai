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
   * Updates the post.
   */
  public function save_draft()
  {

  } // end save_draft()

  /**
   * Saves the draft and writes the changes to file.
   */
  public function publish()
  {

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
}


?>
