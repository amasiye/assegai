$("document").ready(function() {

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

});

function search(term)
{

}


function usernameIsValid(username)
{
  if(username.length >= 5)
  {
    var patt = /^[a-zA-Z0-9]+$/;
    return patt.test(username);
  }
  return false;
}

function passwordIsValid(password)
{
  if(password.length >= 6)
  {
    var patt = /\W\w/;
    return patt.test(password);
  }
  return false;
}

function setDocumentTitle(newTitle)
{
  document.title = newTitle;
}
