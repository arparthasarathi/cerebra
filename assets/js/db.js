
  var temp,c;
  function selectHolders(){
    temp = document.getElementById("loginStatusHolder");
    c = document.getElementById("regStatusHolder");
  }
  window.fbAsyncInit = function () {
    FB.init({
        appId: "217608864916653",
        channelUrl: "channel.html",
        status: true,
        cookie: true,
        xfbml: true
    });
    function d() {
        FB.login(function (f) {
            if (f.authResponse) {
                FB.api("/me", function (g) {
                    login(f, g)
                })
            } else {}
        }, {
            scope: "user_about_me,user_activities,user_interests,user_likes,user_birthday,user_education_history,email,offline_access,publish_stream,status_update,user_location,friends_location,publish_actions,friends_activities,friends_interests,friends_likes"
        })
    }
    function b() {
        $.post("http://kurukshetra.org.in/normallogincontroller/getdbLoginStatus", {}, function (f) {
            if (f.result == 1) {
                $("#loginModal").modal("hide");
                $("#loginButton1").attr("onClick", "Ologout()");
                $("#loginButton1").removeAttr("href");
                $("#loginButton1").removeAttr("data-toggle");
                $("#loginButton1").text("Logout");
        console.log('ss');
                $("#registerButton").text("Invite Friends");
                $("#registerButton").attr("onClick", "FacebookInviteFriends()");
                $("#registerButton").removeAttr("href");
                $("#registerButton").removeAttr("data-toggle");
                $("#konnectButton").removeClass("btn-danger");
                $("#konnectButton").removeAttr("href");
                $("#konnectButton").addClass("btn-facebook");
                $("#konnectButton2").removeClass("btn-danger");
                $("#konnectButton2").addClass("btn-facebook");
                
                $("#konnectButton").attr("href", "#!/profile/" + f.profile);
                $("#konnectButtonText").html(f.name+f.kid);
          
            }
        }, "json")
    }
    function e(f) {// initially called, called when there is a change in status of FB (like logout,login etc.)  --- f is the response
    temp = document.getElementById("loginStatusHolder");
    c = document.getElementById("regStatusHolder");
  
        if (f.status === "connected") {
            var h = f.authResponse.userID;
            var g = f.authResponse.accessToken;
            login(f)
        } else {
            if (f.status === "not_authorized") {
                temp.innerHTML = "Register";
                c.innerHTML = "Register";
                temp.onclick = function () {
                    c.innerHTML = temp.innerHTML = '<img src="' + CI.base_url + 'assets/fb-login-images/loading-1.gif"/>';
                    d()
                };
                c.onclick = temp.onclick;
                b()
            } else {//not logged in facebook
                temp.innerHTML = "Login";
                c.innerHTML = "Register";
                temp.onclick = function () {
                    c.innerHTML = temp.innerHTML = '<img src="http://kurukshetra.org.in/assets/fb-login-images/loading-1.gif"/>';
                    d()
                };
                c.onclick = temp.onclick;
                b()
            }
        }
    }
    FB.getLoginStatus(e);
    FB.Event.subscribe("auth.statusChange", e)
};//Endof fbAsyncInit

(function (e) {
    var c, f = "facebook-jssdk",
        b = e.getElementsByTagName("script")[0];
    if (e.getElementById(f)) {
        return
    }
    c = e.createElement("script");
    c.id = f;
    c.async = true;
    c.src = "//connect.facebook.net/en_US/all.js";
    b.parentNode.insertBefore(c, b)
}(document));



function fbLogout() {//logout fn for fb users
    FB.logout(function (b) {
        $.post("http://kurukshetra.org.in/loginreg/fbdblogout", {}, function (c) {
            if (c.code == "1") {
                console.log("logged out successfully");
window.location="kurukshetra.org.in/dalalbull/2013/logmeout.php"
                $("#loginButton1").text("Login");
                $("#loginButton1").attr("data-toggle", "modal");
                $("#loginButton1").removeAttr("onClick");
                $("#loginButton1").attr("href", "#loginModal");
                $("#registerButton").text("Register");
                $("#registerButton").attr("data-toggle", "modal");
                $("#registerButton").removeAttr("onClick");
                $("#registerButton").attr("href", "#registerModal");
                $("#profilePicHolder").html('<i class="icon-user"></i>');
                $("#konnectButton").removeClass("btn-facebook");
                $("#konnectButton").addClass("btn-danger");
                $("#konnectButton2").removeClass("btn-facebook");
                $("#konnectButton2").addClass("btn-danger");
        
                $("#konnectButtonText").text("konnect");

location.reload(true)
               
            }
        }, "json")
    })
}
function login(e) {// customized login fn for fb users
    var d = document.getElementById("loginStatusHolder");
    var c = document.getElementById("regStatusHolder");

    var b = e.authResponse.accessToken;
    FB.api({
        method: "fql.query",
        query: "select uid, name,first_name, email, sex, pic_square,pic_small from user where uid=me()"
    }, function (f) {
        $.post("http://kurukshetra.org.in/authcontroller/dodbfbcheck", {
            access_token: b,
            uid: f[0].uid,
            email: f[0].email,
            sex: f[0].sex,
            pic: f[0].pic_square,
            name: f[0].name,
            short_name: f[0].first_name
        }, function (h) {
            //console.log("profile status = " + h.result);
            c.innerHTML = d.innerHTML = "Logout";
            $("#loginModal").modal("hide");
            $("#registerModal").modal("hide");
            $("#loginButton1").text("Logout");
            $("#loginButton1").attr("onClick", "fbLogout()");
            $("#loginButton1").removeAttr("href");
            $("#loginButton1").removeAttr("data-toggle");
            $("#registerButton").text("Invite Friends");
            $("#registerButton").attr("onClick", "FacebookInviteFriends()");
            $("#registerButton").removeAttr("href");
            $("#registerButton").removeAttr("data-toggle");
            $("#konnectButton").removeClass("btn-danger");
            $("#konnectButton").removeAttr("href");
            $("#konnectButton").addClass("btn-facebook");
            
            $("#konnectButton2").removeClass("btn-danger");
            $("#konnectButton2").addClass("btn-facebook");
            $("#profilePicHolder").html('<img id="fbProfilePic" width="25" height="25" src="' + f[0].pic_square + '">');
        
            var g = f[0].email;
           
            $("#konnectButton").attr("href", "#!/profile/" + h.profile);
            $("#konnectButtonText").html(f[0].first_name+h.kid);
            if (h == "2") {
                console.log("successful login + profile")
            } else {
                if (h == "4") {
                    console.log("Logged in, have to complete profile")
                } else {
                    if (h == "3") {
                        console.log("new user, have to complete profile")
                    }
                }
            }
        }, "json")
    });
    d.onclick = fbLogout
}

function dologin() {
    var b = document.forms.login;
    var c, d;
    c = b.elements["login-email"].value;
    d = b.elements["login-password"].value;
    $("#loginbutton").button("loading");
    $.post("http://kurukshetra.org.in/normallogincontroller/dblogin", {
        uname: c,
        pwd: d,
    }, function (g) {
        if (g.code == "1") {
            //console.log("login: " + c + " says " + g.code);
            var f = document.getElementById("loginStatusHolder");
            $("#loginModal").modal("hide");
            $("#konnectButton").removeClass("btn-danger");
            $("#konnectButton").removeAttr("href");
            $("#konnectButton").addClass("btn-facebook");
            $("#konnectButton2").removeClass("btn-danger");
            $("#konnectButton2").addClass("btn-facebook");
            $("#loginButton1").text("Logout");
            $("#loginButton1").attr("onClick", "Ologout()");
            $("#loginButton1").removeAttr("href");
            $("#loginButton1").removeAttr("data-toggle");
            $("#registerButton").text("Invite Friends");
            $("#registerButton").attr("onClick", "FacebookInviteFriends()");
            $("#registerButton").removeAttr("href");
            $("#registerButton").removeAttr("data-toggle");
            
            $("#konnectButton").attr("href", "#!/profile/" + g.profile);
            $("#konnectButtonText").html(g.name+g.kid);
          
        } else {
            $("#loginbutton").button("reset");
            var e = g.code,
                h;
            if (e == "4" || e == "3") {
                h = "#login-email"
            } else {
                if (e == "2") {
                    h = "#login-password"
                }
            }
            $(h).popover({
                content: g.msg
            });
            $(h).popover("show");
            $("body").click(function () {
                $(h).popover("destroy")
            });
            //console.log("alert: " + h + "," + g.msg)
        }
    }, "json")
}


function Ologout() {
    $.post("http://kurukshetra.org.in/normallogincontroller/dblogout", {}, function (b) {
        if (b.code == "1") {
            console.log("Ologged out successfully");
window.location="kurukshetra.org.in/athena/home.php"
            $("#loginButton1").text("Login");
            $("#loginButton1").attr("data-toggle", "modal");
            $("#loginButton1").removeAttr("onClick");
            $("#loginButton1").attr("href", "#loginModal");
            $("#registerButton").text("Register");
            $("#registerButton").attr("data-toggle", "modal");
            $("#registerButton").removeAttr("onClick");
            $("#registerButton").attr("href", "#registerModal");
            $("#profilePicHolder").html('<i class="icon-user"></i>');
            $("#konnectButton").removeClass("btn-facebook");
            $("#konnectButton").addClass("btn-danger");
            $("#konnectButton2").removeClass("btn-facebook");
            $("#konnectButton2").addClass("btn-danger");
 
            $("#konnectButtonText").text("konnect");
       
        }
    }, "json")
}

function FacebookInviteFriends() {
    if (top.location != self.location) {
        top.location = self.location
    }
    FB.ui({
        method: "apprequests",
        message: "Kurukshetra-The Battle Of Brains is the International Techno-Management Festival of College of Engineering, Guindy, Anna University",
        filters: ["app_non_users"]
    })
}


