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
  var patt = /e/;
  return patt.test(username);
}

function passwordIsValid(password)
{
  var patt = /\W\w/;
  return patt.test(password);
}
