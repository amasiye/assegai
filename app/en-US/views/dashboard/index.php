<?php
$user = $data['user'];
require_once "includes/admin-header.php";
?>
  <div class="container">
    <h2>Admin Dashboard: <?= ucwords($user->display_name); ?></h2>

    <!-- Row 1 -->
    <div class="row">
      <div class="well well-lg col-md-3">a</div>
      <div class="well well-lg col-md-offset-1 col-md-3">b</div>
      <div class="well well-lg col-md-offset-1 col-md-3">c</div>
    </div>

    <!-- Row 2 -->
    <div class="row">
      <div class="well well-lg col-md-3">d</div>
      <div class="well well-lg col-md-offset-1 col-md-3">e</div>
      <div class="well well-lg col-md-offset-1 col-md-3">f</div>
    </div>

    <!-- Row 3 -->
    <div class="row">
      <div class="well well-lg col-md-3">f</div>
      <div class="well well-lg col-md-offset-1 col-md-3">g</div>
      <div class="well well-lg col-md-offset-1 col-md-3">h</div>
    </div>

  </div>
<?php require_once "includes/admin-footer.php"; ?>
