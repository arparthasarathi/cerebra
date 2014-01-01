<div class="col-lg-10">
	<div class="row" name="track-update-content">
		<div class="col-lg-2">
			<div class="row" name="k-content-track">
			<? if($content_data_primary[0]['content_title']) { ?>
				<div name="animate-title">
					<hr class="firstline">
					<div class="k-content-header">
						<? echo ucfirst(strtolower($content_data_primary[0]['content_title'])); ?>
					</div>
					<div class="k-content-arrow">
						<!-- <div class="share-wrapper">
  							<ul class="share-list">
    							<li class="facebook">
      								<a href="#">
        								<i class="fa fa-facebook"></i>
      								</a>
    							</li>
  							</ul>
						</div> -->
						
						<? if($content_data_primary[0]['content_item_id']) { ?>
						<div class="fb-share-button" data-href="<? echo base_url().$system_type."/".$content_data_primary[0]['content_url']; ?>" data-type="button_count"></div>
						<div class="pull-right">
							<? 
								$subtrack = 'subscription_'.$content_data_primary[0]['content_url'];
								if($$subtrack) { ?>
									<? if(strtolower($system_type) == "workshops") { ?>
										<? $subscriptiontrack = $$subtrack; ?>
										<div class="status-track-header ">
										<? if($subscriptiontrack[0]['responsestatus'] == 0) { ?>
										<div class="claim-pa">
											Pending Approval
											<div class="pull-right"><i class="fa fa-minus-circle"></i></div>
										</div>
										<? } else if($subscriptiontrack[0]['responsestatus'] == 1) { ?>
										<div class="claim-a">
											Approved
											<div class="pull-right"><i class="fa fa-check-circle"></i></div>
										</div>
										<? } else if ($subscriptiontrack[0]['responsestatus'] == 2) { ?>
										<div class="claim-r">
											Rejected
											<div class="pull-right"><i class="fa fa-times-circle"></i></div>
										</div>
										<? } ?>
										</div>
									<? } else { ?>
										<p>Already Registered</p>
									<? } ?>
								<? } else { ?>
									<?  
										if(strtolower($system_type) == "xceed") { 
											if(strtolower($content_data_primary[0]['content_url']) == "warangalgame") { 
														?>
									<div name="attachment_registration">
										<a href="http://xceed-warangal.doattend.com/" class="btn btn-primary"  name="special-register-button" target="_blank">Subscribe <i class="fa fa-angle-double-right"></i></a>
									</div>
									<?
											 	} else {  }
									} else if(strtolower($content_data_primary[0]['content_url']) == "kambassador") { 
											if($logged_in){
													if($profile_complete){
										?>
									<div name="attachment_registration">
										<a href="<? echo base_url(); ?>/profile/<? echo $log->profilename; ?>" class="btn btn-primary"  name="special-register-button" target="_blank">Register SA <i class="fa fa-angle-double-right"></i></a>
									</div>

										<? } else { ?> <p>Oops! Looks like your profile is incomplete. To register complete profile by clicking <a href="<? echo base_url(); ?>profile/<? echo $log->profilename; ?>">here</a></p> <? }	} 
									} else if(strtolower($content_data_primary[0]['content_url']) == "hospitality") {
										?>

										<?
									}

									else if(strtolower($system_type) == "workshops") { 
												if($logged_in){
													if($profile_complete){
									?>
									<div name="attachment_registration">
										<a <? if((strtolower($content_data_primary[0]['content_url']) == "facebot") || (strtolower($content_data_primary[0]['content_url']) == "bluebot") || (strtolower($content_data_primary[0]['content_url']) == "c2000") || (strtolower($content_data_primary[0]['content_url']) == "krithi")) { ?> href="#teamWorkshopModal" <? } else { ?> href="#workshopModal" <? } ?> data-toggle="modal" class="btn btn-primary" <? if((strtolower($content_data_primary[0]['content_url']) == "facebot") || (strtolower($content_data_primary[0]['content_url']) == "bluebot") || (strtolower($content_data_primary[0]['content_url']) == "c2000") || (strtolower($content_data_primary[0]['content_url']) == "krithi")) { ?> name="team-workshop-registration" <? } else { ?> name="workshop-register-button" <? } ?> data-workshop-name="<? echo strtolower($content_data_primary[0]['content_url']); ?>" data-content-id="<? echo $content_data_primary[0]['content_item_id']; ?>" data-profile-complete="<? if($profile_complete){ echo "1"; } else { echo "0"; } ?>" data-logged-in="<? if($logged_in) { echo $log->kid; } else { echo ""; }; ?>">Register <i class="fa fa-angle-double-right"></i></a>
									</div>
									<? } else { ?> <p>Oops! Looks like your profile is incomplete. To register complete profile by clicking <a href="<? echo base_url(); ?>profile/<? echo $log->profilename; ?>">here</a></p> <? }	} else { ?>
									<div name="attachment_registration">
										<a <? if((strtolower($content_data_primary[0]['content_url']) == "facebot") || (strtolower($content_data_primary[0]['content_url']) == "bluebot") || (strtolower($content_data_primary[0]['content_url']) == "c2000") || (strtolower($content_data_primary[0]['content_url']) == "krithi")) { ?> href="#teamWorkshopModal" <? } else { ?> href="#workshopModal" <? } ?> data-toggle="modal" class="btn btn-primary" <? if((strtolower($content_data_primary[0]['content_url']) == "facebot") || (strtolower($content_data_primary[0]['content_url']) == "bluebot") || (strtolower($content_data_primary[0]['content_url']) == "c2000") || (strtolower($content_data_primary[0]['content_url']) == "krithi")) { ?> name="team-workshop-registration" <? } else { ?> name="workshop-register-button" <? } ?> data-workshop-name="<? echo strtolower($content_data_primary[0]['content_url']); ?>" data-content-id="<? echo $content_data_primary[0]['content_item_id']; ?>" data-profile-complete="<? if($profile_complete){ echo "1"; } else { echo "0"; } ?>" data-logged-in="<? if($logged_in) { echo $log->kid; } else { echo ""; }; ?>">Register <i class="fa fa-angle-double-right"></i></a>
									</div>
									<? }	 ?>
									<? 	} else { if($logged_in){
													if($profile_complete){
														?>
									<div name="attachment_registration">
										<button class="btn btn-primary" name="register-button" data-content-id="<? echo $content_data_primary[0]['content_item_id']; ?>" data-profile-complete="<? if($profile_complete){ echo "1"; } else { echo "0"; } ?>" data-logged-in="<? if($logged_in) { echo $log->kid; } else { echo ""; }; ?>">Subscribe <i class="fa fa-angle-double-right"></i></button>
									</div>
									<? } else { ?> <p>Oops! Looks like your profile is incomplete. To register complete profile by clicking <a href="<? echo base_url(); ?>profile/<? echo $log->profilename; ?>">here</a></p> <? }	} else { ?>
									<div name="attachment_registration">
										<button class="btn btn-primary" name="register-button" data-content-id="<? echo $content_data_primary[0]['content_item_id']; ?>" data-profile-complete="<? if($profile_complete){ echo "1"; } else { echo "0"; } ?>" data-logged-in="<? if($logged_in) { echo $log->kid; } else { echo ""; }; ?>">Subscribe <i class="fa fa-angle-double-right"></i></button>
									</div>
									<? } ?>	
									<? } ?>
								<?
								}
								?>
						</div>
						<? } ?>
					</div>
					<hr class="firstline">
				</div>
			<? } ?>
			</div>
			<div class="row">
			<? if($content_data_sponsor) { ?>
				<div class="k-sponsor-wrapper">
					<img src="<? echo base_url(); ?>cms/assets/images/content_item/sponsors/<? echo $content_data_sponsor[0]['content_item_sponsor_url']; ?>">
				</div>
			<? } ?>
			</div>
			<div class="row">
			<? if($content_data_content) { ?>
			<div name="k-tabbed-navigation" id="k-tabbed-interface" class="nav nav-tabs">
			<? 		if($tabbed) { ?>
				<ul>
				<? 			foreach ($content_data_content as $cdc) { ?>
				<li>
					<a href="#<? echo $cdc['content_item_tab_id']; ?>" data-toggle="tab">
						<? echo $cdc['content_item_tab_title']; ?>
					</a>
				</li>
				<? 			} ?>
				</ul>
			<? 		} ?>
			</div>
			<? } ?>
			</div>
		</div>
		<div class="col-lg-10" name="animate-content-box">
			<div class="row">
			<? if($content_data_image[0]['content_item_image_url']) { ?>
				<div class="k-image-wrapper">
					<img src="<? echo base_url(); ?>cms/assets/images/content_item/<? echo $content_data_image[0]['content_item_image_url']; ?>">
				</div>
			<? } ?>
			</div>
			<div class="row" name="k-content-box">
			<? if($content_data_content) { ?>
			<? 		if($tabbed) { ?> 			
			<div class="tab-content">
			<? 			foreach ($content_data_content as $cdc) { ?>
				<div class="tab-pane <?  if($cdc['primary'] == 1) { ?>active<? } ?>" id="<? echo $cdc['content_item_tab_id']; ?>">
					<h3><? echo $cdc['content_item_tab_title']; ?></h3>
					<? echo $cdc['content_item_tab_content']; ?>
				</div>
			<? 			} ?>
			</div>
			<?		} else { ?>
					<h3><? echo $content_data_content[0]['content_item_tab_title']; ?></h3>
					<? echo $content_data_content[0]['content_item_tab_content']; ?>
			<?		} ?>
			<? } else { ?>
				<p>Will be Updated</p>
			<? } ?>
			</div>
		</div>
	</div>
</div>