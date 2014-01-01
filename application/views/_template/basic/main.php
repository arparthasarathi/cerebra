<div class="col-lg-12">
	<div class="row">
		<div class="col-lg-12">
			<h2 class="sub-header-title">EVENT</h2>
		</div>
	</div>
</div>
<div class="col-lg-2">
	<div class="row">
		<? if($subcategories) { ?>
		<div class="accordion" name="k-accordian-subnavigation">
			<?php foreach($subcategories as $subcategory) : ?>
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#collapse-<? echo strtoupper($subcategory['content_subcategory']); ?>">
                            <? echo strtoupper($subcategory['content_subcategory']); ?>
                        </a>
                    </div>
                    <div id="collapse-<? echo strtoupper($subcategory['content_subcategory']); ?>" class="accordion-body collapse" style="height: 0px; ">
                       
                        <div class="accordion-inner">
                            <ul>
                            	 <? 
				          	$item = 'content_'.$subcategory['content_subcategory'];
				          	foreach ($$item as $t) {
				        ?>
                                <li><a href="#"><? echo $t['content_title']; ?></a></li>
                        <?
				            }
				        ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <? endforeach ?>
        </div>
        <? } ?>
		<!-- <div class="sidebar-navigation">

		</div> -->
	</div>
</div>
<div class="col-lg-10">
	
	<div class="row">
		<div class="col-lg-12 polaroid">
			<div class="inner-shadow"></div>
			<div class="row">
				<div class="image-wrapper">
					<img src="<? echo base_url(); ?>cms/assets/images/content_item/<? echo $content_data_primary[0]['content_item_image_url']; ?>">
				</div>
			</div>
			<div class="shadow"></div>
			<div class="row">
				<div class="text-wrapper">
					<div class="col-lg-3">
						<div class="avatar">
							<img src="assets/images/title-sponsor.png">
						</div>
						<div class="row" id="k-tabbed-interface">
							<? foreach ($content_data_content as $cdc) { ?>
							<div class="blue-banner-title">
								<a href="#<? echo $cdc['content_item_tab_id']; ?>" data-toggle="tab">
									<? echo $cdc['content_item_tab_title']; ?>
								</a>
							</div>
							<? } ?>
						</div>
					</div>
					<div class="col-lg-9">
						<div class="row">
							<button class="btn btn-default btn-primary pull-right">Register for Event</button>
							<button class="btn btn-default btn-danger pull-right">Contact for Event</button>
						</div>
						<div class="tab-content">
							<? foreach ($content_data_content as $cdc) { ?>
							<div class="tab-pane active" id="<? echo $cdc['content_item_tab_id']; ?>">
								<h3><? echo $cdc['content_item_tab_title']; ?></h3>
									<? echo $cdc['content_item_tab_content']; ?>
							</div>
							<? } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>