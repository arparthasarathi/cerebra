<title>ROS|LEADERBOARD</title>
<div class="container">
	<div class="empty-track"></div>
	<div class="personal">
	<div class="col personal">
		<div class="col-md-6">

		<?if(isset($log)) echo "  ".$log->fullname;?></div>
		<div class="col-md-6">QUIZZERS ON RIDE:</div></div>
		<div class="col personal">
		<div class="col-md-6"><?if(isset($rank))echo $rank;?></div>
		<div class="col-md-6"><?if(isset($count))echo $count;?></div>
	</div>
</div>
	
	
</div>
<br>
<div class="row-fluid ">
<div class="col-md-8 others">
<div class="col-md-4">RANK</div>
<div class="col-md-4">KID</div>
<div class="col-md-4">POINTS</div>
</div>
</div>
<div class="row-fluid">
<div class="col-md-8 others">
<?php
$i=1;
foreach($id as $mi)
{
	echo '<div class="col-md-4">'.$i.'</div>';
	echo '<div class="col-md-4">'.$mi->kid.'</div>';
  	echo '<div class="col-md-4">'.$mi->points.'</div>';
	$i++;
}
?>
</div>
</div>