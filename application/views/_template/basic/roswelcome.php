<?php

if(isset($welcome)){?>
	<div class="center-page head"><font color="#fff">
<h1>Welcome to Cerebra 2014.</h1></div>

<div class="col-md-8 col-md-offset-2"><h2>Introduction about the game goes here.blah blah blah blah blah blahblah blah blah blah blah blah</h2></div>
<br><br><br><br>
<div class="center-page head">1.Login before you start playing</div>
<div class="center-page head">2.Also complete your profile to play</div>
<?}


	

if(isset($img))
{
	
	echo '<img class="center-page" width="600" height="500" src ='.base_url().'assets/images/'.$img.' class="image-block">';
}

?>