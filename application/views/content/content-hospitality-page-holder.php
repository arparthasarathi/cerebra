<div class="col-lg-10">
	<div class="row">
		<div class="col-lg-2">
			<div class="row">
			<? if($hospitality_data_content[0]['hospitality_title']) { ?>
			<hr class="firstline">
			<div class="k-content-header">
				<? echo $hospitality_data_content[0]['hospitality_title']; ?>
			</div>
			<hr class="firstline">
			<? } ?>
			</div>
		</div>
	<div class="col-lg-10">
			<? if($hospitality_data_image) { ?>
			<div class="row">
				<div class="image-wrapper">
					<img src="<? echo base_url(); ?>cms/assets/images/content_item/<? echo $hospitality_data_image[0]['content_item_image_url']; ?>">
				</div>
			</div>
			<? } ?>
			<? if($hospitality_data_content) { ?> 
			<div class="tab-content">
				<div id="<? echo $hospitality_data_content[0]['hospitality_id']; ?>">
					<h3><? echo $hospitality_data_content[0]['hospitality_title']; ?></h3>
					<? echo $hospitality_data_content[0]['hospitality_content']; ?>
				</div>
			</div>
			<?  } ?>
		</div>
	</div>
</div>