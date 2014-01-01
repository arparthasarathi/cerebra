<div class="col-lg-12">
	<div name="profile-box">
		<div class="row">
			<div class="col-lg-2">
					<h1 name="profile-title">PROFILE</h1>
					<div class="profile-track-image">
						<img src="<?php echo encode_base64_image(gravatar($log->email, array('s' => 150, 'd' => 'wavatar'))); ?>">
					</div>
					<div class="profile-track">
						<p class="profile-track-header">EMAIL ADDRESS</p>
						<p class="profile-track-content"><? echo $log->email; ?></p>
					</div>
					<div class="profile-track">
						<p class="profile-track-header">KURUKSHETRA ID</p>
						<p class="profile-track-content-large"><? echo strtoupper($log->kid); ?></p>
					</div>
					<div class="profile-track">
						<div class="profile-track-header">
							BECOME A STUDENT AMBASSADOR? 
							<? if($profile_complete) { ?> 
								<? if(trim($saclaim[0]['status']) == "pending") { ?>
									<div class="claim-pa">Pending Approval</div>
								<? } else if(trim($saclaim[0]['status']) == "accepted") { ?>
									<div class="claim-a">Approved</div>
								<? } else if(trim($saclaim[0]['status']) == "rejected") { ?>
									<div class="claim-r">Rejected</div>
								<? } else { ?>
								<div name="sa-attachment">
									<a href="#saModal" data-toggle="modal" class="btn btn-default" name="sa-register" data-profile-complete="<? if($profile_complete){ echo "1"; } else { echo "0"; } ?>" data-logged-in="<? if($logged_in) { echo $log->kid; } else { echo ""; }; ?>">CLICK HERE</a>
								</div>
								<? } ?>
						 	<? } else { ?> 
						 		<b>Complete Your Profile. <i class="fa fa-angle-double-right" name="animate-arrow"></i></b> 
							<? } ?>
						</div>
					</div>
					
			</div>
			<div class="col-lg-10">
				<div class="profile-track">
					<hr class="firstline">
						<h3 class="profile-track-url"><span>kurukshetra.org.in/profile/</span><? echo $log->profilename; ?></h3>
					<hr class="firstline">
				</div>
				<form action="javascript:void(0)" method="POST" accept-charset="UTF-8" class="form-horizontal" name="profile-update">
			<div class="form-group">
    			<label for="fullname" class="col-lg-2 control-label">Full Name</label>
    			<div class="col-lg-10">
    				<input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name" value="<? echo $log->fullname; ?>" required>
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="gender" class="col-lg-2 control-label">Gender</label>
    			<div class="col-lg-10">
    				<select class="form-control" name="gender-type">
    					<option  <? if($log->gender == "male") { ?> selected="selected" <? } ?> value="male"><i class="fa fa-male"></i> Male</option>
		  				<option  <? if($log->gender == "female") { ?> selected="selected" <? } ?>  value="female"><i class="fa fa-female"></i> Female</option>
    				</select>
    			</div>
  			</div>
  			<div class="form-group">
    			<label for="contactnumber" class="col-lg-2 control-label">Contact Number</label>
    			<div class="col-lg-10">
    				<input type="text" class="form-control" id="contactnumber" name="contactnumber" value="<? echo $log->contactno; ?>" placeholder="Contact Number">
    			</div>
  			</div>
  			<div class="form-group">
    			<input type="hidden" class="form-control" id="kid" name="kid" value="<? echo $log->kid; ?>">
    		</div>
    		<? if($log->type == null) { ?>
  			<div class="form-group">
  				<label for="semester" class="col-lg-2 control-label">Type</label>
  				<div class="col-lg-10">
		  			<div class="btn-group">
		  				<button type="button" class="btn btn-default" name="profile-type" data-user-type="1">College</button>
		  				<button type="button" class="btn btn-default" name="profile-type" data-user-type="2">School</button>
					</div>
				</div>
			</div>
			<? } ?>
			<div name="student-info" <? if($log->type == 1) { ?>  <? } else { ?> style="display:none;" <? } ?>>
				<div class="form-group">
	    			<label for="degree" class="col-lg-2 control-label">Degree</label>
	    			<div class="col-lg-10">
	    				<input type="text" class="form-control" id="degreename" name="degree" placeholder="Degree" value="<? echo $log->degree; ?>">
	    			</div>
	  			</div>
	  			<div class="form-group">
	    			<label for="course" class="col-lg-2 control-label">Course</label>
	    			<div class="col-lg-10">
	    				<input type="text" class="form-control" id="coursename" name="course" placeholder="Course" value="<? echo $log->course; ?>"> 
	    			</div>
	  			</div>
	  			<div class="form-group">
	  				<label for="semester" class="col-lg-2 control-label">Semester</label>
	  				<div class="col-lg-10">
			  			<select class="form-control" name="semester" required>
			  				<option value="1" <? if($log->semester == 1){ ?> selected="selected" <? } ?>>1</option>
			  				<option value="2" <? if($log->semester == 2){ ?> selected="selected" <? } ?>>2</option>
			  				<option value="3" <? if($log->semester == 3){ ?> selected="selected" <? } ?>>3</option>
			  				<option value="4" <? if($log->semester == 4){ ?> selected="selected" <? } ?>>4</option>
			  				<option value="5" <? if($log->semester == 5){ ?> selected="selected" <? } ?>>5</option>
			  				<option value="6" <? if($log->semester == 6){ ?> selected="selected" <? } ?>>6</option>
			  				<option value="7" <? if($log->semester == 7){ ?> selected="selected" <? } ?>>7</option>
			  				<option value="8" <? if($log->semester == 8){ ?> selected="selected" <? } ?>>8</option>
			  				<option value="9" <? if($log->semester == 9){ ?> selected="selected" <? } ?>>9</option>
			  				<option value="10" <? if($log->semester == 10){ ?> selected="selected" <? } ?>>10</option>
						</select>
					</div>
				</div>
				<div class="form-group">
	    			<label for="institution" class="col-lg-2 control-label">Institution</label>
	    			<div class="col-lg-10">
	    				<input type="text" class="form-control" id="collegename" name="institution" placeholder="Institution" value="<? echo $log->institution; ?>">
	    			</div>
	  			</div>
	  			<div class="form-group">
	  				<div name="student-ambassador-display"></div>
	  			</div>
	  			<div class="form-group">
	  				<div class="col-lg-10 col-lg-offset-2">
	  					<button type="button" class="btn btn-primary" name="attempt-save-profile">Save Profile</button>
	  					<div name="profile-update-message"></div>
	  				</div>
	  			</div>
  			</div>
  			<div name="school-info" <? if($log->type == 2) { ?>  <? } else { ?> style="display:none;" <? } ?>>
  				<div class="form-group">
	  				<label for="semester" class="col-lg-2 control-label">Class</label>
	  				<div class="col-lg-10">
			  			<select class="form-control" name="class" required>
			  				<option value="8" <? if($log->semester == 8){ ?> selected="selected" <? } ?>>8</option>
			  				<option value="9" <? if($log->semester == 9){ ?> selected="selected" <? } ?>>9</option>
			  				<option value="10" <? if($log->semester == 10){ ?> selected="selected" <? } ?>>10</option>
			  				<option value="11" <? if($log->semester == 11){ ?> selected="selected" <? } ?>>11</option>
			  				<option value="12" <? if($log->semester == 12){ ?> selected="selected" <? } ?>>12</option>
						</select>
					</div>
				</div>
  				<div class="form-group">
	    			<label for="school" class="col-lg-2 control-label">School</label>
	    			<div class="col-lg-10">
	    				<input type="text" class="form-control" id="school" name="school" placeholder="School" value="<? echo $log->institution; ?>">
	    			</div>
	  			</div>
	  			<div class="form-group">
	  				<div class="col-lg-10 col-lg-offset-2">
	  					<button type="button" class="btn btn-primary" name="attempt-save-profile">Save Profile</button>
	  					<div name="profile-update-message"></div>
	  				</div>
	  			</div>
	  		</div>
		</form>
			</div>
		</div>
	</div>
</div>
<div class="col-lg-12">

</div>
<div class="col-lg-12">

</div>
<div class="modal" id="saModal">
		<div class="modal-dialog">
            <div id="loginform">
                <div id="registerlogin">
                    <a href="javascript:void(0)" class="pull-right" name="close-button">Close <i class="fa fa-times-circle-o"></i></a>
                    <div class="row">
                        <div class="col-lg-12">
                            <h1><span font-samarkan>k!</span> Ambassador</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div name="saregistermessage"></div>
                        </div>
                    </div>
                    <div class="row">
                   		<div class="col-lg-12">
                        	<form name="saregisterform" role="form" action="javascript:void(0)" method="POST" accept-charset="UTF-8">
                            	<input type="hidden" name="logged-in" value="<? echo $log->kid; ?>">
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="saq1"></span>
                            		<textarea class="form-control" name="saquestion1" placeholder="Your Response for Question 1" required></textarea>
                            	</div>
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="saq2"></span>
                            		<textarea class="form-control" name="saquestion2" placeholder="Your Response for Question 2" required></textarea>
                            	</div>
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="saq3"></span>
                            		<textarea class="form-control" name="saquestion3" placeholder="Your Response for Question 3" required></textarea>
                            	</div>
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="saq4"></span>
                            		<textarea class="form-control" name="saquestion4" placeholder="Your Response for Question 4" required></textarea>
                            	</div>

                            	<button type="button" class="btn btn-primary" name="attempt-sa-registration">Register </button>
                        	</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>