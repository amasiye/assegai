<div id="user-profile-info" class="modal-content hidden">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Edit Profile</h4>
  </div>
  <div class="modal-body">
    <div id="profile-details-input">

      <!-- #Feedback Modal -->
      <div id="feedback-modal" class="alert hidden"></div>

      <!-- User Login -->
      <div class="form-group">
        <label class="control-label col-sm-3">User Login:</label>
        <div class="col-sm-9">
          <input type='text' name='login' id='login' class="form-control" value='<?= $user->login; ?>' />
        </div>
      </div>

      <!-- Username -->
      <div class="form-group">
        <label class="control-label col-sm-3">Username:</label>
        <div class="col-sm-9">
          <input type='text' name='username' id='username' class="form-control" value='<?= $user->username; ?>' />
        </div>
      </div>

      <!-- Display Name -->
      <div class="form-group">
        <label class="control-label col-sm-3">Display Name:</label>
        <div class="col-sm-9">
          <input type='text' name='display-name' id='display-name' class="form-control" value='<?= $user->display_name; ?>' />
        </div>
      </div>

      <!-- Primary Email -->
      <div class="form-group">
        <label class="control-label col-sm-3">Primary Email:</label>
        <div class="col-sm-9">
          <input type='text' name='email-primary' id='email-primary' class="form-control" value='<?= $user->primary_email; ?>' />
        </div>
      </div>

      <!-- Other Email -->
      <div class="form-group">
        <label class="control-label col-sm-3">Other Email:</label>
        <div class="col-sm-9">
          <input type='text' name='email-other' id='email-other' class="form-control" value='<?= $user->emails; ?>' />
        </div>
      </div>

      <!-- Address -->
      <div class="form-group">
        <label class="control-label col-sm-3">Address:</label>
        <div class="col-sm-9">
          <input type='text' name='address' id='address' class="form-control" value='<?= $user->address; ?>' />
        </div>
      </div>

      <?php if (User::is_admin($db, $user->login)): ?>
      <!-- Group -->
      <div class="form-group">
        <label class="control-label col-sm-3">User Group:</label>
        <div class="col-sm-9">
          <select name='group-name' id='group-name' class="form-control">
            <?php
            $group_names = Group::get_group_names($this->db);
            foreach($group_names as $name)
            {
              if(strcmp($user->group_name, $name) == 0)
                echo "<option value='{$name}' selected>{$name}</option>";
              else
                echo "<option value='{$name}'>{$name}</option>";
            }
            ?>
          </select>
        </div>
      </div>
      <?php endif; ?>

    </div>
    <div id="image-gallery" class="hidden">
      <?= $gallery; ?>
    </div>

  </div><!-- #end modal-body -->

  <div class="modal-footer">
    <input type="hidden" name="api-key" id="api-key" class="form-control" value="<?= $data['app']->get_api_key(); ?>">
    <button type="button" class="btn btn-info" name="btn-profile-save">Save</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
  </div><!-- #end modal-footer -->
</div>
