<div class="col-lg-10">
	<div class="row">
		<div class="col-lg-2">
			<div class="row">
				<hr class="firstline">
				<? if($mailing) { ?>
				<div class="k-content-header">
					Contacts
				</div>
				<? } else if($contact_data_content[0]['team']) { ?>
				<div class="k-content-header">
					<? echo $team[$contact_data_content[0]['team']]; ?>
				</div>
				<? } ?>
				<hr class="firstline">
			</div>
		</div>
		<div class="col-lg-10">
		<? if($mailing) { ?>
			<? foreach($team as  $a => $v) { ?>
				<div class="col-lg-6">
					<p><? echo $v; ?></p>
					<? $track_team = 'team_'.$a; ?>
					<? foreach ($$track_team as $tt) { ?>
					<p><? echo $tt['phonenumber']; ?></p>
					<? } ?>
				</div>
			<? } ?>
		<? }  else if($contact_data_content) { ?>
		<div class="row">
		<?
				
				foreach ($contact_data_content as $cdc) {
		?> 
			<div class="col-lg-6">
				<p><? echo $cdc['fullname']; ?><p>
				<p><i class="fa fa-phone"></i> <? echo " ".$cdc['phonenumber']; ?></p>
			</div>
		<? 		
			}
			?>
			</div>
			<div class="row">
			<?
			if($mail[$contact_data_content[0]['team']]) {
			?>
				<div class="col-lg-12">
					<hr class="firstline">
					<h4><i class="fa fa-envelope"></i> <? echo $mail[$contact_data_content[0]['team']]; ?></h4>
				</div>
			<?
				}
			?>
		</div>
			<?
			
		}
		?>
		
		</div>
	</div>
</div>
						