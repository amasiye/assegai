<?php
$user = $data['user'];
$layout = $data['layout'];

require_once "includes/admin-header.php";
?>
  <div class="container-fluid min-height-576">
    <div class="row content">

      <!-- Left Panel -->
      <div class="col-sm-2 sidenav">
        <?= App::get_ui_component($db, $user, 'nav-layouts/edit'); ?>
      </div>

      <!-- Right Panel -->
      <div id="stage" class="col-sm-10">

        <div class="frame editor-frame"><?= $layout->content; ?></div>

      </div><!--#end col-sm-10 (right panel) -->

    </div><!--#end .row, .content -->

  </div>
  <script>
    var container = document.querySelector('.container');
    var minHeight = 576;
    var newTitle = '<?= $layout->title; ?>';
    document.title = "Assegai Layout Editor: " + newTitle;
  </script>
<?php require_once "includes/admin-footer.php"; ?>
