<?php
echo '<form name="ambassador" method="post" onsubmit="scriptJudge()">';
for($i=1;$i<=$length;$i++)
echo '<br/><img width="110" height="100" src ='.base_url().'assets/images/ros/img'.$i.'.jpg>HI</img>';
echo '<br/><label>Answer</label><input type="text" name="answer" id="answer"/>';
echo '<input type="submit" value="sayanswer" name="Sayanswer"/>';
echo '<div id="my"></div>';
echo '<br/><script src ='.base_url().'assets/scripts/gmscript.js></script>';
?>