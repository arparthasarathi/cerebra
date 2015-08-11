<title><? echo $title ?></title>

  <div class="empty-track"></div>
  
  <div class="col">
    <div class="col-md-6 personal">

    <?if(isset($log)) echo "  ".$log->fullname;?></div>
    <div class="col-md-6 personal">QUIZZERS ON RIDE:</div></div>
    <div class="col personal">
    <div class="col-md-6 personal"><?if(isset($rank))echo $rank;?></div>
    <div class="col-md-6 personal"><?if(isset($count))echo $count;?></div>
  </div>

  
  
</div>
<br>
<div class="row-fluid  ">
<div class="col-md-8 others">
<div class="col-md-3">RANK</div>

<div class="col-md-6">NAME</div>
<div class="col-md-3 ral">POINTS</div>
</div>
</div>
<div class="row-fluid">
<div class="col-md-8 others">
<?php
$i=1;
foreach($id as $mi)
{
  echo '<div class="col-md-3">'.$i.'</div>';

  echo '<div class="col-md-6">'.$mi->name.'</div>';
    echo '<div class="col-md-3 ral">'.$mi->points.'</div>';
  $i++;
}
?>

</div>
</div>
