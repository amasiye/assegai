<?php
$user = $data['user'];
require_once "includes/admin-header.php";
?>
  <div class="container">
    <h2>Profile: <?= ucwords($user->display_name); ?></h2>

  </div>
<?php require_once "includes/admin-footer.php" ?>
