<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
Class Rosmodel extends CI_Model
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
			$qid=array(0,1,2,3 );
			for($value=1;$value<count($qid);$value++) 
			{
			$query="insert into k13_cerebra(kid,qid) values(?,$qid[$value])";
			$this->db->query($query,$kid);
			}
			$query="insert into cerebra_users(kid,points) values(?,0)";
			$this->db->query($query,$kid);
			
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
		
		$p     = $rr1->points;
		$answered     = $rr1->answered;//total no of questions answered.
		$totalquestions=3;
		
		$t=time();
		$rs = $this->db->query("select st_time from start_cerebra");
        
        if ($rs->num_rows() == 1) {
            $rrs     = $rs->row();
            $st_time = $rrs->st_time;
            $rem=$t-human_to_unix($st_time);
            //$diff    = $t - $st_time;
            //$rem     = ($diff + 109899) - $t;
			$flag=1;
		}
		
		else{
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
		
		$ques= array("Not to be used","How many days are there in Feb?","What's your age and let me know  wat yu wat to do and just do it as u like before and continue with it as you want.","Days in leap Year??");						
				
					

		//	$time_dif=$t-human_to_unix($st_time);				
			
			$totalques=count($ques);
			$code='<font color="#fff"></h2><div class="col-md-6 col-md-offset-2">
			<h3 >Points : &nbsp' . $p . ' </h3> 
			<h3 >Time remaining : &nbsp; 00:00:00</h3>';
			
			
			if($totalquestions==$answered)
			{
				$code.="<h2>You have completed!</h2>";
				$code.="</div>";
			}
			else if($flag==0){
				$code.=$msg;
			}
			
			else{
					for ($u = 1; $u <$totalques; $u++) {
				if (!$qa[$u]) {
				$code .= '<br>
				<b>Question ' . $u . '</b>
				<div class="span6"><b>Attempts : </b>&nbsp;
				<div style="display:inline;">' . $qw[$u] . '</div></div>
			<form name="unanswered' .$u. '" method="post" action="<? echo base_url();?>/submit">
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
	$answer_arr=array("0","20","28","364.25");
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
