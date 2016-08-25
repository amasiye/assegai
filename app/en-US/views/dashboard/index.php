<?php
$db = $data['db'];
$user = $data['user'];

require_once "includes/header.php";
?>
    <div class="container">
      <div class="list-group">
        <a href="#" class="list-group-item">Add</a>
        <a href="#" id="btn-logout" class="list-group-item">Profile</a>
        <a href="<?= BASEPATH . "user/logout/"; ?>" class="list-group-item">Logout</a>
        <script>
          $('#btn-logout').click(function() {
            alert('logout');
          });
        </script>
      </div>
    </div>

<?php require_once "includes/footer.php"; ?>
