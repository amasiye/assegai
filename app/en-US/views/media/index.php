<?php
$user = $data['user'];
$media = $data['media'];

require_once "includes/admin-header.php";
?>
  <div class="container-fluid min-height-576">
    <div class="row content">

      <!-- Left Panel -->
      <div class="col-sm-2 sidenav">
        <?= App::get_ui_component($user, 'dashboard'); ?>
      </div>

      <!-- Right Panel -->
      <div class="col-sm-10">

        <!-- Page Header -->
        <div class="page-header">
          <h2>Media: <small><?= ucwords(SITE_NAME); ?></small>
            <a href="#" class="pull-right"><span class="glyphicon glyphicon-plus-sign"></span></a>
          </h2>
        </div>

        <!-- Toolbar -->

        <!-- Media Items -->
        <table class="table table-bordered">
          <tr>
            <th>
              <input type="checkbox" name="media-select-all" id="media-select-all-top">
            </th>
            <th>File</th>
            <th>Author</th>
            <th><span class="glyphicon glyphicon-comment"></span></th>
          </tr>

          <tr>

          </tr>

          <tr>
            <th>
              <input type="checkbox" name="media-select-all" id="media-select-all-bottom">
            </th>
            <th>File</th>
            <th>Author</th>
            <th><span class="glyphicon glyphicon-comment"></span></th>
          </tr>
        </table>

      </div><!--#end col-sm-10 (right panel) -->

    </div><!--#end .row, .content -->

  </div>
  <script>
    var container = document.querySelector('.container');
    var minHeight = 576;
  </script>
<?php require_once "includes/admin-footer.php"; ?>
