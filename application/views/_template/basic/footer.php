
	<div class="modal" id="workshopModal">
		<div class="modal-dialog">
            <div id="loginform">
                <div id="registerlogin">
                    <a href="javascript:void(0)" class="pull-right" name="close-button">Close <i class="fa fa-times-circle-o"></i></a>
                    <div class="row">
                        <div class="col-lg-12">
                            <h1><? echo ucfirst(strtolower($content_data_primary[0]['content_title'])); ?></h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div name="workshop-register-message"></div>
                        </div>
                    </div>
                    <div class="row">
                   		<div class="col-lg-12">
                        	<form name="workshopregisterform" role="form" action="javascript:void(0)" method="POST" accept-charset="UTF-8">
                            	<input type="hidden" name="attachment-id" value="<? echo $content_data_primary[0]['content_item_id']; ?>">
                            	<input type="hidden" name="logged-in" value="<? if($logged_in) { echo $log->kid; } else { echo ""; }; ?>">
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="wq1"></span>
                            		<textarea class="form-control" name="wquestion1" placeholder="Your Response for Question 1" required></textarea>
                            	</div>
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="wq2"></span>
                            		<textarea class="form-control" name="wquestion2" placeholder="Your Response for Question 2" required></textarea>
                            	</div>
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="wq3"></span>
                            		<textarea class="form-control" name="wquestion3" placeholder="Your Response for Question 3" required></textarea>
                            	</div>
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="wq4"></span>
                            		<textarea class="form-control" name="wquestion4" placeholder="Your Response for Question 4" required></textarea>
                            	</div>
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="wq5"></span>
                            		<textarea class="form-control" name="wquestion5" placeholder="Your Response for Question 5" required></textarea>
                            	</div>

                            	<button type="button" class="btn btn-primary" name="attempt-workshop-registration">Register for <b><? echo ucfirst(strtolower($content_data_primary[0]['content_title'])); ?></b></button>
                        	</form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
	<div class="modal" id="teamWorkshopModal">
		<div class="modal-dialog">
		 	<div id="loginform">
                <div id="registerlogin">
                    <a href="javascript:void(0)" class="pull-right" name="close-button">Close <i class="fa fa-times-circle-o"></i></a>
                 
					<div class="row">
                		<div class="col-lg-12">
                    		<h1><? echo ucfirst(strtolower($content_data_primary[0]['content_title'])); ?></h1>
                		</div>
            		</div>
            		<div class="row">
            			<div name="team-workshop-register-message"></div>
            		</div>
            		<div class="row">
                		<div class="col-lg-12">
                			<div class="row">
	                			<div class="col-lg-6">
	                				<input type="text" name="kid1" placeholder="Team Member 1" value="<? if($logged_in) { echo $log->kid; } else { echo ""; }; ?>" disabled>
	                				<span name="kidcontent1"></span>
	                			</div>
	                			<div class="col-lg-6">
	                				<input type="text" name="kid2" placeholder="KID of Team Member 2">
	                				<span name="kidcontent2"></span>
	                			</div>
                			</div>
                			<div class="row">
	                			<div class="col-lg-6">
	                				<input type="text" name="kid3" placeholder="KID of Team Member 3">
	                				<span name="kidcontent3"></span>
	                			</div>
	                			<div class="col-lg-6">
	                				<input type="text" name="kid4" placeholder="KID of Team Member 4">
	                				<span name="kidcontent4"></span>
	                			</div>
                			</div>
                		</div>
            		</div>
            		<div class="row">
            			<div class="col-lg-12">
                				<form name="teamworkshopregisterform" role="form" action="javascript:void(0)" method="POST" accept-charset="UTF-8">
                            		<input type="hidden" name="attachment-id" value="<? echo $content_data_primary[0]['content_item_id']; ?>">
                            		<input type="hidden" name="content-url" value="<? echo strtolower($content_data_primary[0]['content_url']); ?>">                 		
                            		<input type="hidden" name="logged-in" value="<? if($logged_in) { echo $log->kid; } else { echo ""; }; ?>">
                            		<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="wq1"></span>
                            		<textarea class="form-control" name="twquestion1" placeholder="Your Response for Question 1" required></textarea>
                            	</div>
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="wq2"></span>
                            		<textarea class="form-control" name="twquestion2" placeholder="Your Response for Question 2" required></textarea>
                            	</div>
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="wq3"></span>
                            		<textarea class="form-control" name="twquestion3" placeholder="Your Response for Question 3" required></textarea>
                            	</div>
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="wq4"></span>
                            		<textarea class="form-control" name="twquestion4" placeholder="Your Response for Question 4" required></textarea>
                            	</div>
                            	<div class="col-lg-12" style="padding: 10px 0;">
                            		<span name="wq5"></span>
                            		<textarea class="form-control" name="twquestion5" placeholder="Your Response for Question 5" required></textarea>
                            	</div>

                            	<button type="button" class="btn btn-primary" name="attempt-team-workshop-registration">Register for <b><? echo ucfirst(strtolower($content_data_primary[0]['content_title'])); ?></b></button>

                            	</form>
                		</div>
            		</div>
            	</div>
           	</div>
		</div>
	</div>
<footer role="footer">
	<div class="container">
		<div class="row">
			<div class="col-lg-9">
				<div class="row">
					<h4 name="k-quick-link-title">
                      <span font-samarkan>k! Wik Navi</span> 
                    </h4>
				</div>
				<div class="row">
                	<div class="col-lg-4">
                		<div class="row">
                        <h4 name="k-quick-link-subtitle">
                          <span font-samarkan>k! events</span>
                        </h4>
                      </div>
                      <div class="row">
                        <ul name="k-quick-link-links">
                          <li><a href="<? echo base_url(); ?>events/designersquest">Designer's quest</a></li>
                          <li><a href="<? echo base_url(); ?>events/angrybots">Angry Bots</a></li>
                          <li><a href="<? echo base_url(); ?>events/robowars">Robo Wars</a></li>
                          <li><a href="<? echo base_url(); ?>events/crisis">Crisis</a></li>
                          <li><a href="<? echo base_url(); ?>events/contraption">Contraption</a></li>
                          <li><a href="<? echo base_url(); ?>events/godspeed">God Speed</a></li>
                          <li><a href="<? echo base_url(); ?>events/paperpresentation">Paper Presentation</a></li>
                        </ul>
                      </div>
                	</div>
                	
                <div class="col-lg-4">
                		<div class="row">
                        <h4 name="k-quick-link-subtitle">
                          <span font-samarkan>k! workshops</span>
                        </h4>
                      </div>
                      <div class="row">
                        <ul name="k-quick-link-links">
                          <li><a href="<? echo base_url(); ?>workshops/3DPRINTING">3D Printing</a></li>
                          <li><a href="<? echo base_url(); ?>workshops/VENTURECAPITALISM">Venture Capitalism</a></li>
                          <li><a href="<? echo base_url(); ?>workshops/KRITHI">Krithi</a></li>
                        </ul>
                      </div>
                	</div>
                </div>
			</div>
			<div class="col-lg-3">
				<div class="socialholder">
					<ul class="social">
						<li class="facebook"><a href="https://www.facebook.com/kurukshetra.org.in" target="_blank"><i class="fa fa-facebook"></i></a></li>
            			<li class="twitter"><a href="https://twitter.com/kurukshetra_ceg" target="_blank"><i class="fa fa-twitter"></i></a></li>
            			<li class="youtube"><a href="http://www.youtube.com/user/kurukshetramedia" target="_blank"><i class="fa fa-youtube"></i></a></li>
						<!-- <li class="behance"><a href="http://www.behance.net/m412c0" class="entypo-behance"></a></li>
						<li class="linked-in"><a href="#" class="entypo-linkedin"></a></li> -->
					</ul>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="©-placeholder">
				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-4">
							<span font-samarkan font-samarkan-size>k! Archives <i class="fa fa-chevron-right"></i><i class="fa fa-chevron-right"></i></span> 
						</div>
						<div class="col-lg-8">
							<a href="http://archive13.kurukshetra.org.in/" target="_blank" class="archives-text">2013</a>
							<a href="http://archive12.kurukshetra.org.in/" target="_blank" class="archives-text">2012</a>
							<a href="http://archive11.kurukshetra.org.in/" target="_blank" class="archives-text">2011</a>
							<a href="http://archive10.kurukshetra.org.in/" target="_blank" class="archives-text">2010</a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="row">
						<div class="col-lg-6">
							<a href="https://www.facebook.com/techforum.ceg" target="_blank">
								<img src="<? echo base_url(); ?>assets/images/ctf.png" name="k-footer-ctf-logo">
							</a>
						</div>
						<div class="col-lg-6">
							<p class="©-text">
								© Copyright <? echo date("Y"); ?>. All Rights Reserved.
							</p>
						</div>	
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>