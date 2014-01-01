<? if($stuamb) { ?>
	<? foreach ($stuamb as $sa) {
?>
<div class="col-lg-6">
	<div class="col-lg-3">
		<img src="<?php echo encode_base64_image(gravatar($sa['email'], array('s' => 50, 'd' => 'wavatar'))); ?>">
	</div>
	<div class="col-lg-9">
		<p><? echo $sa['fullname']; ?></p>
	</div>
</div>
<?	} ?>
<? } ?>