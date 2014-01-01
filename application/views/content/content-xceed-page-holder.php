<div class="col-lg-10">
	<div class="row">
		<div class="col-lg-2">
			<div class="row">
			<? if($xceed_data_content[0]['xceed_title']) { ?>
			<hr class="firstline">
			<div class="k-content-header">
				<? echo $xceed_data_content[0]['xceed_title']; ?>
			</div>
			<hr class="firstline">
			<? } ?>
			</div>
		</div>
	<div class="col-lg-10">
			<? if($xceed_data_image) { ?>
			<div class="row">
				<div class="image-wrapper">
					<img src="<? echo base_url(); ?>cms/assets/images/content_item/<? echo $xceed_data_image[0]['content_item_image_url']; ?>">
				</div>
			</div>
			<? } ?>
			<? if($xceed_data_content) { ?> 
			<div class="tab-content">
				<div id="<? echo $xceed_data_content[0]['xceed_id']; ?>">
					<h3><? echo $xceed_data_content[0]['xceed_title']; ?></h3>
					<? echo $xceed_data_content[0]['xceed_content']; ?>
				</div>
			</div>
			<?  } ?>
		</div>
	</div>
</div>