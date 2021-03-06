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
  public $author_name;
  public $editors;
  public $created;
  public $modified;
  public $title;
  public $excerpt;
  public $content;
  public $status;
  public $type;
  public $tags;
  public $meta;
  public $thumb = RESPATH . 'images/default-placeholder-750x415.png';

  protected $db;
  protected $fetched_data;

  /**
   * Constructs a Post.
   * @param {Database} $db The data base holding the post data.
   * @param {integer} $id The id of the post.
   * @param {string} $type [Optional] Ensures that post of certain type before
   * construction.
   */
  function __construct($db, $id, $type = '')
  {
    $this->db = $db;
    $filters = (!empty($type))?
      array("where" => "post_id='{$id}' AND post_type='{$type}'") : array("where" => "post_id='{$id}'");
    $result = $db->select(POSTS_TABLE, null, $filters)[0];

    $this->id = (int)$result['post_id'];
    $this->name = $result['post_name'];
    $this->author = $result['post_author'];
    $this->author_name = User::get_display_name($db, $result['post_author']);
    $this->editors = $result['post_editors'];
    $this->created = $result['post_created'];
    $this->modified = $result['post_modified'];
    $this->title = $result['post_title'];
    $this->excerpt = $result['post_excerpt'];
    $this->content = $result['post_content'];
    $this->status = $result['post_status'];
    $this->type = $result['post_type'];
    $this->tags = $result['post_tags'];
    $this->meta = json_decode($result['post_meta'], true);
  } // __construct()

  /**
   * Updates the post table of the database.
   * @return {integer} Returns QUERY_EXEC_OK on success or QUERY_STMT_ERR on
   * failure.
   */
  public function save($data = array())
  {
    $db = $this->db;
    $columns = array();
    $values = array();

    # Bind data from data array

    # Update post table
    return $db->update(POSTS_TABLE, $columns, $values, array('where' => "post_id={$this->id}"));
  } // end save_draft()

  /**
   * Performs save and then writes changes to file.
   * @return {integer} Returns QUERY_EXEC_OK on success or QUERY_EXEC_ERR on
   * failure.
   */
  public function publish($data = array())
  {
    $db = $this->db;

    # Save the draft
    $this->save();

    # Do publishing

    return false;
  } // end publish()

  /**
   * Marks the post as trash.
   * @return {integer} Returns QUERY_EXEC_OK on success or QUERY_EXEC_ERR
   * on failure.
   */
  public function trash()
  {
    return $this->db->update(POSTS_TABLE, array('post_trash'), array(1), array('where' => "post_id={$this->id}"));
  } // end trash()

  /**
   * Deletes a post.
   * @param {Database} $db The database containing the post.
   * @param {integer} $id The post id.
   * @return {integer} Returns a status id of QUERY_EXEC_OK if successful or some
   * other error status code if failed.
   */
  public static function delete($db, $id)
  {
    return $db->delete(POSTS_TABLE, array("where" => "post_id='{$id}'"));
  } // end delete()

  /**
   * Returns an array of video posts given the specified filters.
   * @param {Database} $db The database to get the post from.
   * @param {array} $filters [Optional] The filters to apply to the pulled data.
   * @return {array} Returns an array of posts.
   */
  public static function get($db, $filters = null)
  {
    $columns = null;
    $where = "";
    $like = "";
    $distinct = "";

    if(empty($filters) || is_null($filters))
      return $db->select(POSTS_TABLE, null, array());

    if(array_key_exists('columns', $filters))
      $columns = $filters['columns'];

    return $db->select(POSTS_TABLE, $columns, $filters);
  } // end get()

  /**
   * Inserts a new post into the Database.
   * @param {Dataabse} $db The databases where the new post will be created.
   * @param {array} $data The new post's data as an associative array.
   * @return {boolean} Returns true if creation succeeded, otherwise returns false.
   */
  public static function create($db, $data = array())
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

      if($db->insert(POSTS_TABLE, $columns, $values) == QUERY_STMT_OK)
        return true;
    }
    return false;
  } // end create()

  /**
   * Returns an array containing a breakdown of the total number of posts by type.
   * @param {Database} $db The datase holding the posts.
   * @return {array} Returns an array containing post totals information or false if an error occured.
   */
  public static function get_totals($db)
  {
    $totals = true;

    $total_pages = $db->select(POSTS_TABLE, null, array('where' => "post_type='page'", 'count'));
    $total_articles = $db->select(POSTS_TABLE, null, array('where' => "post_type='article'", 'count'));
    $total_sermons = $db->select(POSTS_TABLE, null, array('where' => "post_type='sermon'", 'count'));
    $total_events = $db->select(POSTS_TABLE, null, array('where' => "post_type='event'", 'count'));
    $total_newsletters = $db->select(POSTS_TABLE, null, array('where' => "post_type='newsletter'", 'count'));
    $total_media = $db->select(POSTS_TABLE, null, array('where' => "post_type='media'", 'count'));
    $total_other = $db->select(POSTS_TABLE, null, array('where' => "post_type='other'", 'count'));

    $totals = array(
      'pages' => $total_pages,
      'articles' => $total_articles,
      'sermons' => $total_sermons,
      'events' => $total_events,
      'other' => $total_other
    );

    return $totals;
  } // end get_totals()
}


?>
