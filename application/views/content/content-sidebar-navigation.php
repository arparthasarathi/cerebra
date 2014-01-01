<div class="col-lg-2">
    <? if ($sidebar == 1) { ?>
	<div class="row">
		<? if($subcategories) { ?>
		<div class="panel-group" id="accordion" name="k-accordian-subnavigation">
			<?php foreach($subcategories as $subcategory) : ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="panel-title">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse-<? echo strtoupper($subcategory['content_subcategory']); ?>">
                            <? echo strtoupper($subcategory['content_subcategory']); ?>
                        </a>
                        </div>
                    </div>
                    <div id="collapse-<? echo strtoupper($subcategory['content_subcategory']); ?>" class="panel-collapse collapse">
                       
                        <div  class="panel-body">
                            <ul>
                        <? 
				          	$item = 'content_'.$subcategory['content_subcategory'];
				          	foreach ($$item as $t) {
				        ?>
                                <li><a href="<? echo base_url().$system_type."/".$t['content_url']; ?>" data-pjax="true"><i class="fa fa-angle-double-left" class="arrow-animate-sidebar"></i> <? echo $t['content_title']; ?></a></li>
                        <?
				            }
				        ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <? endforeach ?>
        <? } ?>
    </div>
</div>
    <? } else if($sidebar == 2) { ?>
   <div class="row">
        <div class="quicklinks-holder">
            <div class="quicklinks-title">Quicklinks</div>
            <ul class="quicklinks">
                <!-- <li><a href="<? echo base_url(); ?>hospitality" data-pjax="true"><i class="fa fa-arrow-right quicklinks-arrow"></i> Hospitality</a></li> -->
                <li><a href="<? echo base_url(); ?>xceed" data-pjax="true"><i class="fa fa-arrow-right quicklinks-arrow"></i> XCEED</a></li>
                <li><a href="<? echo base_url(); ?>general/kambassador" data-pjax="true"><i class="fa fa-arrow-right quicklinks-arrow"></i> K! Ambassador</a></li>
                <li><a href="<? echo base_url(); ?>general/hospitality" data-pjax="true"><i class="fa fa-arrow-right quicklinks-arrow"></i> Hospitality</a></li>
                <li><a href="http://dalalbullkurukshetra.org.in/" target="_blank" data-pjax="true"><i class="fa fa-arrow-right quicklinks-arrow"></i> Dalal Bull</a></li>
                <!-- <li><a href="<? echo base_url(); ?>karnival" data-pjax="true"><i class="fa fa-arrow-right quicklinks-arrow"></i> Karnival</a></li> -->
            </ul>
        </div>
    </div>
    <? } else if($sidebar == 4) { ?>
    <? if($logged_in) {  if($profile_complete) { ?>

    <? if($hospicontent[0]['responsestatus'] == 1) { ?>
    <div class="status-track-header ">
        <div class="claim-pa">
                                            Pending Approval
                                            <div class="pull-right"><i class="fa fa-minus-circle"></i></div>
                                        </div>
    </div>
    <? } else if($hospicontent[0]['responsestatus'] == 2) { ?>
    <div class="status-track-header ">
        <div class="claim-a">
                                            Approved
                                            <div class="pull-right"><i class="fa fa-check-circle"></i></div>
                                        </div>
    </div>
    <? } else if($hospicontent[0]['responsestatus'] == 3) { ?> 
    <div class="status-track-header ">
        <div class="claim-r">
                                            Rejected
                                            <div class="pull-right"><i class="fa fa-times-circle"></i></div>
                                        </div>
    </div>
    <? } else { ?>
    <div class="row">
     <div class="row">
        <div class="quicklinks-holder">
             <div class="quicklinks-title">Accomdation Registration</div>
             <p class="col-lg-12" style="color: #FFF;">Accomdation start from Jan 29<sup>th</sup>, 2013 3:00 pm</p>
            <form class="col-lg-12 form" name="registerhospitality" method="POST" action="javascript:void(0);" accept-charset="UTF-8">
                <div class="form-group">
                    <input type="hidden" name="kid" value="<? echo $log->kid; ?>">
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-12">
                        <div class="row">
                        Date of Arrival
                        </div>
                    </label>
                    <div class="col-lg-12">
                    <div class="row">
                        <select class="form-control" name="dateofarrival" required>
                            <option value="29">29<sup>th</sup> January 2013</option>
                            <option value="30">30<sup>th</sup> January 2013</option>
                            <option value="31">31<sup>th</sup> January 2013</option>
                        </select>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-12">
                        <div class="row">
                        Time of Arrival
                        </div>
                    </label>
                    <div class="col-lg-7">
                        <div class="row">
                            <input type="time" class="form-control" name="timeofarrival" required>
                        </div>
                    </div>
                    <div class="col-lg-5">
                    <div class="row">
                        <select class="form-control" name="arrivalmedian">
                            <option value="am">AM</option>
                            <option value="pm">PM</option>
                        </select>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-12">
                        <div class="row">
                        Date of Departure
                        </div>
                    </label>
                    <div class="col-lg-12">
                    <div class="row">
                        <select class="form-control" name="dateofdeparture" required>
                            <option value="30">30<sup>th</sup> January 2013</option>
                            <option value="31">31<sup>th</sup> January 2013</option>
                            <option value="32">1<sup>st</sup> February 2013</option>
                        </select>
                    </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-lg-12">
                        <div class="row">
                        Time of Departure
                        </div>
                    </label>
                    <div class="col-lg-7">
                        <div class="row">
                            <input type="time" class="form-control" name="timeofdeparture" required>
                        </div>
                    </div>
                    <div class="col-lg-5">
                    <div class="row">
                        <select class="form-control" name="departuremedian">
                            <option value="am">AM</option>
                            <option value="pm">PM</option>
                        </select>
                    </div>
                    </div>
                </div>
                 <div class="form-group">
                  <label class="control-label col-lg-12">
                        <div class="row">
                        City
                        </div>
                    </label>
                 <div class="col-lg-12">
                 <div class="row">
                     <input type="text" name="city" class="form-control" placeholder="City">
                     </div>
                 </div>
                 </div>
                 <div class="form-group" style="padding: 40px 0;">
                    <div class="col-lg-12">
                        <button class="btn btn-info" name="attempt-register-hospitality">Register</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?} } else {?> <p> Oops, Profile not complete. </p>   <? }  } else { ?> <p>Login to register for accomdation.</p> <? } ?>
    </div>

    <? } else { ?>

    <? } ?> 
        </div>