<?php
$user = $data['user'];
require_once "includes/admin-header.php";
?>
  <div class="container-fluid min-height-576">
    <div class="row content">

      <!-- Left Panel -->
      <div class="col-sm-2 sidenav">
        <?= App::get_ui_component($db, $user, 'nav-dashboard'); ?>
      </div>

      <!-- Right Panel -->
      <div class="col-sm-10">

          <div class="page-header">
            <h2>Site Analytics: <small><?= ucwords(SITE_NAME); ?></small>
              <a href="#btn-analyze" id="btn-analyze" class="btn btn-info pull-right">Analyze</a>
            </h2>
          </div>
          <div id='analytics-resutls' class="panel">
            <canvas id="canvas"></canvas>
          </div>

      </div><!--#end .col-sm-10 (Right Panel) -->

    </div><!--#end .row, .content -->
  </div>
  <script>
    var container = document.querySelector('.container');
    var minHeight = 576;
  </script>
<?php require_once "includes/admin-footer.php"; ?>
