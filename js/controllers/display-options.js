var requestState, requestStatus;
var Status = {
                200:"OK",
                2001:"Pass",
                4000:"Cancel",
                4001:"Fail"
              };

$('document').ready(function() {
    // Screen Options
    var getvars = location.search.split('&');
    var qvars = [];
    for(x in getvars)
    {
      if(getvars[x].search('show=') > -1)
      {
        var selector = "option[value='" + getvars[x].split('=').pop() + "']";
        document.querySelector(selector).selected = true;
      }
    }

    $('[name=select-showing]').change(function() {
      console.log('Now showing: ' + $(this).val());
      var q = location.search;
      if(q.length > 0)
      {
        if(q.search('show=') < 0)
        {
          q += '&show=' + $(this).val();
        }
        else
        {
          q = q.replace(/show=\d+/, 'show=' + $(this).val());
        }
      }
      else
      {
        q += '?show=' + $(this).val();
      }
      location.search = q;
    });

    $('[name=display-grid]').click(function(event) {
      event.preventDefault();
      var q = location.search;
      if(q.length > 0)
      {
        q = (q.search(/display=\w+/) < 0)? q + '&display=grid' : q = q.replace(/display=\w+/, 'display=grid');
      }
      else
      {
        q += '?display=grid';
      }
      location.search = q;

      return false;
    });

    $('[name=display-list]').click(function(event) {
      event.preventDefault();
      var q = location.search;
      if(q.length > 0)
      {
        q = (q.search(/display=\w+/) < 0)? q + '&display=list' : q = q.replace(/display=\w+/, 'display=list');
      }
      else
      {
        q += '?display=list';
      }
      location.search = q;

      return false;
    });
});
