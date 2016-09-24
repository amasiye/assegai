<?php
$user = $data['user'];
require_once "includes/admin-header.php";
?>
  <div class="container-fluid min-height-576">
    <div class="row content">

      <!-- Left Panel -->
      <div class="col-sm-2 sidenav">
        <?= App::get_ui_component($db, $user, 'pages'); ?>
      </div>

      <!-- Right Panel -->
      <div class="col-sm-10">

        <h2>Pages: <?= ucwords($user->display_name); ?></h2>
        <div class="col-md-4">
          <div class="well well-lg">
            <a href="admin/edit/">
              <div class="jumbotron"></div>
              <h4>Edit Site</h4>
            </a>
          </div>
        </div>

      </div>
    </div>
  </div>

<?php require_once "includes/admin-footer.php"; ?>
