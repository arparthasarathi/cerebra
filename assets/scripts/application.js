$(function () {
  


  $(document).ready(function(){
    loadscripts();
    $.ajaxSetup({ cache: true });
    $.getScript('//connect.facebook.net/en_UK/all.js', function(){
      FB.init({
        appId      : '217608864916653',
        channelUrl :  base_url + '/channel',
        status     : true,
        cookie     : true,
        xfbml      : true,
        oauth     : true
      }); 

      // $('#loginbutton,#feedbutton').removeAttr('disabled');
        //FB.getLoginStatus(updateStatusCallback);
      });



  });

 
  $('#k-tabbed-interface a:last').tab('show');

  

  // $("#slideshow > div:gt(0)").hide();
  // setInterval(function() { $('#slideshow > div:first').fadeOut(1000).next().fadeIn(1000).end().appendTo('#slideshow');},  3000);

  
  $(document).on('click','[name="attempt-login"]', function(){

    var formdata = {
      'username' : $('form[name="loginform"] input[name="emailaddress"]').val(),
      'password' : $('form[name="loginform"] input[name="password"]').val()
    }

    $('#loginform').removeClass('invalidlogin');

    console.log(formdata);

    if(formdata['username'] == null || formdata['password'] == null)
    {

    }
    else
    {
      $.ajax ({
        type: "POST",
        url: base_url+"auth/k_login",  
        data: formdata,    
        cache: false,
        success: function (data) {  
          trapdata = $.parseJSON(data);
          console.log(trapdata);
          if($.trim(trapdata.status) == 1)
          {
            console.log('Status 200');
            $('[name="k-connect-modal"]').hide();
            $('[name="k-connect-profile"]').show();
            $('[name="fullname"]').html(trapdata.response.kid);
            $('[name="register-button"]').data('logged-in',trapdata.response.kid);
            $('[name="workshop-register-button"]').data('logged-in',trapdata.response.kid);
            $('[name="team-workshop-register-button"]').data('logged-in',trapdata.response.kid);
            $('[name="attachment_registration"]').html("<p>Refresh Page to know status.</p>");
            console.log(trapdata.response.email);
            $('#login').modal('hide');
            var opts = {
                message : 'Logged in to play Cerebra at 8.00 P.M IST|SET 1',
                name : 'Cerebra|Kurukshetra 2014',
                link : 'www.kurukshetra.org.in/cerebra',
                description : 'Cerebra is the ultimate online math puzzle challenge for the bunch of "wanna be" mathematicians !!!',
                picture : 'www.kurukshetra.org.in/cerebra.png'
            };

            FB.api('/me/feed', 'post', opts, function(response)
            {
                if (!response || response.error)
                {
                    console.log(response.error);
                }
                else
                {
                    console.log('Success - Post ID: ' + response.id);
                }
            });
            window.location="http://kurukshetra.org.in/cerebra"
          }
          else if($.trim(trapdata.status) == 2)
          {
            $('[ name="login-message"]').html(trapdata.response);
            $('#loginform').addClass('invalidlogin');
            console.log('Invalid');
          }
          else
          {
            console.log('Status 401');  
          }
              
          console.log("Edit Category Form Intiated");
        },    
        error: function() {
          console.log("Edit Category Form Failed");
        }
      });
    }
  });
  
 $(document).on('click','[name="close-button"]',function(){
    console.log('Close');
    $('#loginModal').modal('hide');
    $('#registerModal').modal('hide');
    $('#workshopModal').modal('hide');
    $('#teamWorkshopModal').modal('hide');
    $('#saModal').modal('hide');
  });

  $(document).on('click','[name="attempt-logout"]',function(){
    console.log("Logout");
    var formdata = {
      'logout_prototype' : 1
    };

    $.ajax ({
        type: "POST",
        url: base_url+"auth/k_logout",  
        data: formdata,    
        cache: false,
        success: function (data) {  
          trapdata = $.parseJSON(data);
          console.log(trapdata)
          if($.trim(trapdata.status) == 1)
          {
            $('[name="k-connect-profile"]').hide();
            $('[name="k-connect-modal"]').show();
            $('.k-login-button').show();
            console.log('Logged Out');
            window.location="http://kurukshetra.org.in/cerebra";
            
          }
          else
          {
            console.log('Status 401');  
          }
              
          console.log("Edit Category Form Intiated");
        },    
        error: function() {
          console.log("Edit Category Form Failed");
        }
      });
  });


  $(document).on('click','[name="attempt-facebook"]',function(){
    KFBLogin();
    console.log("FB");
  });

  
});



///////////////////////// LOAD - START //////////////////////////////////////////////////

function loadscripts()
{
  var scriptpath = base_url+'assets/scripts/';

  var scriptfiles = new Array(); 
    scriptfiles.push("jquery.min.js");
    scriptfiles.push("jquery.cookie.js");
    
    scriptfiles.push("bootstrap.min.js");
    
    

    console.log(scriptfiles);

  var scriptfileslength = scriptfiles.length;

}

///////////////////////// LOAD - END ////////////////////////////////////////////////////




///////////////////////// FACEBOOK - START //////////////////////////////////////////////

function KFBLogin()
{
  FB.login(function(response) {
    if (response.authResponse) {
          KFBStore();
          console.log('User Store Login');
        } else {
           console.log('User cancelled login or did not fully authorize.');
      }
  },{scope: 'email'});
}


function KFBLogout()
{
  FB.logout(function(response) {
    
  });
}

function KFBStore()
{
  FB.api('/me', function(response) {
         
         var formdata = {
           'fullname' : response.name,
           'email' : response.email,
           'username' : response.email
         }

         console.log(formdata);

         $.ajax ({
        type: "POST",
        url: base_url+"auth/k_fb",  
        data: formdata,    
        cache: false,
        success: function (data) {
          trapdata = $.parseJSON(data);
          console.log(trapdata);
          if($.trim(trapdata.status) == 1)
          {
            var opts = {
                message : 'Logged in to play Cerebra at 8.00 P.M IST|SET 2',
                name : 'Cerebra|Kurukshetra 2014',
                link : 'www.kurukshetra.org.in/cerebra',
                description : 'Cerebra is the ultimate online math puzzle challenge for the bunch of "wanna be" mathematicians !!!',
                picture : 'www.kurukshetra.org.in/cerebra.png'
            };

            FB.api('/me/feed', 'post', opts, function(response)
            {
                if (!response || response.error)
                {
                    console.log(response.error);
                }
                else
                {
                    console.log('Success - Post ID: ' + response.id);
                }
            });
            $('[name="k-connect-modal"]').hide();
            $('[name="k-connect-profile"]').show();
            $('[name="fullname"]').html(trapdata.response.kid);
            $('[name="register-button"]').data('logged-in',trapdata.response.kid);
            $('[name="workshop-register-button"]').data('logged-in',trapdata.response.kid);
            $('[name="team-workshop-register-button"]').data('logged-in',trapdata.response.kid);
            $('[name="attachment_registration"]').html("<p>Refresh Page to know status.</p>");
            console.log(trapdata.response.email);
            $('#login').modal('hide');
            window.location="http://kurukshetra.org.in/cerebra"

          }
          else if($.trim(trapdata.status) == 2)
          {
            $('[ name="login-message"]').html(trapdata.response);
            $('#loginform').addClass('invalidlogin');
            console.log('Invalid');
          }
          else
          {
            console.log('Status 401');  
          }
              
          console.log("FB Login Intiated");
        },    
        error: function() {
          console.log("Failed");
        }
      });
    });
}


//////////////////////// FACEBOOK - END ////////////////////////////////////////////////