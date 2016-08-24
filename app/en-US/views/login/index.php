<?php
$db = $data['db'];
$user = $data['user'];

require_once "includes/header.php";
?>
<div class="container">
  <div class="col-md-offset-4 col-md-4">
    <div class="panel panel-default">
      <div class="panel-heading">
        <?php
          $user_login  = "Admin";
          $user_password = "admin1234";
          $user_name = "Administrator";
          $user_group = 1;
          $user_meta = json_encode(array('email'=>'admin@host.domain', 'address'=>'', 'phone'=>9027006887));
          // $user->login($db, $user_login, $user_password);
          // User::register($user_login, $user_password, $user_name, $user_group, $user_meta);
          // echo "<h2>Hello World</h2>";
        ?>
        <h2>Login</h2>
      </div>
      <div class="panel-body">

        <form role="form" class="clearfix">
          <div id="alert-feedback" class="alert" style="display:none;"></div>
          <div class="form-group">
            <label for="username">Username:&nbsp;</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Username"
              title="" pattern="[\w\W]+" maxlength="20" required>
          </div>
          <div class="form-group">
            <label for="password">Password:&nbsp;</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Password" maxlength="64" required>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-primary btn-block" id="btn-submit" name="btn-submit">Login</button>
          </div>
          <script>

            document.querySelector("button").onclick = function() { login($('#username').val(), $('#password').val()); };
            function login(username, password)
            {

              $.post(
                "http://localhost/atatusoft/Assegai/assegai/api/user/login/",
                {
                  username: $('#username').val(),
                  password: $('#password').val()
                },
                function(result) {
                  $('#alert-feedback').css("display":"block");
                  $('#alert-feedback').addClass("alert-success");
                  $('#alert-feedback').html(result);
                }
              );

            } // end login(string, string)

          </script>
        </form>

      </div>
    </div>
  </div>
</div>

<?php require_once "includes/footer.php"; ?>
