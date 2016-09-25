<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<div class="container-fluid">
  <div class="page-header">
    <h2>New User Registration</h2>
  </div>
  <p>Welcome <?= $user->dispal_name; ?>,</p>
  <p>
    Thanks for registering as user
  </p>
  <p>
    For your records, your username is: <span class="text-primary"><?= $user->login; ?></span>.
  </p>
  <p>
    To edit your profile, please visit:<br>
    <a href="<?= BASEPATH; ?>/login"><?= BASEPATH ?>/login</a>
  </p>
  <p>
    To login, use the password that you entered when you created your account,
    along with your username listed above. Don't forget that your password is
    case sensitive.
  </p>
  <p>
    Sincerely,
    <?= $user->admin_name(); ?><br>
    Webmaster
  </p>
</div>
