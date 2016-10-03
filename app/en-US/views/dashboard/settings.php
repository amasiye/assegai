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
            <h2>Site Settings: <small><?= ucwords(SITE_NAME); ?></small>
              <?php if ($user->has_permission('edit','settings')): ?>
                <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#edit-settings-modal">Edit</button>
              <?php endif; ?>
            </h2>
          </div>

          <form class="form-horizontal" role="form">

            <!-- Site Address -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="site-url">Site Adress:</label>
              <div class="col-sm-10">
                <p class="form-control-static"><?= Settings::get($db, 'url'); ?></p>
              </div>
            </div>

            <!-- Site Title -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="site-url">Site Title:</label>
              <div class="col-sm-10">
                <p class="form-control-static"><?= Settings::get($db, 'name'); ?></p>
              </div>
            </div>

            <!-- Site Tagline -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="site-url">Site Tagline:</label>
              <div class="col-sm-10">
                <p class="form-control-static"><?= Settings::get($db, 'url'); ?></p>
              </div>
            </div>

            <!-- Site Description -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="site-url">Site Description:</label>
              <div class="col-sm-10">
                <p class="form-control-static"><?= Settings::get($db, 'description'); ?></p>
              </div>
            </div>

            <!-- Keywords -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="site-url">Site Keywords:</label>
              <div class="col-sm-10">
                <p class="form-control-static"><?= Settings::get($db, 'keywords'); ?></p>
              </div>
            </div>

            <!-- Owner -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="site-url">Site Owner:</label>
              <div class="col-sm-10">
                <p class="form-control-static"><?= Settings::get($db, 'owner'); ?></p>
              </div>
            </div>

            <!-- Default Date Format -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="site-url">Default Date Format:</label>
              <div class="col-sm-10">
                <p class="form-control-static"><?= Settings::get($db, 'date_format'); ?></p>
              </div>
            </div>

            <!-- Default Time Format -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="site-url">Default Time Format:</label>
              <div class="col-sm-10">
                <p class="form-control-static"><?= Settings::get($db, 'time_format'); ?></p>
              </div>
            </div>

            <!-- Default Timezone -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="site-url">Default Timezone:</label>
              <div class="col-sm-10">
                <p class="form-control-static"><?= Settings::get($db, 'timezone'); ?></p>
              </div>
            </div>

            <!-- Site Status -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="site-url">Site Status:</label>
              <div class="col-sm-10">
                <p class="form-control-static"><?= Settings::get($db, 'status'); ?></p>
              </div>
            </div>

            <!-- Cookie Notification -->
            <div class="form-group">
              <label class="control-label col-sm-2" for="site-url">Cookie Notification:</label>
              <div class="col-sm-10">
                <p class="form-control-static"><?= Settings::get($db, 'cookie_notification'); ?></p>
              </div>
            </div>

          </form>

      </div><!--#end .col-sm-10 (Right Panel) -->

    </div><!--#end .row, .content -->
  </div>
  <script>
    var container = document.querySelector('.container');
    var minHeight = 576;
  </script>
<?php require_once "includes/admin-footer.php"; ?>
