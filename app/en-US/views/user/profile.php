<?php
$user = $data['user'];
require_once "includes/admin-header.php";
?>
  <div class="container">
    <h2>Profile: <?= ucwords($user->display_name); ?></h2>
    <p>
      ID <?= $user->id; ?>
      <?= '<br>Login: ' . $user->login; ?>
      <?= '<br>Username: ' . $user->username; ?>
      <?= '<br>Password: ' . $user->password; ?>
      <?= '<br>Salt: ' . $user->salt; ?>
      <?= '<br>Group: ' . $user->group; ?>
      <?= '<br>Joined: ' . $user->joined; ?>
      <?= '<br>Primary Email: ' . $user->primary_email; ?>
      <?= '<br>Emails: ' . $user->emails; ?>
      <?= '<br>Address: ' . $user->address; ?>
      <?= '<br>Preferences: ' . $user->preferences; ?>
    </p>
  </div>
<?php require_once "includes/admin-footer.php" ?>
