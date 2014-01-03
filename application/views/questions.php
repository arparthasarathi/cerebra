<title>ROS</title>
<?php

 echo form_open('submit');

echo '<div class="center-page">';
if(isset($level))
{
	echo '<title>ROS'.$level.'</title>';
	echo '<div class="head">LEVEL:'.$level.'</div>';
}
if(isset($img))
{
foreach($img as $pic)
{

     echo '<img width="200" height="200" src ='.base_url().'assets/images/ros/'.$pic.' class="image-block">';
}
   echo '</div>';
  }
 echo '<div class="center-page">';
 echo '<br>';
if(isset($pageclue))
	echo '<b>'.$pageclue.'</b></br></br>';
if(!isset($succesnote))
{
echo form_label('Answer');
echo form_input('answer');
echo '<p></p><input type="submit" class="btn btn-warning" value="Say answer" name="Submit"/>';

echo form_hidden('level',$level);

}
else
{
	echo $succesnote;
}


echo '</div>';


?>