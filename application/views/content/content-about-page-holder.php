<div class="col-lg-10">
	<div class="row">
		<div class="col-lg-2">
			<div class="row">
			<? if($about_data_content[0]['about_title']) { ?>
			<hr class="firstline">
			<div class="k-content-header">
				<? echo $about_data_content[0]['about_title']; ?>
			</div>
			<hr class="firstline">
			<? } ?>
			</div>
		</div>
		<div class="col-lg-10">
			<?php if($about_data_image) { ?>
			<div class="row">
				<div class="image-wrapper">
					<img src="<? echo base_url(); ?>cms/assets/images/content_item/<? echo $content_data_image[0]['content_item_image_url']; ?>">
				</div>
			</div>
			<?php } ?>
			<? if($about_data_content) { ?> 

						<div class="tab-content">
							<div id="<? echo $about_data_content[0]['about_id']; ?>">
								<h3><? echo $about_data_content[0]['about_title']; ?></h3>
									<? echo $about_data_content[0]['about_content']; ?>
							</div>
						</div>
							<?  } ?>
		</div>
	</div>
</div>