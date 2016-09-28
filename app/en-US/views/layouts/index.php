<?php
$user = $data['user'];
$layouts = $data['layouts'];

require_once "includes/admin-header.php";
?>
  <div class="container-fluid min-height-576">
    <div class="row content">

      <!-- Left Panel -->
      <div class="col-sm-2 sidenav">
        <?= App::get_ui_component($db, $user, 'nav-layouts', array('layouts' => $layouts)); ?>
      </div>

      <!-- Right Panel -->
      <div id="stage" class="col-sm-10">


      </div><!--#end col-sm-10 (right panel) -->

    </div><!--#end .row, .content -->

  </div>
<?php require_once "includes/admin-footer.php"; ?>
