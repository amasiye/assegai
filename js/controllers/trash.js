var requestState, requestStatus;
var Status = {
                200:"OK",
                2001:"Pass",
                4000:"Cancel",
                4001:"Fail"
              };

$('document').ready(function () {
  var bulkActionSelector;
  requestState = 0;
  requestStatus = 200;
  var ids = [];
  // var q = (location.search.length > 0)? location.search '&showing=' + $(this).val() : '?showing=' + $(this).val();

  $('.btn').click(function() {}).trigger('blur');

  // Restore buttons
  $("[id^=btn-restore]").click(function() {
    if($(this).hasClass('disabled'))
    {
      return;
    }
    if($(this).attr('id').split('-').pop() !== 'all')
      restore([this.id]);
    else
      restoreAll();

    $(this).trigger('blur');
  });

  // Delete buttons
  $("[id^=btn-delete]").click(function() {
    if($(this).hasClass('disabled'))
    {
      return;
    }
    ids.push($(this).attr('id').split('-').pop());
    if(ids[0] == 'all')
    {
      $('#trashModal').modal();
    }

    $(this).trigger('blur');
  });

  $("#btn-confirm-auth").click(function() {
    attemptAuthorization($("[name=admin-username]").val(), $("[name=admin-password]").val());
  });

  $('#btn-confirm-delete').click(function() {
    if(ids[0] === 'all')
      emptyTrash();
    else
      deleteItems(ids);
  });

  $('#btn-cancel-delete').click(function() {
    // Set auth modal content as visbible and hide delete modal content
    $('#modal-content-delete').addClass('hidden');
    $('#modal-content-auth').removeClass('hidden');
  });

  // Bulk Actions
  $("select[name=bulk-actions]").change(function() {
    switch($(this).find('option:selected').attr('id'))
    {
      case 'opt-restore-selected':
        bulkActionSelector = 'opt-restore-selected';
        break;

      case 'opt-delete-selected':
        bulkActionSelector = 'opt-delete-selected';
        break;

      default:
        bulkActionSelector = '';
    }
  });

  $("input[id^=media-select-all]").click(function() {
    if($(this).attr("checked") === 'checked')
    {
      // Select all
      $("input[id^=media-select-all]").each(function() {
        $(this).attr('checked', 'checked');
      });

      $('table').find("[name^=item-select-]").each(function() {
        $(this).attr('checked', 'checked');
      });
    }
    else
    {
      // Deselect all
      $("input[id^=media-select-all]").each(function() {
        $(this).removeAttr('checked');
      });

      $('table').find("[name^=item-select-]").each(function() {
        $(this).removeAttr('checked');
      });
    }
  });

  // Apply bulk actions
  $('#apply').click(function() {
    if(bulkActionSelector.length > 0)
    {
      var selectedItems = [];

      switch (bulkActionSelector)
      {
        case 'opt-restore-selected':
          $('table').find("[name^=item-select-]:checked").each(function() {
            selectedItems.push($(this).attr('id').split('-').pop());
          });
          restore(selectedItems);
          break;

        case 'opt-delete-selected':
          $('#list-trashed-items, #grid-trashed-items').find("[name^=item-select-]:checked").each(function() {
            selectedItems.push($(this).attr('id').split('-').pop());
          });
          ids = selectedItems;
          console.log(ids);
          $('#modal-content-delete').addClass('hidden');
          $('#modal-content-auth').removeClass('hidden');
          $('#trashModal').modal();
          break;

        default:

      }
    }
  });
}); // end ready()

function attemptAuthorization(username, password)
{
  var endpoint = $("head base").attr('href') + 'api/auth/' + username + "/" + password;

  $.get(endpoint, {}, function(data, status) {
    var result = JSON.parse(data);
    // console.log(data);
    if(!result.success)
    {
      $("#feedback-auth").removeClass('hidden alert-warning alert-success alert-info').addClass('alert-danger').html(result.message);
    }
    else
    {
      $('#modal-content-auth').addClass('hidden');
      $('#modal-content-delete').removeClass('hidden');
    }
  });
  // console.log("Username: " + username);
  // console.log("Pasword: " + password);
}

function restore(ids)
{
  var endpoint = $("head base").attr('href') + 'api/post/restore/';
  var idString = '';
  for(x in ids)
  {
    idString += (x == 0)? ids[x].split('-').pop() : ',' + ids[x].split('-').pop();
  }

  $.post(endpoint, {itemIDs: idString}, function(data, status) {
    var result = JSON.parse(data);
    // console.log(data);
    // console.log(result);
    if(result.success)
    {
      var removeableIds = idString.split(',');
      // Refresh
      if(location.search.split("=").pop() === "grid")
      {
        for(x in removeableIds)
        {
          $('#btn-delete-' + removeableIds[x]).parent().parent().parent().parent().remove();
        }
      }
      else
      {
        for(x in removeableIds)
        {
          $('#btn-delete-' + removeableIds[x]).parent().parent().parent().parent().parent().remove();
        }
      }
      $('#feedback-trash').removeClass('alert-danger');
      $('#feedback-trash').removeClass('hidden');
      $('#feedback-trash').addClass('alert-success');
      $('#feedback-trash').html(result.message);
      // alert(idString);
    }
    else
    {
      $('#feedback-trash').removeClass('alert-success');
      $('#feedback-trash').removeClass('hidden');
      $('#feedback-trash').addClass('alert-danger');
      $('#feedback-trash').html("<strong>Error " + result.status + ":</strong> " + result.message);
    }
  });
} // end restore()

function restoreAll()
{
  var endpoint = $('head base').attr('href') + 'api/post/restore/';

  $.post(endpoint, {itemIDs:"all"}, function(data, status) {
    var result = JSON.parse(data);
    // console.log(data);
    // console.log(result);
    if(result.success)
    {
      if(location.search.split("=").pop() === "grid")
      {
        $('[id=grid-trashed-items]').before('<p>The trash bin is empty.</p>').remove();
      }
      else
      {
        $('[id=list-trashed-items]').before('<p>The trash bin is empty.</p>').remove();
      }
      $('#feedback-trash').removeClass('alert-danger');
      $('#feedback-trash').removeClass('hidden');
      $('#feedback-trash').addClass('alert-success');
      $('#feedback-trash').html(result.message);
    }
    else
    {
      $('#feedback-trash').removeClass('alert-success');
      $('#feedback-trash').removeClass('hidden');
      $('#feedback-trash').addClass('alert-danger');
      $('#feedback-trash').html("<strong>Error " + result.status + ":</strong> " + result.message);
    }
  });
} // end restoreAll()

function deleteItems(ids)
{
  var endpoint = $("head base").attr('href') + 'api/post/delete/';
  var idString = '';
  for(x in ids)
  {
    idString += (x == 0)? ids[x].split('-').pop() : ',' + ids[x].split('-').pop();
  }
  // console.debug(endpoint);

  $.post(endpoint, {itemIDs:idString}, function(data, status) {
    var result = JSON.parse(data);
    console.log(data);
    console.log(result);
    if(result.success)
    {
      var removeableIds = idString.split(',');
      console.log(idString);
      console.log(removeableIds);
      // Refresh
      if(location.search.split("=").pop() === "grid")
      {
        for(x in removeableIds)
        {
          $('#btn-delete-' + removeableIds[x]).parent().parent().parent().parent().remove();
        }
      }
      else
      {
        for(x in removeableIds)
        {
          $('#btn-delete-' + removeableIds[x]).parent().parent().parent().parent().parent().remove();
        }
      }

      $('#feedback-trash').removeClass('alert-danger');
      $('#feedback-trash').removeClass('hidden');
      $('#feedback-trash').addClass('alert-success')
      $('#feedback-trash').html(result.message);
      // alert(idString);
    }
    else
    {
      $('#feedback-trash').removeClass('alert-success');
      $('#feedback-trash').removeClass('hidden');
      $('#feedback-trash').addClass('alert-danger');
      $('#feedback-trash').html("<strong>Error " + result.status + ":</strong> " + result.message);
    }
  });
} // end delete()

function emptyTrash()
{
  var endpoint = $('head base').attr('href') + 'api/post/delete/';
  $.post(endpoint, {itemIDs:'all'}, function(data, status) {
    var result = JSON.parse(data);
    console.log(data);
    console.log(result);
    if(result.success)
    {
      if(location.search.split("=").pop() === "grid")
      {
        $('[id=grid-trashed-items]').before('<p>The trash bin is empty.</p>').remove();
      }
      else
      {
        $('[id=list-trashed-items]').before('<p>The trash bin is empty.</p>').remove();
      }
      $('#feedback-trash').removeClass('alert-danger');
      $('#feedback-trash').removeClass('hidden');
      $('#feedback-trash').addClass('alert-success');
      $('#feedback-trash').html(result.message);
    }
    else
    {
      $('#feedback-trash').removeClass('alert-success');
      $('#feedback-trash').removeClass('hidden');
      $('#feedback-trash').addClass('alert-danger');
      $('#feedback-trash').html("<strong>Error " + result.status + ":</strong> " + result.message);
    }
  });
} // empty()
