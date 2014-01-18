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
				oauth	   : true
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
				url: base_url+"index.php/auth/k_login",	
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
						$('#loginModal').modal('hide');
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
	

	$(document).on('click','[name="attempt-register"]', function(){

		var formdata = {
			'email' : $('form[name="registerform"] input[name="email"]').val(),
			'password' : $('form[name="registerform"] input[name="password"]').val(),
			'spassword':  $('form[name="registerform"] input[name="spassword"]').val()
		}

		console.log(formdata);

		if(formdata['email'] == "" || formdata['password'] == "")
		{
			
		}
		else
		{
			$.ajax ({
				type: "POST",
				url: base_url+"auth/k_register",	
				data: formdata,		
				cache: false,
				success: function (data) {	
					trapdata = $.parseJSON(data);
					if(trapdata.status)
					{
						$('#loginModal').modal('hide');
						$('[name="register-message"]').html("You've successfully registered with KID " + trapdata.response.kid);
						$('form[name="registerform"]').hide();
						console.log('Status 200');

					}
					else
					{
						$('[name="register-message"]').html(trapdata.response);
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

	$(document).on('click','[name="register-button"]',function(){
		
		var formdata = {
			'content-item-id' : $(this).data('content-id'),
			'logged-in-status' : $(this).data('logged-in')
		};

		console.log(formdata);

		if(formdata['logged-in-status'] == "")
		{
			$('#loginModal').modal('show')
		}
		else
		{
			$.ajax ({
				type: "POST",
				url: base_url+"k_attachment",	
				data: formdata,		
				cache: false,
				success: function (data) {	
					trapdata = $.parseJSON(data);
					if(trapdata.status == 2)
					{
						console.log('Status 200');
						$('[name="attachment_registration"]').html(trapdata.response.success);
					}
					else if(trapdata.status == 1)
					{
						console.log('Status T');
						$('[name="attachment_registration"]').html(trapdata.response.error);
					}
					else
					{
						console.log('Status 401');	
						$('[name="attachment_registration"]').html(trapdata.response.error);
					}
							
					console.log("Edit Category Form Intiated");
				},		
				error: function() {
					console.log("Edit Category Form Failed");
				}
			});
		}
	});

	$(document).on('keyup','#collegename',function(){

		var formdata = {
			'institution' : $(this).val()
		};
		

		console.log(formdata);

		$.ajax ({
				type: "POST",
				url: base_url+"k_get_ambassador",	
				data: formdata,		
				cache: false,
				success: function (data) {	
					$('[name="student-ambassador-display"]').html(data);							
					console.log("Edit Category Form Intiated");
				},		
				error: function() {
					console.log("Edit Category Form Failed");
				}
			});

	});

	var workshopquestionnaire  = {
				"3dprinting" : [
						"What is your idea about 3D printing?",
						"Why do you want to attend this workshop?",
						"What do you think is the future of 3D printing in India?",
						"Do you think 3D printing is efficient? If so, why? ",
						"Do you think it is better to have a 3D printer and make objects as we like rather than buying something available in the market?"
					],
				"journalism" : [ 
						"What is your idea about journalism?",
						"If you would prefer a career in journalism, why would that be?",
						"What makes you to attend the ‘journalism‘ workshop?",
						"If you become a journalist, Will you be ethical in reporting news in order to fulfill the responsibilities to the society?",
						"Who is the journalist you admire the most? And why?"	
					],
				"facebot" : [ 
						"What is the first thing that comes into your head when you hear a word ”Face Gesture Recognition robot”?",
						"Why do you want to attend this workshop?",
						"What is your opinion about living in a fully robot controlled environment?",
						"How will the use of Face Gesture Recognition robot influence our daily life?",
						"Can you think of any application of Face Gesture Recognition robots?"	
					],
				"bluebot" : [ 
						"Why do you wish to attend this workshop?",
						"What do you expect to learn from this workshop?",
						"What is your idea (or vision) about Bluetooth Controlled Robotics?",
						"How do you wish to implement this technology? Describe your imagination.",
						"Can you think of any practical application of Bluetooth-controlled Robots?"	
					],
				"baker" : [ 
						"Why do you think you should attend the workshop?", 
						"Have you heard about Laurie bakers techniques before?", 
						"Justify the importance of curves and circles in buildings.", 
						"Do you think Indian ways of construction can be interpreted for modern day use?", 
						"What comes to your mind if you hear “Eco friendly buildings“?"
					],
				"c2000" : [
						"What made you to involve in attending this workshop?",
						"Give some practical applications of launchpad in solving real time problems.",
						"What do you think about the influence of programming in real time tasks?",
						"Is there any other way  to obtain real time solutions  than using launchpads?",
						"What do you expect to learn out of this workshop?"
					],
				"venture" : [
						"How can this workshop be helpful to you?",
						"Why would you want to be an Entrepreneur?",
						"Have you been in any sort of Entrepreneurial activity (startup, pitch it event, startup events, like wise) Also name the activity you took part in?",
						"How would you collect financial resources for your startup idea, if you have one?",
						"Entrepreneurs tend to solve major social problems, so enlighten us with the one social problem that you would want to solve?"
					],
				"livecoding" : [
						"What factors drive you to join this workshop?",
						"Have you ever heard of 'Live coding' before? If yes, when and where?",
						"What are your expectations from this workshop?",
						"What according to you would be a significant real time application of live coding?",
						"Would you like considering live coding as a career option??"
					]
			};

	$(document).on('click','[name="workshop-register-button"]', function(){
		var formdata = {
			'content-item-id' : $(this).data('content-id'),
			'workshop-name' : $(this).data('workshop-name'),
			'logged-in-status' : $(this).data('logged-in')
		};

		if(formdata['logged-in-status'] == "")
		{
			$('#workshopModal').modal('hide')
			$('#loginModal').modal('show')
		}
		else
		{
			$('[name="wq1"]').html(workshopquestionnaire[formdata['workshop-name']][0]);
			$('[name="wq2"]').html(workshopquestionnaire[formdata['workshop-name']][1]);
			$('[name="wq3"]').html(workshopquestionnaire[formdata['workshop-name']][2]);
			$('[name="wq4"]').html(workshopquestionnaire[formdata['workshop-name']][3]);
			$('[name="wq5"]').html(workshopquestionnaire[formdata['workshop-name']][4]);
		}

	});

	$(document).on('click','[name="team-workshop-registration"]', function(){
		var formdata = {
			'content-item-id' : $(this).data('content-id'),
			'workshop-name' : $(this).data('workshop-name'),
			'logged-in-status' : $(this).data('logged-in')
		};

		if(formdata['logged-in-status'] == "")
		{
			$('#teamWorkshopModal').modal('hide')
			$('#loginModal').modal('show')
		}
		else
		{
			
			if(formdata['workshop-name'] == "c2000")
			{
				$('[name="kid4"]').hide();
				$('[name="wq1"]').html(workshopquestionnaire[formdata['workshop-name']][0]);
				$('[name="wq2"]').html(workshopquestionnaire[formdata['workshop-name']][1]);
				$('[name="wq3"]').html(workshopquestionnaire[formdata['workshop-name']][2]);
				$('[name="wq4"]').html(workshopquestionnaire[formdata['workshop-name']][3]);
				$('[name="wq5"]').html(workshopquestionnaire[formdata['workshop-name']][4]);
			}
			else if(formdata['workshop-name'] == "krithi")
			{
				$('[name="kid4"]').hide();
				$('[name="twquestion1"]').val('krithi').hide();
				$('[name="twquestion2"]').val('krithi').hide();
				$('[name="twquestion3"]').val('krithi').hide();
				$('[name="twquestion4"]').val('krithi').hide();
				$('[name="twquestion5"]').val('krithi').hide();
			}
			else
			{
				$('[name="wq1"]').html(workshopquestionnaire[formdata['workshop-name']][0]);
				$('[name="wq2"]').html(workshopquestionnaire[formdata['workshop-name']][1]);
				$('[name="wq3"]').html(workshopquestionnaire[formdata['workshop-name']][2]);
				$('[name="wq4"]').html(workshopquestionnaire[formdata['workshop-name']][3]);
				$('[name="wq5"]').html(workshopquestionnaire[formdata['workshop-name']][4]);

			}

		}

	});

	$(document).on('click','[name="attempt-team-workshop-registration"]',function(){
		var formdata = {
			'workshopurl' : $('form[name="teamworkshopregisterform"] [name="content-url"]').val(),
			'logged-in-status' : $('form[name="teamworkshopregisterform"] [name="logged-in"]').val(),
			'attachment-id' : $('form[name="teamworkshopregisterform"] [name="attachment-id"]').val(),
			'response1' : $('[name="twquestion1"]').val(),
			'response2' : $('[name="twquestion2"]').val(),
			'response3' : $('[name="twquestion3"]').val(),
			'response4' : $('[name="twquestion4"]').val(),
			'response5' : $('[name="twquestion5"]').val(),
			'kid1' : $('[name="kid1"]').val(),
			'kid2' : $('[name="kid2"]').val(),
			'kid3' : $('[name="kid3"]').val(),
			'kid4' : $('[name="kid4"]').val(),
		}


		if(formdata['logged-in-status'] == "")
		{
			$('#loginModal').modal('show')
		}
		else if(formdata['response1'] == "" || formdata['response2'] == "" || formdata['response3'] == "" || formdata['response4'] == "" || formdata['response5'] == "")
		{
			alert('Required Fields not provided.');
		}
		else
		{
			console.log(formdata);
			$.ajax ({
				type: "POST",
				url: base_url+"k_team_workshop_attachment",	
				data: formdata,		
				cache: false,
				success: function (data) {	
					trapdata = $.parseJSON(data);
					if(trapdata.status == 2)
					{
						console.log('Status 200');
						$('form[name="teamworkshopregisterform"]').hide();
						$('[name="team-workshop-register-message"]').html(trapdata.response.success);
					}
					else if(trapdata.status == 1)
					{
						console.log('Status T');
						$('form[name="teamworkshopregisterform"]').hide();
						$('[name="team-workshop-register-message"]').html(trapdata.response.error);
					}
					else if(trapdata.status == 4)
					{
						$('[name="team-workshop-register-message"]').html(trapdata.response.error);
					}
					else if(trapdata.status == 5)
					{
						$('[name="team-workshop-register-message"]').html(trapdata.response.error);
					}
					else
					{
						console.log('Status 401');	
						$('[name="team-workshop-register-message"]').html(trapdata.response.error);
					}
							
					console.log("Edit Category Form Intiated");
				},		
				error: function() {
					console.log("Edit Category Form Failed");
				}
			});
		}
		
	});

	$(document).on('click','[name="attempt-workshop-registration"]',function(){
		var formdata = {
			'logged-in-status' : $('form[name="workshopregisterform"] [name="logged-in"]').val(),
			'attachment-id' : $('form[name="workshopregisterform"] [name="attachment-id"]').val(),
			'response1' : $('[name="wquestion1"]').val(),
			'response2' : $('[name="wquestion2"]').val(),
			'response3' : $('[name="wquestion3"]').val(),
			'response4' : $('[name="wquestion4"]').val(),
			'response5' : $('[name="wquestion5"]').val()
		}

		
		
		if(formdata['logged-in-status'] == "")
		{
			$('#loginModal').modal('show')
		}
		else if(formdata['response1'] == "" || formdata['response2'] == "" || formdata['response3'] == "" || formdata['response4'] == "" || formdata['response5'] == "")
		{
			alert('Required Fields not provided.');
		}
		else
		{
			console.log(formdata);
			$.ajax ({
				type: "POST",
				url: base_url+"k_workshop_attachment",	
				data: formdata,		
				cache: false,
				success: function (data) {	
					trapdata = $.parseJSON(data);
					if(trapdata.status == 2)
					{
						console.log('Status 200');
						$('form[name="workshopregisterform"]').hide();
						$('[name="workshop-register-message"]').html(trapdata.response.success);
					}
					else if(trapdata.status == 1)
					{
						console.log('Status T');
						$('form[name="workshopregisterform"]').hide();
						$('[name="workshop-register-message"]').html(trapdata.response.error);
					}
					else
					{
						console.log('Status 401');	
						$('[name="workshop-register-message"]').html(trapdata.response.error);
					}
							
					console.log("Edit Category Form Intiated");
				},		
				error: function() {
					console.log("Edit Category Form Failed");
				}
			});
		}
	});

	$(document).on('click','[name="sa-register"]',function(){
		var formdata = {
			'logged-in-status' : $(this).data('logged-in')
		};

		var studentambassador = [
			"Have you participated in earlier versions of K!?If yes, in which?",
			"Have you been a K! student ambassador of your college?",
			"Why do you want to be a student ambassador of K!?",
			"How do you plan to target the audience of your college?"
		];


		if(formdata['logged-in-status'] == "")
		{
			$('#saModal').modal('hide')
			$('#loginModal').modal('show')
		}
		else
		{
			$('[name="saq1"]').html(studentambassador[0]);
			$('[name="saq2"]').html(studentambassador[1]);
			$('[name="saq3"]').html(studentambassador[2]);
			$('[name="saq4"]').html(studentambassador[3]);
		}		
	});

	$(document).on('click','[name="attempt-sa-registration"]',function(){
		var formdata = {
			'logged-in-status' : $('form[name="saregisterform"] input[name="logged-in"]').val(),
			'saresponse1' : $('[name="saquestion1"]').val(),
			'saresponse2' : $('[name="saquestion2"]').val(),
			'saresponse3' : $('[name="saquestion3"]').val(),
			'saresponse4' : $('[name="saquestion4"]').val()
		};

		console.log(formdata);

		if(formdata['logged-in-status'] == "")
		{
			$('#loginModal').modal('show')
		}
		else
		{
			$.ajax ({
				type: "POST",
				url: base_url+"k_sa_register",	
				data: formdata,		
				cache: false,
				success: function (data) {	
					trapdata = $.parseJSON(data);
					console.log(trapdata);

					if(trapdata.status == 1)
					{
						console.log('Status 200');
						$('[name="saregisterform"]').hide();
						$('[name="saregistermessage"]').html(trapdata.response.message);
						$('[name="sa-attachment"]').html('<div class="claim-pa">Pending Approval</div>');
					}
					else if(trapdata.status == 2)
					{
						console.log('Status T');
						$('[name="saregistermessage"]').html(trapdata.response.message);
					}
					else
					{
						console.log('Status 401');	
						$('[name="saregistermessage"]').html(trapdata.response.message);
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
				url: base_url+"index.php/auth/k_logout",	
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

	$(document).on('click','[name="attempt-register-hospitality"]',function(){
		var formdata = {
			'kid' : $('[name="registerhospitality"] [name="kid"]').val(),
			'arrivaldate' : $('[name="registerhospitality"] [name="dateofarrival"]').val(),
			'arrivaltime' : $('[name="registerhospitality"] [name="timeofarrival"]').val(),
			'arrivalmedian' : $('[name="registerhospitality"] [name="arrivalmedian"]').val(),
			'departuredate' : $('[name="registerhospitality"] [name="dateofdeparture"]').val(),
			'departuretime' : $('[name="registerhospitality"] [name="timeofdeparture"]').val(),
			'departuremedian' : $('[name="registerhospitality"] [name="departuremedian"]').val(),
			'city' : $('[name="registerhospitality"] [name="city"]').val()
		};

		console.log(formdata);

		if(formdata['departuredate'] < formdata['arrivaldate'])
		{
			alert('Departure Date is less than Arrival Date');
		}
		else if(formdata['departuredate'] == "" || formdata['arrivaldate'] == "" || formdata['arrivalmedian'] == "" || formdata['departuremedian'] == "" || formdata['departuretime'] == "" || formdata['arrivaltime'] == "" || formdata['city'] == "")
		{
			alert('Required Fields are empty');
		}
		else
		{
			$.ajax ({
				type: "POST",
				url: base_url+"k_hospitality_register",	
				data: formdata,		
				cache: false,
				success: function(data) {	
					console.log(data);
					var trapdata = $.parseJSON(data);
					if(trapdata.status == 1)
					{
						$('[name="registerhospitality"]').html(trapdata.response.message);
		
					}
					else if(trapdata.status == 2)
					{
						$('[name="registerhospitality"]').html(trapdata.response.message);
		
					}
					else
					{
						console.log(trapdata.response.message);
					}
				},		
				error: function() {
					console.log("Edit Category Form Failed");
				}
			});
		}
	})

	$(document).on('click','[name="attempt-facebook"]',function(){
		KFBLogin();
		console.log("FB");
	});

	

	$(document).on('click','[name="profile-type"]', function(){
		var formdata = {
			'profile-name' : $(this).data('user-type')
		}
		console.log(formdata);

		if(formdata['profile-name'] == 1)
		{
			$('[name="student-info"]').show();
			$('[name="school-info"]').hide();	
			profiletype = 1;
		}
		else if(formdata['profile-name'] == 2)
		{
			$('[name="student-info"]').hide();
			$('[name="school-info"]').show();
			profiletype = 2;				
		}
	});


	$(document).on('click','[name="attempt-save-profile"]',function(){

		var type = $('[name="profile-type"]').data('user-type');
		if($.trim(profiletype) == 1) {
			var formdata = {
				'fullname' : $('form[name="profile-update"] input[name="fullname"]').val(),
				'semester' : $('form[name="profile-update"] select[name="semester"]').val(),
				'gender' : $('form[name="profile-update"] select[name="gender-type"]').val(),
				'type' : profiletype,
				'institution' :  $('form[name="profile-update"] input[name="institution"]').val(),
				'contactnumber' :   $('form[name="profile-update"] input[name="contactnumber"]').val(),
				'degree' :   $('form[name="profile-update"] input[name="degree"]').val(),
				'course' :   $('form[name="profile-update"] input[name="course"]').val(),
				'kid' : $('form[name="profile-update"] input[name="kid"]').val()
			}
		} else {
			var formdata = {
				'fullname' : $('form[name="profile-update"] input[name="fullname"]').val(),
				'semester' : $('form[name="profile-update"] select[name="class"]').val(),
				'gender' : $('form[name="profile-update"] select[name="gender-type"]').val(),
				'type' : profiletype,
				'institution' :  $('form[name="profile-update"] input[name="school"]').val(),
				'contactnumber' :   $('form[name="profile-update"] input[name="contactnumber"]').val(),
				'kid' : $('form[name="profile-update"] input[name="kid"]').val()
			}
		}
		

		console.log(formdata);

		$.ajax ({
				type: "POST",
				url: base_url+"k_profile_update",	
				data: formdata,		
				cache: false,
				success: function (data) {	
					var trapdata = $.parseJSON(data);
					if(trapdata.status == 1)
					{
						$('[name="profile-update-message"]').html(trapdata.response.message).fadeOut(5000);
		
					}
					else if(trapdata.status == 2)
					{
						$('[name="profile-update-message"]').html(trapdata.response.message).fadeOut(5000);
		
					}
					else
					{
						console.log(trapdata.response.message);
					}
				},		
				error: function() {
					console.log("Edit Category Form Failed");
				}
			});
	});
	
});



///////////////////////// LOAD - START //////////////////////////////////////////////////

function loadscripts()
{
	var scriptpath = base_url+'assets/scripts/';

	var scriptfiles = new Array(); 
		scriptfiles.push("jquery-2.0.3.js");
		scriptfiles.push("jquery.cookie.js");
		scriptfiles.push("jquery.pjax.js");
		scriptfiles.push("bootstrap.min.js");
		scriptfiles.push("jquery.tickertype.js");
		scriptfiles.push("responsiveslides.min.js");

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
				url: base_url+"index.php/auth/k_fb",	
				data: formdata,		
				cache: false,
				success: function (data) {
					trapdata = $.parseJSON(data);
					console.log(trapdata);
					if($.trim(trapdata.status) == 1)
					{
						$('[name="k-connect-modal"]').hide();
						$('[name="k-connect-profile"]').show();
						$('[name="fullname"]').html(trapdata.response.kid);
						$('[name="register-button"]').data('logged-in',trapdata.response.kid);
						$('[name="workshop-register-button"]').data('logged-in',trapdata.response.kid);
						$('[name="team-workshop-register-button"]').data('logged-in',trapdata.response.kid);
						$('[name="attachment_registration"]').html("<p>Refresh Page to know status.</p>");
						console.log(trapdata.response.email);
						$('#loginModal').modal('hide');

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