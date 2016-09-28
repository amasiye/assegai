<?php
$user = $data['user'];
$settings = $data['settings'];
require_once "includes/admin-header.php";
?>
  <div class="container-fluid min-height-576">
    <div class="row content">

      <!-- Left Panel -->
      <div class="col-sm-2 sidenav">
        <?= App::get_ui_component($db, $user, 'nav-settings'); ?>
      </div>

      <!-- Right Panel -->
      <div class="col-sm-10">

          <div class="page-header">
            <h2>Site Settings: <small><?= ucwords(SITE_NAME); ?></small></h2>
          </div>
          <table class="table table-bordered">
            <tr>
              <th></th>
            </tr>
          </table>

      </div><!--#end .col-sm-10 (Right Panel) -->

    </div><!--#end .row, .content -->
  </div>
  <script>
    var container = document.querySelector('.container');
    var minHeight = 576;
  </script>
<?php require_once "includes/admin-footer.php"; ?>
