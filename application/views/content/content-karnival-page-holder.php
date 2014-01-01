<div class="col-lg-10">
	<div class="row">
		<div class="col-lg-2">
			<div class="row">
			<? if($karnival_data_content[0]['karnival_title']) { ?>
			<hr class="firstline">
			<div class="k-content-header">
				<? echo $karnival_data_content[0]['karnival_title']; ?>
			</div>
			<hr class="firstline">
			<? } ?>
			</div>
		</div>
	<div class="col-lg-10">
			<? if($karnival_data_image) { ?>
			<div class="row">
				<div class="image-wrapper">
					<img src="<? echo base_url(); ?>cms/assets/images/content_item/<? echo $karnival_data_image[0]['content_item_image_url']; ?>">
				</div>
			</div>
			<? } ?>
			<? if($karnival_data_content) { ?> 
			<div class="tab-content">
				<div id="<? echo $karnival_data_content[0]['karnival_id']; ?>">
					<h3><? echo $karnival_data_content[0]['karnival_title']; ?></h3>
					<? echo $karnival_data_content[0]['karnival_content']; ?>
				</div>
			</div>
			<?  } ?>
		</div>
	</div>
</div>