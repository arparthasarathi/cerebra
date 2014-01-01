<div class="col-lg-10">	
	<div class="row" name="k-home-gallery">
		<ul class="rslides">
			<? 	
					if($galleries) {
						foreach ($galleries as $gallery) {
				?>
						<li><img src="<? echo encode_base64_image(base_url().'cms/assets/images/gallery_image/'.$gallery['gallery_image_url']); ?>"></li>
					
				<? 
						}
					}
				?>
			</ul>
	</div>
	<div class="row k-content-box-p" name="k-content-box">
		<? echo $static_page[0]['static_page_content']; ?>
	</div>
</div>