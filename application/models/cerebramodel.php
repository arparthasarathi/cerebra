<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Cerebramodel extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		{
			$this->load->database();
			$this->load->helper('url');
			$this->load->helper('date');

		}
	}
function initialize($kid){
		$q="SELECT kid from k13_cerebra where kid=?";
		$res=$this->db->query($q,$kid);
		if($res->num_rows()>0)
			return;
		else
		{//set initial value in database.
			$query1="Select fullname from bitauth_userdata where kid=?";
			$result1=$this->db->query($query1,$kid);
			foreach($result1->result() as $row1)
				$name=trim($row1->fullname);		
			$qid=array(0,1,2,3,4,5,6,7);
			
			for($value=1;$value<count($qid);$value++) 
			{
			$this->db->insert('k13_cerebra',array('kid'=>$kid,'qid'=>$qid[$value],'attempt'=>0,'flag'=>0));
			}

		$this->db->insert('cerebra_users',array('kid'=>$kid,'name'=>$name,'points'=>0,'answered'=>0));	

			
			//fb post..
		}
	}

public function getques($kid)
{
	$q1="select points,answered from cerebra_users where kid=?";
	$r1= $this->db->query($q1,$kid);
	$rr1   = $r1->row();
	
	
		$q2    = "select qid,attempt,flag from k13_cerebra where kid=?";
		$r2    = $this->db->query($q2,$kid);
		$rr2   = $r2->row();
		$qid=array(0);
		foreach($r2->result() as $row)
			$qid[]=$row->qid;
		
		$qa=array(0);
		$qw=array(0);
		//$qa    = $rr2->flag;
		//$qw    = $rr2->attempt;
		foreach($r2->result() as $row)
			{
				$qa[]=$row->flag;
				$qw[] = $row->attempt;
			}
				$ques= array("Not to be used","How many days are there in Feb?","What's your age and let me know  wat yu wat to do and just do it as u like before and continue with it as you want.","Days in leap Year??","What do u want to do","What else do u wnat now","hows your home going on","what happens is for good");						
		$p     = $rr1->points;
		$answered     = $rr1->answered;//total no of questions answered.
		$totalquestions=count($ques);
		
		$t=time();
		$rs = $this->db->query("select st_time from start_cerebra");
        
        if ($rs->num_rows() == 1) {
            $rrs     = $rs->row();
            $st_time = $rrs->st_time;
            $rem=$t-human_to_unix($st_time);
?>
<script type="text/javascript">
			var phptimestamp = "<? echo human_to_unix($st_time)+5400;?>";			
			 
		</script>
<?
            //$diff    = $t - $st_time;
            //$rem     = ($diff + 109899) - $t;
			$flag=1;
		}
		
	if($rem<0){
			$msg="<h2>Please wait for main contest</h2></div>";
			$flag=0;
		}
		
		if($flag==1){
			if($rem>=5400)
			{
				$msg="<h2>Athena main contest ended</h2></div>";
				$flag=0;
			}
		}
		

				
					

		//	$time_dif=$t-human_to_unix($st_time);				
			
			$totalques=count($ques);
			$code='<font color="#fff"></h2><div class="col-md-6 col-md-offset-2">';
			
			
			if($totalquestions==$answered)
			{
				$code.="<h2>You have completed!</h2>";
				$code.="</div>";
			}
			else if($flag==0){
				$code.=$msg;
			}
			
			else{
					$code.='<div id="fixed-div">
<div class="row"><h3><div id="countdown"></div></h3>
<h3 align="left"><div style="display:inline;">Points : &nbsp' . $p . '</div></h3></div></div>
    <script>
    // set the date were counting down to

var target_date =new Date(phptimestamp*1000);
 
// variables for time units
var days, hours, minutes, seconds;
 
// get tag element
 
// update the tag with id "countdown" every 1 second
setInterval(function () {
 
    // find the amount of "seconds" between now and target
    var current_date = new Date().getTime();
    var seconds_left = (target_date - current_date) / 1000;
 
    // do some time calculations
    
    seconds_left = seconds_left % 86400;
     
    hours = parseInt(seconds_left / 3600);
    seconds_left = seconds_left % 3600;
     
    minutes = parseInt(seconds_left / 60);
    seconds = parseInt(seconds_left % 60);
     if(minutes<=0)
 { 
if(seconds<=0) { location.reload(true); 
     document.getElementById("countdown").innerHTML="Time is Up !!" ; }
else document.getElementById("countdown").innerHTML="Time is  Running Up !! "+ hours + "h: "+ minutes + "m: " + seconds + "s";
}
    // format countdown string + set tag value
if(seconds>=0 && minutes>0)
    document.getElementById("countdown").innerHTML = hours + "h: "+ minutes + "m: " + seconds + "s";  
 
}, 1000);
    </script></h3> 
			';
					for ($u = 1; $u <$totalques; $u++) {

				if (!$qa[$u]) {
				$code .= '<br>
				<b>Question ' . $u . '</b>
				<div class="span6"><b>Attempts : </b>&nbsp;
				<div style="display:inline;">' . $qw[$u] . '</div></div>
			<form name="unanswered' .$u. '" method="post" action="http:/localhost/cerebra/submit">
			<input type="hidden" name="level" value="' .$u. '"/>
			<br>' . $ques[$u] . '<br>
			<br>
			<input type="text" class="form-control span4" name="answer" id="t' . $u . '" placeholder="Your Answer Here!!"/>
			<br><button type="submit" class="btn btn-primary btn-sm" id="but'.$u.'" >Submit</button>
			</form>';
								} 

			else {
						$code .= '<br><div clas="span4" ><div class="well alert-success round">
									<b>Question ' . $u . '</b>
									<div class="span4"><b>Attempts : </b>&nbsp;
									<div id=athena_attempts_t' . $u . ' style="display:inline;">' . $qw[$u] . '</div></div>
									<div class="span4"><div id=qc' . $u . ' style="display:inline;">
									<strong>Answered Correctly!</strong></div><div id=qs' . $u . '></div></div></div></div>';
								}
					}
					
					
			}
			return $code;
	
	

}

public function getanswer($level,$answer,$kid)
{
	//return 10;
	$answer_arr=array("0","20","28","364.25","1","2","3","4");
	 $t  = time();
        $rs = $this->db->query("select st_time from start_cerebra");
        if ($rs->num_rows() == 1) {
            $rrs     = $rs->row();
            $st_time = $rrs->st_time;
            $diff    = $t - human_to_unix($st_time);
            if ($diff > 5400)
                return ;
                }
		if(trim($answer)==null) return;
		
		else{
		
		$q1="select points,answered from cerebra_users where kid=?";
		$r1= $this->db->query($q1,$kid);
		$rr1   = $r1->row();
		$q2    = "select qid,attempt,flag from k13_cerebra where kid=?";
		$r2    = $this->db->query($q2,$kid);
		$rr2   = $r2->row();
		$qid=array(0);
		foreach($r2->result() as $row)
			$qid[]=$row->qid;
		
		$qa=array(0);
		$qw=array(0);
		//$qa    = $rr2->flag;
		//$qw    = $rr2->attempt;
		foreach($r2->result() as $row)
			{
				$qa[]=$row->flag;
				$qw[] = $row->attempt;
			}
		
		$p     = $rr1->points;
		$answered     = $rr1->answered;
			if(strcmp(strtolower($answer),$answer_arr[$level])==0)
			{

				$p=$p+3;
				$answered=$answered+1;
				$qq = "update k13_cerebra set flag='1' where kid='$kid' and qid='$level'";
                $this->db->query($qq);
                $ar = "update cerebra_users set points='$p',answered='$answered' where kid='$kid'";
                $this->db->query($ar);

                 	$config['appId'] = FB_APPID;
                    $config['secret'] = FB_SECRET;
                    $config['cookie'] = true;
              
              $this->load->library('facebook-source/facebook',$config);
                   
                    $facebook = new Facebook(array(
                        'appId'  => FB_APPID,
                        'secret' => FB_SECRET,
                    ));
                     $user = $facebook->getUser();
                    if($user)
                      {
                      try {
                            $publishStream = $facebook->api("/$user/feed", 'post', array(
                              'message' => "Started playing Cerebra Set-4",
                              'link'    => 'http://kurukshetra.org.in/cerebra',
                              'picture' => 'http://mediahive.kurukshetra.org.in/2013/thumb/CER.jpg',
                              'name'    => 'Cerebra | Kurukshetra 2013',
                              'description'=> 'Cerebra is the Online Puzzle Challenge of Kurukshetra\'13 conducted for 90 minutes. Its open for both Students and Corporates. Get ready for the challenge!'
                              )
                   
                            );
                   //echo "asassa";
                          } catch (FacebookApiException $e) {
                            
                       }   
                    }
			}
			else
			{
				$attempt=$qw[$level];
				$attempt=$attempt+1;
				$p=$p-1;
				$qq = "update k13_cerebra set attempt='$attempt' where kid='$kid' and qid='$level'";
				$ar = "update cerebra_users set points='$p' where kid='$kid'";
				$this->db->query($qq);
				$this->db->query($ar);
			}
			
	}
}
}
