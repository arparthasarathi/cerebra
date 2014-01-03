<?php
echo '<title>ROS</title>';
if(isset($welcome))
	echo '<div class="center-page head">Welcome to Riddles of Sphinx 2014.<br><div class="center-page head"></div>Login before you start playing</div>';
if(isset($profile))
{
	echo '<div class="alert">Please complete your profile</div>';
}
if(isset($img))
{
	echo '<div class="center-page">You dont say??</div>';
	echo '<img class="center-page" width="300" height="300" src ='.base_url().'assets/images/ros/'.$img.' class="image-block">';
}

?>