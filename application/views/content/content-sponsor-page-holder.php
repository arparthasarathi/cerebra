<div class="col-lg-10">
<div class="col-lg-2">
	<div class="row">
	<? if($sponsors)
		{
	?>
	<hr class="firstline">
		<div class="k-content-header">
			Kurukshetra <? echo ucfirst(strtolower($sponsor_year)); ?>
		</div>
	<hr class="firstline">
	<?
		}
	?>
	
	</div>
</div>
<div class="col-lg-10">
<?
	if($sponsors)
	{
		foreach ($sponsors as $sponsor) {
			$level1 = "getcategories_".$sponsor['sponsor_year'];
			if(isset($$level1))
			{
			foreach($$level1 as $l1)
			{
?>
<div class="col-lg-12">
		<div class="row">
			<h4 class="sponsor-category-header"><? echo $avenues[$l1['sponsor_category']]; ?></h4>
			<hr class="firstline">
		</div>
</div>
<div class="col-lg-12">
<div class="row">
<?
				$level2 = 'track_sponsor_'.$l1['sponsor_category'];
				if($$level2) {
				foreach ($$level2 as $l2) {
?>

<div class="col-lg-4">
	<div class="row">
		<div class="col-lg-12 sponsor">
			<div class="inner-shadow"></div>
			<div class="row">
				<div class="image-wrapper">
					<a target = "_blank" href = "<?="http://".$l2['sponsor_url'];?>"><img src="<? echo base_url(); ?>cms/assets/images/sponsors/<? echo $l2['sponsor_item_url']; ?>"></a>
				</div>
			</div>
			<div class="shadow"></div>
			<div class="row">
				<div class="text-wrapper">
					<div class="col-lg-9">
						<div class="tab-content">
							<div class="tab-pane active">
								<p><? echo $l2['sponsor_title']; ?></p>
									<a href="<? echo $l2['sponsor_url']; ?>"><? echo $l2['sponsor_url']; ?></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?
				
				} 
		}
?>
</div>
		</div>
<?
			}
		}
				else
		{
?>
		
<?
		}
		}

	}
?>
</div>
</div>