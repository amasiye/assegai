<?php
$user = $data['user'];
$page = $data['page'];

require_once "includes/admin-header.php";
?>
  <div class="container-fluid min-height-576">
    <div class="row content">

      <!-- Left Panel -->
      <div class="col-sm-2 sidenav">
        <?= App::get_ui_component($db, $user, 'nav-pages/edit'); ?>
      </div>

      <!-- Right Panel -->
      <div id="stage" class="col-sm-10">

        <!-- Page Header -->
        <div class="page-header">
          <h2>Page Edit: <small><?= $page->title; ?></small></h2>
        </div>

        <div><?= $page->content; ?></div>

      </div><!--#end col-sm-10 (right panel) -->

    </div><!--#end .row, .content -->

  </div>
  <script>
    var container = document.querySelector('.container');
    var minHeight = 576;
    var newTitle = '<?= $page->title; ?>';
    document.title = "Page Edit: " + newTitle;
  </script>
<?php require_once "includes/admin-footer.php"; ?>
