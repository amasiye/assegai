<?php

/**
 * The Element class represents an object of a Page. This class
 * describes methods and properties common to all kinds of elements. Specific
 * behaviors are described in classes which inherit from Element but add
 * additional functionality.
 * @author Andrew Masiye
 * @version 1.0.0
 * @since 1.0.0
 */
class Element extends Post implements iNode
{

  private $parent = null;
  private $children = array();
  private $contents = "";

  public $classes = '';
  public $width;
  public $height;

  function __construct($db, $id)
  {
    parent::__construct($db, $id);
  } // end __construct

  /**
   * Adds the specified childNode argument as the last child to the current node.
   * If the argument referenced an existing node on the DOM gree, the node will
   * be detached from its current position and attached at the new position.
   */
  public function append_child($id)
  {
  } // end append_child()

  /**
   * Removes a child node from the current element, which must be a child of
   * the current node.
   * @param {int} $id The id of the node.
   */
  public function remove_child($id)
  {
  } // end remove_child()

  /**
   * Returns an array containing all the child nodes that belong to this node.
   * @return {int} Returns an array containing all the child nodes that belong
   * to this node.
   */
  public function get_children()
  {
    return $this->children;
  } // end get_children()

  /**
   * Sets the parent node of this node to the given node.
   * @param {Node} $node The new parent node.
   */
  public function set_parent($node)
  {
    $this->parent = $node;
  } // end set_parent()

  /**
   * Returns the parent node of this node or null if none exists.
   * @return {Node} Returns the parent node of this node or null if none exists.
   */
  public function get_parent()
  {
    return $this->parent;
  } // end get_parent()

  /**
   * Clone a Node, and optionally, all of its contents. By default, it clones
   * the content of the node.
   */
  public function clone_node()
  {
    
  } // end  clone_node()

  public static function create_html_element()
  {
    return HTML::create_html_element();
  } // end create_html_element()
}


?>
