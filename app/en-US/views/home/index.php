<?php require_once "includes/admin-header.php"; ?>
    <article>
      <header>
        <div class="panel panel-default">
          <div class="panel-heading">
            <h4>Salutations</h4>
          </div>
          <div class="panel-content">
            <h3>Hello <?= $data['user']->display_name; ?></h3>
            <p>This is one awesome app isn't it?</p>
          </div>
        </div>
      </header>
    </article>
<?php require_once "includes/admin-footer.php"; ?>
