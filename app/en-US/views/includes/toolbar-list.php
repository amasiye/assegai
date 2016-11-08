<div class="panel panel-default">
  <div class="panel-body">
    <div class="col-sm-6">
      <div class="input-group">
        <select class="form-control" name="bulk-actions">
          <option>Bulk Actions</option>
          <option id="opt-restore-selected">Restore Selected</option>
          <option id="opt-delete-selected">Delete Selected</option>
        </select>
        <div class="input-group-btn">
          <?php if (count($trash) > 0): ?>
            <button type="button" name="apply" id="apply" class="btn btn-primary">Apply</button>
          <?php else: ?>
            <button type="button" name="apply" id="apply" class="btn btn-primary disabled">Apply</button>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-sm-6">
      <!-- Display Type -->
      <div class="btn-group pull-right" role="group">
        <a href="#" name="display-list" class="btn btn-default" title="List"><span class="glyphicon glyphicon-th-list"></span></a>
        <a href="#" name="display-grid" class="btn btn-default" title="Grid"><span class="glyphicon glyphicon-th"></span></a>
      </div>
      <!-- Items per page -->
      <form class="form-inline pull-right">
        <div class="form-group">
          <label for="select-showing">Showing: </label>
          <select class="form-control" name="select-showing">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="100">100</option>
          </select>
        </div>
        <br>
      </form>
    </div>
  </div>
</div>
