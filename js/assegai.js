$("document").ready(function() {

  /*  Event Handlers  */
  $("#btn-login").click(function(event) {
    var uname = $("#username").val();
    var pass = $("#password").val();
    var url = "api/auth/";
    alert(uname);

    if(usernameIsValid(uname) && passwordIsValid(pass))
    {

      // $.post(
      //   url,
      //   {
      //     login : u
      //   },
      //   function(data) {
      //
      //   });

    }

    return false;
  });

  // Side navigation tabs
  $('.nav-tabs a').click(function(event) {
    event.preventDefault;
    // Remove active class from all other tabs
    $(this).parent().parent().find('li').removeClass('active');
    //find('li');

    // Add active tab to this
    $(this).parent().addClass('active');

    // Change menu panel e.g if clicked elements show elements list panel
    console.debug($(this).parent().parent().parent().parent().find("div[id*=menu-]").addClass('hidden'));
    console.debug($($(this).attr('data-target')).removeClass('hidden'));

    return false;
  });

  // Initializations
  var editorFrame = document.querySelector('.editor-frame');
  // Check storage for cached settings and preferences
  if(typeof(Storage) !== "undefined")
  {
    /* Check session storage */

    /* Check local storage */
    // View Mode
    if(localStorage.getItem('assg-vm') == null)
      localStorage.setItem('assg-vm', 'desktop');

    // Set view mode icon
    switch(localStorage.getItem('assg-vm'))
    {
      case 'tablet':
        // document.querySelector('#icon-view-mode').className = 'fa fa-tablet';
        $("[title*='Tablet']").trigger('click');
        break;
      case 'mobile':
        // document.querySelector('#icon-view-mode').className = 'fa fa-mobile';
        $("[title*='Mobile']").trigger('click');
        break;
      default:
        // document.querySelector('#icon-view-mode').className = 'fa fa-desktop';
        $("[title*='Desktop']").trigger('click');
        break;
    }

  }
  else /* Check cookies for cached settings and preferences */
  {
    // View Mode
    if(getCookie('assg-vm') == null)
      setCookie('assg-vm', 'desktop', 1);

    // Set view mode icon
    switch(getCookie('assg-vm'))
    {
      case 'tablet':
        document.querySelector('#icon-view-mode').className = 'fa fa-tablet';
        break;
      case 'mobile':
        document.querySelector('#icon-view-mode').className = 'fa fa-mobile';
        break;
      default:
        document.querySelector('#icon-view-mode').className = 'fa fa-desktop';
        break;
    }
  }
  $('.frame').parent().css("padding","0px");

}); // end $('document').ready()

/**
 * Sets a cookie value of given name
 * @param {string} name - The name of the cookie.
 * @param {string} value - The value of the cookie.
 * @param {string} days - The number of days until the cookie should expire.
 */
function setCookie(name, value, days)
{
  var d = new Date();
  d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
  var expires = "expires=" + d.toUTCString();
  document.cookie = name + "=" + value + "; " + expires;
} // end setCookie()

/**
 * Returns the value of the cookie of given name.
 * @param {string} name The name of the cookie.
 * @return {string} value Returns the value of the string, or null
 * if no cookie of the given name was found.
 */
function getCookie(name)
{
  var cname = name + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i <ca.length; i++)
  {
      var c = ca[i];
      while (c.charAt(0)==' ') {
          c = c.substring(1);
      }
      if (c.indexOf(cname) == 0) {
          return c.substring(cname.length,c.length);
      }
  }
  return null;
} // end getCookie()

function search(term)
{

} // end search()

function usernameIsValid(username)
{
  if(username.length >= 5)
  {
    var patt = /^[a-zA-Z0-9]+$/;
    return patt.test(username);
  }
  return false;
} // end usernameIsValid()

function passwordIsValid(password)
{
  if(password.length >= 6)
  {
    var patt = /\W\w/;
    return patt.test(password);
  }
  return false;
} // end passwordIsValid()

function setDocumentTitle(newTitle)
{
  document.title = newTitle;
} // en setDocumentTitle()

function loadController(path)
{
  var controller = document.createElement('script');
  controller.src = path;
  document.querySelector('head').appendChild(controller);
} // end loadController
